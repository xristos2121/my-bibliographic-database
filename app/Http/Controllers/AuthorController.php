<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as TitleView;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function index(Request $request): View
    {
        $query = Author::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $terms = explode(' ', $search);

                foreach ($terms as $term) {
                    $q->orWhere('id', $term)
                        ->orWhere('first_name', 'like', "%{$term}%")
                        ->orWhere('last_name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                }

                if (count($terms) > 1) {
                    $q->orWhere(function ($subQuery) use ($terms) {
                        $subQuery->where('first_name', 'like', "%{$terms[0]}%")
                            ->where('last_name', 'like', "%{$terms[1]}%");
                    });
                }
            });
        }

        foreach (['affiliation', 'position', 'orcid_id'] as $filter) {
            if ($value = $request->get($filter)) {
                $query->where($filter, 'like', "%{$value}%");
            }
        }

        $totalResults = $query->count();
        $authors = $query->paginate(10);
        $searchTerms = $request->only('search', 'affiliation', 'position', 'orcid_id');

        TitleView::share('pageTitle', 'Authors');
        return view('admin.author.index', compact('authors', 'searchTerms', 'totalResults'));
    }

    public function create(): View
    {
        TitleView::share('pageTitle', 'Create Author');
        return view('admin.author.create');
    }

    public function store(StoreAuthorRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['profile_picture'] = $this->handleFileUpload($request);

        Author::create($validatedData);

        return redirect()->route('author.index')->with('success', 'Author created successfully!');
    }

    public function edit(Author $author): View
    {
        TitleView::share('pageTitle', 'Edit Author');
        return view('admin.author.edit', compact('author'));
    }

    public function update(UpdateAuthorRequest $request, Author $author): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($filePath = $this->handleFileUpload($request, $author)) {
            $validatedData['profile_picture'] = $filePath;
        }

        $author->update($validatedData);

        return redirect()->route('author.index')->with('success', 'Author updated successfully!');
    }

    public function destroy(Author $author): RedirectResponse
    {
        try {
            if ($author->publications()->exists()) {
                return redirect()->route('author.index')->with('error', 'Cannot delete author because they are associated with one or more publications.');
            }

            if ($author->profile_picture) {
                Storage::disk('public')->delete($author->profile_picture);
            }

            $author->delete();
            $message = 'Author deleted successfully!';
            $status = 'success';
        } catch (\Exception $e) {
            $message = 'Failed to delete the author. It might be in use.';
            $status = 'error';
        }

        return redirect()->route('author.index')->with($status, $message);
    }

    private function handleFileUpload(Request $request, Author $author = null): ?string
    {
        if (!$request->hasFile('profile_picture')) {
            return null;
        }

        $file = $request->file('profile_picture');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        $name = $originalName;
        $counter = 1;

        while (Storage::disk('public')->exists("profile_pictures/{$name}.{$extension}")) {
            $name = $originalName . '_' . $counter;
            $counter++;
        }

        $filePath = $file->storeAs('profile_pictures', "{$name}.{$extension}", 'public');

        if ($author && $author->profile_picture) {
            Storage::disk('public')->delete($author->profile_picture);
        }

        return $filePath;
    }
}

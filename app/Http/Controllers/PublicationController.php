<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Publication;
use App\Models\Author;
use App\Models\Type;
use App\Models\Keyword;
use App\Models\Publisher;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    public function index(): View
    {
        // Consider using eager loading if you're displaying related data
        $publications = Publication::with(['authors', 'types', 'keywords'])->get();
        return view('admin.publications.index', compact('publications'));
    }

    public function create(): View
    {
        $authors = Author::all();
        $types = Type::all();
        $keywords = Keyword::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('admin.publications.create', compact('authors', 'types', 'keywords','publishers','categories'));
    }

    public function store(StorePublicationRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $name = $originalName;
            $counter = 1;

            // Check if the file exists and append a number if it does
            while (Storage::disk('public')->exists("publications/{$name}.{$extension}")) {
                $name = $originalName . '_' . $counter;
                $counter++;
            }

            $filePath = $file->storeAs('publications', "{$name}.{$extension}", 'public');
            $validatedData['file'] = $filePath;
        }

        $publication = Publication::create($validatedData);
        $this->syncRelations($publication, $request);

        return to_route('publications.index')->with('success', 'Publication created successfully.');
    }

    public function show(Publication $publication): View
    {
        return view('publications.show', compact('publication'));
    }

    public function edit(Publication $publication): View
    {
        $authors = Author::all();
        $types = Type::all();
        $keywords = Keyword::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('admin.publications.edit', compact('publication', 'authors', 'types', 'keywords','publishers','categories'));
    }

    public function update(UpdatePublicationRequest $request, Publication $publication): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $name = $originalName;
            $counter = 1;

            while (Storage::disk('public')->exists("publications/{$name}.{$extension}")) {
                if ("publications/{$name}.{$extension}" != $publication->file) {
                    $name = $originalName . '_' . $counter;
                    $counter++;
                } else {
                    break;
                }
            }

            $filePath = $file->storeAs('publications', "{$name}.{$extension}", 'public');
            $validatedData['file'] = $filePath;

            if ($publication->file && $publication->file !== $filePath) {
                Storage::disk('public')->delete($publication->file);
            }
        }

        $publication->update($validatedData);
        $this->syncRelations($publication, $request);

        return to_route('publications.index')->with('success', 'Publication updated successfully.');
    }

    public function destroy(Publication $publication): RedirectResponse
    {
        if ($publication->file) {
            Storage::disk('public')->delete($publication->file);
        }
        $publication->delete();
        return to_route('publications.index')->with('success', 'Publication deleted successfully.');
    }

    /**
     * Syncs authors and keywords relations for a publication.
     *
     * @param  \App\Models\Publication  $publication
     * @param  \Illuminate\Foundation\Http\FormRequest  $request
     */

    private function syncRelations(Publication $publication, FormRequest $request): void
    {
        $authors = $request->input('authors', []);
        $publication->authors()->sync($authors);

        $keywords = $request->input('keywords', []);
        $publication->keywords()->sync($keywords);

        $categories = $request->input('categories', []);
        $publication->categories()->sync($categories);
    }


}

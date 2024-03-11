<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function index(): View
    {
        $authors = Author::all();
        return view('admin.author.index', compact('authors'));
    }

    public function create(): View
    {
        return view('admin.author.create');
    }

    public function store(StoreAuthorRequest $request): RedirectResponse
    {
        Author::create($request->validated());

        return to_route('author.index')->with('status', 'Author created successfully!');
    }

    public function edit(Author $author): View
    {
        return view('admin.author.edit', compact('author'));
    }

    public function update(UpdateAuthorRequest $request, Author $author): RedirectResponse
    {
        $author->update($request->validated());
        return to_route('author.index')->with('status', 'Category updated successfully!');
    }

    public function destroy(Author $author): RedirectResponse
    {
        try {
            $author->delete();
            $message = 'Author deleted successfully!';
        } catch (\Exception $e) {
            $message = 'Failed to delete the Author. It might be in use.';
        }
        return to_route('author.index')->with('status', $message);
    }
}

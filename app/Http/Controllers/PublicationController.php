<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Category;
use App\Models\Author;

// Make sure to use your Category model if you are going to reference categories
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicationController extends Controller
{
    public function index(): View
    {
        $publications = Publication::all();
        return view('admin.publications.index', compact('publications'));
    }

    public function create(): View
    {
        $authors = Author::all();
        return view('admin.publications.create', compact('authors'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
            'keywords' => 'nullable|string'
        ]);

        Publication::create($validated);
        return to_route('publications.index')->with('success', 'Publication created successfully.');
    }

    public function show(Publication $publication): View
    {
        return view('publications.show', compact('publication'));
    }

    public function edit(Publication $publication): View
    {
        $categories = Category::all();
        return view('admin.publications.edit', compact('publication', 'categories'));
    }

    public function update(Request $request, Publication $publication): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
            'keywords' => 'nullable|string'
        ]);

        $publication->update($validated);
        return to_route('publications.index')->with('success', 'Publication updated successfully.');
    }

    public function destroy(Publication $publication): RedirectResponse
    {
        $publication->delete();
        return to_route('publications.index')->with('success', 'Publication deleted successfully.');
    }
}

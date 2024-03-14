<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeywordRequest;
use App\Http\Requests\UpdateKeywordRequest;
use App\Models\Keyword;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KeywordController extends Controller
{
    public function index(): View
    {
        $keywords = Keyword::all();
        return view('admin.keywords.index', compact('keywords'));
    }

    public function create(): View
    {
        return view('admin.keywords.create');
    }

    public function store(StoreKeywordRequest $request): RedirectResponse
    {
        Keyword::create($request->validated());
        return to_route('keywords.index')->with('success', 'Type created successfully.');
    }

    public function edit(Keyword $keyword): View
    {
        return view('admin.keywords.edit', compact('keyword'));
    }

    public function update(UpdateKeywordRequest $request, Keyword $keyword): RedirectResponse
    {
        $keyword->update($request->validated());
        return to_route('keywords.index')->with('success', 'Type updated successfully.');
    }

    public function destroy(Keyword $keyword): RedirectResponse
    {
        $keyword->delete();
        return to_route('keywords.index')->with('success', 'Type   deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeywordRequest;
use App\Http\Requests\UpdateKeywordRequest;
use App\Models\Keyword;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $keywords = Keyword::search($search)->get();

        return view('admin.keywords.index', compact('keywords', 'search'));
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

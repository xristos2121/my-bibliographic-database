<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeywordRequest;
use App\Http\Requests\UpdateKeywordRequest;
use App\Models\Keyword;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as TitleView;

class KeywordController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $active = $request->query('active');

        $keywords = Keyword::query()
            ->when($search, function ($query, $search) {
                $query->where('keyword', 'like', "%{$search}%");
            })
            ->when(isset($active), function ($query) use ($active) {
                $query->where('active', $active);
            })
            ->paginate(10);

        $totalResults = $keywords->total();

        TitleView::share('pageTitle', 'Keywords');
        return view('admin.keywords.index', compact('keywords', 'search', 'active', 'totalResults'));
    }

    public function create(): View
    {
        TitleView::share('pageTitle', 'Create Keyword');
        return view('admin.keywords.create');
    }

    public function store(StoreKeywordRequest $request): RedirectResponse
    {
        Keyword::create($request->validated());
        return to_route('keywords.index')->with('success', 'Keyword created successfully.');
    }

    public function edit(Keyword $keyword): View
    {
        TitleView::share('pageTitle', 'Edit Keyword');
        return view('admin.keywords.edit', compact('keyword'));
    }

    public function update(UpdateKeywordRequest $request, Keyword $keyword): RedirectResponse
    {
        $keyword->update($request->validated());
        return to_route('keywords.index')->with('success', 'Keyword updated successfully.');
    }

    public function destroy(Keyword $keyword): RedirectResponse
    {
        if ($keyword->publications()->count() > 0) {
            return redirect()->route('keywords.index')->with('error', 'Keyword cannot be deleted because it is associated with one or more publications.');
        }

        $keyword->delete();
        return to_route('keywords.index')->with('success', 'Keyword deleted successfully.');
    }
}

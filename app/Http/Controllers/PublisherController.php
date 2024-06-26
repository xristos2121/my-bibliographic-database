<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublisherRequest;
use App\Http\Requests\UpdatePublisherRequest;
use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as TitleView;

class PublisherController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $publishers = Publisher::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('id', $search);
        })
            ->paginate(10);

        $totalResults = $publishers->total();

        TitleView::share('pageTitle', 'Publishers');
        return view('admin.publisher.index', compact('publishers', 'search', 'totalResults'));
    }

    public function create(): View
    {
        TitleView::share('pageTitle', 'Create Publisher');
        return view('admin.publisher.create');
    }

    public function store(StorePublisherRequest $request): RedirectResponse
    {
        Publisher::create($request->validated());
        return to_route('publisher.index')->with('success', 'Publisher created successfully.');
    }

    public function edit(Publisher $publisher): View
    {
        TitleView::share('pageTitle', 'Edit Publisher');
        return view('admin.publisher.edit', compact('publisher'));
    }

    public function update(UpdatePublisherRequest $request, Publisher $publisher): RedirectResponse
    {
        $publisher->update($request->validated());
        return to_route('publisher.index')->with('success', 'Publisher updated successfully.');
    }

    public function destroy(Publisher $publisher): RedirectResponse
    {
        if ($publisher->publications()->exists()) {
            return to_route('publisher.index')->with('error', 'Cannot delete publisher because it is associated with one or more publications.');
        }

        $publisher->delete();
        return to_route('publisher.index')->with('success', 'Publisher deleted successfully.');
    }
}

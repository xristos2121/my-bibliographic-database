<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\View\View;
use App\Http\Requests\StoreCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as TitleView;

class CollectionController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $collections = Collection::with('children')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            }, function ($query) {
                return $query->whereNull('parent_id');
            });
        $totalResults = $collections->count();
        $collections = $collections->paginate(10);
        TitleView::share('pageTitle', 'Collections');

        return view('admin.collection.index', compact('collections', 'search', 'totalResults'));
    }

    public function children(Collection $collection)
    {
        $children = $collection->children;
        TitleView::share('pageTitle', 'Children of ' . $collection->name);
        return view('admin.collection.children', compact('collection', 'children'));
    }

    public function create()
    {
        $collections = Collection::all();
        $collectionsWithPath = $this->buildCollectionPaths($collections);
        TitleView::share('pageTitle', 'Create Collection');
        return view('admin.collection.create', compact('collections', 'collectionsWithPath'));
    }

    public function store(StoreCollectionRequest $request): RedirectResponse
    {
        Collection::create($request->validated());

        return to_route('collections.index')->with('success', 'Collection created successfully!');
    }

    public function edit(Collection $collection): View
    {
        $collections = Collection::all();
        $collectionsWithPath = $this->buildCollectionPaths($collections);
        TitleView::share('pageTitle', 'Edit Collection');
        return view('admin.collection.edit', compact('collection', 'collections', 'collectionsWithPath'));
    }

    public function update(UpdateCollectionRequest $request, Collection $collection): RedirectResponse
    {
        $collection->update($request->validated());
        return to_route('collections.index')->with('success', 'Collection updated successfully!');
    }

    public function destroy(Collection $collection): RedirectResponse
    {
        try {
            if ($collection->publications()->exists()) {
                return redirect()->route('collections.index')->with('error', 'Collection cannot be deleted because it is associated with publications.');
            }

            $collection->delete();

            return redirect()->route('collections.index')->with('success', 'Collection deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('collections.index')->with('error', 'Failed to delete the collection. It might be in use.');
        }
    }

    private function buildCollectionPaths($collections, $parentId = null, $prefix = '')
    {
        $result = [];
        foreach ($collections->where('parent_id', $parentId) as $collection) {
            $collection->full_path = $prefix . $collection->name;
            $result[] = $collection;
            $result = array_merge($result, $this->buildCollectionPaths($collections, $collection->id, $collection->full_path . ' > '));
        }
        return $result;
    }


}

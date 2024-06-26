<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\View as TitleView;

class PublicationTypeController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = Type::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            });
        }

        $types = $query->paginate(10);
        $totalResults = $types->total();

        TitleView::share('pageTitle', 'Publication Types');
        return view('admin.types.index', compact('types', 'search', 'totalResults'));
    }

    public function create(): View
    {
        TitleView::share('pageTitle', 'Create Publication Type');
        return view('admin.types.create');
    }

    public function store(StoreTypeRequest $request): RedirectResponse
    {
        Type::create($request->validated());
        return redirect()->route('publications_types.index')->with('success', 'Type created successfully.');
    }

    public function edit(Type $type): View
    {
        TitleView::share('pageTitle', 'Edit Publication Type');
        return view('admin.types.edit', compact('type'));
    }

    public function update(UpdateTypeRequest $request, Type $type): RedirectResponse
    {
        $type->update($request->validated());
        return redirect()->route('publications_types.index')->with('success', 'Type updated successfully.');
    }

    public function destroy(Type $type): RedirectResponse
    {
        if ($type->publications()->exists()) {
            return redirect()->route('publications_types.index')->with('error', 'Field is in use and cannot be deleted.');
        }

        $type->delete();
        return redirect()->route('publications_types.index')->with('success', 'Type deleted successfully.');
    }
}

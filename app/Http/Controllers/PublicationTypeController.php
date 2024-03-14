<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Tag;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicationTypeController extends Controller
{
    public function index(): View
    {
        $types = Type::all();
        return view('admin.types.index', compact('types'));
    }

    public function create(): View
    {
        return view('admin.types.create');
    }

    public function store(StoreTypeRequest $request): RedirectResponse
    {
        Type::create($request->validated());
        return to_route('publications_types.index')->with('success', 'Type created successfully.');
    }

    public function edit(Type $type): View
    {
        return view('admin.types.edit', compact('type'));
    }

    public function update(UpdateTypeRequest $request, Type $type): RedirectResponse
    {
        $type->update($request->validated());
        return to_route('publications_types.index')->with('success', 'Type updated successfully.');
    }

    public function destroy(Type $type): RedirectResponse
    {
        $type->delete();
        return to_route('publications_types.index')->with('success', 'Type   deleted successfully.');
    }

}

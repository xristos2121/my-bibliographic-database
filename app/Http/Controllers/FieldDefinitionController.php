<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\CustomField;
use App\Models\FieldDefinition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFieldDefinitionRequest;
use App\Http\Requests\UpdateFieldDefinitionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View as TitleView;

class FieldDefinitionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $fieldDefinitions = FieldDefinition::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->when(isset($type), function ($query) use ($type) {
                return $query->where('type', $type);
            });
        $totalResults = $fieldDefinitions->count();
        $fieldDefinitions = $fieldDefinitions->paginate(10);

        TitleView::share('pageTitle', 'Custom Fields');
        return view('admin.custom_fields.index', compact('fieldDefinitions', 'search', 'totalResults'));
    }

    public function create()
    {
        TitleView::share('pageTitle', 'Create Custom Field');
        return view('admin.custom_fields.create');
    }

    public function store(StoreFieldDefinitionRequest $request)
    {
        FieldDefinition::create($request->all());
        return to_route('custom_fields.index')->with('success', 'Field created successfully.');
    }

    public function edit($id)
    {
        $fieldDefinition = FieldDefinition::findOrFail($id);
        TitleView::share('pageTitle', 'Edit Custom Field');
        return view('admin.custom_fields.edit', compact('fieldDefinition'));
    }

    public function update(UpdateFieldDefinitionRequest $request, int $id)
    {
        $fieldDefinition = FieldDefinition::findOrFail($id);

        if ($fieldDefinition->update($request->validated())) {
            return to_route('custom_fields.index')->with('success', 'Field updated successfully.');
        }

        return to_route('custom_fields.index')->with('error', 'Failed to update.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $fieldDefinition = FieldDefinition::findOrFail($id);
        if ($fieldDefinition->publications()->exists()) {
            return to_route('custom_fields.index')->with('error', 'Field is in use and cannot be deleted.');
        }
        $fieldDefinition->delete();
        return to_route('custom_fields.index')->with('success', 'Custom Field deleted successfully.');
    }
}

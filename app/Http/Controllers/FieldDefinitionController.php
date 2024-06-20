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
class FieldDefinitionController extends Controller
{
    public function index()
    {
        $fieldDefinitions = FieldDefinition::all();
        return view('admin.custom_fields.index', compact('fieldDefinitions'));
    }

    public function create()
    {
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

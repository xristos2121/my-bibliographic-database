<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePublicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'active' => $this->has('active')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'active' => 'boolean',
            'publication_date' => 'nullable|date_format:Y-m',
            'type_id' => 'required|exists:publication_types,id',
            'category_id' => 'nullable|exists:categories,id',
            'authors' => 'required|array',
            'authors.*' => 'integer|exists:authors,id',
            'keywords' => 'nullable|array',
            'keywords.*' => 'integer|exists:keywords,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'category_publication' => 'nullable|array',
            'category_publication.*' => 'integer|exists:categories,id',
            'file' => 'nullable|file|mimes:pdf',
            'custom_fields' => 'nullable|array',
            'custom_fields.*.field_definition_id' => 'required_with:custom_fields|integer|exists:field_definitions,id',
            'custom_fields.*.value' => 'required_with:custom_fields|string',
            'uris' => 'nullable|array',
            'uris.*' => 'url',
        ];
    }
}

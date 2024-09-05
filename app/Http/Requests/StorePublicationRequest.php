<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicationRequest extends FormRequest
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
            'active' => $this->has('active'),
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
            'publication_date' => 'nullable|date_format:Y-m',
            'active' => 'nullable|boolean',
            'type_id' => 'required|exists:publication_types,id',
            'collection_id' => 'nullable|exists:collections,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'authors' => 'required|array',
            'authors.*' => 'integer|exists:authors,id',
            'keywords' => 'nullable|array',
            'keywords.*' => 'string|max:255',
            'collection_publication' => 'nullable|array',
            'collection_publication.*' => 'integer|exists:collections,id',
            'file' => 'nullable|file|mimes:pdf',
            'link' => 'nullable|url',
            'custom_fields' => 'nullable|array',
            'custom_fields.*.type_id' => 'required_with:custom_fields|integer|exists:field_definitions,id',
            'custom_fields.*.value' => 'required_with:custom_fields|string',
            'uris' => 'nullable|array',
            'uris.*' => 'nullable|url',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->file('file') && !$this->input('link')) {
                $validator->errors()->add('file_or_link', 'Either a file or a link must be provided.');
            }
        });
    }
}

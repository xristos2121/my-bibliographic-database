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
            'active' => 'boolean',
            'publication_date' => 'nullable|date_format:Y-m',
            'type_id' => 'required|exists:publication_types,id',
            'collection_id' => 'nullable|exists:collections,id',
            'authors' => 'required|array',
            'authors.*' => 'integer|exists:authors,id',
            'keywords' => 'array',
            'keywords.*' => 'string|max:255',
            'publisher_id' => 'nullable|exists:publishers,id',
            'collection_publication' => 'nullable|array',
            'collection_publication.*' => 'integer|exists:collections,id',
            'file' => 'nullable|file|mimes:pdf|max:51200',
            'link' => 'nullable|url',
            'custom_fields' => 'nullable|array',
            'custom_fields.*.field_definition_id' => 'required_with:custom_fields|integer|exists:field_definitions,id',
            'custom_fields.*.value' => 'required_with:custom_fields|string',
            'uris' => 'nullable|array',
            'uris.*' => 'url',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->file && !$this->link) {
                $validator->errors()->add('file_or_link', 'Either a file or a link must be provided.');
            }
        });
    }
}

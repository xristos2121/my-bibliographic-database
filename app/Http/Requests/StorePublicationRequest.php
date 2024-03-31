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
            'publication_date' => 'nullable|date',
            'type_id' => 'required|exists:publication_types,id',
            'category_id' => 'nullable|exists:categories,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'authors' => 'required|array',
            'authors.*' => 'integer|exists:authors,id',
            'keywords' => 'nullable|array',
            'keywords.*' => 'integer|exists:keywords,id',
            'category_publication' => 'nullable|array',
            'category_publication.*' => 'integer|exists:categories,id'
        ];
    }
}

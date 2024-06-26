<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
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
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:authors', // Replace 'authors' with your actual table name
            'affiliation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'orcid_id' => 'nullable|string|max:255|unique:authors', // Replace 'authors' with your actual table name
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg', // Adjust mime types and max size as necessary
            'biography' => 'nullable|string',
            'research_interests' => 'nullable|string',
        ];
    }
}

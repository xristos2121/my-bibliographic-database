<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
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
        // Assuming 'author' is the route key name for the Author model
        $authorId = $this->author->id;

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // Make sure 'authors' is your actual table name, and 'email' is the actual column name
            'email' => 'required|string|email|max:255|unique:authors,email,' . $authorId,
            'affiliation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            // Ensure 'orcid_id' is the correct column name, and 'authors' is the actual table name
            'orcid_id' => 'nullable|string|max:255|unique:authors,orcid_id,' . $authorId,
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'biography' => 'nullable|string',
            'research_interests' => 'nullable|string',
        ];
    }


}

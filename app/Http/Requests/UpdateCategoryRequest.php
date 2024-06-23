<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateCategoryRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                Rule::unique('categories')->ignore($this->category),
            ],
           'slug' => [
                'required',
                'string',
                Rule::unique('categories')->ignore($this->category),
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) {
                    if ($value && $this->category->id == $value) {
                        $fail('The category cannot be its own parent.');
                    }
                    if ($value && $this->isDescendant($this->category, $value)) {
                        $fail('The category cannot be a descendant of itself.');
                    }
                },
            ],
        ];
    }

    protected function isDescendant($category, $parentId)
    {
        $parent = \App\Models\Category::find($parentId);

        while ($parent) {
            if ($parent->id == $category->id) {
                return true;
            }
            $parent = $parent->parent;
        }

        return false;
    }
}

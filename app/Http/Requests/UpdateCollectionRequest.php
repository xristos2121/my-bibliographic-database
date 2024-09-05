<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateCollectionRequest extends FormRequest
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
                Rule::unique('collections')->ignore($this->collection),
            ],
           'slug' => [
                'required',
                'string',
                Rule::unique('collections')->ignore($this->collection),
            ],
            'parent_id' => [
                'nullable',
                'exists:collections,id',
                function ($attribute, $value, $fail) {
                    if ($value && $this->collection->id == $value) {
                        $fail('The collection cannot be its own parent.');
                    }
                    if ($value && $this->isDescendant($this->collection, $value)) {
                        $fail('The collection cannot be a descendant of itself.');
                    }
                },
            ],
        ];
    }

    protected function isDescendant($collection, $parentId)
    {
        $parent = \App\Models\Collection::find($parentId);

        while ($parent) {
            if ($parent->id == $collection->id) {
                return true;
            }
            $parent = $parent->parent;
        }

        return false;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvancedSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type.*' => 'required|in:entire_document,title,author,abstract,keyword,publisher',
            'lookfor.*' => 'nullable|string',
            'fromMonthYear' => 'nullable|date_format:Y-m',
            'untilMonthYear' => 'nullable|date_format:Y-m'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ListSummaryRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'filter' => ['sometimes', 'array', 'nullable'],
            'filter.title' => ['sometimes', 'string', 'nullable'],
            'filter.author' => ['sometimes', 'string', 'nullable'],
            'filter.year' => ['sometimes', 'string', 'nullable'],
            'filter.user_id' => ['sometimes', 'uuid', 'nullable'],
            'include' => ['sometimes', 'string'],
            'exact' => ['sometimes', 'boolean'],
        ];
    }
}

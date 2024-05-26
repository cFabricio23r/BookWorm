<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Supports\Traits\WithPasswordRulesTrait;

class LoginRequest extends FormRequest
{
    use WithPasswordRulesTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['sometimes', 'email', 'string'],
            'phone_number' => ['sometimes', 'string', 'nullable'],
            'password' => ['required', 'string', $this->getPasswordRules()],
        ];
    }
}

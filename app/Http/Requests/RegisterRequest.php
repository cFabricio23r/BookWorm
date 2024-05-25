<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Supports\Traits\WithPasswordRulesTrait;

class RegisterRequest extends FormRequest
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
            'user' => ['array', 'required'],
            'user.name' => ['string', 'required', 'max:50'],
            'user.lastname' => ['string', 'sometimes', 'nullable', 'max:50'],
            'user.email' => ['string', 'required', 'email', (new Unique('users', 'email'))->withoutTrashed()],
            'user.password' => ['string', 'required', $this->getPasswordRules()],
        ];
    }
}

<?php

namespace App\DTOs;

use Illuminate\Foundation\Http\FormRequest;

class LoginDTO extends AbstractDTO
{
    protected array $requiredFields = ['password', 'email'];

    public function __construct(
        public ?string $password,
        public ?string $email,
    ) {

    }

    public static function FromRequest(FormRequest $request): LoginDTO
    {
        return new self(
            password: get_request_string_default_null('password'),
            email: get_request_string_default_null('email'),
        );
    }
}

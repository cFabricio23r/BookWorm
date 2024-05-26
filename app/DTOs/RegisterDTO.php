<?php

namespace App\DTOs;

use Illuminate\Foundation\Http\FormRequest;

class RegisterDTO extends AbstractDTO
{
    protected array $requiredFields = ['name', 'password', 'email'];

    public function __construct(
        public ?string $name,
        public ?string $lastname,
        public ?string $password,
        public ?string $email,
    ) {

    }

    public static function FromRequest(FormRequest $request): RegisterDTO
    {
        return new self(
            name: get_request_string_default_null('user.name'),
            lastname: get_request_string_default_null('user.lastname'),
            password: get_request_string_default_null('user.password'),
            email: get_request_string_default_null('user.email'),
        );
    }
}

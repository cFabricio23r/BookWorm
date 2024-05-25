<?php

namespace App\Actions;

use App\DTOs\LoginDTO;
use App\Http\Resources\AuthResource;
use App\Responses\DataResponse;
use Illuminate\Support\Facades\Auth;
use JustSteveKing\StatusCode\Http;

class LoginAction
{
    public function execute(LoginDTO $loginDTO): DataResponse
    {
        if ($loginDTO->isRequiredFieldFilled()) {
            $credentials = [
                'email' => $loginDTO->email,
                'password' => $loginDTO->password,
            ];

            if (Auth::guard('web')->attempt($credentials)) {
                return new DataResponse(
                    data: [
                        'token' => (new CreateUserTokenAction())->execute(Auth::user()),
                        'user' => new AuthResource(Auth::user()),
                    ],
                    status: Http::OK,
                    message: 'User logged in successfully'
                );
            }

            return new DataResponse(
                status: Http::UNAUTHORIZED,
                message: 'Invalid credentials'
            );
        }

        return new DataResponse(
            status: Http::UNPROCESSABLE_ENTITY,
            message: 'Please fill all required fields'
        );
    }
}

<?php

namespace App\Http\Controllers\API\v1;

use App\Actions\LoginAction;
use App\Actions\RegisterAction;
use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Responses\DataResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginAction $action): DataResponse
    {
        $data = LoginDTO::FromRequest($request);

        return $action->execute($data);
    }

    public function logout(): DataResponse
    {
        /** @var User|null $user */
        $user = auth()->user();
        $user?->tokens()->where('name', 'wep-app')->delete();

        return new DataResponse(
            message: 'User logged out successfully'
        );
    }

    public function register(RegisterAction $action, RegisterRequest $request): DataResponse
    {
        $dto = RegisterDTO::FromRequest($request);

        return $action->execute($dto);
    }
}

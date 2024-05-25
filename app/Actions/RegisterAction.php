<?php

namespace App\Actions;

use App\DTOs\RegisterDTO;
use App\Http\Resources\AuthResource;
use App\Models\User;
use App\Responses\DataResponse;
use Illuminate\Support\Facades\Hash;
use JustSteveKing\StatusCode\Http;

class RegisterAction
{
    public function execute(RegisterDTO $registerDTO): DataResponse
    {
        if ($registerDTO->isRequiredFieldFilled()) {
            $user = new User($registerDTO->toArrayWithoutNull());
            $user->password = Hash::make($registerDTO->password);
            $user->save();

            return new DataResponse(
                data: new AuthResource($user),
                status: Http::CREATED,
                message: 'User created successfully'
            );
        }

        return new DataResponse(
            status: Http::UNPROCESSABLE_ENTITY,
            message: 'Please fill all required fields'
        );
    }
}

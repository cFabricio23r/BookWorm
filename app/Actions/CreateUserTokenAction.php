<?php

namespace App\Actions;

use App\Models\User;

class CreateUserTokenAction
{
    public function execute(User $user): string
    {
        $user->tokens()->where('name')->delete();

        return $user->createToken('web-app')->plainTextToken;
    }
}

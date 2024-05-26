<?php

namespace Supports\Traits;

use Illuminate\Validation\Rules\Password;

trait WithPasswordRulesTrait
{
    private function getPasswordRules(): Password
    {
        return Password::min(8)
            ->numbers()
            ->mixedCase();
    }
}

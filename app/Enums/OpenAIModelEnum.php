<?php

namespace App\Enums;

use Supports\Traits\EnumTrait;

enum OpenAIModelEnum: string
{
    use EnumTrait;
    case GPT3 = 'gpt-4-turbo';
    case GPT4 = 'gpt-4-turbo2';
}

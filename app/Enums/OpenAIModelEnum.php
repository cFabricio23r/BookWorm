<?php

namespace App\Enums;

use Supports\Traits\EnumTrait;

enum OpenAIModelEnum: string
{
    use EnumTrait;
    case GPT3 = 'gpt-3.5-turbo-0125';
    case GPT4 = 'gpt-4o';
}

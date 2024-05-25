<?php

namespace App\DTOs;

use Illuminate\Foundation\Http\FormRequest;

class ChatSummaryDTO extends AbstractDTO
{
    protected array $requiredFields = ['question'];

    public function __construct(
        public ?string $question = null,
    ) {

    }

    public static function FromRequest(FormRequest $request): ChatSummaryDTO
    {
        return new self(
            question: get_request_string_default_null('question'),
        );
    }
}

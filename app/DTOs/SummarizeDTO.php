<?php

namespace App\DTOs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class SummarizeDTO extends AbstractDTO
{
    protected array $requiredFields = [];

    public function __construct(
        public UploadedFile|string|null $file = null,
    ) {

    }

    public static function FromRequest(FormRequest $request): SummarizeDTO
    {
        return new self(
            file: $request->file('file'),
        );
    }
}

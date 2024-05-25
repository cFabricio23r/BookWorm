<?php

namespace App\DTOs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class StoreEditSummary extends AbstractDTO
{
    protected array $requiredFields = ['file'];

    public function __construct(
        public UploadedFile|string|null $file = null,
    ) {

    }

    public static function FromRequest(FormRequest $request): StoreEditSummary
    {
        return new self(
            file: $request->file('file'),
        );
    }
}

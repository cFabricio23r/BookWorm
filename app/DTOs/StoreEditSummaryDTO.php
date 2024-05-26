<?php

namespace App\DTOs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Smalot\PdfParser\PDFObject;

class StoreEditSummaryDTO extends AbstractDTO
{
    protected array $requiredFields = ['file'];

    public function __construct(
        public UploadedFile|PDFObject|string|null $file = null,
    ) {

    }

    public static function FromRequest(FormRequest $request): StoreEditSummaryDTO
    {
        return new self(
            file: $request->file('file'),
        );
    }
}

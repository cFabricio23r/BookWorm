<?php

namespace App\DTOs;

use App\Contracts\DTOContract;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\Data;
use Supports\Traits\DTOTrait;

abstract class AbstractDTO extends Data implements DTOContract
{
    use DTOTrait;

    protected array $requiredFields = [];

    abstract public static function FromRequest(FormRequest $request): self;
}

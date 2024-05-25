<?php

namespace Supports\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait UUIDTrait
{
    public static function bootUUIDTrait(): void
    {
        static::creating(function (Model $model) {
            $model->keyType = 'string';

            $model->incrementing = false;

            $model->id = Str::uuid()->toString();
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}

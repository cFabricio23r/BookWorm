<?php

namespace Supports\Traits;

use Illuminate\Support\Collection;

trait EnumTrait
{
    public static function values(): array
    {
        return collect(self::cases())->map(function (self $enum) {
            return $enum->value;
        })->toArray();
    }

    protected static function resources(): array
    {
        return collect(self::cases())->map(function (self $enum) {
            return [
                'name' => $enum->value,
                'label' => $enum->label(),
            ];
        })->toArray();
    }

    /**
     * @return Collection<int, mixed>
     */
    public static function data(): Collection
    {
        return collect(self::cases())->map(function (self $enum) {
            return $enum;
        });
    }
}

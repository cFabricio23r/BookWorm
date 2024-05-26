<?php

namespace Supports\Traits;

use Illuminate\Support\Collection;

trait DTOTrait
{
    public function toArrayWithoutNull(): array
    {
        return collect($this->toArray())->filter(fn ($value) => $this->verifyField($value))->toArray();
    }

    private function verifyField(mixed $value): bool
    {
        if (is_string($value) && strlen($value) === 0) {
            return true;
        }

        if (is_null($value)) {
            return false;
        }

        return true;
    }

    public function isFilled(string $property): bool
    {
        if (empty($this->{$property})) {
            return false;
        }

        return true;
    }

    public function isNotFilled(string $property): bool
    {
        if ($this->{$property} instanceof Collection) {
            if ($this->{$property}->count() == 0) {
                return true;
            }

            return false;
        }

        if (is_numeric($this->{$property}) === false && empty($this->{$property})) {
            return true;
        }

        return false;
    }

    public function isRequiredFieldFilled(): bool
    {
        return collect($this->requiredFields)->map(function (string $field) {
            if ($this->isNotFilled($field)) {
                return $field;
            }

            return null;
        })->filter()->isEmpty();
    }
}

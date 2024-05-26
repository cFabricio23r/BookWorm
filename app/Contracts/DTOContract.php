<?php

namespace App\Contracts;

interface DTOContract
{
    public function toArrayWithoutNull(): array;

    public function isFilled(string $property): bool;

    public function isRequiredFieldFilled(): bool;

    public function isNotFilled(string $property): bool;
}

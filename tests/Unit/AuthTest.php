<?php

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;

uses(

)->group('unit');

/** DTOs */
test('LoginDTO has all fields', function () {
    $data = new LoginDTO(
        email: fake()->email,
        password: fake()->password,
    );

    expect($data->email)->not->toBeNull()
        ->and($data->password)->not->toBeNull();
});

test('RegisterDTO has all fields', function () {
    $data = new RegisterDTO(
        name: fake()->name,
        lastname: fake()->lastName,
        email: fake()->email,
        password: fake()->password,
    );

    expect($data->name)->not->toBeNull()
        ->and($data->lastname)->not->toBeNull()
        ->and($data->email)->not->toBeNull()
        ->and($data->password)->not->toBeNull();
});

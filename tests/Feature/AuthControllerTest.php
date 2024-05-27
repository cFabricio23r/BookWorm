<?php

use Database\Factories\UserFactory;

uses()->group('feature');

test('User can login with valid credentials', function () {
    $password = 'passworD123';
    $user = UserFactory::new()->create(['password' => Hash::make($password)]);

    $data = [
        'email' => $user->email,
        'password' => $password,
    ];
    $response = $this->postJson(route('auth.login'), $data);

    $response->assertOk();
    expect($response->json('data.token'))->not->toBeNull()
        ->and($response->json('data.user.id'))->not->toBeNull();

});

test('User cannot login with valid credentials', function () {
    $password = 'passworD123';
    $user = UserFactory::new()->create(['password' => Hash::make($password)]);

    $data = [
        'email' => $user->email,
        'password' => 'passworD123Wrong',
    ];
    $response = $this->postJson(route('auth.login'), $data);

    $response->assertUnauthorized();
});

it('user can register', function () {
    config(['mail.active' => true]);

    $body = [
        'user' => [
            'name' => fake()->name,
            'lastname' => fake()->lastName,
            'email' => fake()->email,
            'password' => '12312312Dd',
        ],
    ];

    $response = $this->postJson(route('auth.register'), $body);

    $response->assertCreated();

    expect($response->json('data.name'))->toBe($body['user']['name'])
        ->and($response->json('data.lastname'))->toBe($body['user']['lastname'])
        ->and($response->json('data.email'))->toBe($body['user']['email']);

    $this->assertDatabaseCount('users', 1);
});

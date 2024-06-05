<?php

use Database\Factories\SummaryFactory;
use Database\Factories\UserFactory;
use Illuminate\Http\UploadedFile;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Chat\CreateResponse;

uses()->group('feature');

test('User can create a book summary', function () {
    $user = UserFactory::new()->create();
    $pdf = $this->rootDir.'/samples/test_file.pdf';

    $pdf = UploadedFile::fake()->createWithContent('test_file.pdf', file_get_contents($pdf));

    $this->actingAs($user);

    $data = [
        'file' => $pdf,
    ];

    $arguments = [
        'title' => 'Test Title',
        'author' => 'Test Author',
        'year' => '2022',
        'key_aspects' => [
            [
                'aspect' => 'Test Aspect',
                'page' => '1',
                'description' => 'Test Description',
            ],
        ],
        'summary' => 'Test Summary',
    ];

    $function_call_name = 'book_summary';

    OpenAI::fake([
        CreateResponse::fake([
            'choices' => [
                [
                    'message' => [
                        'function_call' => [
                            'arguments' => json_encode($arguments),
                            'name' => $function_call_name,
                        ],
                    ],
                ],
            ],
        ]),
    ]);

    $response = $this->postJson(route('summary.store'), $data);

    $response->assertOk();

    expect($response->json('data.id'))->not->toBeNull()
        ->and($response->json('data.title'))->toBe($arguments['title']);

    $this->assertDatabaseCount('summaries', 1);
})->skip('Need to fix the test');

test('User can ask a question related from a summary', function () {
    $user = UserFactory::new()->create();
    $summary = SummaryFactory::new()->withUser($user)->create();

    $this->actingAs($user);

    $data = [
        'question' => 'What is the summary of this book?',
    ];

    $answer = 'This is the summary of the book';

    OpenAI::fake([
        CreateResponse::fake([
            'choices' => [
                [
                    'message' => [
                        'content' => $answer,
                    ],
                ],
            ],
        ]),
    ]);

    $response = $this->postJson(route('summary.chat', [
        'summary' => $summary->id,
    ]), $data);

    $response->assertOk();

    expect($response->json('data.answer'))->not->toBeNull()
        ->and($response->json('data.answer'))->toBe($answer);

    $this->assertDatabaseCount('summaries', 1);
})->skip('Need to fix the test');

test('User can get details of a summary', function () {
    $user = UserFactory::new()->create();
    $summary = SummaryFactory::new()->withUser($user)->create();

    $this->actingAs($user);

    $response = $this->getJson(route('summary.show', [
        'summary' => $summary->id,
    ]));

    $response->assertOk();

    expect($response->json('data.id'))->not->toBeNull()
        ->and($response->json('data.title'))->toBe($summary->title);

    $this->assertDatabaseCount('summaries', 1);
});

test('User can get list of summaries', function () {
    $user = UserFactory::new()->create();
    $count = 5;
    SummaryFactory::new()->count($count)->withUser($user)->create();
    SummaryFactory::new()->count($count)->withUser()->create();

    $this->actingAs($user);

    $response = $this->getJson(route('summary.index'));

    $response->assertOk();

    expect($response->json('data'))->toHaveCount($count);

    $this->assertDatabaseCount('summaries', 10);
});

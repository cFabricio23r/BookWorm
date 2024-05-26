<?php

use App\Actions\ChatSummaryAction;
use App\Actions\ListSummaryAction;
use App\Actions\ShowSummaryAction;
use App\Actions\StoreSummaryAction;
use App\Builders\SummaryQueryBuilder;
use App\DTOs\ChatSummaryDTO;
use App\DTOs\StoreEditSummaryDTO;
use App\Http\Requests\ShowSummaryRequest;
use App\Models\Summary;
use Database\Factories\SummaryFactory;
use Database\Factories\UserFactory;
use Illuminate\Http\UploadedFile;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Chat\CreateResponse;

uses(

)->group('unit');

/** DTOs */
test('StoreEditSummaryDTO has all fields', function () {
    $data = new StoreEditSummaryDTO(
        file: UploadedFile::fake()->create('test.pdf'),
    );

    expect($data->file)->not->toBeNull();
});

test('ChatSummaryDTO has all fields', function () {
    $data = new ChatSummaryDTO(
        question: fake()->sentence(),
    );

    expect($data->question)->not->toBeNull();
});

/** Queries */
test('Summary has new eloquent query', function () {
    $query = Summary::query();
    $reflection = new ReflectionClass($query);

    expect($reflection->getName())->toBe(SummaryQueryBuilder::class);
});

test('Summary eloquent query can get summary by user', function () {
    $user = UserFactory::new()->create();
    $summary = SummaryFactory::new()->withUser($user)->create();

    /* @var $query SummaryQueryBuilder */
    $query = Summary::query();

    $result = $query->whereUser($user->id)->get();

    expect($result)->toHaveCount(1)
        ->and($summary->id)->toBe($result->get(0)['id']);
});

/** Actions */
test('ShowSummaryAction can get summary by id', function () {
    $user = UserFactory::new()->create();

    $this->actingAs($user);

    $summary = SummaryFactory::new()->withUser($user)->create();

    $request = app()->make(ShowSummaryRequest::class);

    $request->query->set('include', 'user');

    $result = (new ShowSummaryAction())->execute($summary, $request);

    expect($result->data->resource->id)->toBe($summary->id)
        ->and($result->data->resource->user->id)->toBe($user->id);
});

test('ListSummaryAction can get summaries by user', function () {
    $user = UserFactory::new()->create();
    $count = 5;
    $this->actingAs($user);

    SummaryFactory::new()->count($count)->withUser($user)->create();
    SummaryFactory::new()->count($count)->withUser()->create();

    request()->query->set('include', 'user');

    $result = (new ListSummaryAction())->execute();

    expect($result)->toHaveCount($count)
        ->and($result[0]->relationLoaded('user'))->toBeTrue();
});

test('ListSummaryAction can include from filters when include is empty', function () {
    $user = UserFactory::new()->create();
    $count = 5;
    $this->actingAs($user);

    SummaryFactory::new()->count($count)->withUser($user)->create();
    SummaryFactory::new()->count($count)->withUser()->create();

    request()->query->set('include', null);

    $result = (new ListSummaryAction())->execute();

    expect($result)->toHaveCount($count)
        ->and($result[0]->relationLoaded('user'))->toBeFalse();
});

test('StoreSummaryAction can store a summary', function () {
    $pdf = $this->rootDir.'/samples/test_file.pdf';

    $user = UserFactory::new()->create();
    $this->actingAs($user);

    $data = new StoreEditSummaryDTO(
        file: $pdf,
    );

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

    $result = (new StoreSummaryAction())->execute($data);

    expect($result->data->resource->user_id)->toBe($user->id)
        ->and($result->data->resource->title)->toBe($arguments['title'])
        ->and($result->data->resource->author)->toBe($arguments['author'])
        ->and($result->data->resource->year)->toBe($arguments['year'])
        ->and($result->data->resource->key_aspects)->toBe($arguments['key_aspects'])
        ->and($result->data->resource->summary)->toBe($arguments['summary']);
});

test('ChatSummaryAction can ask a question related with the PDF', function () {
    $user = UserFactory::new()->create();
    $this->actingAs($user);

    $summary = SummaryFactory::new()->withUser($user)->create();

    $chat = new ChatSummaryDTO(
        question: 'What is the summary of this book?'
    );

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

    $result = (new ChatSummaryAction())->execute($chat, $summary);

    expect($result->data['answer'])->toBe($answer);
});

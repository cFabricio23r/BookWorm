<?php

namespace Supports\Traits;

use App\Enums\OpenAIModelEnum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Assistants\AssistantResponse;
use OpenAI\Responses\Assistants\Files\AssistantFileResponse;
use OpenAI\Responses\Files\CreateResponse;
use OpenAI\Responses\StreamResponse;
use OpenAI\Responses\Threads\Messages\ThreadMessageListResponse;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use OpenAI\Responses\Threads\ThreadResponse;

trait OpenAITrait
{
    public function uploadFile(UploadedFile $file): CreateResponse
    {
        Storage::disk('local')->put($file->getClientOriginalName(), fopen($file, 'rb'));

        $file = storage_path('app/'.$file->getClientOriginalName());

        return OpenAI::files()->upload([
            'purpose' => 'assistants',
            'file' => fopen($file, 'rb'),
        ]);
    }

    public function createAssistant(string $model, array $options): AssistantResponse
    {
        return OpenAI::assistants()->create([
            'model' => $model,
            'name' => $options['name'],
            'instructions' => $options['instructions'],
            'tools' => [
                [
                    'type' => 'retrieval',
                ],
            ],
        ]);
    }

    public function assignFileToAssistant($assistantId, $fileId): AssistantFileResponse
    {
        return OpenAI::assistants()->files()->create($assistantId, [
            'file_id' => $fileId,
        ]);
    }

    public function createThread(): ThreadResponse
    {
        return OpenAI::threads()->create([]);
    }

    public function runThread(string $assistantId, string $message, string $threadId): StreamResponse
    {
        $this->sendMessageToThread($threadId, $message);

        $run = OpenAI::threads()->runs()->createStreamed(
            $threadId,
            [
                'assistant_id' => $assistantId,
            ]
        );

        foreach ($run as $response) {
            if (connection_aborted()) {
                break;
            }

            if ($response->event === 'thread.run.requires_action') {
                //dump($response);
            }

            if ($response->event === 'thread.run.completed') {
                //dump($response);
            }
        }

        return $run;
    }

    public function loadAnswer($threadId): mixed
    {
        $messageList = OpenAI::threads()->messages()->list(
            threadId: $threadId,
        );

        $result = $messageList->data[0]->content[0]->text->value;

        if (str_contains($result, '```json')) {
            $result = get_string_between($result, '```json', '```');
        }

        return json_validate($result) ? json_decode($result, true) : $result;
    }

    public function sendMessageToThread(string $threadId, string $message): ThreadMessageResponse
    {
        return OpenAI::threads()->messages()->create($threadId, $this->userMessage($message));
    }

    public function getMessagesFromThread(string $threadId): ThreadMessageListResponse
    {
        return OpenAI::threads()->messages()->list($threadId);
    }

    public function startAssistantWithThread(UploadedFile $file, array $assistantConfig, string $initialMessage): array
    {
        $fileResponse = $this->uploadFile($file);

        $assistantResponse = $this->createAssistant(OpenAIModelEnum::GPT3->value, $assistantConfig);

        $this->assignFileToAssistant($assistantResponse->id, $fileResponse->id);

        $threadResponse = $this->createThread();

        $this->runThread($assistantResponse->id, $initialMessage, $threadResponse->id);

        $answer = $this->loadAnswer($threadResponse->id);

        $response = [
            'assistant_id' => $assistantResponse->id,
            'file_id' => $fileResponse->id,
            'thread_id' => $threadResponse->id,
        ];

        return is_array($answer) ? [...$response, ...$answer] : [...$response, 'answer' => $answer];
    }

    public function chatWithExistingThread(string $assistantId, string $message, string $threadId): mixed
    {
        $this->runThread($assistantId, $message, $threadId);

        return $this->loadAnswer($threadId);
    }

    public function chatOpenAI(OpenAIModelEnum $enum, ?array $messages = null, ?array $functions = null): mixed
    {
        $options = [
            'model' => $enum->value,
            'functions' => $functions,
            'messages' => $messages,
        ];

        $result = OpenAI::chat()->create($options);

        return $this->processResult($result, $functions);
    }

    private function processResult($result, $functions): mixed
    {
        return $functions ? json_decode($result['choices'][0]['message']['function_call']['arguments'], true) : $result['choices'][0]['message']['content'];
    }

    public function userMessage(string $message): array
    {
        return $this->createMessage('user', $message);
    }

    /**
     * @return string[]
     */
    public function systemMessage(string $message): array
    {
        return $this->createMessage('system', $message);
    }

    /**
     * @return string[]
     */
    public function assistantMessage(string $function): array
    {
        return $this->createMessage('assistant', $function);
    }

    /**
     * @return string[]
     */
    private function createMessage(string $role, string $content): array
    {
        return [
            'role' => $role,
            'content' => $content,
        ];
    }
}

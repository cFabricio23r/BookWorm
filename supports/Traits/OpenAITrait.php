<?php

namespace Supports\Traits;

use App\Enums\OpenAIModelEnum;
use OpenAI\Laravel\Facades\OpenAI;

trait OpenAITrait
{
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

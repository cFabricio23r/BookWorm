<?php

namespace App\Actions;

use App\DTOs\ChatSummaryDTO;
use App\Enums\OpenAIModelEnum;
use App\Models\Summary;
use App\Responses\DataResponse;
use Exception;
use JustSteveKing\StatusCode\Http;
use Supports\Traits\OpenAITrait;

class ChatSummaryAction
{
    use OpenAITrait;

    /**
     * @throws Exception
     */
    public function execute(ChatSummaryDTO $chatSummaryDTO, Summary $summary): DataResponse
    {
        if ($chatSummaryDTO->isRequiredFieldFilled()) {
            $question = $this->userMessage($chatSummaryDTO->question);
            $context = $summary->context;

            $result = $this->chat($summary->context, [$question]);
            $context[] = $question;
            $context[] = $this->assistantMessage($result);

            $summary->update([
                'context' => $context,
            ]);

            return new DataResponse(
                data: [
                    'answer' => $result,
                ],
                status: Http::OK,
                message: 'Summary created successfully'
            );
        }

        return new DataResponse(
            status: Http::UNPROCESSABLE_ENTITY,
            message: 'Please fill all required fields'
        );

    }

    private function chat(array $context, array $question): mixed
    {
        return $this->chatOpenAI(
            OpenAIModelEnum::GPT4,
            [
                ...$context,
                ...$question,
            ],
        );
    }
}

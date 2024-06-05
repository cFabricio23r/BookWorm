<?php

namespace App\Actions;

use App\DTOs\ChatSummaryDTO;
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
        if (! $chatSummaryDTO->isRequiredFieldFilled()) {
            return new DataResponse(
                status: Http::UNPROCESSABLE_ENTITY,
                message: 'Please fill all required fields'
            );
        }

        try {
            $answer = $this->chatWithExistingThread($summary->assistant_id, $chatSummaryDTO->question, $summary->thread_id);

            return new DataResponse(
                data: [
                    'answer' => $answer,
                ],
                status: Http::OK,
                message: 'Summary created successfully'
            );
        } catch (Exception $exception) {
            report($exception);

            return new DataResponse(
                status: Http::INTERNAL_SERVER_ERROR,
                message: $exception->getMessage()
            );
        }
    }
}

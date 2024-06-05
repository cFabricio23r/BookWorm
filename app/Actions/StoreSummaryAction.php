<?php

namespace App\Actions;

use App\DTOs\StoreEditSummaryDTO;
use App\Http\Resources\SummaryResource;
use App\Models\Summary;
use App\Responses\DataResponse;
use Exception;
use JustSteveKing\StatusCode\Http;
use Supports\Traits\OpenAITrait;

class StoreSummaryAction
{
    use OpenAITrait;

    /**
     * @throws Exception
     */
    public function execute(StoreEditSummaryDTO $summarizeDTO): DataResponse
    {
        if (!$summarizeDTO->isRequiredFieldFilled()) {
            return new DataResponse(
                status: Http::UNPROCESSABLE_ENTITY,
                message: 'Please fill all required fields'
            );
        }
        try {
            $result = $this->startAssistantWithThread(
                $summarizeDTO->file,
                config('assistants.book_worm'),
                config('prompts.initial_message')
            );

            $summary = new Summary([
                ...$result,
                'user_id' => auth()->id(),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            $summary->save();

            return new DataResponse(
                data: new SummaryResource($summary),
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

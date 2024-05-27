<?php

namespace App\Actions;

use App\DTOs\StoreEditSummaryDTO;
use App\Enums\OpenAIModelEnum;
use App\Http\Resources\SummaryResource;
use App\Models\Summary;
use App\Responses\DataResponse;
use Exception;
use Illuminate\Http\UploadedFile;
use JustSteveKing\StatusCode\Http;
use Smalot\PdfParser\Page;
use Smalot\PdfParser\Parser;
use Smalot\PdfParser\PDFObject;
use Spatie\LaravelData\Support\Types\Type;
use Supports\Traits\OpenAITrait;

class StoreSummaryAction
{
    use OpenAITrait;

    /**
     * @throws Exception
     */
    public function execute(StoreEditSummaryDTO $summarizeDTO): DataResponse
    {
        if ($summarizeDTO->isRequiredFieldFilled()) {
            $book = $this->parseAndProcessPdf($summarizeDTO->file);

            $result = $this->generateSummary($book);

            $summary = new Summary([
                ...$result,
                'user_id' => auth()->id(),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'context' => $book,
            ]);

            $summary->save();

            return new DataResponse(
                data: new SummaryResource($summary),
                status: Http::OK,
                message: 'Summary created successfully'
            );
        }

        return new DataResponse(
            status: Http::UNPROCESSABLE_ENTITY,
            message: 'Please fill all required fields'
        );

    }

    /**
     * @param  array<Type>  $book
     */
    private function generateSummary(array $book): mixed
    {
        return $this->chatOpenAI(
            OpenAIModelEnum::GPT4,
            [
                $this->systemMessage(config('prompts.function_request')),
                ...$book,
            ],
            [
                config('prompts.book_summary_function'),
            ]
        );
    }

    /**
     * @throws Exception
     */
    private function parseAndProcessPdf(UploadedFile|PDFObject|string $file): mixed
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($file);

        return $this->processPages($pdf->getPages());
    }

    /**
     * @param  array<Page>  $pages
     */
    private function processPages(array $pages): mixed
    {
        return array_map(function ($page) {
            return $this->userMessage($page->getText());
        }, $pages);
    }
}

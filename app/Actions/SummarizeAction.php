<?php

namespace App\Actions;

use App\DTOs\SummarizeDTO;
use App\Enums\OpenAIModelEnum;
use App\Responses\DataResponse;
use Exception;
use JustSteveKing\StatusCode\Http;
use Smalot\PdfParser\Page;
use Smalot\PdfParser\Parser;
use Spatie\LaravelData\Support\Types\Type;
use Supports\Traits\OpenAITrait;

class SummarizeAction
{
    use OpenAITrait;

    /**
     * @throws Exception
     */
    public function execute(SummarizeDTO $summarizeDTO): DataResponse
    {
        $book = $this->parseAndProcessPdf($summarizeDTO->file);

        $result = $this->generateSummary($book);

        return new DataResponse(
            data: $result,
            status: Http::OK,
            message: 'Summary created successfully'
        );
    }

    /**
     * @param  array<Type>  $book
     */
    private function generateSummary(array $book): mixed
    {
        return $this->chatOpenAI(
            OpenAIModelEnum::GPT3,
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
    private function parseAndProcessPdf(string $file): mixed
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

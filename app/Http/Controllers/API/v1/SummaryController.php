<?php

namespace App\Http\Controllers\API\v1;

use App\Actions\ChatSummaryAction;
use App\Actions\ListSummaryAction;
use App\Actions\ShowSummaryAction;
use App\Actions\StoreSummaryAction;
use App\DTOs\ChatSummaryDTO;
use App\DTOs\StoreEditSummary;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatSummaryRequest;
use App\Http\Requests\ListSummaryRequest;
use App\Http\Requests\ShowSummaryRequest;
use App\Http\Requests\StoreSummaryRequest;
use App\Http\Resources\SummaryCollection;
use App\Models\Summary;
use App\Responses\CollectionResponse;
use App\Responses\DataResponse;
use Exception;

class SummaryController extends Controller
{
    public function index(ListSummaryRequest $request, ListSummaryAction $action): CollectionResponse
    {
        return new CollectionResponse(new SummaryCollection($action->execute()));
    }

    /**
     * @throws Exception
     */
    public function store(StoreSummaryRequest $request, StoreSummaryAction $action): DataResponse
    {
        $dto = StoreEditSummary::fromRequest($request);

        return $action->execute($dto);
    }

    public function show(Summary $summary, ShowSummaryAction $action, ShowSummaryRequest $request): DataResponse
    {
        return $action->execute($summary, $request);
    }

    /**
     * @throws Exception
     */
    public function chat(Summary $summary, ChatSummaryAction $action, ChatSummaryRequest $request): DataResponse
    {
        return $action->execute(ChatSummaryDTO::fromRequest($request), $summary);
    }
}

<?php

namespace App\Actions;

use App\Http\Requests\ShowSummaryRequest;
use App\Http\Resources\SummaryResource;
use App\Models\Summary;
use App\Responses\DataResponse;
use Supports\Traits\WithRequestIncludeTrait;

class ShowSummaryAction
{
    use WithRequestIncludeTrait;

    protected array $include = [
        'user',
        'createdBy',
        'updatedBy',
    ];

    public function execute(Summary $summary, ShowSummaryRequest $request): DataResponse
    {
        $this->loadIncludeFromRequests($request, $summary);

        return new DataResponse(
            data: new SummaryResource($summary),
            message: 'Summary retrieved successfully.'
        );
    }
}

<?php

namespace App\Http\Controllers\API\v1;

use App\Actions\SummarizeAction;
use App\DTOs\SummarizeDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SummarizeRequest;
use App\Responses\DataResponse;
use Exception;

class SummarizeController extends Controller
{
    public function __construct()
    {

    }

    /**
     * @throws Exception
     */
    public function summarize(SummarizeRequest $request, SummarizeAction $action): DataResponse
    {
        $dto = SummarizeDTO::fromRequest($request);

        return $action->execute($dto);
    }
}

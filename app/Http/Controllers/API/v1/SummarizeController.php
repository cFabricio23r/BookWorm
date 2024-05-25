<?php

namespace App\Http\Controllers\API\v1;

use App\Actions\SummarizeAction;
use App\DTOs\SummarizeDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SummarizeRequest;

class SummarizeController extends Controller
{
    public function __construct()
    {

    }

    public function summarize(SummarizeRequest $request, SummarizeAction $action)
    {
        $dto = SummarizeDTO::fromRequest($request);

        $test = $action->execute($dto);

        return $test;
    }
}

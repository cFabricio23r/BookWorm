<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JustSteveKing\StatusCode\Http;

class CollectionResponse implements Responsable
{
    public function __construct(
        public readonly ResourceCollection|array $data,
        public readonly Http $status = Http::OK,
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: $this->data->resource,
            status: $this->status->value,
        );
    }
}

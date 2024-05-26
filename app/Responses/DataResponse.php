<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use JustSteveKing\StatusCode\Http;

class DataResponse implements Responsable
{
    public function __construct(
        public readonly array|JsonResource|null $data = null,
        public readonly Http $status = Http::OK,
        public readonly string $message = '',
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: [
                'data' => $this->data ?: [],
                'status' => $this->status->value,
                'message' => $this->message ?: '',
            ],
            status: $this->status->value,
        );
    }
}

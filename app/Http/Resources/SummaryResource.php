<?php

namespace App\Http\Resources;

use App\Models\Summary;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SummaryResource extends JsonResource
{
    public function __construct($resource, protected bool $is_impersonated = false)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /* @var Summary $resource */
        $resource = $this->resource;

        return [
            'id' => $resource->id,
            'user_id' => $resource->user_id,
            'title' => $resource->title,
            'author' => $resource->author,
            'year' => $resource->year,
            'key_aspects' => $resource->key_aspects,
            'summary' => $resource->summary,
            'created_by' => $resource->created_by,
            'updated_by' => $resource->updated_by,
        ];
    }
}

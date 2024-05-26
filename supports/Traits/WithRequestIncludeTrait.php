<?php

namespace Supports\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

trait WithRequestIncludeTrait
{
    public function loadIncludeFromRequests(FormRequest|Request $request, Model $model): void
    {
        $model->unsetRelations();

        $include = [];
        $include_count = [];

        if ($request->filled('include')) {
            $fields_to_include = $request->str('include');
            $include = explode(',', $fields_to_include);
            $include_count = $this->checkForCount($include);
            $include = $this->removeCount($include);
        }

        $include = array_intersect($include, $this->include);

        if (empty($include) === false) {
            $model->load($include);
        }

        if (empty($include_count) === false) {
            $counts = $this->parseCount($include_count);
            $model->loadCount($counts);
        }
    }

    private function checkForCount(array $includes): array
    {
        return collect($includes)->filter(function (string $value) {
            return str_contains($value, 'Count');
        })->toArray();
    }

    private function removeCount(array $values): array
    {
        return collect($values)->filter(function (string $value) {
            return ! str_contains($value, 'Count');
        })->toArray();
    }

    private function parseCount(array $values): array
    {
        return collect($values)->map(function (string $value) {
            return str_replace('Count', '', $value);
        })->toArray();
    }
}

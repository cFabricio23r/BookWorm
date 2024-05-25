<?php

namespace Supports\Abstracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

abstract class AbstractIndexAction
{
    /**
     * @var array|string[]
     */
    protected array $allowedFields = ['*'];

    protected array $allowedFilters = [];

    protected array $includes = [];

    protected string|Builder $class = '';

    /**
     * @var array|string[]
     */
    protected array $allowedSorts = ['created_at', 'number'];

    /**
     * @var array|string[]
     */
    protected array $defaultSorts = ['-created_at'];

    public bool $hasGroupBy = false;

    public bool $hasSum = false;

    protected array $groupBy = [];

    protected array $with = [];

    protected array $join = [];

    protected array $with_count = [];

    /**
     * @var bool|array|string|null
     */
    protected bool $withExactFilters = false;

    public function __construct(protected bool $withPagination = true)
    {
        $this->withExactFilters = request()->query('exact', false);
        $this->hasGroupBy = request()->has('groupBy');
        $this->hasSum = request()->has('sum');
    }

    public function changeClassBuilder(Builder $newBuilder): void
    {
        $this->class = $newBuilder;
    }

    protected function getFilters(): array
    {
        return $this->withExactFilters ? $this->withExactFilter() : $this->withPartialFilter();
    }

    protected function withExactFilter(): array
    {
        $exactFilters = collect($this->allowedFilters)->map(function (string|AllowedFilter $filter) {
            return $filter instanceof AllowedFilter ? $filter : AllowedFilter::exact($filter)->ignore(null);
        });

        return $exactFilters->toArray();
    }

    protected function withPartialFilter(): array
    {
        $partialFilters = collect($this->allowedFilters)->map(function (string|AllowedFilter $filter) {
            return $filter instanceof AllowedFilter ? $filter : AllowedFilter::partial($filter)->ignore(null);
        });

        return $partialFilters->toArray();
    }

    /**
     * @return $this
     */
    public function addWith(array|string $relations): self
    {
        if (is_string($relations)) {
            $this->with = [$relations];

            return $this;
        }

        $this->with = $relations;

        return $this;
    }

    /**
     * @return $this
     */
    public function addJoin(array|string $relations): self
    {
        if (is_string($relations)) {
            $this->join = [$relations];

            return $this;
        }

        $this->join = $relations;

        return $this;
    }

    /**
     * @return $this
     */
    public function addWithCount(array|string $relations_to_count): self
    {
        if (is_string($relations_to_count)) {
            $this->with = [$relations_to_count];

            return $this;
        }

        $this->with_count = $relations_to_count;

        return $this;
    }

    public function execute(): LengthAwarePaginator|Builder
    {
        $paginator = QueryBuilder::for(subject: $this->class)
            ->with($this->with)
            ->withCount($this->with_count)
            ->allowedFields(fields: $this->allowedFields)
            ->allowedFilters(filters: $this->getFilters())
            ->allowedIncludes(includes: $this->includes)
            ->allowedSorts(sorts: $this->allowedSorts)
            ->defaultSorts(sorts: $this->defaultSorts)
            ->getEloquentBuilder();

        if ($this->withPagination) {
            $paginator = $paginator->paginate(per_page_from_request())
                ->withQueryString();
        }

        return $paginator;
    }
}

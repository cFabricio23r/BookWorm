<?php

namespace App\Actions;

use App\Builders\SummaryQueryBuilder;
use App\Contracts\IndexActionContract;
use App\Models\Summary;
use Illuminate\Database\Eloquent\Builder;
use Supports\Abstracts\AbstractIndexAction;

class ListSummaryAction extends AbstractIndexAction implements IndexActionContract
{
    /**
     * @var array|string[]
     */
    protected array $allowedFields = [
        'title',
        'author',
        'year',
        'key_aspects',
        'summary',
    ];

    /**
     * @var array|string[]
     */
    protected array $allowedFilters = [
        'title',
        'author',
        'year',
        'user_id',
    ];

    /**
     * @var array|string[]
     */
    protected array $includes = [
        'user',
        'createdBy',
        'updatedBy',
    ];

    public function __construct(bool $withOutDefault = true)
    {
        parent::__construct();

        $this->class = $withOutDefault ? $this->getSummaryByAuthUserQuery() : Summary::class;
    }

    /**
     * @return Builder<Summary>
     */
    private function getSummaryByAuthUserQuery(): Builder
    {
        /* @var $query SummaryQueryBuilder */
        $query = Summary::query();

        return $query->whereUser(auth()->id());
    }
}

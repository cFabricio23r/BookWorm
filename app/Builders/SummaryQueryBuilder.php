<?php

namespace App\Builders;

use App\Models\Summary;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Summary>
 */
class SummaryQueryBuilder extends Builder
{
    public function whereUser(string $user): SummaryQueryBuilder
    {
        return $this->where('summaries.user_id', $user);
    }
}

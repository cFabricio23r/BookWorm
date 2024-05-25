<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface IndexActionContract
{
    public function execute(): LengthAwarePaginator|Builder;
}

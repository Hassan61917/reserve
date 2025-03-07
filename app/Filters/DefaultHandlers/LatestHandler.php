<?php

namespace App\Filters\DefaultHandlers;

use App\Filters\IFilterHandler;
use Illuminate\Database\Eloquent\Builder;

class LatestHandler implements IFilterHandler
{
    public function handle(Builder $builder, ?string $value = null): Builder
    {
        return $builder->latest();
    }
}

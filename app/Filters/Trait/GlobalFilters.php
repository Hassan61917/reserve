<?php

namespace App\Filters\Trait;

use Illuminate\Database\Eloquent\Builder;

trait GlobalFilters
{
    protected string $searchValue = "";

    protected function search(Builder $builder, string $value): Builder
    {
        return $builder->where($this->searchValue, "LIKE", "%{$value}%");
    }
}

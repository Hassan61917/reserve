<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

interface IFilterHandler
{
    public function handle(Builder $builder, ?string $value = null): Builder;
}

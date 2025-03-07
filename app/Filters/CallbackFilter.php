<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class CallbackFilter implements IFilterHandler
{
    public function __construct(
        protected Closure $closure
    ) {}

    public function handle(Builder $builder, ?string $value = null): Builder
    {
        return call_user_func($this->closure, $builder, $value);
    }
}

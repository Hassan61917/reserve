<?php

namespace App\Models\Trait\Scopes;

use App\Filters\DefaultFilter;
use Illuminate\Database\Eloquent\Builder;

trait AppModelScopes
{
    public function scopeWithFilters(Builder $builder, ?string $class = null): Builder
    {
        if (!$class) {
            $name = last(explode("\\", static::class));
            $class = "App\\Filters\\{$name}\\{$name}Filter";
        }
        if (!class_exists($class)) {
            $class = DefaultFilter::class;
        }
        $filter = app()->make($class);
        return $filter->apply($builder, request()->query());
    }
}

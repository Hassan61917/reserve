<?php

namespace App\Models\Trait\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait DiscountScopes
{
    public function scopePublic(Builder $builder,): Builder
    {
        return $builder->whereNull(["service_id", "item_id"]);
    }

    public function scopeForClient(Builder $builder, int $clientId): Builder
    {
        return $builder->where("client_id", $clientId);
    }

    public function scopeForServices(Builder $builder, array $serviceIds): Builder
    {
        return $builder->whereIn('service_id', $serviceIds);
    }
    public function scopeActive(Builder $builder): Builder
    {
        return $builder
            ->whereNull("expire_at")
            ->orWhere("expire_at", ">", now());
    }
}

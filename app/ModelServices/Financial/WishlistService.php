<?php

namespace App\ModelServices\Financial;

use App\Models\ServiceItem;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WishlistService
{
    public function getAll(array $relations = []): Builder
    {
        return Wishlist::query()->withFilters()->with($relations);
    }

    public function getAllFor(User $user, array $relations = []): HasMany
    {
        return $user->wishlist()->withFilters()->with($relations);
    }

    public function make(User $user, ServiceItem $item): Wishlist
    {
        return $user->wishlist()->create([
            "item_id" => $item->id
        ]);
    }
}

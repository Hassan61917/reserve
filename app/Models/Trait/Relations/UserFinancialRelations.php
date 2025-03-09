<?php

namespace App\Models\Trait\Relations;

use App\Models\Discount;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait UserFinancialRelations
{
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }

    public function myDiscounts(): HasMany
    {
        return $this->hasMany(Discount::class, "client_id");
    }

    public function usedDiscounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class, "discount_user");
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function wishlist(): HasMany
    {
        return $this->hasMany(WishList::class);
    }
}

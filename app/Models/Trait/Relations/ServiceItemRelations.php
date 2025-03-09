<?php

namespace App\Models\Trait\Relations;

use App\Models\Booking;
use App\Models\Discount;
use App\Models\Question;
use App\Models\Service;
use App\Models\ServiceDayOff;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
trait ServiceItemRelations
{
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function dayOffs(): HasMany
    {
        return $this->hasMany(ServiceDayOff::class, "item_id");
    }
    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class,"item_id");
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, "item_id");
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class,"item_id");
    }
    public function wishlist(): HasMany
    {
        return $this->hasMany(WishList::class,"item_id");
    }
}

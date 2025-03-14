<?php

namespace App\Models\Trait\Relations;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait BookingRelations
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class, "item_id");
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}

<?php

namespace App\Models\Trait\Relations;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Question;
use App\Models\ServiceDayoff;
use App\Models\ServiceItem;
use App\Models\ServiceProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait ServiceRelations
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(ServiceProfile::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ServiceItem::class);
    }
    public function dayOffs(): HasMany
    {
        return $this->hasMany(ServiceDayOff::class,"service_id");
    }
}

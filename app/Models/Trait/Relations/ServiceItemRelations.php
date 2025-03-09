<?php

namespace App\Models\Trait\Relations;

use App\Models\Discount;
use App\Models\Service;
use App\Models\ServiceDayOff;
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
}

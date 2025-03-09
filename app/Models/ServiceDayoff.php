<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceDayoff extends AppModel
{
    protected $fillable = [
        "service_item_id", "in_week", "in_month", "date"
    ];
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class,"service_id");
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class);
    }
}

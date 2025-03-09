<?php

namespace App\Models;

use App\ModelServices\Ads\ShowModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertiseOrder extends ShowModel
{
    protected $fillable = [
        "ads_id", "link", "image", "status", "show_at", "end_at"
    ];

    public function lastOrder(): ?ShowModel
    {
        return $this->ads->lastOrder();
    }

    public function ads(): BelongsTo
    {
        return $this->belongsTo(Advertise::class, "ads_id");
    }
}



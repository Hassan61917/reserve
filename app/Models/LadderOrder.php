<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LadderOrder extends ShowModel
{
    protected $fillable = [
        "item_id", "ladder_id", "status", "show_at", "end_at"
    ];

    public function lastOrder(): ?ShowModel
    {
        return $this->ladder->lastOrder();
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class, "item_id");
    }

    public function ladder(): BelongsTo
    {
        return $this->BelongsTo(Ladder::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends AppModel
{
    protected $fillable = [
        "item_id"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class, "item_id");
    }
}

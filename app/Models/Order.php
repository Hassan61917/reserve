<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Order extends AppModel
{
    protected $fillable = [
        "status", "total_price", "discount_code", "discount_price"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function item(): MorphTo
    {
        return $this->morphTo();
    }

    public function getAmount(): int
    {
        return $this->discount_price ?: $this->total_price;
    }

    public function isStatus(OrderStatus $status): bool
    {
        return $this->status == $status->value;
    }
}

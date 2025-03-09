<?php

namespace App\Models;

use App\Models\Interfaces\Likeable;
use App\Models\Trait\With\WithLike;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends AppModel implements Likeable
{
    use WithLike;
    protected $fillable = [
        "booking_id", "rate", "body", "reply"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}

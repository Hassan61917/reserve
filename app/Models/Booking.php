<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Models\Trait\Relations\BookingRelations;
use Illuminate\Database\Eloquent\Builder;

class Booking extends AppModel
{
    use BookingRelations;

    protected $fillable = [
        "service_id", "item_id", "date", "hour", "status"
    ];

    public function scopeAvailable(Builder $builder): Builder
    {
        return $builder->where('status', "!=", BookingStatus::Draft->value);
    }

    public function scopeComplete(Builder $builder, ?int $user_id = null): Builder
    {
        if ($user_id) {
            $builder = $builder->where('user_id', $user_id);
        }
        return $builder->where('status', BookingStatus::Completed->value);
    }
}

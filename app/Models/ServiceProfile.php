<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceProfile extends AppModel
{
    protected $with = ['service'];
    protected $fillable = [
        "open_at", "close_at", "phone", "address",
    ];

    public function scopeIsOpen(Builder $builder, int $hour): Builder
    {
        return $builder
            ->where("open_at", "<=", $hour)
            ->where("close_at", ">=", $hour);
    }

    public function scopeInCity(Builder $builder, int $stateId, int $cityId): Builder
    {
        return $builder->where(["state_id"=>$stateId,"city_id"=>$cityId]);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}

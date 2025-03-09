<?php

namespace App\Models;


use App\Models\Trait\Relations\ServiceItemRelations;
use App\Models\Trait\With\WithDayOffs;
use Illuminate\Database\Eloquent\Builder;

class ServiceItem extends AppModel
{
    use ServiceItemRelations,
        WithDayOffs;

    protected $fillable = [
        "name", "slug", "price", "duration", "hidden", "available", "description"
    ];

    public function scopeAvailable(Builder $builder): Builder
    {
        return $builder->where([
            "hidden" => false,
            "available" => true
        ]);
    }

    public function casts(): array
    {
        return [
            "hidden" => "boolean",
            "available" => "boolean"
        ];
    }
}

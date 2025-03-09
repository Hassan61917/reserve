<?php

namespace App\Models;


use App\Models\Interfaces\Likeable;
use App\Models\Interfaces\Visitable;
use App\Models\Trait\Relations\ServiceItemRelations;
use App\Models\Trait\With\WithDayOffs;
use App\Models\Trait\With\WithLike;
use App\Models\Trait\With\WithVisit;
use Illuminate\Database\Eloquent\Builder;

class ServiceItem extends AppModel implements Visitable, Likeable
{
    use ServiceItemRelations,
        WithDayOffs,
        WithVisit, WithLike;

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

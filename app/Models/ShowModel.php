<?php

namespace App\Models;

use App\Enums\ShowStatus;
use App\Models\Interfaces\IOrderItem;
use App\Models\Trait\With\WithOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

abstract class ShowModel extends AppModel implements IOrderItem
{
    use WithOrder;

    public function scopeShowing(Builder $builder): Builder
    {
        return $builder->where("status", ShowStatus::Showing->value);
    }

    public function casts(): array
    {
        return [
            "show_at" => "datetime",
            "end_at" => "datetime",
        ];
    }

    public function lastOrder(): ?ShowModel
    {
        return null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}

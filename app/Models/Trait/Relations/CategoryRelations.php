<?php

namespace App\Models\Trait\Relations;

use App\Models\Category;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CategoryRelations
{
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }
}

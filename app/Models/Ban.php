<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ban extends AppModel
{
    protected $with = ['user', 'admin'];

    protected $fillable = [
        "user_id",
        "reason",
        "duration",
        "finished",
        "started_at",
    ];

    public function scopeActive(Builder $builder): Builder
    {
        return $builder
            ->where("started_at", "<=", now())
            ->where("finished", false);
    }

    public function scopeFinished(Builder $builder): Builder
    {
        return $builder->where("finished", true);
    }

    public function casts(): array
    {
        return [
            "started_at" => "datetime",
            "finished" => "boolean",
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, "admin_id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }
}

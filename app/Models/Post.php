<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Models\Interfaces\Likeable;
use App\Models\Interfaces\Visitable;
use App\Models\Trait\With\WithLike;
use App\Models\Trait\With\WithVisit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends AppModel implements Visitable, Likeable
{
    use WithVisit, WithLike;
    protected $fillable = [
        "title",
        "slug",
        "body",
        "status",
        "can_comment",
        "published_at"
    ];

    public function scopeWithStatus(Builder $builder,PostStatus $status): Builder
    {
        return $builder->where('status', $status->value);
    }
    public function isPublished(): bool
    {
        return $this->status == PostStatus::Published->value;
    }

    protected function casts(): array
    {
        return [
            "can_comment" => "boolean",
            "published_at" => "datetime"
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}

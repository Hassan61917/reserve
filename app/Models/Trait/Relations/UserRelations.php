<?php

namespace App\Models\Trait\Relations;

use App\Models\Ban;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserRelations
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, "role_user");
    }
    public function banHistory(): HasMany
    {
        return $this->hasMany(Ban::class);
    }

    public function bannedUsers(): HasMany
    {
        return $this->hasMany(Ban::class, 'admin_id');
    }
}

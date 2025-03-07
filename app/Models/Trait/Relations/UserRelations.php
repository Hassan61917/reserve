<?php

namespace App\Models\Trait\Relations;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait UserRelations
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, "role_user");
    }
}

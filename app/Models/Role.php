<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends AppModel
{
    protected $fillable = ["title", "slug"];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "role_user");
    }
}

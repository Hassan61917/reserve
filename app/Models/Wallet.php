<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends AppModel
{
    protected $fillable = ["password", "balance", "number", "blocked"];
    protected $hidden = ["password"];

    protected function casts(): array
    {
        return [
            "blocked" => "boolean",
            'password' => 'hashed'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }
}


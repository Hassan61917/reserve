<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends AppModel
{
    protected $fillable = [
        "type",
        "amount",
        "code",
        "before_balance",
        "after_balance",
        "wallet_number",
        "description",
        "temporary"
    ];

    public function casts(): array
    {
        return [
            "temporary" => "boolean"
        ];
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}

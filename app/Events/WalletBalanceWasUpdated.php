<?php

namespace App\Events;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WalletBalanceWasUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Wallet            $wallet,
        public WalletTransaction $transaction,
    ) {
        //
    }
}

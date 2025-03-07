<?php

namespace App\Listeners;

use App\Events\WalletBalanceWasUpdated;
use App\Notifications\WalletBalanceUpdatedNotification;

class SendBalanceUpdatedNotification
{
    public function handle(WalletBalanceWasUpdated $event): void
    {
        $wallet = $event->wallet;
        $transaction = $event->transaction;
        $wallet->user->notify(new WalletBalanceUpdatedNotification($transaction));
    }
}

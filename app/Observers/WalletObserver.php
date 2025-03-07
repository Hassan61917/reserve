<?php

namespace App\Observers;

use App\Models\Wallet;
use App\Utils\CodeGenerator\ICodeGenerator;

class WalletObserver
{
    public function __construct(
        private ICodeGenerator $generator
    ) {}

    public function creating(Wallet $wallet): void
    {
        $wallet->number = $this->generator->generate(8);
    }

    /**
     * Handle the Wallet "created" event.
     */
    public function created(Wallet $wallet): void {}

    /**
     * Handle the Wallet "updated" event.
     */
    public function updated(Wallet $wallet): void
    {
        //
    }

    /**
     * Handle the Wallet "deleted" event.
     */
    public function deleted(Wallet $wallet): void
    {
        //
    }

    /**
     * Handle the Wallet "restored" event.
     */
    public function restored(Wallet $wallet): void
    {
        //
    }

    /**
     * Handle the Wallet "force deleted" event.
     */
    public function forceDeleted(Wallet $wallet): void
    {
        //
    }
}

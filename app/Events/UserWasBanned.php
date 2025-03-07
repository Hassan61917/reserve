<?php

namespace App\Events;

use App\Models\Ban;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserWasBanned
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        private Ban $ban
    ) {
        //
    }
}

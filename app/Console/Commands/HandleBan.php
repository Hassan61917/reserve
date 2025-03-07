<?php

namespace App\Console\Commands;

use App\ModelServices\User\BanService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class HandleBan extends Command
{
    public function __construct(
        private BanService $banService
    ) {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'handle:ban';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handing Banned Users';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->finishBans();
    }

    private function finishBans(): void
    {
        $bans = $this->banService->activeBanned();
        foreach ($bans as $ban) {
            $time = Carbon::make($ban->start_at)->addDays($ban->reason->duration);
            if (now()->lte($time)) {
                $this->banService->finishBan($ban);
            }
        }
    }
}

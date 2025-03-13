<?php

namespace App\Console\Commands;

use App\ModelServices\Ads\LadderService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class HandleLadderOrders extends Command
{
    private int $count = 5;

    public function __construct(
        private LadderService $ladderService
    )
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'handle:ladder-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle ladder orders ';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->completeOrders();
        $this->processOrders();
    }

    private function processOrders(): void
    {
        $orders = $this->takeOrders(LadderOrderStatus::Showing, $this->count);
        if (!$orders->count() < $this->count) {
            return;
        }
        $count = $this->count - $orders->count();
        $pendingOrders = $this->takeOrders(LadderOrderStatus::Paid, $count);
        foreach ($pendingOrders as $order) {
            $this->ladderService->processOrder($order);
        }
    }

    private function completeOrders(): void
    {
        $orders = $this->takeOrders(LadderOrderStatus::Showing, $this->count);
        foreach ($orders as $order) {
            if ($this->ladderService->isExpired($order)) {
                $this->ladderService->completeOrder($order);
            }
        }
    }

    private function takeOrders(LadderOrderStatus $status, int $count): Collection
    {
        return $this->ladderService->ordersWithStatus($status)
            ->take($count)
            ->get();
    }
}

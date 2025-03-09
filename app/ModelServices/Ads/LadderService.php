<?php

namespace App\ModelServices\Ads;

use App\Events\LadderWasOrdered;
use App\Exceptions\ModelException;
use App\Models\Ladder;
use App\Models\LadderOrder;
use App\Models\ServiceItem;
use App\Models\User;
use App\ModelServices\Financial\OrderService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LadderService
{
    use OrderShowable;

    public function __construct(
        private OrderService $orderService,
    )
    {
    }

    public function getLadders(array $relations = []): Builder
    {
        return Ladder::query()->with($relations);
    }

    public function makeLadder(array $data): Ladder
    {
        return Ladder::create($data);
    }

    public function getOrders(array $relations = []): Builder
    {
        return LadderOrder::query()->with($relations);
    }

    public function getAvailableOrders(array $relations = []): Builder
    {
        return LadderOrder::showing()->with($relations);
    }

    public function getOrdersFor(User $user, array $relations = []): HasMany
    {
        return $user->ladderOrders()->with($relations);
    }

    public function makeOrder(User $user, array $data): LadderOrder
    {
        if (!$this->sameCategory($data)) {
            throw new ModelException("category type is not same");
        }
        $order = $user->ladderOrders()->create($data);
        $this->updateShowingTime($order);
        $this->orderService->makeOrder($user, $order, $order->ladder->price);
        LadderWasOrdered::dispatch($order);
        return $order;
    }

    public function cancelOrder(LadderOrder $order): LadderOrder
    {
        $this->cancel($order);
        return $order;
    }

    public function showOrder(LadderOrder $order): LadderOrder
    {
        $this->show($order, $order->ladder->duration);
        return $order;
    }

    public function completeOrder(LadderOrder $order): LadderOrder
    {
        $this->complete($order);
        return $order;
    }
    private function sameCategory(array $data): bool
    {
        $item = ServiceItem::find($data['item_id']);
        $ladder = Ladder::find($data["ladder_id"]);
        return $ladder->category->is($item->service->category);
    }
}

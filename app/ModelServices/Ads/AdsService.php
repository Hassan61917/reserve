<?php

namespace App\ModelServices\Ads;

use App\Events\AdsWasOrdered;
use App\Models\Advertise;
use App\Models\AdvertiseOrder;
use App\Models\User;
use App\ModelServices\Financial\OrderService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdsService
{
    use OrderShowable;

    public function __construct(
        private OrderService $orderService,
    )
    {
    }

    public function getAdvertises(): Builder
    {
        return Advertise::query();
    }

    public function makeAds(array $data): Advertise
    {
        return Advertise::create($data);
    }

    public function getOrders(array $relations = []): Builder
    {
        return AdvertiseOrder::query()->with($relations);
    }

    public function getOrdersFor(User $user, array $relations = []): HasMany
    {
        return $user->adsOrders()->with($relations);
    }

    public function getAvailableOrders(): Builder
    {
        return AdvertiseOrder::query()->showing()->with("ads");
    }

    public function makeOrder(User $user, array $data): AdvertiseOrder
    {
        $order = $user->adsOrders()->make($data);
        $this->updateShowingTime($order);
        $this->orderService->makeOrder($user, $order, $order->ads->price);
        AdsWasOrdered::dispatch($order);
        return $order;
    }

    private function order(AdvertiseOrder $order): AdvertiseOrder
    {
        $this->updateShowingTime($order);
        return $order;
    }

    public function cancelOrder(AdvertiseOrder $order): AdvertiseOrder
    {
        $this->cancel($order);
        return $order;
    }

    public function showOrder(AdvertiseOrder $order): AdvertiseOrder
    {
        $this->show($order, $order->ads->duration);
        return $order;
    }


    public function completeOrder(AdvertiseOrder $order): AdvertiseOrder
    {
        $this->complete($order);
        return $order;
    }
}

<?php

namespace App\Handlers\Discount\Rules;

use App\Exceptions\ModelException;
use App\Handlers\IModelHandler;
use App\Models\Booking;
use App\Models\Discount;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class CheckService implements IModelHandler
{
    public function handle(Model|Discount $model, array $params = []): void
    {
        $order = $params[0];
        if (!$this->canApply($order, $model)) {
            throw new ModelException("discount can not be applied");
        }
    }

    public function canApply(Order $order, Discount $discount): bool
    {
        if ($order->item->type != Booking::class) {
            return true;
        }
        $booking = Booking::find($order->item->id);
        return $this->checkModel($booking->service->category, $discount, "category")
            && $this->checkModel($booking->service, $discount, "service")
            && $this->checkModel($booking->item, $discount, "item");
    }

    private function checkModel(Model $model, Discount $discount, string $relation): bool
    {
        return !$discount->$relation || $model->is($discount->$relation);
    }


}

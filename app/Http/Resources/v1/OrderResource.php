<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use App\Models\AdvertiseOrder;
use App\Models\Booking;
use App\Models\LadderOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "totalPrice" => $this->total_price,
            "status" => $this->status,
            "priceAfterDiscount" => $this->getAmount(),
            "discountCode" => $this->discount_code,
            "user" => $this->mergeRelation(UserResource::class, "user"),
            "item" => $this->mergeWhenLoaded("item", $this->mergeItem())
        ];
    }

    private function mergeItem(): JsonResource
    {
        $type = $this->item_type;
        $id = $this->item_id;
        return match ($type) {
            Booking::class => BookingResource::make($id),
            AdvertiseOrder::class => AdsOrderResource::class,
            LadderOrder::class => LadderOrderResource::class,
        };
    }
}

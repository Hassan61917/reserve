<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\ServiceItem;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $item = ServiceItem::factory()->create();
        return [
            "user_id" => User::factory(),
            "item_type" => $item::class,
            "item_id" => $item->id,
            "status" => OrderStatus::Draft->value,
            "total_price" => $item->price,
            "discount_price" => null,
            "discount_code" => null,
        ];
    }
}

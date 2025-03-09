<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\ServiceItem;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $item = $this->randomModel(ServiceItem::class);
        return [
            "user_id" => User::factory(),
            "service_id" => $item->service,
            "item_id" => $item,
            "date" => now()->addDay()->format('Y-m-d'),
            "hour" => 9,
            "status" => BookingStatus::Draft->value
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\ServiceItem;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wishlist>
 */
class WishlistFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => $this->randomModel(User::class),
            "item_id" => $this->randomModel(ServiceItem::class)
        ];
    }
}

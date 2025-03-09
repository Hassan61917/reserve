<?php

namespace Database\Factories;

use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->sentence(),
            "description" => $this->faker->paragraph(),
            "code" => Str::random(12),
            "category_id" => null,
            "client_id" => null,
            "service_id" => null,
            "item_id" => null,
            "limit" => 1,
            "amount" => 20,
            "percent" => 10,
            "total_balance" => 100,
            "max_amount" => 100,
            "expire_at" => now()->addMonth(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ban>
 */
class BanFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "admin_id" => User::factory(),
            "user_id" => User::factory(),
            "reason" => $this->faker->sentence(),
            "duration" => 3,
            "started_at" => now(),
            "finished" => false
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Service;
use App\Models\State;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceProfile>
 */
class ServiceProfileFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "service_id" => $this->randomModel(Service::class),
            "state_id" => State::factory(),
            "city_id" => City::factory(),
            "open_at" => 1,
            "close_at" => 23,
            "phone" => $this->faker->phoneNumber(),
            "address" => $this->faker->address(),
        ];
    }
}

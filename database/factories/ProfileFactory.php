<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\State;
use App\Models\User;

class ProfileFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::factory(),
            "state_id" => $this->randomModel(State::class),
            "city_id" => $this->randomModel(City::class),
            "name" => $this->faker->name(),
            "phone" => $this->faker->phoneNumber(),
            "avatar" => $this->faker->imageUrl(),
        ];
    }
}

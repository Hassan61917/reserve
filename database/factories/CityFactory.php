<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->city();
        return [
            "state_id" => $this->randomModel(State::class),
            "name" => $name,
            "slug" => Str::slug($name)
        ];
    }
}

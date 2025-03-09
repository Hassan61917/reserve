<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\ServiceProfile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceItem>
 */
class ServiceItemFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $service = Service::factory()->has(ServiceProfile::factory(),"profile");
        return [
            "service_id" => $service,
            "name" => $this->faker->jobTitle(),
            "slug" => $this->faker->slug(),
            "description" => $this->faker->realText(),
            "price" => 100,
            "duration" => 30,
            "hidden" => false,
            "available" => true,
        ];
    }
}

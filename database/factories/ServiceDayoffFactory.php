<?php

namespace Database\Factories;

use App\Models\Service;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceDayoff>
 */
class ServiceDayoffFactory extends AppFactory
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
            "item_id" => null,
            "in_week" => null,
            "in_month" => null,
            "date" => null,
        ];
    }
}

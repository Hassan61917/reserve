<?php

namespace Database\Factories;

use App\Enums\ServiceStatus;
use App\Models\Category;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends AppFactory
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
            "category_id" => $this->randomModel(Category::class),
            "name" => $this->faker->company(),
            "description" => $this->faker->text(),
            "slug" => $this->faker->slug(),
            "status" => ServiceStatus::Draft->value
        ];
    }
}

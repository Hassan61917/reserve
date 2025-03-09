<?php

namespace Database\Factories;

use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ladder>
 */
class LadderFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "category_id" => $this->randomModel(Category::class),
            "duration" => 1,
            "price" => 1000,
        ];
    }
}

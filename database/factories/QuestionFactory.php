<?php

namespace Database\Factories;

use App\Models\ServiceItem;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $item = $this->randomModel(ServiceItem::class);
        return [
            "user_id" => User::factory(),
            "service_id" => $item->service,
            "item_id" => $item,
            "question" => $this->faker->sentence(),
            "answer" => $this->faker->text(),
        ];
    }
}

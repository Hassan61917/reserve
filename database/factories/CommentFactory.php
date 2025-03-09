<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends AppFactory
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
            "post_id" => $this->randomModel(Post::class),
            "parent_id" => null,
            "comment" => $this->faker->realText(),
        ];
    }
}

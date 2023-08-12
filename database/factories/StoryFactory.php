<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Story>
 */
class StoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::query()->where('role', 1)->pluck("id");
        return [
            "user_id" => fake()->randomElement($users),
            "title" => fake()->jobTitle(),
            "content" => fake()->paragraphs(5, true),
            "status" => fake()->biasedNumberBetween(1, 2)
        ];
    }
}

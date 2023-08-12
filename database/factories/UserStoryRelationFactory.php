<?php

namespace Database\Factories;

use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserStoryRelation>
 */
class UserStoryRelationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::query()->pluck("id");
        $stories = Story::query()->pluck("id");
        return [
            "user_id" => fake()->randomElement($users),
            "story_id" => fake()->randomElement($stories)
        ];
    }
}

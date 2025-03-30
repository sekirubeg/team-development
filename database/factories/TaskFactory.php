<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tasks>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'title' => fake()->realText(10),
            'content' => fake()->realText(50),
            'user_id' => User::factory(),
            'importance' => fake()->numberBetween(1, 3),
            'limit' => Carbon::now()->addDays(rand(1, 30))->toDateString(),
        ];
    }
}

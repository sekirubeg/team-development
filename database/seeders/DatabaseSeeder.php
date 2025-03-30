<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();


        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => "sekirubeg",
        ]);
        Task::factory()->create([
            'title' => "test",
            'content' => "testtesttest",
            'user_id' => 11,
            'importance' => fake()->numberBetween(1, 3),
            'limit' => Carbon::now()->addDays(rand(1, 30))->toDateString(),
        ]);
        Task::factory(20)->create();
    }

}

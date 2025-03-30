<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
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
        $faker = FakerFactory::create('ja_JP');

        // 通常ユーザー10人
        User::factory(10)->create();

        // テスト用ユーザー
        $testUser = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('sekirubeg'), // パスワードはハッシュ化！
        ]);

        // テスト用タスク（特定のユーザーに紐づけ）
        Task::factory()->create([
            'title' => $faker->realText(10),
            'content' => $faker->realText(30),
            'user_id' => $testUser->id,
            'importance' => $faker->numberBetween(1, 3),
            'limit' => Carbon::now()->addDays(rand(1, 30))->toDateString(),
        ]);

        // その他のタスクをランダムに生成
        Task::factory(20)->create();
    }

}

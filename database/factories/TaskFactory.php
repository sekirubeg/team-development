<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as FakerFactory;

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
        $faker = FakerFactory::create('ja_JP'); // 日本語ロケール

        return [
            'title' => $faker->text(5), // 10文字程度の日本語タイトル
            'content' => $faker->realText(20), // 50文字程度の日本語本文
            'user_id' => User::factory(), // ユーザーモデルのファクトリ
            'importance' => $faker->numberBetween(1, 3), // 重要度（1〜3）
            'limit' => Carbon::now()->addDays(rand(1, 30))->toDateString(), // 今日から30日以内の期日
        ];
    }
}

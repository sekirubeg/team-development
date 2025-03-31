<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $users = \App\Models\User::all();

            foreach ($users as $user) {
                $todayTasks = $user->tasks()->whereDate('limit', now()->toDateString())->get();

                if ($todayTasks->count()) {
                    $user->notify(new \App\Notifications\TodayTasksNotification($todayTasks));
                }
            }
        })->dailyAt('08:00'); // 毎朝8時に送信
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TodayTasksNotification extends Notification
{
    use Queueable;

    public $tasks;
    /**
     * Create a new notification instance.
     */
    public function __construct($tasks)
    {
        //
        $this->tasks = $tasks;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('今日のタスク一覧')
            ->greeting($notifiable->name . 'さん、こんにちは！')
            ->line('本日が締切のタスク一覧です:');

        foreach ($this->tasks as $task) {
            $message->line('・' . $task->title . '（期限: ' . \Carbon\Carbon::parse($task->limit)->format('Y年m月d日') . '）');
        }

        $message->line('忘れずに確認しましょう！');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

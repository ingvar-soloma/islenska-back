<?php

namespace App\Notifications\Backup;

use App\Notifications\Channels\TelegramChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Spatie\Backup\Notifications\Notifications\BackupNotification as SpatieBackupNotification;

abstract class BackupNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Always include both mail and Telegram channels
        return ['mail', TelegramChannel::class];
    }

    /**
     * Get the Telegram representation of the notification.
     *
     * @param mixed $notifiable
     * @return string
     */
    abstract public function toTelegram($notifiable): string;
}

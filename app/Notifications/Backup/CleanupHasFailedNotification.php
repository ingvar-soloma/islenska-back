<?php

namespace App\Notifications\Backup;

use Spatie\Backup\Notifications\Notifications\CleanupHasFailedNotification as SpatieCleanupHasFailedNotification;

class CleanupHasFailedNotification extends BackupNotification
{
    protected SpatieCleanupHasFailedNotification $spatieNotification;

    public function __construct(SpatieCleanupHasFailedNotification $spatieNotification)
    {
        $this->spatieNotification = $spatieNotification;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return $this->spatieNotification->toMail($notifiable);
    }

    /**
     * Get the Telegram representation of the notification.
     *
     * @param mixed $notifiable
     * @return string
     */
    public function toTelegram($notifiable): string
    {
        $applicationName = $this->spatieNotification->applicationName();
        $exception = $this->spatieNotification->exception();

        return "❌ <b>Cleanup failed!</b>\n\n" .
            "Application: <b>{$applicationName}</b>\n" .
            "Error: <b>{$exception->getMessage()}</b>";
    }
}

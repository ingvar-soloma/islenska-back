<?php

namespace App\Notifications\Backup;

use Spatie\Backup\Notifications\Notifications\BackupHasFailedNotification as SpatieBackupHasFailedNotification;

class BackupHasFailedNotification extends BackupNotification
{
    protected SpatieBackupHasFailedNotification $spatieNotification;

    public function __construct(SpatieBackupHasFailedNotification $spatieNotification)
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

        return "❌ <b>Backup failed!</b>\n\n" .
            "Application: <b>{$applicationName}</b>\n" .
            "Error: <b>{$exception->getMessage()}</b>";
    }
}

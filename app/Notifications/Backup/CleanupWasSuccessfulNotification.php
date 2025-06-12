<?php

namespace App\Notifications\Backup;

use Spatie\Backup\Notifications\Notifications\CleanupWasSuccessfulNotification as SpatieCleanupWasSuccessfulNotification;

class CleanupWasSuccessfulNotification extends BackupNotification
{
    protected SpatieCleanupWasSuccessfulNotification $spatieNotification;

    public function __construct(SpatieCleanupWasSuccessfulNotification $spatieNotification)
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
        $diskName = $this->spatieNotification->diskName();

        return "🧹 <b>Cleanup successful!</b>\n\n" .
            "Application: <b>{$applicationName}</b>\n" .
            "Disk: <b>{$diskName}</b>";
    }
}

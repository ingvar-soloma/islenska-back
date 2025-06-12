<?php

namespace App\Notifications\Backup;

use Spatie\Backup\Notifications\Notifications\BackupWasSuccessfulNotification as SpatieBackupWasSuccessfulNotification;

class BackupWasSuccessfulNotification extends BackupNotification
{
    protected SpatieBackupWasSuccessfulNotification $spatieNotification;

    public function __construct(SpatieBackupWasSuccessfulNotification $spatieNotification)
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
        $backupSize = $this->spatieNotification->sizeInMb();

        return "✅ <b>Backup successful!</b>\n\n" .
            "Application: <b>{$applicationName}</b>\n" .
            "Disk: <b>{$diskName}</b>\n" .
            "Size: <b>{$backupSize} MB</b>";
    }
}

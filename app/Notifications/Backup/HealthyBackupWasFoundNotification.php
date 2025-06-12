<?php

namespace App\Notifications\Backup;

use Illuminate\Notifications\Messages\MailMessage;
use Spatie\Backup\Notifications\Notifications\HealthyBackupWasFoundNotification as SpatieHealthyBackupWasFoundNotification;

class HealthyBackupWasFoundNotification extends BackupNotification
{
    protected SpatieHealthyBackupWasFoundNotification $spatieNotification;

    public function __construct(SpatieHealthyBackupWasFoundNotification $spatieNotification)
    {
        $this->spatieNotification = $spatieNotification;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    final public function toMail($notifiable): MailMessage
    {
        return $this->spatieNotification->toMail($notifiable);
    }

    /**
     * Get the Telegram representation of the notification.
     *
     * @param mixed $notifiable
     * @return string
     */
    final public function toTelegram($notifiable): string
    {
        $applicationName = $this->spatieNotification->applicationName();
        $diskName = $this->spatieNotification->diskName();
        $backupDestination = $this->spatieNotification->backupDestination();
        $backupSize = $backupDestination->size() ? round($backupDestination->size() / 1024 / 1024, 2) : 0;
        $newestBackup = $backupDestination->newestBackup() ? $backupDestination->newestBackup()->date()->diffForHumans() : 'No backups present';

        return "✅ <b>Healthy backup found!</b>\n\n" .
            "Application: <b>{$applicationName}</b>\n" .
            "Disk: <b>{$diskName}</b>\n" .
            "Size: <b>{$backupSize} MB</b>\n" .
            "Newest backup: <b>{$newestBackup}</b>";
    }
}

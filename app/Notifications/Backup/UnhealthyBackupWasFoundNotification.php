<?php

namespace App\Notifications\Backup;

use Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFoundNotification as SpatieUnhealthyBackupWasFoundNotification;

class UnhealthyBackupWasFoundNotification extends BackupNotification
{
    protected SpatieUnhealthyBackupWasFoundNotification $spatieNotification;

    public function __construct(SpatieUnhealthyBackupWasFoundNotification $spatieNotification)
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
        $unhealthyBackupDestination = $this->spatieNotification->backupDestination();

        // Get the health check results from the backup destination
        $healthCheckResults = $unhealthyBackupDestination->getHealthCheckResults();
        $problems = [];

        foreach ($healthCheckResults as $result) {
            if (! $result->isHealthy()) {
                $problems[] = $result->message();
            }
        }

        $message = "⚠️ <b>Unhealthy backup found!</b>\n\n" .
            "Application: <b>{$applicationName}</b>\n" .
            "Disk: <b>{$diskName}</b>\n\n" .
            "<b>Problems:</b>\n";

        foreach ($problems as $problem) {
            $message .= "- {$problem}\n";
        }

        return $message;
    }
}

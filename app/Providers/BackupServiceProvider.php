<?php

namespace App\Providers;

use App\Notifications\Backup\BackupHasFailedNotification;
use App\Notifications\Backup\BackupWasSuccessfulNotification;
use App\Notifications\Backup\CleanupHasFailedNotification;
use App\Notifications\Backup\CleanupWasSuccessfulNotification;
use App\Notifications\Backup\HealthyBackupWasFoundNotification;
use App\Notifications\Backup\UnhealthyBackupWasFoundNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Spatie\Backup\Events\BackupHasFailed;
use Spatie\Backup\Events\BackupWasSuccessful;
use Spatie\Backup\Events\CleanupHasFailed;
use Spatie\Backup\Events\CleanupWasSuccessful;
use Spatie\Backup\Events\HealthyBackupWasFound;
use Spatie\Backup\Events\UnhealthyBackupWasFound;
use Spatie\Backup\Listeners\BackupHasFailedListener;
use Spatie\Backup\Listeners\BackupWasSuccessfulListener;
use Spatie\Backup\Listeners\CleanupHasFailedListener;
use Spatie\Backup\Listeners\CleanupWasSuccessfulListener;
use Spatie\Backup\Listeners\HealthyBackupWasFoundListener;
use Spatie\Backup\Listeners\UnhealthyBackupWasFoundListener;

class BackupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    final public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    final public function boot(): void
    {
        // Bind our custom notification classes
        $this->app->bind(
            \Spatie\Backup\Notifications\Notifications\BackupHasFailedNotification::class,
            function () {
                return new BackupHasFailedNotification(
                    new \Spatie\Backup\Notifications\Notifications\BackupHasFailedNotification()
                );
            }
        );

        $this->app->bind(
            \Spatie\Backup\Notifications\Notifications\BackupWasSuccessfulNotification::class,
            function () {
                return new BackupWasSuccessfulNotification(
                    new \Spatie\Backup\Notifications\Notifications\BackupWasSuccessfulNotification()
                );
            }
        );

        $this->app->bind(
            \Spatie\Backup\Notifications\Notifications\CleanupHasFailedNotification::class,
            function () {
                return new CleanupHasFailedNotification(
                    new \Spatie\Backup\Notifications\Notifications\CleanupHasFailedNotification()
                );
            }
        );

        $this->app->bind(
            \Spatie\Backup\Notifications\Notifications\CleanupWasSuccessfulNotification::class,
            function () {
                return new CleanupWasSuccessfulNotification(
                    new \Spatie\Backup\Notifications\Notifications\CleanupWasSuccessfulNotification()
                );
            }
        );

        $this->app->bind(
            \Spatie\Backup\Notifications\Notifications\HealthyBackupWasFoundNotification::class,
            function () {
                return new HealthyBackupWasFoundNotification(
                    new \Spatie\Backup\Notifications\Notifications\HealthyBackupWasFoundNotification()
                );
            }
        );

        $this->app->bind(
            \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFoundNotification::class,
            function () {
                return new UnhealthyBackupWasFoundNotification(
                    new \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFoundNotification()
                );
            }
        );

        // Add debug logging for backup events
        $this->app['events']->listen(BackupWasSuccessful::class, function (BackupWasSuccessful $event) {
            Log::info('Backup was successful event fired', ['event' => get_class($event)]);
        });

        $this->app['events']->listen(BackupHasFailed::class, function (BackupHasFailed $event) {
            Log::info('Backup has failed event fired', ['event' => get_class($event)]);
        });

        $this->app['events']->listen(CleanupWasSuccessful::class, function (CleanupWasSuccessful $event) {
            Log::info('Cleanup was successful event fired', ['event' => get_class($event)]);
        });

        $this->app['events']->listen(CleanupHasFailed::class, function (CleanupHasFailed $event) {
            Log::info('Cleanup has failed event fired', ['event' => get_class($event)]);
        });

        $this->app['events']->listen(HealthyBackupWasFound::class, function (HealthyBackupWasFound $event) {
            Log::info('Healthy backup was found event fired', ['event' => get_class($event)]);
        });

        $this->app['events']->listen(UnhealthyBackupWasFound::class, function (UnhealthyBackupWasFound $event) {
            Log::info('Unhealthy backup was found event fired', ['event' => get_class($event)]);
        });
    }
}

# Automatic Database Backup Documentation

This document explains how the automatic database backup system is set up and how to use it.

## Overview

The application uses the [spatie/laravel-backup](https://github.com/spatie/laravel-backup) package to handle automatic database backups. The system is configured to:

1. Run daily backups at 1:30 AM
2. Clean up old backups at 1:00 AM according to the retention policy
3. Send email notifications about backup status

## Configuration

### Scheduler Service

The application uses a dedicated Docker container to run the Laravel scheduler, which ensures that the backup commands run automatically at the scheduled times. This service is defined in the `docker-compose.yml` file:

```yaml
scheduler:
    build:
        context: ./vendor/laravel/sail/runtimes/8.3
        dockerfile: Dockerfile
        args:
            WWWGROUP: '${WWWGROUP}'
    image: sail-8.3/app
    container_name: ib-scheduler
    restart: unless-stopped
    command:
        - php
        - /var/www/html/artisan
        - schedule:work
    volumes:
        - ".:/var/www/html"
    networks:
        - sail
    depends_on:
        - mysql
```

### Backup Schedule

The backup schedule is defined in `routes/console.php`:

```php
Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');
```

### Backup Settings

The backup settings are defined in `config/backup.php` and include:

- Backing up the MySQL database
- Backing up application files (excluding vendor and node_modules)
- Storing backups on the 'local' disk (in `storage/app/backups` by default)
- Retention policy that keeps:
  - All backups for 7 days
  - Daily backups for 16 days
  - Weekly backups for 8 weeks
  - Monthly backups for 4 months
  - Yearly backups for 2 years

### Notifications

The system is configured to send notifications about backup status via both email and Telegram.

#### Email Notifications

The email address is set in the `config/backup.php` file:

```php
'mail' => [
    'to' => env('BACKUP_NOTIFICATION_EMAIL', 'admin@vikinglingo.online'),
    // ...
],
```

You can set the `BACKUP_NOTIFICATION_EMAIL` environment variable to change the email address.

#### Telegram Notifications

Backup status notifications are also sent to a Telegram chat. The Telegram bot token and chat ID are configured in the `config/services.php` file:

```php
'telegram' => [
    'bot_token' => env('TELEGRAM_BOT_TOKEN'),
    'chat_id' => env('TELEGRAM_CHAT_ID'),
],
```

You can set the `TELEGRAM_BOT_TOKEN` and `TELEGRAM_CHAT_ID` environment variables to change these values.

## Manual Backup Commands

You can also run backups manually:

```bash
# Create a backup
php artisan backup:run

# Clean up old backups
php artisan backup:clean

# List all backups
php artisan backup:list
```

In Docker/Sail, prefix these with `sail`:

```bash
sail artisan backup:run
```

## Testing the Backup System

A test script is provided to verify that the backup system is working correctly:

```bash
# Make the script executable
chmod +x test-backup.sh

# Run the test script
./test-backup.sh
```

This script will run the backup:clean, backup:run, and backup:list commands to verify that the backup system is working correctly.

## Customizing Backup Settings

If you need to customize the backup settings:

1. **Change backup frequency**: Edit the schedule in `routes/console.php`
2. **Change what gets backed up**: Modify the `config/backup.php` file:
   - `backup.source.files.include` and `exclude` arrays control which files are backed up
   - `backup.source.databases` array controls which databases are backed up

3. **Change backup storage location**: By default, backups are stored on the 'local' disk. To store backups elsewhere (like S3):
   - Configure the S3 disk in `config/filesystems.php`
   - Update the `backup.destination.disks` array in `config/backup.php` to include 's3'

4. **Change retention policy**: Modify the values in the `cleanup.default_strategy` section of `config/backup.php`

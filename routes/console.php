<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');

Artisan::command('test:telegram', function () {
    $botToken = config('services.telegram.bot_token');
    $chatId = config('services.telegram.chat_id', '518383100');

    $this->info("Testing Telegram notification with:");
    $this->info("Bot Token: {$botToken}");
    $this->info("Chat ID: {$chatId}");

    try {
        $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'parse_mode' => 'HTML',
            'text' => '<b>Test message from backup system</b> - ' . now()->toDateTimeString()
        ]);

        $this->info("Response status: " . $response->status());
        $this->info("Response body: " . $response->body());

        Log::info('Telegram test response', [
            'status' => $response->status(),
            'body' => $response->body(),
            'successful' => $response->successful(),
            'chat_id' => $chatId
        ]);

        if ($response->successful()) {
            $this->info("Test message sent successfully!");
        } else {
            $this->error("Failed to send test message!");
        }
    } catch (\Exception $e) {
        $this->error("Exception: " . $e->getMessage());
        Log::error('Telegram test exception', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
})->purpose('Test Telegram notification');

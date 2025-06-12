<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class TelegramChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toTelegram')) {
            return;
        }

        $message = $notification->toTelegram($notifiable);

        if (is_string($message)) {
            $message = ['text' => $message];
        }

        $this->sendMessage($message);
    }

    /**
     * Send message to Telegram.
     *
     * @param array $message
     * @return void
     */
    protected function sendMessage(array $message)
    {
        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id', '518383100'); // Default to the ID from the issue description

        $params = array_merge([
            'chat_id' => $chatId,
            'parse_mode' => 'HTML',
        ], $message);

        try {
            $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", $params);

            // Log the response for debugging
            \Illuminate\Support\Facades\Log::info('Telegram API Response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'successful' => $response->successful(),
                'chat_id' => $chatId,
                'message' => $message['text'] ?? 'No text provided'
            ]);

            if (!$response->successful()) {
                \Illuminate\Support\Facades\Log::error('Telegram API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'chat_id' => $chatId
                ]);
            }

            return $response;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Telegram Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'chat_id' => $chatId
            ]);

            throw $e;
        }
    }
}

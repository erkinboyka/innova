<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send notification through multiple channels.
     */
    public function notify(User $user, string $message, array $channels = ['push', 'email'])
    {
        foreach ($channels as $channel) {
            $this->sendToChannel($user, $message, $channel);
        }
    }

    protected function sendToChannel(User $user, string $message, string $channel)
    {
        switch ($channel) {
            case 'push':
                $this->sendPush($user, $message);
                break;
            case 'email':
                $this->sendEmail($user, $message);
                break;
            case 'sms':
                $this->sendSms($user, $message);
                break;
            case 'telegram':
                $this->sendTelegram($user, $message);
                break;
        }
    }

    protected function sendPush(User $user, string $message)
    {
        // OneSignal or Firebase logic
        Log::info("Push sent to user {$user->id}: {$message}");
    }

    protected function sendEmail(User $user, string $message)
    {
        // Laravel Mail logic
        Log::info("Email sent to user {$user->id}: {$message}");
    }

    protected function sendSms(User $user, string $message)
    {
        // Twilio or locally-sourced SMS provider logic
        Log::info("SMS sent to user {$user->id}: {$message}");
    }

    protected function sendTelegram(User $user, string $message)
    {
        // Telegram Bot API logic
        Log::info("Telegram sent to user {$user->id}: {$message}");
    }
}

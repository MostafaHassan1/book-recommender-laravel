<?php

namespace App\Notifications;

use App\Services\SMSService;
use App\ToSMSInterface;
use Illuminate\Notifications\Notification;

class SMSChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if(!$notification instanceof ToSMSInterface)
            throw new \Exception("Notification must implements ToSMSInterface");

        $message = $notification->toSMS($notifiable);

        app(SMSService::class)->send($notifiable->phone,$message);
    }
}

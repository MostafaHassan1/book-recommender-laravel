<?php

declare(strict_types=1);

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
        if (!$notification instanceof ToSMSInterface) {
            throw new \Exception('Notification must implements ToSMSInterface');
        }

        $message = $notification->toSMS($notifiable);

        app(SMSService::class)->send($notifiable->phone, $message);
    }
}

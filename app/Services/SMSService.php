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

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SMSService
{
    public function __construct(private string $url)
    {
        throw_if(empty($this->url), 'Please set the url of your SMS service provider');
    }

    public function send(string $phone, string $message): void
    {
        $response = Http::post($this->url, [
            'phone' => $phone,
            'message' => $message,
        ]);

        throw_if($response->failed(), 'Failed to send SMS message with error: '.$response->body());
    }
}

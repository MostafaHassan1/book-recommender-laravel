<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SMSService
{
    public function __construct(private string $url)
    {
        throw_if(empty($this->url),'Please set the url of your SMS service provider');
    }
    public function send(string $phone, string $message){
        $response = Http::post($this->url,[
            'phone' => $phone,
            'message' => $message
        ]);

        thorw_if($response->failed(),'Failed to send SMS message with error:' . $response->body());
    }
}

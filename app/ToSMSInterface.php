<?php

namespace App;

interface ToSMSInterface
{
    public function toSMS(object $notifiable): string;
}

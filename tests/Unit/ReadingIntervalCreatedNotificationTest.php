<?php

use App\Models\ReadingInterval;
use Illuminate\Support\Facades\Http;

test('can create notification',function (){
    Http::fake();
    $readingInterval = ReadingInterval::factory()->create();
    expect(true)->toBeTrue();
});

test('can send real notification to first sms provider',function (){
    config()->set('services.sms_provider','first_sms_provider');
    $readingInterval = ReadingInterval::factory()->create();
    expect(true)->toBeTrue();
});

test('can send real notification to second sms provider',function (){
    config()->set('services.sms_provider','second_sms_provider');
    $readingInterval = ReadingInterval::factory()->create();
    expect(true)->toBeTrue();
});

test('if sms provider does not have a url, an exception get thrown',function (){
    config()->set('services.sms_provider','first_sms_provider');
    config()->set('services.first_sms_provider.url','');
    $readingInterval = ReadingInterval::factory()->create();
})->throws(Exception::class,'Please set the url of your SMS service provider');

test('if sms provider fails during request, an exception get thrown',function (){
    Http::fake([
        'run.mocky.io/*' => Http::response(['message' => 'failed'],500),
    ]);
    config()->set('services.sms_provider','first_sms_provider');
    $readingInterval = ReadingInterval::factory()->create();
})->throws(Exception::class,'Failed to send SMS message with error: {"message":"failed"}');

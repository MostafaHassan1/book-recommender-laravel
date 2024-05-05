<?php

use App\Jobs\CalculateNumberOfPagesReadJob;
use App\Models\Book;
use App\Models\ReadingInterval;
use App\Notifications\ReadingIntervalCreatedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

describe('Creating Reading Interval', function () {
    test('CalculateNumberOfPagesRead gets queued', function () {
        Queue::fake();
        Notification::fake();
        ReadingInterval::factory()->create();
        Queue::assertPushed(CalculateNumberOfPagesReadJob::class);
    });

    test('CalculateNumberOfPagesRead does not get queue if the book is fully read', function () {
        Queue::fake();
        Notification::fake();
        ReadingInterval::factory()->for(Book::factory()->fullyRead())->create();
        Queue::assertNotPushed(CalculateNumberOfPagesReadJob::class);
    });

    test('ReadIntervalCreatedNotification gets queued', function () {
        Notification::fake();
        $readingInterval = ReadingInterval::factory()->create();
        Notification::assertSentTo($readingInterval->user, ReadingIntervalCreatedNotification::class);
    });
});

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

use App\Jobs\CalculateNumberOfPagesReadJob;
use App\Models\Book;
use App\Models\ReadingInterval;
use App\Notifications\ReadingIntervalCreatedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

describe('Creating Reading Interval', static function (): void {
    test('CalculateNumberOfPagesRead gets queued', static function (): void {
        Queue::fake();
        Notification::fake();
        ReadingInterval::factory()->create();
        Queue::assertPushed(CalculateNumberOfPagesReadJob::class);
    });

    test('CalculateNumberOfPagesRead does not get queue if the book is fully read', static function (): void {
        Queue::fake();
        Notification::fake();
        ReadingInterval::factory()->for(Book::factory()->fullyRead())->create();
        Queue::assertNotPushed(CalculateNumberOfPagesReadJob::class);
    });

    test('ReadIntervalCreatedNotification gets queued', static function (): void {
        Notification::fake();
        $readingInterval = ReadingInterval::factory()->create();
        Notification::assertSentTo($readingInterval->user, ReadingIntervalCreatedNotification::class);
    });
});

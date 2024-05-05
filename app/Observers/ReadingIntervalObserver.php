<?php

namespace App\Observers;

use App\Jobs\CalculateNumberOfPagesReadJob;
use App\Models\ReadingInterval;
use App\Notifications\ReadingIntervalCreatedNotification;

class ReadingIntervalObserver
{
    /**
     * Handle the ReadingInterval "created" event.
     */
    public function created(ReadingInterval $readingInterval): void
    {
        if (! $readingInterval->book->isFullyRead()) {
            CalculateNumberOfPagesReadJob::dispatch($readingInterval);
        }

        $readingInterval->user->notify(new ReadingIntervalCreatedNotification());
    }
}

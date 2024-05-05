<?php

use App\Jobs\CalculateNumberOfPagesReadJob;
use App\Models\Book;
use App\Models\ReadingInterval;
use Illuminate\Support\Facades\Queue;

describe('Creating Reading Interval',function (){
    test('CalculateNumberOfPagesRead gets queued', function () {
        Queue::fake();
        ReadingInterval::factory()->create();
        Queue::assertPushed(CalculateNumberOfPagesReadJob::class);
    });

    test('CalculateNumberOfPagesRead does not get queue if the book is fully read',function (){
        Queue::fake();
        ReadingInterval::factory()->for(Book::factory()->fullyRead())->create();
        Queue::assertNotPushed(CalculateNumberOfPagesReadJob::class);
    });
});

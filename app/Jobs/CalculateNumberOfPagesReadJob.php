<?php

namespace App\Jobs;

use App\Models\ReadingInterval;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateNumberOfPagesReadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly ReadingInterval $readingInterval)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $intersectingIntervals = $this->readingInterval->getIntersectingReadingIntervals();
        $uniquePagesCount = $this->readingInterval->end_page - $this->readingInterval->start_page;

        foreach ($intersectingIntervals as $intersectingInterval){
            $overlap = max(
                0,
                min($intersectingInterval->end_page,$this->readingInterval->end_page) - max($this->readingInterval->start_page,$intersectingInterval->start_page)
            );
            $uniquePagesCount -= $overlap;
        }

        $this->readingInterval->book()->increment('number_of_read_pages',$uniquePagesCount);
    }
}

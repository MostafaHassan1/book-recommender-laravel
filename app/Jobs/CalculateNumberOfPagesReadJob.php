<?php

namespace App\Jobs;

use App\Models\ReadingInterval;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class CalculateNumberOfPagesReadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly ReadingInterval $readingInterval) {}

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [
            new WithoutOverlapping($this->readingInterval->book_id), // should only process one interval per book at a time
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $intersectingIntervals = $this->readingInterval->getIntersectingReadingIntervals();
        $startPage = $this->readingInterval->start_page;
        $endPage = $this->readingInterval->end_page;
        $uniquePagesCount = $endPage - $startPage;

        foreach ($intersectingIntervals as $intersectingInterval) {
            $overlap = max(
                0,
                min($intersectingInterval->end_page, $endPage) - max($startPage, $intersectingInterval->start_page)
            );
            $uniquePagesCount -= $overlap;
            $this->mergeIntervals($intersectingInterval, $startPage, $endPage);
        }
        $this->readingInterval->book()->increment('number_of_read_pages', max(0, $uniquePagesCount));
    }

    public function mergeIntervals(ReadingInterval $intersectingInterval, int $startPage, int $endPage): void
    {
        $this->readingInterval->start_page = min($intersectingInterval->start_page, $startPage);
        $this->readingInterval->end_page = max($intersectingInterval->end_page, $endPage);
        $intersectingInterval->merged();
        $this->readingInterval->isDirty() ? $this->readingInterval->save() : null;
    }
}

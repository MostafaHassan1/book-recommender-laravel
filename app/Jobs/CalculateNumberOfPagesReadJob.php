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
    }
}

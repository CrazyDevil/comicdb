<?php

namespace App\Jobs;

use App\Models\Series;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteSeries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Series $series;

    public function __construct(Series $series)
    {
        $this->series = $series;
    }

    public function handle()
    {
        $this->series->delete();
    }
}

<?php

namespace App\Jobs;

use App\Models\Series;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateComic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Series $series;

    private array $requestData;

    public function __construct(Series $series, array $requestData)
    {
        $this->series = $series;
        $this->requestData = $requestData;
    }

    public function handle()
    {
        $this->series->comics()->create($this->requestData);
    }
}

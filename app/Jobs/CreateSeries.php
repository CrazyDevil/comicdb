<?php

namespace App\Jobs;

use App\Models\Publisher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateSeries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Publisher $publisher;

    private array $requestData;

    public function __construct(Publisher $publisher, array $requestData)
    {
        $this->publisher = $publisher;
        $this->requestData = $requestData;
    }

    public function handle()
    {
        $this->publisher->series()->create($this->requestData);
    }
}

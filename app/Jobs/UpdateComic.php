<?php

namespace App\Jobs;

use App\Models\Comic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateComic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Comic $comic;
    private array $requestData;

    public function __construct(Comic $comic, array $requestData)
    {
        $this->comic = $comic;
        $this->requestData = $requestData;
    }

    public function handle()
    {
        $this->comic->update($this->requestData);
    }
}

<?php

namespace App\Jobs;

use App\Models\Comic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateCover implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Comic $comic;

    private array $data;

    public function __construct(Comic $comic, array $data)
    {
        $this->comic = $comic;
        $this->data = $data;
    }

    public function handle()
    {
        $this->comic->covers()->create($this->data);
    }
}

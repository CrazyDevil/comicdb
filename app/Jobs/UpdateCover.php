<?php

namespace App\Jobs;

use App\Models\Cover;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCover implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Cover $cover;

    private array $requestData;

    public function __construct(Cover $cover, array $requestData)
    {
        $this->cover = $cover;
        $this->requestData = $requestData;
    }

    public function handle()
    {
        $this->cover->update($this->requestData);
    }
}

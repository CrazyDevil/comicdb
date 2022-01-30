<?php

namespace App\Jobs;

use App\Models\Cover;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteCover implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Cover $cover;

    public function __construct(Cover $cover)
    {
        $this->cover = $cover;
    }

    public function handle()
    {
        $this->cover->delete();
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Series;
use Illuminate\Http\Resources\Json\JsonResource;

class SeriesSimpleResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Series $series */
        $series = $this;

        return [
            'resourceUrl' => route('series.show', $series->id),
            'title' => $series->title,
        ];
    }
}

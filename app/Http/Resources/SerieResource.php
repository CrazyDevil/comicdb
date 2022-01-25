<?php

namespace App\Http\Resources;

use App\Models\Serie;
use Illuminate\Http\Resources\Json\JsonResource;

class SerieResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Serie $serie */
        $serie = $this;

        return [
            'id' => $serie->id,
            'title' => $serie->title,
            'volume' => $serie->volume ?? 1,
            'description' => $serie->description ?? '',
            'start-year' => $serie->start_year ?? 0,
            'end-year' => $serie->end_year ?? 0,
            'rating' => $serie->rating ?? '',
            'created-at' => $serie->created_at->toIso8601String(),
            'updated-at' => $serie->updated_at->toIso8601String(),
            'publisher' => new PublisherResource($serie->publisher),
        ];
    }
}

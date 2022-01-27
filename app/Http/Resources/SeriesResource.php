<?php

namespace App\Http\Resources;

use App\Models\Series;
use Illuminate\Http\Resources\Json\JsonResource;

class SeriesResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Series $serie */
        $serie = $this;

        return [
            'id' => $serie->id,
            'title' => $serie->title,
            'volume' => $serie->volume ?? 1,
            'description' => $serie->description ?? '',
            'startYear' => $serie->start_year,
            'endYear' => $serie->end_year,
            'rating' => $serie->rating ?? '',
            'type' => $serie->type ?? '',
            'createdAt' => $serie->created_at->toIso8601String(),
            'updatedAt' => $serie->updated_at->toIso8601String(),
            'publisher' => PublisherSimpleResource::make($serie->publisher),
        ];
    }
}

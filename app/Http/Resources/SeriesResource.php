<?php

namespace App\Http\Resources;

use App\Models\Series;
use Illuminate\Http\Resources\Json\JsonResource;

class SeriesResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Series $series */
        $series = $this;

        return [
            'id' => $series->id,
            'title' => $series->title,
            'volume' => $series->volume ?? 1,
            'description' => $series->description ?? '',
            'startYear' => $series->start_year,
            'endYear' => $series->end_year,
            'rating' => $series->rating ?? '',
            'type' => $series->type ?? '',
            'createdAt' => $series->created_at->toIso8601String(),
            'updatedAt' => $series->updated_at->toIso8601String(),
            'publisher' => PublisherSimpleResource::make($series->publisher),
            'comics' => ComicSimpleResource::collection($series->comics),
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Comic;
use Illuminate\Http\Resources\Json\JsonResource;

class ComicResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Comic $comic */
        $comic = $this;

        return [
            'id' => $comic->id,
            'title' => $comic->title,
            'issueNumber' => $comic->issue_number,
            'description' => $comic->description,
            'format' => $comic->format,
            'createdAt' => $comic->created_at->toIso8601String(),
            'updatedAt' => $comic->updated_at->toIso8601String(),
            'series' => SeriesSimpleResource::make($comic->series),
        ];
    }
}

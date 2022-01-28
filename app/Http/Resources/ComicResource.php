<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComicResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'issueNumber' => $this->issue_number,
            'description' => $this->description ?? '',
            'format' => $this->format,
            'series' => SeriesSimpleResource::make($this->series),
        ];
    }
}

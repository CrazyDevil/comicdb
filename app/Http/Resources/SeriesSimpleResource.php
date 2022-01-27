<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeriesSimpleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'resourceUrl' => route('series.show', $this->id),
            'title' => $this->title,
        ];
    }
}

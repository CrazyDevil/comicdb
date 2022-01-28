<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComicSimpleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'resourceUrl' => route('comics.show', $this->id),
            'title' => $this->title,
        ];
    }
}

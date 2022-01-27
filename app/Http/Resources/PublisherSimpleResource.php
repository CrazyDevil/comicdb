<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublisherSimpleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'resourceUrl' => route('publishers.show', $this->id),
            'name' => $this->name,
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Publisher;
use Illuminate\Http\Resources\Json\JsonResource;

class PublisherSimpleResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Publisher $publisher */
        $publisher = $this;

        return [
            'resourceUrl' => route('publishers.show', $publisher->id),
            'name' => $publisher->name,
        ];
    }
}

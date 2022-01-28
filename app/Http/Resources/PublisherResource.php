<?php

namespace App\Http\Resources;

use App\Models\Publisher;
use Illuminate\Http\Resources\Json\JsonResource;

class PublisherResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Publisher $publisher */
        $publisher = $this;

        return [
            'id' => $publisher->id,
            'name' => $publisher->name,
            'foundedAt' => $publisher->founded_year
                . ($publisher->founded_month ? '-' . $publisher->founded_month : '')
                . ($publisher->founded_day ? '-' . $publisher->founded_day : ''),
            'websiteUrl' => $publisher->website_url ?? '',
            'twitterUrl' => $publisher->twitter_url ?? '',
            'address' => $publisher->address ?? '',
            'city' => $publisher->city ?? '',
            'state' => $publisher->state ?? '',
            'zip' => $publisher->zip ?? '',
            'country' => $publisher->country ?? '',
            'createdAt' => $publisher->created_at->toIso8601String(),
            'updatedAt' => $publisher->updated_at->toIso8601String(),
            'series' => SeriesSimpleResource::collection($publisher->series),
        ];
    }
}

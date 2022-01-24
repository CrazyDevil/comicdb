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
            'founded-at' => $publisher->founded_year
                . ($publisher->founded_month ? '-' . $publisher->founded_month : '')
                . ($publisher->founded_day ? '-' . $publisher->founded_day : ''),
            'website-url' => $publisher->website_url ?? '',
            'twitter-url' => $publisher->twitter_url ?? '',
            'address' => $publisher->address ?? '',
            'city' => $publisher->city ?? '',
            'state' => $publisher->state ?? '',
            'zip' => $publisher->zip ?? '',
            'country' => $publisher->country ?? '',
            'created-at' => $publisher->created_at->toIso8601String(),
            'updated-at' => $publisher->updated_at->toIso8601String(),
        ];
    }
}

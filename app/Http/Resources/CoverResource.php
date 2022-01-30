<?php

namespace App\Http\Resources;

use App\Models\Cover;
use Illuminate\Http\Resources\Json\JsonResource;

class CoverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Cover $cover */
        $cover = $this;

        return [
            'id' => $cover->id,
            'identificator' => $cover->identificator,
            'name' => $cover->name,
            'distributorSku' => $cover->distributor_sku,
            'upc' => $cover->upc,
            'cover_url' => $cover->cover_path ?? null,
            'coverPrice' => $cover->cover_price,
            'releaseDate' => $cover->release_date,
            'createdAt' => $cover->created_at->toIso8601String(),
            'updatedAt' => $cover->updated_at->toIso8601String(),
            'comic' => ComicSimpleResource::make($cover->comic),
        ];
    }
}

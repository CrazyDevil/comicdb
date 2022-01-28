<?php

namespace App\Http\Resources;

use App\Models\Comic;
use Illuminate\Http\Resources\Json\JsonResource;

class ComicSimpleResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Comic $comic */
        $comic = $this;

        return [
            'resourceUrl' => route('comics.show', $comic->id),
            'title' => $comic->title,
        ];
    }
}

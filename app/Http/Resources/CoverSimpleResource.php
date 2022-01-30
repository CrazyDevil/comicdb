<?php

namespace App\Http\Resources;

use App\Models\Cover;
use Illuminate\Http\Resources\Json\JsonResource;

class CoverSimpleResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Cover $cover */
        $cover = $this;

        return [
            'resourceUrl' => route('covers.show', $cover->id),
            'identificator' => $cover->comic->issue_number . '-' . $cover->identificator,
        ];
    }
}

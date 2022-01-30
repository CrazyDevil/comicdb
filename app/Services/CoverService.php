<?php

namespace App\Services;

use App\Jobs\CreateCover;
use App\Jobs\DeleteCover;
use App\Jobs\UpdateCover;
use App\Models\Comic;
use App\Models\Cover;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CoverService
{
    public function createCover(Comic $comic, array $data)
    {
        CreateCover::dispatch($comic, $data);
    }

    public function updateCover(Cover $cover, array $data)
    {
        UpdateCover::dispatch($cover, $data);
    }

    public function deleteCover(Cover $cover)
    {
        DeleteCover::dispatch($cover);
    }

    public function getCoverList(Comic $comic): LengthAwarePaginator
    {
        return QueryBuilder::for(Cover::class)
            ->allowedSorts([
                'identificator',
                'name',
                'upc',
            ])
            ->allowedFilters([
                AllowedFilter::partial('identificator'),
                AllowedFilter::partial('name'),
            ])
            ->with('comic')
            ->when($comic->id, function ($query) use ($comic) {
                return $query->where('comic_id', $comic->id);
            })
            ->jsonPaginate()
            ->appends(request()->query());
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\SerieResource;
use App\Models\Serie;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Serie
 */
class SerieController extends Controller
{
    /**
     * @authenticated
     *
     * @header Accept application/json
     *
     * @queryParam sort The field to sort the list by. Example: title
     * @queryParam page[number] int The page number (default 1). Example: 2
     * @queryParam page[size] int The page size (default 30). Example: 10
     *
     * @apiResourceCollection App\Http\Resources\SerieResource
     * @apiResourceModel App\Models\Serie paginate=30
     */
    public function index()
    {
        $series = QueryBuilder::for(Serie::class)
            ->allowedSorts([
                'title',
            ])
            ->jsonPaginate()
            ->appends(request()->query());

        return SerieResource::collection($series);
    }
}

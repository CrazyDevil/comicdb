<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesRequest;
use App\Http\Resources\SeriesResource;
use App\Jobs\CreateSeries;
use App\Jobs\DeleteSeries;
use App\Jobs\UpdateSeries;
use App\Models\Publisher;
use App\Models\Series;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Series
 */
class SeriesController extends Controller
{
    /**
     * @authenticated
     *
     * @header Accept application/json
     *
     * @queryParam sort The field to sort the list by (title, start_year)
     * @queryParam filter[title] Filter the list by title
     * @queryParam filter[start_year] Filter the list by start year
     * @queryParam page[number] int The page number (default 1). Example: 2
     * @queryParam page[size] int The page size (default 30). Example: 10
     *
     * @apiResourceCollection App\Http\Resources\SeriesResource
     * @apiResourceModel App\Models\Series paginate=30
     */
    public function index(Publisher $publisher): AnonymousResourceCollection
    {
        $series = QueryBuilder::for(Series::class)
            ->allowedSorts([
                'title',
                'start_year',
            ])
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::exact('start_year'),
            ])
            ->allowedIncludes([
                'publisher',
            ])
            ->when($publisher->id, function ($query) use ($publisher) {
                return $query->where('publisher_id', $publisher->id);
            })
            ->jsonPaginate()
            ->appends(request()->query());

        return SeriesResource::collection($series);
    }

    /**
     * @authenticated
     *
     * @apiResource App\Http\Resources\SeriesResource
     * @apiResourceModel App\Models\Series
     */
    public function show(Series $series): SeriesResource
    {
        return new SeriesResource($series);
    }

    /**
     * @authenticated
     *
     * @header Accept application/json
     *
     * @response 202 {
     *     "message": "Accepted"
     * }
     *
     * @response 422 {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "field": [
     *             "Error message"
     *         ]
     *     }
     * }
     */
    public function store(SeriesRequest $request, Publisher $publisher)
    {
        $request->merge(['publisher_id' => $publisher->id]);

        CreateSeries::dispatch($request->all());

        return response()->json(['message' => 'Accepted'], 202);
    }

    /**
     * @authenticated
     *
     * @header Accept application/json
     *
     * @response 202 {
     *     "message": "Accepted"
     * }
     *
     * @response 422 {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "field": [
     *             "Error message"
     *         ]
     *     }
     * }
     */
    public function update(SeriesRequest $request, Series $series): JsonResponse
    {
        UpdateSeries::dispatch($series, $request->validated());

        return response()->json(['message' => 'Accepted'], 202);
    }

    /**
     * @authenticated
     *
     * @header Accept application/json
     *
     * @response 202 {
     *     "message": "Accepted"
     * }
     *
     * @response 404 {
     *  "message": "Resource not found."
     * }
     */
    public function destroy(Series $series): JsonResponse
    {
        DeleteSeries::dispatch($series);

        return response()->json(['message' => 'Accepted'], 202);
    }
}

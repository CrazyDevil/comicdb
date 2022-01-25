<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublisherRequest;
use App\Http\Resources\PublisherResource;
use App\Jobs\CreatePublisher;
use App\Jobs\DeletePublisher;
use App\Jobs\UpdatePublisher;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Publisher
 */
class PublisherController extends Controller
{
    /**
     * @authenticated
     *
     * @header Accept application/json
     *
     * @queryParam sort The field to sort the list by. Example: name
     * @queryParam filter[name] string Filter by publisher name containing value. Example: comics
     * @queryParam filter[country] string Filter by publisher country. Example: USA
     * @queryParam filter[founded-year] int Filter by publisher founded year. Example: 1940
     * @queryParam filter[founded-year-between] string Filter by publisher founded year in the given range. Example: 1940,1990
     * @queryParam page[number] int The page number (default 1). Example: 2
     * @queryParam page[size] int The page size (default 30). Example: 10
     *
     * @apiResourceCollection App\Http\Resources\PublisherResource
     * @apiResourceModel App\Models\Publisher paginate=30
     */
    public function index(): AnonymousResourceCollection
    {
        $publishers = QueryBuilder::for(Publisher::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::exact('country'),
                AllowedFilter::scope('founded-year-between'),
                AllowedFilter::scope('founded-year'),
            ])
            ->allowedSorts([
                'name',
                'founded_year',
            ])
            ->jsonPaginate()
            ->appends(request()->query());

        return PublisherResource::collection($publishers);
    }

    /**
     * @authenticated
     *
     * @apiResource App\Http\Resources\PublisherResource
     * @apiResourceModel App\Models\Publisher
     */
    public function show(Publisher $publisher): PublisherResource
    {
        return new PublisherResource($publisher);
    }

    /**
     * @authenticated
     *
     * @header Accept application/json
     *
     * @bodyParam name string required The name of the publisher.
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
    public function store(PublisherRequest $request): JsonResponse
    {
        CreatePublisher::dispatch($request->validated());

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
    public function update(PublisherRequest $request, Publisher $publisher): JsonResponse
    {
        UpdatePublisher::dispatch($publisher, $request->validated());

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
     *
     * @response 422 {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *   "name": [
     *      "Error message"
     *   ]
     * }
     */
    public function destroy(Publisher $publisher): JsonResponse
    {
        DeletePublisher::dispatch($publisher);

        return response()->json(['message' => 'Accepted'], 202);
    }
}

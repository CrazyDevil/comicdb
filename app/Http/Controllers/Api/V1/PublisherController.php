<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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

class PublisherController extends Controller
{
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
            ->with('series', 'series.comics')
            ->jsonPaginate()
            ->appends(request()->query());

        return PublisherResource::collection($publishers);
    }

    public function show(Publisher $publisher): PublisherResource
    {
        return new PublisherResource($publisher);
    }

    public function store(PublisherRequest $request): JsonResponse
    {
        CreatePublisher::dispatch($request->validated());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function update(PublisherRequest $request, Publisher $publisher): JsonResponse
    {
        UpdatePublisher::dispatch($publisher, $request->validated());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function destroy(Publisher $publisher): JsonResponse
    {
        DeletePublisher::dispatch($publisher);

        return response()->json(['message' => 'Accepted'], 202);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublisherRequest;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
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
            ->jsonPaginate()
            ->appends(request()->query());

        return PublisherResource::collection($publishers);
    }

    public function show(Publisher $publisher): PublisherResource
    {
        return new PublisherResource($publisher);
    }

    public function store(PublisherRequest $request): PublisherResource
    {
        $publisher = Publisher::create($request->validated());

        return new PublisherResource($publisher);
    }

    public function update(PublisherRequest $request, Publisher $publisher): PublisherResource
    {
        $publisher->update($request->validated());

        return new PublisherResource($publisher);
    }

    public function destroy(Publisher $publisher): PublisherResource
    {
        $publisher->delete();

        return new PublisherResource($publisher);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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

class SeriesController extends Controller
{
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
            ->with('publisher')
            ->when($publisher->id, function ($query) use ($publisher) {
                return $query->where('publisher_id', $publisher->id);
            })
            ->jsonPaginate()
            ->appends(request()->query());

        return SeriesResource::collection($series);
    }

    public function show(Series $series): SeriesResource
    {
        return new SeriesResource($series);
    }

    public function store(SeriesRequest $request, Publisher $publisher): JsonResponse
    {
        CreateSeries::dispatch($publisher, $request->all());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function update(SeriesRequest $request, Series $series): JsonResponse
    {
        UpdateSeries::dispatch($series, $request->validated());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function destroy(Series $series): JsonResponse
    {
        DeleteSeries::dispatch($series);

        return response()->json(['message' => 'Accepted'], 202);
    }
}

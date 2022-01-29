<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesRequest;
use App\Http\Resources\SeriesResource;
use App\Models\Publisher;
use App\Models\Series;
use App\Services\SeriesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SeriesController extends Controller
{
    private SeriesService $seriesService;

    public function __construct(SeriesService $seriesService)
    {
        $this->seriesService = $seriesService;
    }

    public function index(Publisher $publisher): AnonymousResourceCollection
    {
        $series = $this->seriesService->getSeriesList($publisher);

        return SeriesResource::collection($series);
    }

    public function show(Series $series): SeriesResource
    {
        return new SeriesResource($series);
    }

    public function store(SeriesRequest $request, Publisher $publisher): JsonResponse
    {
        $this->seriesService->createSeries($publisher, $request->validated());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function update(SeriesRequest $request, Series $series): JsonResponse
    {
        $this->seriesService->updateSeries($series, $request->validated());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function destroy(Series $series): JsonResponse
    {
        $this->seriesService->deleteSeries($series);

        return response()->json(['message' => 'Accepted'], 202);
    }
}

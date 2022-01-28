<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComicRequest;
use App\Http\Resources\ComicResource;
use App\Jobs\CreateComic;
use App\Jobs\DeleteComic;
use App\Jobs\UpdateComic;
use App\Models\Comic;
use App\Models\Series;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ComicController extends Controller
{
    public function index(Series $series): AnonymousResourceCollection
    {
        $comics = QueryBuilder::for(Comic::class)
            ->allowedSorts([
                'title',
                'issue_number',
            ])
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::exact('format'),
            ])
            ->with('series', 'series.publisher')
            ->when($series->id, function ($query) use ($series) {
                return $query->where('series_id', $series->id);
            })
            ->jsonPaginate()
            ->appends(request()->query());

        return ComicResource::collection($comics);
    }

    public function show(Comic $comic): ComicResource
    {
        return new ComicResource($comic);
    }

    public function store(ComicRequest $request, Series $series): JsonResponse
    {
        $request->merge(['title' => $series->title . ' #' . $request->issue_number]);
        CreateComic::dispatch($series, $request->all());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function update(ComicRequest $request, Comic $comic): JsonResponse
    {
        UpdateComic::dispatch($comic, $request->validated());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function destroy(Comic $comic): JsonResponse
    {
        DeleteComic::dispatch($comic);

        return response()->json(['message' => 'Accepted'], 202);
    }
}

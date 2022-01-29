<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComicRequest;
use App\Http\Resources\ComicResource;
use App\Models\Comic;
use App\Models\Series;
use App\Services\ComicService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ComicController extends Controller
{
    private ComicService $comicService;

    public function __construct(ComicService $comicService)
    {
        $this->comicService = $comicService;
    }

    public function index(Series $series): AnonymousResourceCollection
    {
        $comics = $this->comicService->getComicsList($series);

        return ComicResource::collection($comics);
    }

    public function show(Comic $comic): ComicResource
    {
        return new ComicResource($comic);
    }

    public function store(ComicRequest $request, Series $series): JsonResponse
    {
        $this->comicService->createComic($series, $request->all());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function update(ComicRequest $request, Comic $comic): JsonResponse
    {
        $this->comicService->updateComic($comic, $request->validated());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function destroy(Comic $comic): JsonResponse
    {
        $this->comicService->deleteComic($comic);

        return response()->json(['message' => 'Accepted'], 202);
    }
}

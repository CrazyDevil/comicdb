<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoverRequest;
use App\Http\Resources\CoverResource;
use App\Models\Comic;
use App\Models\Cover;
use App\Services\CoverService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CoverController extends Controller
{
    private CoverService $coverService;

    public function __construct(CoverService $coverService)
    {
        $this->coverService = $coverService;
    }

    public function index(Comic $comic): AnonymousResourceCollection
    {
        $covers = $this->coverService->getCoverList($comic);

        return CoverResource::collection($covers);
    }

    public function show(Cover $cover): CoverResource
    {
        return new CoverResource($cover);
    }

    public function store(CoverRequest $request, Comic $comic): JsonResponse
    {
        $this->coverService->createCover($comic, $request->all());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function update(CoverRequest $request, Cover $cover): JsonResponse
    {
        $this->coverService->updateCover($cover, $request->validated());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function destroy(Cover $cover)
    {
        $this->coverService->deleteCover($cover);

        return response()->json(['message' => 'Accepted'], 202);
    }
}

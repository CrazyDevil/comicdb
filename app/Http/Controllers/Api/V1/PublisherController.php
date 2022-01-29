<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublisherRequest;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use App\Services\PublisherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PublisherController extends Controller
{
    private PublisherService $publisherService;

    public function __construct(PublisherService $publisherService)
    {
        $this->publisherService = $publisherService;
    }

    public function index(): AnonymousResourceCollection
    {
        $publishers = $this->publisherService->getPublishersList();

        return PublisherResource::collection($publishers);
    }

    public function show(Publisher $publisher): PublisherResource
    {
        return new PublisherResource($publisher);
    }

    public function store(PublisherRequest $request): JsonResponse
    {
        $this->publisherService->createPublisher($request->validated());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function update(PublisherRequest $request, Publisher $publisher): JsonResponse
    {
        $this->publisherService->updatePublisher($publisher, $request->validated());

        return response()->json(['message' => 'Accepted'], 202);
    }

    public function destroy(Publisher $publisher): JsonResponse
    {
        $this->publisherService->deletePublisher($publisher);

        return response()->json(['message' => 'Accepted'], 202);
    }
}

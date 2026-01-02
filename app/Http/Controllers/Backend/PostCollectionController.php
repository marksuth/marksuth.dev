<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostCollectionRequest;
use App\Http\Requests\UpdatePostCollectionRequest;
use App\Http\Resources\PostCollectionResource;
use App\Models\PostCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PostCollectionController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PostCollectionResource::collection(PostCollection::all());
    }

    public function store(StorePostCollectionRequest $request): PostCollectionResource
    {
        return new PostCollectionResource(PostCollection::create($request->validated()));
    }

    public function show(PostCollection $postCollection): PostCollectionResource
    {
        return new PostCollectionResource($postCollection);
    }

    public function update(UpdatePostCollectionRequest $request, PostCollection $postCollection): PostCollectionResource
    {
        $postCollection->update($request->validated());

        return new PostCollectionResource($postCollection);
    }

    public function destroy(PostCollection $postCollection): JsonResponse
    {
        $postCollection->delete();

        return response()->json();
    }
}

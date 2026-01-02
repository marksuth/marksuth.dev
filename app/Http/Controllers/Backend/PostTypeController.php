<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostTypeRequest;
use App\Http\Requests\UpdatePostTypeRequest;
use App\Http\Resources\PostTypeResource;
use App\Models\PostType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PostTypeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PostTypeResource::collection(PostType::all());
    }

    public function store(StorePostTypeRequest $request): PostTypeResource
    {
        return new PostTypeResource(PostType::create($request->validated()));
    }

    public function show(PostType $postType): PostTypeResource
    {
        return new PostTypeResource($postType);
    }

    public function update(UpdatePostTypeRequest $request, PostType $postType): PostTypeResource
    {
        $postType->update($request->validated());

        return new PostTypeResource($postType);
    }

    public function destroy(PostType $postType): JsonResponse
    {
        $postType->delete();

        return response()->json();
    }
}

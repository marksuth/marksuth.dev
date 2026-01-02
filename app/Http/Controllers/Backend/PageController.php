<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PageController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PageResource::collection(Page::all());
    }

    public function store(StorePageRequest $request): PageResource
    {
        return new PageResource(Page::create($request->validated()));
    }

    public function show(Page $page): PageResource
    {
        return new PageResource($page);
    }

    public function update(UpdatePageRequest $request, Page $page): PageResource
    {
        $page->update($request->validated());

        return new PageResource($page);
    }

    public function destroy(Page $page): JsonResponse
    {
        $page->delete();

        return response()->json();
    }
}

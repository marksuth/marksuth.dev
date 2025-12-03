<?php

declare(strict_types=1);

namespace App\Http\Traits;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

trait ViewRendererTrait
{
    /**
     * Render a view with the given data.
     */
    protected function renderView(string $view, array $data = []): View|Factory|Application
    {
        return view($view, $data);
    }

    /**
     * Render a paginated index view.
     *
     * @param  mixed  $items
     */
    protected function renderPaginatedView(string $viewName, string $resourceName, $items, array $additionalData = []): View|Factory|Application
    {
        return $this->renderView($viewName, array_merge([$resourceName => $items], $additionalData));
    }

    /**
     * Render a single item view.
     *
     * @param  mixed  $item
     */
    protected function renderSingleItemView(string $viewName, string $resourceName, $item, array $additionalData = []): View|Factory|Application
    {
        return $this->renderView($viewName, array_merge([$resourceName => $item], $additionalData));
    }

    /**
     * Render a special response with custom headers.
     *
     * @return Response
     */
    protected function renderSpecialResponse(string $viewName, string $contentType, array $data = [])
    {
        return response()
            ->view($viewName, $data)
            ->header('Content-Type', $contentType);
    }
}

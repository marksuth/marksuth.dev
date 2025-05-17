<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Traits\HandlesMetadata;
use App\Http\Controllers\Backend\Traits\HandlesSlugGeneration;
use App\Models\PostCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class BackendCollectionController extends BaseBackendController
{
    use HandlesMetadata;
    use HandlesSlugGeneration;

    /**
     * The model class name.
     */
    protected string $modelClass = PostCollection::class;

    /**
     * The view path for this resource.
     */
    protected string $viewPath = 'backend.collections';

    /**
     * The redirect path after store/update/delete.
     */
    protected string $redirectPath = '/backend/collections';

    /**
     * Get the model query builder.
     */
    protected function getModelQuery()
    {
        return app($this->modelClass)::query()->orderBy('name');
    }

    /**
     * Fill basic model attributes from request.
     */
    protected function fillBasicAttributes(Model $model): void
    {
        $model->name = request('name');
        $model->description = request('description');

        // Generate slug from name instead of title
        $model->slug = $this->generateSlug($model->name);
    }

    /**
     * Process additional data for the model.
     */
    protected function processAdditionalData(Model $model): void
    {
        // Process metadata
        $metadataFields = ['published'];
        $booleanFields = ['published'];

        $this->applyMetadata($model, $metadataFields, $booleanFields);
    }
}

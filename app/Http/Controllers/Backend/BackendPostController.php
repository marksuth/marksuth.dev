<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Traits\HandlesImageProcessing;
use App\Http\Controllers\Backend\Traits\HandlesMetadata;
use App\Http\Controllers\Backend\Traits\HandlesSlugGeneration;
use App\Models\Post;
use App\Models\PostType;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class BackendPostController extends BaseBackendController
{
    use HandlesImageProcessing;
    use HandlesMetadata;
    use HandlesSlugGeneration;

    /**
     * The model class name.
     */
    protected string $modelClass = Post::class;

    /**
     * The view path for this resource.
     */
    protected string $viewPath = 'backend.posts';

    /**
     * The redirect path after store/update/delete.
     */
    protected string $redirectPath = '/backend/posts';

    /**
     * Get the model query builder.
     */
    protected function getModelQuery()
    {
        return app($this->modelClass)::whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('created_at');
    }

    /**
     * Prepare data for the create view.
     */
    protected function prepareCreateViewData(): array
    {
        return [
            'post_types' => $this->getPostTypes(),
        ];
    }

    /**
     * Prepare data for the edit view.
     */
    protected function prepareEditViewData(Model $model): array
    {
        return [
            'post' => $model,
            'post_types' => $this->getPostTypes(),
        ];
    }

    /**
     * Get post types for the form.
     */
    protected function getPostTypes()
    {
        return PostType::whereNotIn('id', [49, 50, 51])->get();
    }

    /**
     * Fill basic model attributes from request.
     */
    protected function fillBasicAttributes(Model $model): void
    {
        $model->title = request('title');
        $model->content = request('content');
        $model->published_at = request('published_at');
        $model->post_type_id = request('type');

        $this->applySlug($model);
    }

    /**
     * Process additional data for the model.
     */
    protected function processAdditionalData(Model $model): void
    {
        // Process metadata
        $metadataFields = [
            'description', 'web_url', 'medium_url', 'untappd_url',
            'twitter_url', 'instagram_url', 'facebook_url',
            'published', 'distant_past', 'near_future',
        ];

        $booleanFields = ['published', 'distant_past', 'near_future'];

        $meta = $this->processMetadata($model, $metadataFields, $booleanFields);

        // Process image if it's a new upload
        if (request()->hasFile('image')) {
            $image = $this->processAndStoreImage(request('image'));
            $meta['img_url'] = str_replace('public/', '', $image);
        }

        $model->meta = $meta;
    }
}

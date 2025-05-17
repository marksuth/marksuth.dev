<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Traits\HandlesImageProcessing;
use App\Http\Controllers\Backend\Traits\HandlesMetadata;
use App\Http\Controllers\Backend\Traits\HandlesSlugGeneration;
use App\Models\Photo;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Spatie\Image\Exceptions\CouldNotLoadImage;

class BackendPhotoController extends BaseBackendController
{
    use HandlesImageProcessing;
    use HandlesMetadata;
    use HandlesSlugGeneration;

    /**
     * The model class name.
     */
    protected string $modelClass = Photo::class;

    /**
     * The view path for this resource.
     */
    protected string $viewPath = 'backend.photos';

    /**
     * The redirect path after store/update/delete.
     */
    protected string $redirectPath = '/backend/photos';

    /**
     * Get the model query builder.
     */
    protected function getModelQuery()
    {
        return app($this->modelClass)::latest('created_at');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show($id): View|Factory|Application
    {
        $photo = $this->findModel($id);

        return view($this->getFormViewPath(), ['photo' => $photo]);
    }

    /**
     * Fill basic model attributes from request.
     */
    protected function fillBasicAttributes(Model $model): void
    {
        $model->title = request('title');
        $model->content = request('content');
        $model->published_at = request('published_at');

        $this->applySlug($model);
    }

    /**
     * Process additional data for the model.
     *
     * @throws CouldNotLoadImage
     */
    protected function processAdditionalData(Model $model): void
    {
        // Process metadata
        $metadataFields = ['location', 'instagram_url', 'published'];
        $booleanFields = ['published'];
        $meta = $this->processMetadata($model, $metadataFields, $booleanFields);

        // Process image if it's a new upload
        if (request()->hasFile('image')) {
            $image = $this->processAndStoreImage(request('image'));
            $thumb = $this->createThumbnail(request('image'));

            $meta['img_url'] = $this->getImageUrl($image);
        }

        $model->meta = $meta;
    }
}

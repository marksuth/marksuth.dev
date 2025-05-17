<?php

namespace App\Http\Controllers\Backend\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HandlesSlugGeneration
{
    /**
     * Generate a slug from a title.
     *
     * @param  string  $title  The title to generate a slug from
     * @return string The generated slug
     */
    protected function generateSlug(string $title): string
    {
        return Str::slug($title);
    }

    /**
     * Apply a slug to a model based on its title.
     *
     * @param  Model  $model  The model to apply the slug to
     * @param  string  $titleField  The field name containing the title
     * @param  string  $slugField  The field name to store the slug
     */
    protected function applySlug(
        Model $model,
        string $titleField = 'title',
        string $slugField = 'slug'
    ): void {
        if (isset($model->$titleField)) {
            $model->$slugField = $this->generateSlug($model->$titleField);
        }
    }
}

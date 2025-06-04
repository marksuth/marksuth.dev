<?php

namespace App\Http\Controllers\Backend\Traits;

use Illuminate\Database\Eloquent\Model;

trait HandlesMetadata
{
    /**
     * Process metadata for the model.
     *
     * @param  Model  $model  The model to process metadata for
     * @param  array  $fields  The metadata fields to process
     * @param  bool  $booleanFields  Whether to convert values to boolean for these fields
     * @return array The processed metadata
     */
    protected function processMetadata(Model $model, array $fields, array $booleanFields = []): array
    {
        $meta = [];

        // If the model already has metadata, use it as a base
        if (isset($model->meta) && is_array($model->meta)) {
            $meta = $model->meta;
        }

        // Process each field from the request
        foreach ($fields as $field) {
            if (request()->has($field)) {
                $value = request($field);

                // Convert to boolean if this field should be a boolean
                if (in_array($field, $booleanFields)) {
                    $value = (bool) $value;
                }

                $meta[$field] = $value;
            }
        }

        return $meta;
    }

    /**
     * Apply metadata to a model.
     *
     * @param  Model  $model  The model to apply metadata to
     * @param  array  $fields  The metadata fields to process
     * @param  array  $booleanFields  Fields that should be converted to boolean
     */
    protected function applyMetadata(Model $model, array $fields, array $booleanFields = []): void
    {
        $meta = $this->processMetadata($model, $fields, $booleanFields);
        $model->meta = $meta;
    }
}

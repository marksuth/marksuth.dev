<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,'.$this->post->id],
            'content' => ['required', 'string'],
            'post_type_id' => ['nullable', 'integer', 'exists:post_types,id'],
            'collection_id' => ['nullable', 'integer', 'exists:collections,id'],
            'meta' => ['nullable', 'array'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}

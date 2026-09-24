<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveGuideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    public function rules(): array
    {
        $guide = $this->route('guide');

        return [
            'title' => ['required', 'string', 'max:190'],
            'slug' => [
                'nullable',
                'string',
                'max:190',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('guides', 'slug')->ignore($guide),
            ],
            'category' => ['required', 'string', 'max:80'],
            'excerpt' => ['required', 'string', 'max:600'],
            'content' => ['required', 'string', 'min:100'],
            'meta_title' => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ];
    }
}

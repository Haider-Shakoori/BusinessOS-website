<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSeoPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    public function rules(): array
    {
        $page = $this->route('seo_page');

        return [
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:190', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('seo_pages', 'slug')->ignore($page)],
            'eyebrow' => ['nullable', 'string', 'max:190'],
            'headline' => ['required', 'string', 'max:500'],
            'excerpt' => ['required', 'string', 'max:1200'],
            'content' => ['required', 'string', 'min:250'],
            'target_keywords_text' => ['nullable', 'string', 'max:10000'],
            'faq_text' => ['nullable', 'string', 'max:20000'],
            'related_products_text' => ['nullable', 'string', 'max:5000'],
            'meta_title' => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ];
    }
}

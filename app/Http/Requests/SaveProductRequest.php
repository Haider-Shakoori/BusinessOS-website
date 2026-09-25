<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'name' => ['required', 'string', 'max:190'],
            'slug' => [
                'nullable',
                'string',
                'max:190',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('products', 'slug')->ignore($product),
            ],
            'icon_letter' => ['required', 'string', 'max:8'],
            'eyebrow' => ['nullable', 'string', 'max:190'],
            'headline' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:1200'],
            'description' => ['required', 'string', 'max:5000'],
            'category' => ['required', 'string', 'max:80'],
            'application_category' => ['required', 'string', 'max:80'],
            'operating_system' => ['required', 'string', 'max:190'],
            'platforms_text' => ['nullable', 'string', 'max:4000'],
            'status' => ['required', 'string', 'max:80'],
            'accent' => ['nullable', 'string', 'max:40'],
            'subdomain' => [
                'nullable',
                'string',
                'max:190',
                'regex:/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,63}$/i',
            ],
            'web_url' => ['nullable', 'url:http,https', 'max:2048'],
            'featured' => ['nullable', 'boolean'],
            'is_visible' => ['nullable', 'boolean'],
            'show_on_homepage' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:100000'],
            'homepage_order' => ['required', 'integer', 'min:0', 'max:100000'],
            'publication_state' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'seo_title' => ['nullable', 'string', 'max:190'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'screenshots_text' => ['nullable', 'string', 'max:10000'],
            'highlights_text' => ['nullable', 'string', 'max:10000'],
            'problem_title' => ['nullable', 'string', 'max:500'],
            'problem_body_text' => ['nullable', 'string', 'max:10000'],
            'features_intro_title' => ['nullable', 'string', 'max:500'],
            'features_intro_description' => ['nullable', 'string', 'max:2000'],
            'features_text' => ['nullable', 'string', 'max:20000'],
            'use_cases_intro_title' => ['nullable', 'string', 'max:500'],
            'use_cases_intro_description' => ['nullable', 'string', 'max:2000'],
            'use_cases_text' => ['nullable', 'string', 'max:10000'],
            'preview_section' => ['nullable', 'string', 'max:120'],
            'preview_title' => ['nullable', 'string', 'max:190'],
            'preview_status' => ['nullable', 'string', 'max:80'],
            'preview_metrics_text' => ['nullable', 'string', 'max:10000'],
            'preview_rows_text' => ['nullable', 'string', 'max:10000'],
            'spotlight_kicker' => ['nullable', 'string', 'max:190'],
            'spotlight_title' => ['nullable', 'string', 'max:500'],
            'spotlight_description' => ['nullable', 'string', 'max:3000'],
            'spotlight_items_text' => ['nullable', 'string', 'max:10000'],
            'pricing_status' => ['nullable', 'string', 'max:190'],
            'pricing_note' => ['nullable', 'string', 'max:3000'],
            'final_title' => ['nullable', 'string', 'max:500'],
            'final_description' => ['nullable', 'string', 'max:3000'],
            'faq_text' => ['nullable', 'string', 'max:20000'],
            'live_note' => ['nullable', 'string', 'max:2000'],
            'name_fa' => ['nullable', 'string', 'max:190'],
            'eyebrow_fa' => ['nullable', 'string', 'max:190'],
            'headline_fa' => ['nullable', 'string', 'max:255'],
            'short_description_fa' => ['nullable', 'string', 'max:1200'],
            'description_fa' => ['nullable', 'string', 'max:5000'],
            'seo_title_fa' => ['nullable', 'string', 'max:190'],
            'seo_description_fa' => ['nullable', 'string', 'max:255'],
            'name_ps' => ['nullable', 'string', 'max:190'],
            'eyebrow_ps' => ['nullable', 'string', 'max:190'],
            'headline_ps' => ['nullable', 'string', 'max:255'],
            'short_description_ps' => ['nullable', 'string', 'max:1200'],
            'description_ps' => ['nullable', 'string', 'max:5000'],
            'seo_title_ps' => ['nullable', 'string', 'max:190'],
            'seo_description_ps' => ['nullable', 'string', 'max:255'],
            'pricing_model' => ['nullable', 'string', 'max:190'],
            'pricing_plans_text' => ['nullable', 'string', 'max:20000'],
            'deployment_options_text' => ['nullable', 'string', 'max:10000'],
        ];
    }
}

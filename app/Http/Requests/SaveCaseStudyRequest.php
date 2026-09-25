<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveCaseStudyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    public function rules(): array
    {
        $caseStudy = $this->route('case_study');

        return [
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:190', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('case_studies', 'slug')->ignore($caseStudy)],
            'industry' => ['required', 'string', 'max:120'],
            'summary' => ['required', 'string', 'max:1200'],
            'challenge' => ['required', 'string', 'min:100'],
            'solution' => ['required', 'string', 'min:100'],
            'outcome' => ['nullable', 'string', 'min:50'],
            'meta_title' => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ];
    }
}

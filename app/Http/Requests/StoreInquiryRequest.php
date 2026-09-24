<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'company' => ['nullable', 'string', 'max:190'],
            'phone' => ['nullable', 'string', 'max:60'],
            'inquiry_type' => ['required', Rule::in(['contact', 'demo', 'sales'])],
            'app_slug' => ['nullable', 'string', Rule::in(array_keys(config('businessos.apps', [])))],
            'team_size' => ['nullable', 'string', 'max:80'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
            'website' => ['prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'website.prohibited' => 'Unable to submit this request.',
        ];
    }
}

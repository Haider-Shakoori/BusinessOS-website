@extends('layouts.admin')

@section('title', 'Website Settings')
@section('page-heading', 'Website Settings')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">Global CMS</span>
        <h1>Website content and identity.</h1>
        <p>Edit brand, homepage, About, contact and SEO defaults without changing Blade templates.</p>
    </div>
</div>

<form class="cms-editor settings-editor" method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    @method('PUT')
    <div class="cms-editor-main">
        @foreach ($fields as $group => $items)
            <section class="admin-panel admin-form">
                <div class="admin-form-section-head"><span>{{ strtoupper($group) }}</span><h2>{{ str($group)->headline() }}</h2></div>
                @foreach ($items as $key => $field)
                    <label>{{ $field['label'] }}
                        @if (($field['max'] ?? 5000) > 500)
                            <textarea name="{{ $key }}" rows="{{ str_contains($key, 'body') || str_contains($key, 'description') ? 5 : 3 }}" maxlength="{{ $field['max'] ?? 5000 }}">{{ old($key, $settings[$key] ?? $field['default']) }}</textarea>
                        @else
                            <input type="text" name="{{ $key }}" maxlength="{{ $field['max'] ?? 5000 }}" value="{{ old($key, $settings[$key] ?? $field['default']) }}">
                        @endif
                        @error($key)<small>{{ $message }}</small>@enderror
                    </label>
                @endforeach
            </section>
        @endforeach
    </div>
    <aside class="cms-editor-side">
        <section class="admin-panel admin-form sticky-save-panel">
            <div class="admin-form-section-head"><span>PUBLISH</span><h2>Global settings</h2></div>
            <p class="admin-panel-copy">Changes are reflected immediately after saving. Empty translated fields fall back to English.</p>
            <button class="admin-primary-button" type="submit">Save website settings</button>
        </section>
    </aside>
</form>
@endsection

@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero contact-hero">
    <div class="shell contact-grid">
        <div>
            <span class="kicker">{{ $pageKicker }}</span>
            <h1>{{ $pageTitle }}</h1>
            <p>{{ $pageLead }}</p>
            <div class="contact-promises">
                <span><i>01</i>{{ __('marketing.pages.contact.promise_1') }}</span>
                <span><i>02</i>{{ __('marketing.pages.contact.promise_2') }}</span>
                <span><i>03</i>{{ __('marketing.pages.contact.promise_3') }}</span>
            </div>
        </div>

        <div class="contact-form-card">
            @if (session('inquiry_success'))
                <div class="form-success" role="status">{{ session('inquiry_success') }}</div>
            @endif

            <form method="POST" action="{{ route('inquiries.store') }}">
                @csrf
                <input type="hidden" name="inquiry_type" value="{{ request('type', $inquiryType) === 'sales' ? 'sales' : $inquiryType }}">

                <div class="hp-field" aria-hidden="true">
                    <label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                </div>

                <div class="form-row">
                    <label>{{ __('marketing.pages.contact.name') }}
                        <input type="text" name="name" value="{{ old('name') }}" maxlength="120" autocomplete="name" required>
                        @error('name')<small>{{ $message }}</small>@enderror
                    </label>
                    <label>{{ __('marketing.pages.contact.email') }}
                        <input type="email" name="email" value="{{ old('email') }}" maxlength="190" autocomplete="email" required>
                        @error('email')<small>{{ $message }}</small>@enderror
                    </label>
                </div>

                <div class="form-row">
                    <label>{{ __('marketing.pages.contact.company') }}
                        <input type="text" name="company" value="{{ old('company') }}" maxlength="190" autocomplete="organization">
                    </label>
                    <label>{{ __('marketing.pages.contact.phone') }} <span>{{ __('marketing.pages.contact.optional') }}</span>
                        <input type="text" name="phone" value="{{ old('phone') }}" maxlength="60" autocomplete="tel">
                    </label>
                </div>

                <div class="form-row">
                    <label>{{ __('marketing.pages.contact.product') }}
                        <select name="app_slug">
                            <option value="">{{ __('marketing.pages.contact.general') }}</option>
                            @foreach ($apps as $app)
                                <option value="{{ $app['slug'] }}" @selected(old('app_slug', $selectedApp) === $app['slug'])>{{ $app['name'] }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>{{ __('marketing.pages.contact.team_size') }} <span>{{ __('marketing.pages.contact.optional') }}</span>
                        <input type="text" name="team_size" value="{{ old('team_size') }}" maxlength="80" placeholder="{{ __('marketing.pages.contact.team_placeholder') }}">
                    </label>
                </div>

                <label>{{ __('marketing.pages.contact.message') }}
                    <textarea name="message" rows="6" maxlength="3000" required placeholder="{{ __('marketing.pages.contact.message_placeholder') }}">{{ old('message') }}</textarea>
                    @error('message')<small>{{ $message }}</small>@enderror
                </label>

                @if ($errors->any())
                    <div class="form-error-summary" role="alert">{{ __('marketing.pages.contact.review') }}</div>
                @endif

                <button class="button button-primary contact-submit" type="submit">{{ __('marketing.pages.contact.send') }} <span aria-hidden="true">→</span></button>
                <p class="form-privacy">{{ __('marketing.pages.contact.privacy') }} <a href="{{ route('privacy') }}">{{ __('marketing.pages.contact.privacy_link') }}</a>.</p>
            </form>
        </div>
    </div>
</section>
@endsection

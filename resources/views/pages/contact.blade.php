@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero contact-hero">
    <div class="shell contact-grid">
        <div>
            <span class="kicker">{{ $pageKicker }}</span>
            <h1>{{ $pageTitle }}</h1>
            <p>{{ $pageLead }}</p>
            <div class="contact-promises">
                <span><i>01</i>No invented sales claims</span>
                <span><i>02</i>Product-specific discussion</span>
                <span><i>03</i>Your request is saved for follow-up</span>
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
                    <label>Full name
                        <input type="text" name="name" value="{{ old('name') }}" maxlength="120" autocomplete="name" required>
                        @error('name')<small>{{ $message }}</small>@enderror
                    </label>
                    <label>Work email
                        <input type="email" name="email" value="{{ old('email') }}" maxlength="190" autocomplete="email" required>
                        @error('email')<small>{{ $message }}</small>@enderror
                    </label>
                </div>

                <div class="form-row">
                    <label>Company
                        <input type="text" name="company" value="{{ old('company') }}" maxlength="190" autocomplete="organization">
                    </label>
                    <label>Phone <span>optional</span>
                        <input type="text" name="phone" value="{{ old('phone') }}" maxlength="60" autocomplete="tel">
                    </label>
                </div>

                <div class="form-row">
                    <label>Product
                        <select name="app_slug">
                            <option value="">General BusinessOS inquiry</option>
                            @foreach ($apps as $app)
                                <option value="{{ $app['slug'] }}" @selected(old('app_slug', $selectedApp) === $app['slug'])>{{ $app['name'] }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>Team size <span>optional</span>
                        <input type="text" name="team_size" value="{{ old('team_size') }}" maxlength="80" placeholder="e.g. 10 field users">
                    </label>
                </div>

                <label>What do you want to improve?
                    <textarea name="message" rows="6" maxlength="3000" required placeholder="Describe the workflow, team or problem you want to discuss.">{{ old('message') }}</textarea>
                    @error('message')<small>{{ $message }}</small>@enderror
                </label>

                @if ($errors->any())
                    <div class="form-error-summary" role="alert">Please review the highlighted fields and submit again.</div>
                @endif

                <button class="button button-primary contact-submit" type="submit">Send request <span aria-hidden="true">→</span></button>
                <p class="form-privacy">By submitting, you agree that BusinessOS may use the information to respond to your request. See the <a href="{{ route('privacy') }}">Privacy Policy</a>.</p>
            </form>
        </div>
    </div>
</section>
@endsection

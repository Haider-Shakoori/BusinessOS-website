@extends('layouts.admin')

@section('title', 'Inquiry')
@section('page-heading', 'Inquiry')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">{{ strtoupper($inquiry->inquiry_type) }} · {{ $inquiry->created_at->format('M j, Y H:i') }}</span>
        <h1>{{ $inquiry->name }}</h1>
        <p>{{ $inquiry->company ?: 'No company supplied' }} · <a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a>@if($inquiry->phone) · {{ $inquiry->phone }}@endif</p>
    </div>
    <a class="admin-secondary-button" href="{{ route('admin.inquiries.index') }}">← Inbox</a>
</div>

<div class="admin-panel-grid inquiry-detail-grid">
    <section class="admin-panel admin-form">
        <div class="admin-form-section-head"><span>REQUEST</span><h2>Customer message</h2></div>
        <div class="inquiry-facts">
            <div><span>Product</span><strong>{{ $inquiry->app_slug ?: 'General BusinessOS' }}</strong></div>
            <div><span>Team size</span><strong>{{ $inquiry->team_size ?: 'Not supplied' }}</strong></div>
            <div><span>Source</span><strong>{{ $inquiry->source_url ?: 'Direct / unknown' }}</strong></div>
        </div>
        <div class="inquiry-message">{{ $inquiry->message }}</div>
    </section>

    <section class="admin-panel admin-form">
        <div class="admin-form-section-head"><span>FOLLOW-UP</span><h2>Status and next action</h2></div>
        <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}">
            @csrf
            @method('PUT')
            <label>Status
                <select name="status">
                    @foreach (['new' => 'New', 'in_progress' => 'In progress', 'resolved' => 'Resolved', 'archived' => 'Archived'] as $key => $label)
                        <option value="{{ $key }}" @selected($inquiry->status === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label>Follow-up date/time
                <input type="datetime-local" name="follow_up_at" value="{{ $inquiry->follow_up_at?->format('Y-m-d\TH:i') }}">
            </label>
            <button class="admin-primary-button" type="submit">Save follow-up</button>
        </form>
    </section>
</div>

<section class="admin-panel admin-form">
    <div class="admin-form-section-head"><span>HISTORY</span><h2>Internal notes</h2></div>
    <form method="POST" action="{{ route('admin.inquiries.notes.store', $inquiry) }}">
        @csrf
        <label>Add internal note
            <textarea name="note" rows="4" maxlength="5000" required placeholder="What happened, what was promised, and what should happen next?"></textarea>
        </label>
        <button class="admin-primary-button" type="submit">Add note</button>
    </form>

    <div class="inquiry-notes">
        @forelse ($inquiry->notes as $note)
            <article>
                <div><strong>{{ $note->user?->name ?: 'Administrator' }}</strong><time>{{ $note->created_at->format('M j, Y H:i') }}</time></div>
                <p>{{ $note->note }}</p>
            </article>
        @empty
            <div class="cms-empty">No internal notes yet.</div>
        @endforelse
    </div>
</section>
@endsection

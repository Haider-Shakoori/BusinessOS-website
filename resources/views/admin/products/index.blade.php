@extends('layouts.admin')

@section('title', 'Products')
@section('page-heading', 'Products')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">Product CMS</span>
        <h1>BusinessOS products.</h1>
        <p>Manage the products shown across the public website. Publication, visibility and ordering are controlled here instead of in Blade or config files.</p>
    </div>
    <a class="admin-primary-button" href="{{ route('admin.products.create') }}">New product <span>+</span></a>
</div>

<section class="admin-panel">
    <div class="cms-table">
        <div class="cms-table-head"><span>Product</span><span>Publication</span><span>Homepage</span><span></span></div>
        @forelse ($products as $product)
            <div class="cms-table-row">
                <div>
                    <strong>{{ $product->name }}</strong>
                    <small>/apps/{{ $product->slug }}@if($product->subdomain) · {{ $product->subdomain }}@endif</small>
                </div>
                <span class="status-chip {{ $product->publication_state === 'published' ? 'published' : 'draft' }}">{{ ucfirst($product->publication_state) }}</span>
                <span class="cms-product-home">
                    {{ $product->show_on_homepage && $product->is_visible ? 'Visible' : 'Hidden' }}
                    · {{ $product->homepage_order }}
                </span>
                <a href="{{ route('admin.products.edit', $product) }}">Edit →</a>
            </div>
        @empty
            <div class="cms-empty">No products yet. Create the first BusinessOS product or run the product seeder.</div>
        @endforelse
    </div>

    @if ($products->hasPages())
        <div class="admin-pagination">
            @if (!$products->onFirstPage())<a href="{{ $products->previousPageUrl() }}">← Previous</a>@else<span>← Previous</span>@endif
            <span>Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</span>
            @if ($products->hasMorePages())<a href="{{ $products->nextPageUrl() }}">Next →</a>@else<span>Next →</span>@endif
        </div>
    @endif
</section>
@endsection

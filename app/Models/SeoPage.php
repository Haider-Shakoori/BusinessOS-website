<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeoPage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'eyebrow', 'headline', 'excerpt', 'content',
        'target_keywords', 'faq', 'related_product_slugs',
        'meta_title', 'meta_description', 'status', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'target_keywords' => 'array',
            'faq' => 'array',
            'related_product_slugs' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}

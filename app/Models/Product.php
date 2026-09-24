<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon_letter',
        'eyebrow',
        'headline',
        'short_description',
        'description',
        'category',
        'application_category',
        'operating_system',
        'platforms',
        'status',
        'accent',
        'subdomain',
        'web_url',
        'featured',
        'is_visible',
        'show_on_homepage',
        'sort_order',
        'homepage_order',
        'publication_state',
        'published_at',
        'seo_title',
        'seo_description',
        'screenshots',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'platforms' => 'array',
            'screenshots' => 'array',
            'content' => 'array',
            'featured' => 'boolean',
            'is_visible' => 'boolean',
            'show_on_homepage' => 'boolean',
            'sort_order' => 'integer',
            'homepage_order' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query
            ->where('publication_state', 'published')
            ->where('is_visible', true);
    }

    public function scopeHomepage(Builder $query): Builder
    {
        return $query
            ->publiclyVisible()
            ->where('show_on_homepage', true)
            ->orderBy('homepage_order')
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public static function marketingDefaults(): array
    {
        return [
            'platforms' => [],
            'preview' => [
                'section' => 'Product',
                'title' => 'Overview',
                'status' => 'Available',
                'metrics' => [],
                'rows' => [],
            ],
            'highlights' => [],
            'problem' => [
                'title' => '',
                'body' => [],
            ],
            'features_intro' => [
                'title' => '',
                'description' => '',
            ],
            'features' => [],
            'use_cases_intro' => [
                'title' => '',
                'description' => '',
            ],
            'use_cases' => [],
            'spotlight' => [
                'kicker' => '',
                'title' => '',
                'description' => '',
                'items' => [],
            ],
            'commercial' => [
                'pricing_status' => 'Pricing in preparation',
                'pricing_note' => '',
            ],
            'final' => [
                'title' => '',
                'description' => '',
            ],
            'faq' => [],
            'screenshots' => [],
            'live_note' => null,
        ];
    }

    public function toMarketingArray(): array
    {
        $content = array_merge(
            self::marketingDefaults(),
            is_array($this->content) ? $this->content : []
        );

        return array_merge($content, [
            'name' => $this->name,
            'slug' => $this->slug,
            'icon_letter' => $this->icon_letter,
            'eyebrow' => $this->eyebrow,
            'headline' => $this->headline,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'category' => $this->category,
            'application_category' => $this->application_category,
            'operating_system' => $this->operating_system,
            'platforms' => $this->platforms ?? [],
            'status' => $this->status,
            'featured' => $this->featured,
            'accent' => $this->accent,
            'subdomain' => $this->subdomain,
            'web_url' => $this->web_url,
            'screenshots' => $this->screenshots ?? [],
            'updated_at' => $this->updated_at?->toDateString(),
            'seo' => [
                'title' => $this->seo_title ?: $this->name.' — BusinessOS',
                'description' => $this->seo_description ?: ($this->short_description ?: $this->description),
            ],
        ]);
    }
}

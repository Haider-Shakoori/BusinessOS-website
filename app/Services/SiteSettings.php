<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Throwable;

class SiteSettings
{
    public const CACHE_KEY = 'businessos.site-settings.v1';

    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            try {
                return SiteSetting::query()->pluck('value', 'key')->all();
            } catch (Throwable) {
                return [];
            }
        });
    }

    public function get(string $key, ?string $default = null): ?string
    {
        $value = $this->all()[$key] ?? null;

        return is_string($value) && $value !== '' ? $value : $default;
    }

    public function localized(string $key, ?string $default = null, ?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();

        if ($locale !== 'en') {
            $localized = $this->get($key.'_'.$locale);
            if ($localized !== null && $localized !== '') {
                return $localized;
            }
        }

        return $this->get($key, $default);
    }

    public function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}

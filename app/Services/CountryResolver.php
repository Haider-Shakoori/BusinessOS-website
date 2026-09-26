<?php

namespace App\Services;

use MaxMind\Db\Reader;
use Throwable;

class CountryResolver
{
    private ?Reader $reader = null;

    private ?string $readerPath = null;

    public function resolve(?string $ip): ?string
    {
        $ip = trim((string) $ip);

        if ($ip === '' || filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) === false) {
            return null;
        }

        $reader = $this->reader();

        if (! $reader) {
            return null;
        }

        try {
            return $this->normalizeCountryCode(data_get($reader->get($ip), 'country.iso_code'));
        } catch (Throwable) {
            return null;
        }
    }

    public function __destruct()
    {
        $this->closeReader();
    }

    private function reader(): ?Reader
    {
        if (! (bool) config('analytics.local_country_lookup', true)) {
            return null;
        }

        $path = (string) config(
            'analytics.country_database_path',
            storage_path('app/analytics/dbip-country-lite.mmdb')
        );

        if ($path === '' || ! is_file($path) || ! is_readable($path)) {
            return null;
        }

        if ($this->reader && $this->readerPath === $path) {
            return $this->reader;
        }

        $this->closeReader();

        try {
            $this->reader = new Reader($path);
            $this->readerPath = $path;

            return $this->reader;
        } catch (Throwable) {
            $this->reader = null;
            $this->readerPath = null;

            return null;
        }
    }

    private function closeReader(): void
    {
        if ($this->reader) {
            try {
                $this->reader->close();
            } catch (Throwable) {
                // Never let analytics affect the public request.
            }
        }

        $this->reader = null;
        $this->readerPath = null;
    }

    private function normalizeCountryCode(mixed $value): ?string
    {
        $code = strtoupper(trim((string) $value));

        return preg_match('/^[A-Z]{2}$/', $code) && ! in_array($code, ['XX', 'T1'], true)
            ? $code
            : null;
    }
}

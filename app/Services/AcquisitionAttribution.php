<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AcquisitionAttribution
{
    /**
     * Attribution is only derived from explicitly tagged URLs and recognized search
     * referrals. Ordinary on-site search terms and full referrer URLs are not stored.
     *
     * @return array{campaign_source: ?string, search_keyword: ?string}
     */
    public function fromRequest(Request $request): array
    {
        $source = $this->clean($request->query('utm_source'), 120);
        $keyword = $this->clean($request->query('utm_term'), 160);

        if ($keyword === null) {
            $keyword = $this->searchReferrerKeyword((string) $request->header('referer'));
        }

        return [
            'campaign_source' => $source,
            'search_keyword' => $keyword,
        ];
    }

    private function searchReferrerKeyword(string $url): ?string
    {
        if (strlen($url) > 4096) {
            return null;
        }

        $parts = parse_url($url);
        if (! is_array($parts) || ! in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)) {
            return null;
        }

        $host = strtolower((string) ($parts['host'] ?? ''));
        $params = match (true) {
            $this->isDomain($host, 'google.com'),
            $this->isDomain($host, 'bing.com'),
            $this->isDomain($host, 'duckduckgo.com'),
            $this->isDomain($host, 'ecosia.org'),
            $this->isDomain($host, 'search.brave.com') => ['q'],
            $this->isDomain($host, 'yahoo.com') => ['p'],
            $this->isDomain($host, 'yandex.com'),
            $this->isDomain($host, 'yandex.ru') => ['text'],
            $this->isDomain($host, 'baidu.com') => ['wd'],
            default => [],
        };

        if ($params === [] || empty($parts['query'])) {
            return null;
        }

        parse_str((string) $parts['query'], $query);
        foreach ($params as $param) {
            $keyword = $this->clean($query[$param] ?? null, 160);
            if ($keyword !== null) {
                return $keyword;
            }
        }

        return null;
    }

    private function isDomain(string $host, string $domain): bool
    {
        return $host === $domain || str_ends_with($host, '.'.$domain);
    }

    private function clean(mixed $value, int $max): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value) ?? '');
        $value = Str::limit($value, $max, '');

        return $value !== '' ? $value : null;
    }
}

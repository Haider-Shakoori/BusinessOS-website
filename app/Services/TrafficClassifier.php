<?php

namespace App\Services;

class TrafficClassifier
{
    /**
     * @return array{type: string, family: ?string}
     */
    public function classify(?string $userAgent): array
    {
        $userAgent = trim((string) $userAgent);
        $ua = strtolower($userAgent);

        if ($ua === '') {
            return ['type' => 'other_bot', 'family' => 'Empty user agent'];
        }

        foreach ($this->aiCrawlers() as $family => $pattern) {
            if (preg_match($pattern, $ua)) {
                return ['type' => 'ai_crawler', 'family' => $family];
            }
        }

        foreach ($this->searchCrawlers() as $family => $pattern) {
            if (preg_match($pattern, $ua)) {
                return ['type' => 'search_crawler', 'family' => $family];
            }
        }
        foreach ($this->otherBots() as $family => $pattern) {
            if (preg_match($pattern, $ua)) {
                return ['type' => 'other_bot', 'family' => $family];
            }
        }

        if (preg_match('/\b(bot|crawler|spider|scraper|scan(?:ner)?)\b/i', $ua)) {
            return ['type' => 'other_bot', 'family' => 'Generic bot'];
        }

        return ['type' => 'human', 'family' => null];
    }

    /**
     * @return array<string, string>
     */
    private function aiCrawlers(): array
    {
        return [
            'OpenAI GPTBot' => '/gptbot/i',
            'OpenAI SearchBot' => '/oai-searchbot/i',
            'ChatGPT User' => '/chatgpt-user/i',
            'Anthropic ClaudeBot' => '/claudebot/i',
            'Anthropic Claude User' => '/claude-user/i',
            'Anthropic Claude SearchBot' => '/claude-searchbot/i',
            'Anthropic crawler' => '/anthropic-ai|claude-web/i',
            'PerplexityBot' => '/perplexitybot/i',
            'Perplexity User' => '/perplexity-user/i',
            'Cohere crawler' => '/cohere-ai/i',
            'YouBot' => '/youbot/i',
            'Meta AI crawler' => '/meta-externalagent|meta-externalfetcher/i',
            'ByteDance Bytespider' => '/bytespider/i',
        ];
    }

    /**
     * @return array<string, string>
     */
    private function searchCrawlers(): array
    {
        return [
            'Googlebot' => '/googlebot/i',
            'GoogleOther' => '/googleother/i',
            'Google Inspection Tool' => '/google-inspectiontool/i',
            'Google Lens' => '/google-lens/i',
            'Bingbot' => '/bingbot|bingpreview/i',
            'DuckDuckBot' => '/duckduckbot/i',
            'Applebot' => '/applebot/i',
            'YandexBot' => '/yandex(?:bot|images)/i',
            'Baidu Spider' => '/baiduspider/i',
            'Yahoo Slurp' => '/\bslurp\b/i',
            'PetalBot' => '/petalbot/i',
            'Sogou' => '/sogou/i',
        ];
    }

    /**
     * @return array<string, string>
     */
    private function otherBots(): array
    {
        return [
            'Common Crawl' => '/ccbot/i',
            'Facebook crawler' => '/facebookexternalhit|facebookbot/i',
            'X / Twitter crawler' => '/twitterbot/i',
            'LinkedIn crawler' => '/linkedinbot/i',
            'Slack crawler' => '/slackbot/i',
            'Discord crawler' => '/discordbot/i',
            'Telegram crawler' => '/telegrambot/i',
            'WhatsApp crawler' => '/whatsapp/i',
            'Ahrefs' => '/ahrefsbot/i',
            'Semrush' => '/semrushbot/i',
            'MJ12bot' => '/mj12bot/i',
            'DotBot' => '/dotbot/i',
            'DataForSeo' => '/dataforseobot/i',
            'Amazonbot' => '/amazonbot/i',
            'Diffbot' => '/diffbot/i',
            'VisionHeight scanner' => '/visionheight\.com\/scan/i',
            'cURL' => '/\bcurl\//i',
            'Wget' => '/\bwget\//i',
            'Python HTTP client' => '/python-requests|python-urllib|aiohttp/i',
            'Go HTTP client' => '/go-http-client/i',
            'Java HTTP client' => '/apache-httpclient|java\//i',
            'Node HTTP client' => '/node-fetch|axios\//i',
            'OkHttp' => '/okhttp/i',
            'Postman' => '/postmanruntime/i',
            'Headless browser' => '/headlesschrome|phantomjs|selenium|playwright/i',
            'Lighthouse' => '/lighthouse/i',
            'Monitoring service' => '/monitoring|uptime|statuscake|pingdom|uptimerobot/i',
            'Security scanner' => '/zgrab|masscan|nmap|nikto|nuclei|sqlmap|acunetix|nessus|burp/i',
        ];
    }
}
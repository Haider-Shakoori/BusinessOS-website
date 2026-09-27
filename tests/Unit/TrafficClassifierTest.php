<?php

namespace Tests\Unit;

use App\Services\TrafficClassifier;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TrafficClassifierTest extends TestCase
{
    #[DataProvider('automatedClients')]
    public function test_automated_clients_are_classified(string $userAgent, string $type, string $family): void
    {
        $result = (new TrafficClassifier)->classify($userAgent);

        $this->assertSame($type, $result['type']);
        $this->assertSame($family, $result['family']);
    }

    public function test_normal_browser_is_human(): void
    {
        $result = (new TrafficClassifier)->classify(
            'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 Version/18.0 Mobile/15E148 Safari/604.1'
        );

        $this->assertSame('human', $result['type']);
        $this->assertNull($result['family']);
    }

    public static function automatedClients(): array
    {
        return [
            'GoogleOther' => [
                'Mozilla/5.0 Chrome/153.0 Mobile Safari/537.36 (compatible; GoogleOther)',
                'search_crawler',
                'GoogleOther',
            ],
            'Google inspection' => [
                'Mozilla/5.0 (compatible; Google-InspectionTool/1.0)',
                'search_crawler',
                'Google Inspection Tool',
            ],
            'GPTBot' => [
                'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; GPTBot/1.2',
                'ai_crawler',
                'OpenAI GPTBot',
            ],
            'Perplexity' => [
                'Mozilla/5.0 (compatible; PerplexityBot/1.0)',
                'ai_crawler',
                'PerplexityBot',
            ],
            'curl' => [
                'curl/7.76.1',
                'other_bot',
                'cURL',
            ],
            'scanner' => [
                'visionheight.com/scan Mozilla/5.0 Chrome/126.0.0.0 Safari/537.36',
                'other_bot',
                'VisionHeight scanner',
            ],
            'empty user agent' => [
                '',
                'other_bot',
                'Empty user agent',
            ],
        ];
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiService
{
    protected $apiKey;
    protected $model;
    protected $endpointTemplate;
    protected $timeout;
    protected $maxRetries;
    protected $retryDelay;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->model = env('GEMINI_MODEL', 'gemini-2.5-flash');
        $this->endpointTemplate = env('GEMINI_API_ENDPOINT', 'https://generativelanguage.googleapis.com/v1/models/{MODEL}:generateContent');
        $this->timeout = (int) env('GEMINI_TIMEOUT', 30);
        $this->maxRetries = (int) env('GEMINI_MAX_RETRIES', 3);
        $this->retryDelay = (int) env('GEMINI_RETRY_DELAY', 5);
    }

    /**
     * Get the final endpoint URL by replacing placeholders.
     */
    protected function getUrl(): string
    {
        return str_replace('{MODEL}', $this->model, $this->endpointTemplate);
    }

    /**
     * Send a prompt to the AI and return the structured response.
     *
     * @param string $prompt
     * @param bool $mock
     * @return array
     */
    public function getAnalysis(string $prompt, bool $mock = false): array
    {

        if ($mock || empty($this->apiKey)) {
            Log::info('AiService: Using mock response.');
            return $this->getMockResponse();
        }

        $url = $this->getUrl();
        $fullUrl = $url . (str_contains($url, '?') ? '&' : '?') . 'key=' . $this->apiKey;
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])
                ->timeout($this->timeout)
                ->retry($this->maxRetries, $this->retryDelay * 1000)
                ->post($fullUrl, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]);
            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
                return json_decode($text, true) ?: ['error' => 'Invalid JSON from AI', 'raw' => $text];
            }

            Log::error('AiService: API Request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'url' => $url // Log without API key for safety
            ]);

            return [
                'error' => 'AI Service unavailable',
                'status' => $response->status(),
                'details' => $response->json('error.message') ?? 'Unknown error'
            ];
        } catch (\Throwable $th) {
            Log::error('AiService: Exception occurred', [
                'message' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            return ['error' => 'Exception in AI Service: ' . $th->getMessage()];
        }
    }

    /**
     * Returns a mock RCA response for testing/demonstration.
     */
    protected function getMockResponse(): array
    {
        return [
            'root_causes' => [
                [
                    'cause' => 'Database connection timeout',
                    'description' => 'The application failed to connect to the MySQL database because the connection was refused or timed out.',
                    'confidence' => 0.85,
                    'severity' => 'Critical',
                    'correlation_id' => 'err_db_001'
                ],
                [
                    'cause' => 'Missing Bugsnag Driver',
                    'description' => 'The logging configuration specifies "bugsnag" but the necessary driver or package seems to be missing or misconfigured in the current environment.',
                    'confidence' => 0.95,
                    'severity' => 'Medium',
                    'correlation_id' => 'err_log_002'
                ]
            ],
            'recommendations' => [
                'Verify database credentials in .env',
                'Check if Bugsnag package is installed via composer',
                'Ensure the database server is running and accessible from the app'
            ]
        ];
    }
}

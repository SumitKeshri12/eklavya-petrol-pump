<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class RcaService
{
    protected $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Preprocess logs and get RCA results.
     *
     * @param int $lines
     * @return array
     */
    public function analyzeLogs(int $lines = 200): array
    {
        $rawLogs = $this->getLastLogLines($lines);
        if (empty($rawLogs)) {
            return [
                'status' => 'success',
                'message' => 'No logs found to analyze.',
                'results' => []
            ];
        }

        $preprocessedLogs = $this->preprocess($rawLogs);

        // Limit the number of unique error clusters sent to the AI
        $batchSize = (int) env('GEMINI_BATCH_SIZE', 10);
        $limitedLogs = array_slice($preprocessedLogs, 0, $batchSize, true);

        $prompt = $this->buildPrompt($limitedLogs);

        $analysis = $this->aiService->getAnalysis($prompt);

        return [
            'status' => 'success',
            'timestamp' => now()->toIso8601String(),
            'log_summary' => [
                'total_lines_read' => count(explode("\n", $rawLogs)),
                'unique_clusters' => count($preprocessedLogs)
            ],
            'analysis' => $analysis
        ];
    }

    /**
     * Read the last N lines from the laravel log file.
     */
    protected function getLastLogLines(int $lines): string
    {
        $logPath = storage_path('logs/laravel.log');

        if (!file_exists($logPath)) {
            return "";
        }

        // Read last N lines
        $data = file($logPath);
        $lastLines = array_slice($data, -$lines);

        return implode("", $lastLines);
    }

    /**
     * Preprocess logs: Handle multi-line entries and Cluster.
     */
    protected function preprocess(string $rawLogs): array
    {
        $lines = explode("\n", trim($rawLogs));
        $entries = [];
        $currentEntry = null;

        // Group lines into entries (a Laravel log entry starts with [timestamp])
        foreach ($lines as $line) {
            if (preg_match('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]/', $line)) {
                if ($currentEntry) {
                    $entries[] = $currentEntry;
                }
                $currentEntry = $line;
            } else {
                if ($currentEntry !== null) {
                    $currentEntry .= "\n" . $line;
                }
            }
        }
        if ($currentEntry) {
            $entries[] = $currentEntry;
        }

        $clusters = [];
        foreach ($entries as $entry) {
            $pattern = $this->extractPattern($entry);

            if (!isset($clusters[$pattern])) {
                $clusters[$pattern] = [
                    'message' => $this->truncateEntry($entry),
                    'count' => 1,
                    'severity' => $this->detectSeverity($entry)
                ];
            } else {
                $clusters[$pattern]['count']++;
            }
        }

        return $clusters;
    }

    /**
     * Extract a generalized pattern from a log entry (first 100 chars of the message).
     */
    protected function extractPattern(string $entry): string
    {
        $firstLine = explode("\n", $entry)[0];
        $pattern = preg_replace('/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]/', '', $firstLine);
        $pattern = preg_replace('/\d+/', '#', $pattern);
        return trim(substr($pattern, 0, 150));
    }

    /**
     * Truncate entry to first few lines to keep prompt size manageable.
     */
    protected function truncateEntry(string $entry, int $lines = 5): string
    {
        $parts = explode("\n", $entry);
        return implode("\n", array_slice($parts, 0, $lines));
    }

    /**
     * Detect severity based on log level or keywords.
     */
    protected function detectSeverity(string $entry): string
    {
        if (stripos($entry, '.EMERGENCY') !== false || stripos($entry, '.CRITICAL') !== false) return 'Critical';
        if (stripos($entry, '.ERROR') !== false) return 'High';
        if (stripos($entry, '.WARNING') !== false) return 'Medium';
        return 'Low';
    }

    /**
     * Build the prompt for the AI.
     */
    protected function buildPrompt(array $clusters): string
    {
        $instructions = "Analyze the following clustered Laravel log entries and provide a structured Root Cause Analysis in JSON format.\n";
        $instructions .= "The input contains unique error clusters identified from the server logs.\n\n";
        $instructions .= "Clustered Logs:\n";

        foreach ($clusters as $cluster) {
            $instructions .= "--- Cluster ---\n";
            $instructions .= "Occurrence Count: {$cluster['count']}\n";
            $instructions .= "Detected Severity: {$cluster['severity']}\n";
            $instructions .= "Log Snippet:\n{$cluster['message']}\n";
        }

        $instructions .= "\nReturn results ONLY as a valid JSON object. Do not include markdown formatting like ```json. \n";
        $instructions .= "JSON Schema:\n";
        $instructions .= "{\n";
        $instructions .= "  \"root_causes\": [\n";
        $instructions .= "    { \"cause\": \"string\", \"description\": \"string\", \"confidence\": 0.0-1.0, \"severity\": \"string\" }\n";
        $instructions .= "  ],\n";
        $instructions .= "  \"recommendations\": [ \"string\" ]\n";
        $instructions .= "}";

        return $instructions;
    }
}

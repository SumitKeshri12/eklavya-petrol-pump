<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RcaService
{
    protected $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Task 1-5: Complex RCA Analysis.
     *
     * @param array $logs Input array of logs (Task 1)
     * @param array $metrics Input metrics JSON (Task 1)
     * @return array
     */
    public function analyzeRootCause(array $logs, array $metrics): array
    {
        // Task 2: Preprocessing
        $preprocessedLogs = $this->preprocess($logs);

        // Task 3: MCP AI Analysis
        $prompt = $this->buildComplexPrompt($preprocessedLogs, $metrics);
        $aiResult = $this->aiService->getAnalysis($prompt);

        // Task 4: Decision Layer (Ranking and Correlation)
        $rankedResult = $this->applyDecisionLayer($aiResult, $metrics);

        // Task 5: Store in DB and Return Response
        $this->storeReport($logs, $metrics, $rankedResult);

        return array_merge($rankedResult, [
            'status' => 'success',
            'timestamp' => now()->toIso8601String(),
            'log_summary' => [
                'total_lines' => count($logs),
                'unique_clusters' => count($preprocessedLogs)
            ]
        ]);
    }

    /**
     * Backward compatibility or default log analysis.
     */
    public function analyzeLogs(int $lines = 200): array
    {
        $rawLogs = $this->getLastLogLines($lines);
        $logs = explode("\n", trim($rawLogs));
        $metrics = ['source' => 'last_logs', 'system_load' => 'unknown']; // Mock metrics

        return $this->analyzeRootCause($logs, $metrics);
    }

    /**
     * Task 2: Preprocessing - Deduplicate and Group by Time Window.
     */
    protected function preprocess(array $logs): array
    {
        $clusters = [];
        $windowSize = 300; // 5 minutes in seconds

        foreach ($logs as $log) {
            if (empty($log)) continue;

            $timestamp = $this->extractTimestamp($log);
            $pattern = $this->extractPattern($log);

            // Task 2: Group by time window (rounding timestamp to window)
            $timeKey = $timestamp ? floor($timestamp / $windowSize) * $windowSize : 0;
            $clusterKey = $pattern . '_' . $timeKey;

            if (!isset($clusters[$clusterKey])) {
                $clusters[$clusterKey] = [
                    'message' => $this->truncateEntry($log),
                    'count' => 1,
                    'severity' => $this->detectSeverity($log),
                    'timestamp' => $timestamp
                ];
            } else {
                $clusters[$clusterKey]['count']++;
            }
        }

        return array_values($clusters);
    }

    /**
     * Task 4: Decision Layer - Rank causes and add confidence based on metrics.
     */
    protected function applyDecisionLayer(array $aiResult, array $metrics): array
    {
        $likelyCause = "Unknown";
        $confidence = 0.5;
        $nextSteps = "Manual investigation required.";

        if (!empty($aiResult['root_causes'])) {
            // Sort by confidence or severity
            usort($aiResult['root_causes'], function ($a, $b) {
                return $b['confidence'] <=> $a['confidence'];
            });

            $bestMatch = $aiResult['root_causes'][0];
            $likelyCause = $bestMatch['cause'];
            $confidence = $bestMatch['confidence'];
            $nextSteps = $aiResult['recommendations'][0] ?? "Check system logs.";

            // Example Task 4 correlation: If metrics show high latency and AI says DB issue
            if (isset($metrics['latency']) && $metrics['latency'] > 1000 && stripos($likelyCause, 'database') !== false) {
                $confidence = min(1.0, $confidence + 0.15); // Stronger signal
                $nextSteps = "URGENT: " . $nextSteps;
            }
        }

        return [
            'likely_cause' => $likelyCause,
            'confidence' => (float) $confidence,
            'next_steps' => $nextSteps,
            'results' => $aiResult // Keep original analysis for depth
        ];
    }

    /**
     * Task 1: Store in DB.
     */
    protected function storeReport(array $logs, array $metrics, array $result)
    {
        try {
            DB::table('rca_reports')->insert([
                'likely_cause' => $result['likely_cause'],
                'confidence' => $result['confidence'],
                'next_steps' => $result['next_steps'],
                'raw_logs' => json_encode($logs),
                'metrics' => json_encode($metrics),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('RcaService: Failed to store report', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Task 3: MCP AI Analysis - Build prompt with metric summary.
     */
    protected function buildComplexPrompt(array $clusters, array $metrics): string
    {
        $prompt = "Suggest probable root causes and reasoning based on the following server state.\n\n";

        $prompt .= "--- Metric Summary ---\n";
        $prompt .= json_encode($metrics, JSON_PRETTY_PRINT) . "\n\n";

        $prompt .= "--- Clustered Log Events ---\n";
        foreach (array_slice($clusters, 0, 10) as $cluster) {
            $prompt .= "- [Count: {$cluster['count']}, Severity: {$cluster['severity']}] {$cluster['message']}\n";
        }

        $prompt .= "\nReturn results ONLY as a valid JSON object with 'root_causes' (array with 'cause', 'description', 'confidence', 'severity') and 'recommendations' (array of strings).";

        return $prompt;
    }

    protected function extractTimestamp(string $line): ?int
    {
        if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]/', $line, $matches)) {
            return strtotime($matches[1]);
        }
        return null;
    }

    protected function extractPattern(string $line): string
    {
        $pattern = preg_replace('/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]/', '', $line);
        $pattern = preg_replace('/\d+/', '#', $pattern);
        return trim(substr($pattern, 0, 100));
    }

    protected function truncateEntry(string $entry, int $lines = 3): string
    {
        $parts = explode("\n", $entry);
        return implode(" ", array_slice($parts, 0, $lines));
    }

    protected function detectSeverity(string $entry): string
    {
        if (stripos($entry, '.EMERGENCY') !== false || stripos($entry, '.CRITICAL') !== false) return 'Critical';
        if (stripos($entry, '.ERROR') !== false) return 'High';
        if (stripos($entry, '.WARNING') !== false) return 'Medium';
        return 'Low';
    }

    protected function getLastLogLines(int $lines): string
    {
        $logPath = storage_path('logs/laravel.log');
        if (!file_exists($logPath)) return "";
        $data = file($logPath);
        return implode("", array_slice($data, -$lines));
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\RcaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RcaController extends Controller
{
    protected $rcaService;

    public function __construct(RcaService $rcaService)
    {
        $this->rcaService = $rcaService;
    }

    /**
     * Task 1 & 5: Analyze logs/metrics and return standardized RCA.
     */
    public function analyze(Request $request)
    {
        // Task 1: Intake (accept logs array and metrics JSON)
        $logs = $request->input('logs');
        $metrics = $request->input('metrics', []);
        $format = $request->get('format', 'json');

        // Fallback to file-based logs if no logs are provided in payload
        if (empty($logs)) {
            $lines = $request->get('lines', 500);
            $rawLogs = $this->rcaService->analyzeLogs($lines);
            // If it returns a full result object already, handle it
            if (isset($rawLogs['likely_cause'])) {
                return $this->formatResponse($rawLogs, $format);
            }
            return response()->json($rawLogs);
        }

        try {
            // Task 2-4: Service orchestration
            $result = $this->rcaService->analyzeRootCause($logs, (array) $metrics);

            return $this->formatResponse($result, $format);
        } catch (\Throwable $th) {
            Log::error('RcaController: Analysis failed', ['error' => $th->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during root cause analysis.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Task 5: Final standardized response formatting.
     */
    protected function formatResponse(array $result, string $format)
    {
        if ($format === 'html') {
            return view('reports.rca', $result);
        }

        if ($format === 'docx') {
            return $this->exportToDocx($result);
        }

        // Standard Task 5 JSON response
        return response()->json([
            'likely_cause' => $result['likely_cause'],
            'confidence'   => $result['confidence'],
            'next_steps'   => $result['next_steps']
        ]);
    }

    /**
     * Export analysis result to DOCX via Pandoc.
     */
    protected function exportToDocx(array $data)
    {
        $html = view('reports.rca', $data)->render();

        if (!is_dir(storage_path('app/reports'))) {
            mkdir(storage_path('app/reports'), 0755, true);
        }

        $timestamp = time();
        $tempHtml = storage_path("app/reports/temp_rca_{$timestamp}.html");
        $tempDocx = storage_path("app/reports/rca_report_{$timestamp}.docx");

        file_put_contents($tempHtml, $html);

        $output = [];
        $returnVar = 0;
        $command = "pandoc \"$tempHtml\" -o \"$tempDocx\" 2>&1";
        exec($command, $output, $returnVar);

        if ($returnVar !== 0 || !file_exists($tempDocx)) {
            $errorMsg = implode("\n", $output);
            Log::error('RcaController: Pandoc failed', ['error' => $errorMsg]);
            @unlink($tempHtml);
            throw new \Exception("DOCX generation failed: " . ($errorMsg ?: "Unknown error"));
        }

        @unlink($tempHtml);
        return response()->download($tempDocx, 'Root_Cause_Analysis.docx')->deleteFileAfterSend(true);
    }
}

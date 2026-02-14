<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\RcaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class RcaController extends Controller
{
    protected $rcaService;

    public function __construct(RcaService $rcaService)
    {
        $this->rcaService = $rcaService;
    }

    /**
     * Analyze logs and return Root Cause Analysis.
     *
     * @param Request $request
     * @return mixed
     */
    public function analyze(Request $request)
    {
        $lines = $request->get('lines', 200);
        $format = $request->get('format', 'json');

        try {
            $result = $this->rcaService->analyzeLogs($lines);

            if ($format === 'html') {
                return view('reports.rca', $result);
            }

            if ($format === 'docx') {
                return $this->exportToDocx($result);
            }

            return response()->json($result);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during analysis.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Export the analysis result to a DOCX file using Pandoc.
     */
    protected function exportToDocx(array $data)
    {
        $html = view('reports.rca', $data)->render();

        // Ensure the temp directory exists
        if (!is_dir(storage_path('app/reports'))) {
            mkdir(storage_path('app/reports'), 0755, true);
        }

        $timestamp = time();
        $tempHtml = storage_path("app/reports/temp_rca_{$timestamp}.html");
        $tempDocx = storage_path("app/reports/rca_report_{$timestamp}.docx");

        file_put_contents($tempHtml, $html);

        // Execute Pandoc to convert HTML to DOCX
        // Using 2>&1 to capture error output
        $output = [];
        $returnVar = 0;
        $command = "pandoc \"$tempHtml\" -o \"$tempDocx\" 2>&1";
        exec($command, $output, $returnVar);

        if ($returnVar !== 0 || !file_exists($tempDocx)) {
            $errorMsg = implode("\n", $output);
            Log::error('RcaController: Pandoc failed', [
                'command' => $command,
                'output' => $errorMsg,
                'return_var' => $returnVar
            ]);

            @unlink($tempHtml);
            throw new \Exception("DOCX generation failed: " . ($errorMsg ?: "Unknown Pandoc error"));
        }

        @unlink($tempHtml); // Clean up HTML file

        return response()->download($tempDocx, 'Root_Cause_Analysis.docx')->deleteFileAfterSend(true);
    }
}

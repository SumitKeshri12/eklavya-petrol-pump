<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\AiService;
use Mockery;

class RcaApiTest extends TestCase
{
    /**
     * Test the RCA analysis API.
     */
    public function test_rca_analyze_endpoint()
    {
        // Mock the AiService to avoid actual API calls
        $mockAi = Mockery::mock(AiService::class);
        $mockAi->shouldReceive('getAnalysis')->andReturn([
            'root_causes' => [
                [
                    'cause' => 'Test Cause',
                    'description' => 'Test Description',
                    'confidence' => 0.9,
                    'severity' => 'High'
                ]
            ],
            'recommendations' => ['Fix it']
        ]);

        $this->app->instance(AiService::class, $mockAi);

        $response = $this->postJson('/api/v1/rca/analyze', ['lines' => 10]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'timestamp',
                'log_summary' => ['total_lines_read', 'unique_clusters'],
                'analysis' => [
                    'root_causes',
                    'recommendations'
                ]
            ]);
    }

    /**
     * Test the RCA analysis API with HTML format.
     */
    public function test_rca_analyze_html_format()
    {
        $mockAi = Mockery::mock(AiService::class);
        $mockAi->shouldReceive('getAnalysis')->andReturn(['root_causes' => [], 'recommendations' => []]);
        $this->app->instance(AiService::class, $mockAi);

        $response = $this->get('/api/v1/rca/analyze?format=html');

        $response->assertStatus(200)
            ->assertViewIs('reports.rca');
    }

    /**
     * Test the RCA analysis API with DOCX format.
     */
    public function test_rca_analyze_docx_format()
    {
        $mockAi = Mockery::mock(AiService::class);
        $mockAi->shouldReceive('getAnalysis')->andReturn(['root_causes' => [], 'recommendations' => []]);
        $this->app->instance(AiService::class, $mockAi);

        $response = $this->get('/api/v1/rca/analyze?format=docx');

        $response->assertStatus(200)
            ->assertHeader('Content-Disposition', 'attachment; filename=Root_Cause_Analysis.docx');
    }
}

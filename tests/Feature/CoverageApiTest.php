<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoverageApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_coverage_check_endpoint_returns_success(): void
    {
        $response = $this->postJson('/api/v1/coverage/check', [
            'governorate' => 'Tunis',
            'latitude' => 36.8065,
            'longitude' => 10.1815,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'data' => [
                    'governorate',
                    'signal_strength',
                    'coverage_type',
                    'availability',
                    'speed_download',
                    'speed_upload',
                    'checked_at',
                ],
                'cached',
            ]);
    }

    public function test_coverage_history_endpoint_returns_success(): void
    {
        $response = $this->getJson('/api/v1/coverage/history');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'data',
            ]);
    }

    public function test_coverage_statistics_endpoint_returns_success(): void
    {
        $response = $this->getJson('/api/v1/coverage/stats');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'data' => [
                    'total_checks',
                    'total_areas',
                    'checks_today',
                    'most_checked_areas',
                ],
            ]);
    }

    public function test_coverage_checker_page_can_be_rendered(): void
    {
        $response = $this->get('/coverage-checker');

        $response->assertStatus(200);
    }
}

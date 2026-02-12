<?php

namespace Tests\Feature;

use Tests\TestCase;

class CoverageCheckerTest extends TestCase
{
    /**
     * Test that the coverage checker route exists and returns a successful response.
     */
    public function test_coverage_checker_route_exists(): void
    {
        $response = $this->get('/coverage-checker');

        $response->assertStatus(200);
    }

    /**
     * Test that the coverage checker route uses the correct view.
     */
    public function test_coverage_checker_uses_correct_view(): void
    {
        $response = $this->get('/coverage-checker');

        $response->assertViewIs('coverage.checker');
    }

    /**
     * Test that the coverage checker route has the correct name.
     */
    public function test_coverage_checker_route_name(): void
    {
        $this->assertTrue(
            \Illuminate\Support\Facades\Route::has('coverage.checker'),
            'Route coverage.checker should exist'
        );
    }
}

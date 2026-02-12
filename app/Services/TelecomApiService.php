<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelecomApiService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.tunisietelecom.url', 'https://geo.tunisietelecom.tn/mytaghtia');
        $this->apiKey = config('services.tunisietelecom.api_key');
    }

    /**
     * Get coverage data from Tunisie Telecom API
     */
    public function getCoverage($params)
    {
        try {
            // This is a placeholder - adapt based on actual TT API
            $response = Http::timeout(10)->get($this->baseUrl . '/api/coverage', [
                'governorate' => $params['governorate'],
                'lat' => $params['latitude'] ?? null,
                'lng' => $params['longitude'] ?? null,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('TT API Error', ['response' => $response->body()]);
            
            // Return mock data for now
            return $this->getMockCoverageData($params['governorate']);
            
        } catch (\Exception $e) {
            Log::error('TT API Exception', ['error' => $e->getMessage()]);
            return $this->getMockCoverageData($params['governorate']);
        }
    }

    /**
     * Mock coverage data for testing
     */
    private function getMockCoverageData($governorate)
    {
        return [
            'governorate' => $governorate,
            'signal_strength' => rand(60, 100),
            'coverage_type' => '4G/5G',
            'availability' => 'available',
            'speed_download' => rand(50, 150) . ' Mbps',
            'speed_upload' => rand(10, 50) . ' Mbps',
            'checked_at' => now()->toISOString(),
        ];
    }
}

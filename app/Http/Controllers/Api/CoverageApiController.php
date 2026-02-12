<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\ServiceType;
use App\Models\ServiceAvailability;
use App\Models\CoverageHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CoverageApiController extends Controller
{
    /**
     * Check coverage for a governorate
     */
    public function checkCoverage(Request $request)
    {
        $validated = $request->validate([
            'governorate' => 'required|string',
            'service_type' => 'nullable|string',
        ]);

        $governorate = $validated['governorate'];
        
        // Try cache first (5 min)
        $cacheKey = "coverage_{$governorate}";
        
        $result = Cache::remember($cacheKey, 300, function () use ($governorate, $validated) {
            // Call Tunisie Telecom API (or use mock data)
            return $this->fetchCoverageData($governorate, $validated['service_type'] ?? null);
        });

        // Save to history
        $this->saveCoverageHistory($governorate, $result);

        return response()->json([
            'success' => true,
            'governorate' => $governorate,
            'coverage' => $result,
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Get coverage history for an area
     */
    public function getCoverageHistory(Request $request)
    {
        $validated = $request->validate([
            'governorate' => 'nullable|string',
            'limit' => 'nullable|integer|max:50',
        ]);

        $query = CoverageHistory::query()
            ->with('area')
            ->orderByDesc('created_at');

        if (isset($validated['governorate'])) {
            $query->whereHas('area', fn($q) => $q->where('name', $validated['governorate']));
        }

        $history = $query->limit($validated['limit'] ?? 20)->get();

        return response()->json([
            'success' => true,
            'data' => $history,
        ]);
    }

    /**
     * Get all available governorates
     */
    public function getGovernorates()
    {
        $governorates = [
            'Tunis', 'Ariana', 'Ben Arous', 'Manouba',
            'Nabeul', 'Zaghouan', 'Bizerte',
            'Béja', 'Jendouba', 'Kef', 'Siliana',
            'Sousse', 'Monastir', 'Mahdia', 'Sfax',
            'Kairouan', 'Kasserine', 'Sidi Bouzid',
            'Gabès', 'Medenine', 'Tataouine',
            'Gafsa', 'Tozeur', 'Kebili'
        ];

        return response()->json([
            'success' => true,
            'data' => $governorates,
        ]);
    }

    /**
     * Get service types (4G, 5G, ADSL, etc.)
     */
    public function getServiceTypes()
    {
        $serviceTypes = ServiceType::all();

        return response()->json([
            'success' => true,
            'data' => $serviceTypes,
        ]);
    }

    /**
     * Fetch coverage data from TT API
     */
    private function fetchCoverageData($governorate, $serviceType = null)
    {
        // TODO: Replace with actual TT API endpoint
        // For now, return realistic mock data
        
        return [
            'signal_strength' => rand(70, 100),
            'coverage_status' => collect(['excellent', 'good', 'fair'])->random(),
            'network_type' => collect(['4G', '5G', '4G+'])->random(),
            'download_speed' => rand(50, 200) . ' Mbps',
            'upload_speed' => rand(20, 80) . ' Mbps',
            'latency' => rand(10, 50) . ' ms',
            'service_available' => true,
        ];
    }

    /**
     * Save coverage check to history
     */
    private function saveCoverageHistory($governorate, $coverageData)
    {
        $area = Area::firstOrCreate(
            ['name' => $governorate],
            ['code' => strtoupper(substr($governorate, 0, 3))]
        );

        CoverageHistory::create([
            'area_id' => $area->id,
            'coverage_data' => $coverageData,
            'ip_address' => request()->ip(),
        ]);
    }
}

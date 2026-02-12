<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TelecomApiService;
use App\Models\ServiceAvailability;
use App\Models\Area;
use App\Models\CoverageCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CoverageController extends Controller
{
    protected $telecomService;

    public function __construct(TelecomApiService $telecomService)
    {
        $this->telecomService = $telecomService;
    }

    /**
     * Check coverage for a given governorate
     */
    public function check(Request $request)
    {
        $validated = $request->validate([
            'governorate' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Cache key based on governorate
        $cacheKey = 'coverage_' . md5($validated['governorate']);
        
        // Try to get from cache (5 minutes)
        $coverageData = Cache::remember($cacheKey, 300, function () use ($validated) {
            return $this->telecomService->getCoverage($validated);
        });

        // Store check in database for history
        $this->storeCheck($validated, $coverageData);

        return response()->json([
            'success' => true,
            'data' => $coverageData,
            'cached' => Cache::has($cacheKey),
        ]);
    }

    /**
     * Get coverage history for a governorate
     */
    public function history(Request $request)
    {
        $validated = $request->validate([
            'governorate' => 'nullable|string',
            'limit' => 'nullable|integer|max:100',
        ]);

        $query = CoverageCheck::with('area')
            ->latest();

        if (isset($validated['governorate'])) {
            $query->whereHas('area', function ($q) use ($validated) {
                $q->where('name', 'like', '%' . $validated['governorate'] . '%');
            });
        }

        $limit = $validated['limit'] ?? 20;
        $checks = $query->limit($limit)->get();

        return response()->json([
            'success' => true,
            'data' => $checks,
        ]);
    }

    /**
     * Get coverage statistics
     */
    public function statistics()
    {
        $stats = [
            'total_checks' => CoverageCheck::count(),
            'total_areas' => Area::count(),
            'checks_today' => CoverageCheck::whereDate('created_at', today())->count(),
            'most_checked_areas' => $this->getMostCheckedAreas(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Compare coverage between areas
     */
    public function compare(Request $request)
    {
        $validated = $request->validate([
            'areas' => 'required|array|min:2|max:5',
            'areas.*' => 'required|string',
        ]);

        $comparison = [];
        foreach ($validated['areas'] as $areaName) {
            $latestCheck = CoverageCheck::whereHas('area', function ($q) use ($areaName) {
                $q->where('name', 'like', '%' . $areaName . '%');
            })->latest()->first();

            if ($latestCheck) {
                $comparison[] = [
                    'area' => $areaName,
                    'coverage_data' => $latestCheck->coverage_data,
                    'last_checked' => $latestCheck->created_at,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $comparison,
        ]);
    }

    /**
     * Get coverage by governorate code
     */
    public function getByGovernorate($code)
    {
        $latestCheck = CoverageCheck::whereHas('area', function ($q) use ($code) {
            $q->where('code', $code);
        })->latest()->first();

        if (!$latestCheck) {
            return response()->json([
                'success' => false,
                'message' => 'No coverage data found for this governorate',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $latestCheck,
        ]);
    }

    private function storeCheck($validated, $coverageData)
    {
        // Find or create area
        $area = Area::firstOrCreate(
            ['code' => $validated['governorate']],
            ['name' => $validated['governorate']]
        );

        // Store coverage check
        CoverageCheck::create([
            'area_id' => $area->id,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'coverage_data' => $coverageData,
            'user_ip' => request()->ip(),
        ]);
    }

    private function getMostCheckedAreas()
    {
        return CoverageCheck::select('area_id', \DB::raw('count(*) as check_count'))
            ->with('area')
            ->groupBy('area_id')
            ->orderByDesc('check_count')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'area' => $item->area->name,
                    'count' => $item->check_count,
                ];
            });
    }
}

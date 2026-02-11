<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceAvailability;
use App\Models\StatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Count total services
        $totalServices = ServiceAvailability::count();

        // Count by status
        $availableCount = ServiceAvailability::where('status', 'available')->count();
        $maintenanceCount = ServiceAvailability::where('status', 'maintenance')->count();
        $problemCount = ServiceAvailability::where('status', 'problem')->count();

        // Get recent status changes (last 10) with relationships
        $recentChanges = StatusHistory::with([
            'serviceAvailability.area',
            'serviceAvailability.serviceType',
            'changedBy'
        ])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get status distribution data for chart
        $statusDistribution = [
            'labels' => ['Available', 'Maintenance', 'Problem'],
            'data' => [$availableCount, $maintenanceCount, $problemCount],
        ];

        // Get status changes over last 7 days for line chart
        $sevenDaysAgo = now()->subDays(7);
        $statusChangesOverTime = StatusHistory::select(
            DB::raw('DATE(created_at) as date'),
            'new_status',
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $sevenDaysAgo)
            ->groupBy('date', 'new_status')
            ->orderBy('date')
            ->get();

        // Fill in missing dates with 0 counts for each status
        $dateRange = [];
        $availableCounts = [];
        $maintenanceCounts = [];
        $problemCounts = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dateRange[] = $date;
            
            $availableChange = $statusChangesOverTime->where('date', $date)->where('new_status', 'available')->first();
            $availableCounts[] = $availableChange ? $availableChange->count : 0;
            
            $maintenanceChange = $statusChangesOverTime->where('date', $date)->where('new_status', 'maintenance')->first();
            $maintenanceCounts[] = $maintenanceChange ? $maintenanceChange->count : 0;
            
            $problemChange = $statusChangesOverTime->where('date', $date)->where('new_status', 'problem')->first();
            $problemCounts[] = $problemChange ? $problemChange->count : 0;
        }

        $statusChangesChart = [
            'labels' => $dateRange,
            'available' => $availableCounts,
            'maintenance' => $maintenanceCounts,
            'problem' => $problemCounts,
        ];

        // Package stats into an array for the view
        $stats = [
            'total' => $totalServices,
            'available' => $availableCount,
            'maintenance' => $maintenanceCount,
            'problem' => $problemCount,
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recentChanges',
            'statusDistribution',
            'statusChangesChart'
        ));
    }
}

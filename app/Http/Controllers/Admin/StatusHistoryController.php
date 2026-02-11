<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatusHistory;
use App\Models\Area;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Http\Request;

class StatusHistoryController extends Controller
{
    /**
     * Display a listing of status history with filters.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = StatusHistory::with([
            'serviceAvailability.area',
            'serviceAvailability.serviceType',
            'changedBy'
        ]);

        // Apply date range filter
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Apply area filter
        if ($request->filled('area_id')) {
            $query->whereHas('serviceAvailability', function ($q) use ($request) {
                $q->where('area_id', $request->area_id);
            });
        }

        // Apply service type filter
        if ($request->filled('service_type_id')) {
            $query->whereHas('serviceAvailability', function ($q) use ($request) {
                $q->where('service_type_id', $request->service_type_id);
            });
        }

        // Apply changed by filter
        if ($request->filled('changed_by')) {
            $query->where('changed_by', $request->changed_by);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('new_status', $request->status);
        }

        $statusHistory = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get filter options
        $areas = Area::orderBy('name')->get();
        $serviceTypes = ServiceType::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.status-history.index', compact(
            'statusHistory',
            'areas',
            'serviceTypes',
            'users'
        ));
    }

    /**
     * Export filtered status history to CSV.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(Request $request)
    {
        $fileName = 'status_history_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($request) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Area',
                'Service Type',
                'Old Status',
                'New Status',
                'Changed By',
                'Notes',
                'Changed At'
            ]);

            // Build query with same filters as index
            $query = StatusHistory::with([
                'serviceAvailability.area',
                'serviceAvailability.serviceType',
                'changedBy'
            ]);

            // Apply date range filter
            if ($request->filled('date_from')) {
                $query->where('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
            }

            // Apply area filter
            if ($request->filled('area_id')) {
                $query->whereHas('serviceAvailability', function ($q) use ($request) {
                    $q->where('area_id', $request->area_id);
                });
            }

            // Apply service type filter
            if ($request->filled('service_type_id')) {
                $query->whereHas('serviceAvailability', function ($q) use ($request) {
                    $q->where('service_type_id', $request->service_type_id);
                });
            }

            // Apply changed by filter
            if ($request->filled('changed_by')) {
                $query->where('changed_by', $request->changed_by);
            }

            // Apply status filter
            if ($request->filled('status')) {
                $query->where('new_status', $request->status);
            }

            // Export data in chunks
            $query->orderBy('created_at', 'desc')
                ->chunk(100, function ($history) use ($file) {
                    foreach ($history as $record) {
                        fputcsv($file, [
                            $record->id,
                            $record->serviceAvailability->area->name ?? 'N/A',
                            $record->serviceAvailability->serviceType->name ?? 'N/A',
                            ucfirst($record->old_status ?? 'N/A'),
                            ucfirst($record->new_status),
                            $record->changedBy->name ?? 'System',
                            $record->notes,
                            $record->created_at->format('Y-m-d H:i:s'),
                        ]);
                    }
                });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

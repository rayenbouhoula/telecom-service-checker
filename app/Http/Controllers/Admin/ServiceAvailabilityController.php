<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceAvailability;
use App\Models\Area;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceAvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = ServiceAvailability::with(['area', 'serviceType']);

        // Apply filters
        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        if ($request->filled('service_type_id')) {
            $query->where('service_type_id', $request->service_type_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('area', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('serviceType', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $serviceAvailabilities = $query->orderBy('updated_at', 'desc')->paginate(15);
        $areas = Area::orderBy('name')->get();
        $serviceTypes = ServiceType::orderBy('name')->get();

        return view('admin.service-availability.index', compact('serviceAvailabilities', 'areas', 'serviceTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $areas = Area::orderBy('name')->get();
        $serviceTypes = ServiceType::orderBy('name')->get();

        return view('admin.service-availability.create', compact('areas', 'serviceTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'area_id' => 'required|exists:areas,id',
                'service_type_id' => 'required|exists:service_types,id',
                'status' => 'required|in:available,maintenance,problem',
                'notes' => 'nullable|string',
            ]);

            // Check for duplicate
            $exists = ServiceAvailability::where('area_id', $validated['area_id'])
                ->where('service_type_id', $validated['service_type_id'])
                ->exists();

            if ($exists) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['area_id' => 'Service availability for this area and service type already exists.']);
            }

            $validated['last_updated'] = now();
            ServiceAvailability::create($validated);

            return redirect()->route('admin.service-availability.index')
                ->with('success', 'Service availability created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while creating the service availability.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ServiceAvailability $serviceAvailability
     * @return \Illuminate\View\View
     */
    public function edit(ServiceAvailability $serviceAvailability)
    {
        $areas = Area::orderBy('name')->get();
        $serviceTypes = ServiceType::orderBy('name')->get();

        return view('admin.service-availability.edit', compact('serviceAvailability', 'areas', 'serviceTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ServiceAvailability $serviceAvailability
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ServiceAvailability $serviceAvailability)
    {
        try {
            $validated = $request->validate([
                'area_id' => 'required|exists:areas,id',
                'service_type_id' => 'required|exists:service_types,id',
                'status' => 'required|in:available,maintenance,problem',
                'notes' => 'nullable|string',
            ]);

            // Check for duplicate (excluding current record)
            $exists = ServiceAvailability::where('area_id', $validated['area_id'])
                ->where('service_type_id', $validated['service_type_id'])
                ->where('id', '!=', $serviceAvailability->id)
                ->exists();

            if ($exists) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['area_id' => 'Service availability for this area and service type already exists.']);
            }

            $validated['last_updated'] = now();
            $serviceAvailability->update($validated);

            return redirect()->route('admin.service-availability.index')
                ->with('success', 'Service availability updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while updating the service availability.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ServiceAvailability $serviceAvailability
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ServiceAvailability $serviceAvailability)
    {
        try {
            $serviceAvailability->delete();

            return redirect()->route('admin.service-availability.index')
                ->with('success', 'Service availability deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while deleting the service availability.']);
        }
    }

    /**
     * Quick update status for service availability.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:service_availability,id',
                'status' => 'required|in:available,maintenance,problem',
                'notes' => 'nullable|string',
            ]);

            $serviceAvailability = ServiceAvailability::findOrFail($validated['id']);
            $serviceAvailability->update([
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? $serviceAvailability->notes,
                'last_updated' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the status.'
            ], 500);
        }
    }

    /**
     * Bulk update service availabilities.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:service_availability,id',
                'status' => 'required|in:available,maintenance,problem',
                'notes' => 'nullable|string',
            ]);

            ServiceAvailability::whereIn('id', $validated['ids'])->update([
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
                'last_updated' => now(),
            ]);

            return redirect()->route('admin.service-availability.index')
                ->with('success', 'Service availabilities updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while updating service availabilities.']);
        }
    }

    /**
     * Export service availabilities to CSV.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        $fileName = 'service_availability_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['ID', 'Area', 'Service Type', 'Status', 'Notes', 'Last Updated', 'Created At', 'Updated At']);

            // Get all service availabilities with relationships
            ServiceAvailability::with(['area', 'serviceType'])
                ->chunk(100, function ($serviceAvailabilities) use ($file) {
                    foreach ($serviceAvailabilities as $sa) {
                        fputcsv($file, [
                            $sa->id,
                            $sa->area->name,
                            $sa->serviceType->name,
                            ucfirst($sa->status),
                            $sa->notes,
                            $sa->last_updated->format('Y-m-d H:i:s'),
                            $sa->created_at->format('Y-m-d H:i:s'),
                            $sa->updated_at->format('Y-m-d H:i:s'),
                        ]);
                    }
                });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

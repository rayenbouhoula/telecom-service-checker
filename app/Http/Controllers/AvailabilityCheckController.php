<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\ServiceType;
use App\Models\ServiceAvailability;
use Illuminate\Http\Request;

class AvailabilityCheckController extends Controller
{
    /**
     * Display the check availability page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $areas = Area::orderBy('name')->get();
        $serviceTypes = ServiceType::orderBy('name')->get();

        return view('availability.index', compact('areas', 'serviceTypes'));
    }

    /**
     * Check service availability for a specific area and service type.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request)
    {
        try {
            $validated = $request->validate([
                'area_id' => 'required|exists:areas,id',
                'service_type_id' => 'required|exists:service_types,id',
            ]);

            $availability = ServiceAvailability::with(['area', 'serviceType'])
                ->where('area_id', $validated['area_id'])
                ->where('service_type_id', $validated['service_type_id'])
                ->first();

            if (!$availability) {
                return response()->json([
                    'message' => 'Service availability information not found.'
                ], 404);
            }

            return response()->json([
                'status' => $availability->status,
                'notes' => $availability->notes,
                'last_updated' => $availability->last_updated->format('Y-m-d H:i:s'),
                'area_name' => $availability->area->name,
                'service_type_name' => $availability->serviceType->name,
                'icon' => $availability->serviceType->icon,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while checking availability.'
            ], 500);
        }
    }
}

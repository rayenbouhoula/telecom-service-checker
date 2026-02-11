<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = ServiceType::query();

        // Apply search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $serviceTypes = $query->orderBy('name')->paginate(15);

        return view('admin.service-types.index', compact('serviceTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.service-types.create');
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
                'name' => 'required|string|max:255|unique:service_types,name',
                'description' => 'nullable|string',
                'icon' => 'nullable|string|max:255',
            ]);

            ServiceType::create($validated);

            return redirect()->route('admin.service-types.index')
                ->with('success', 'Service type created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while creating the service type.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ServiceType $serviceType
     * @return \Illuminate\View\View
     */
    public function edit(ServiceType $serviceType)
    {
        return view('admin.service-types.edit', compact('serviceType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ServiceType $serviceType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ServiceType $serviceType)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:service_types,name,' . $serviceType->id,
                'description' => 'nullable|string',
                'icon' => 'nullable|string|max:255',
            ]);

            $serviceType->update($validated);

            return redirect()->route('admin.service-types.index')
                ->with('success', 'Service type updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while updating the service type.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ServiceType $serviceType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ServiceType $serviceType)
    {
        try {
            // Check if service type has associated service availabilities
            if ($serviceType->serviceAvailabilities()->count() > 0) {
                return redirect()->back()
                    ->withErrors(['error' => 'Cannot delete service type with associated service availabilities.']);
            }

            $serviceType->delete();

            return redirect()->route('admin.service-types.index')
                ->with('success', 'Service type deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while deleting the service type.']);
        }
    }
}

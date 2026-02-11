<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Area::query();

        // Apply search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $areas = $query->orderBy('name')->paginate(15);

        return view('admin.areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.areas.create');
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
                'name' => 'required|string|max:255|unique:areas,name',
                'code' => 'required|string|max:50|unique:areas,code',
            ]);

            Area::create($validated);

            return redirect()->route('admin.areas.index')
                ->with('success', 'Area created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while creating the area.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Area $area
     * @return \Illuminate\View\View
     */
    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Area $area)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:areas,name,' . $area->id,
                'code' => 'required|string|max:50|unique:areas,code,' . $area->id,
            ]);

            $area->update($validated);

            return redirect()->route('admin.areas.index')
                ->with('success', 'Area updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while updating the area.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Area $area)
    {
        try {
            // Check if area has associated service availabilities
            if ($area->serviceAvailabilities()->count() > 0) {
                return redirect()->back()
                    ->withErrors(['error' => 'Cannot delete area with associated service availabilities.']);
            }

            $area->delete();

            return redirect()->route('admin.areas.index')
                ->with('success', 'Area deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while deleting the area.']);
        }
    }
}

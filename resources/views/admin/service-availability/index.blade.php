@extends('layouts.admin')

@section('title', 'Service Availability')

@php
    $breadcrumbs = [
        ['title' => 'Service Availability', 'url' => '']
    ];
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-broadcast-pin"></i> Service Availability</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.services.export') }}" class="btn btn-outline-success">
            <i class="bi bi-download"></i> Export CSV
        </a>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Service
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.services.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Area</label>
                <select name="area_id" class="form-select">
                    <option value="">All Areas</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Service Type</label>
                <select name="service_type_id" class="form-select">
                    <option value="">All Service Types</option>
                    @foreach($serviceTypes as $type)
                        <option value="{{ $type->id }}" {{ request('service_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                    <option value="problem" {{ request('status') == 'problem' ? 'selected' : '' }}>Service Issue</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-search"></i> Apply Filters
                </button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Services Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Area</th>
                        <th>Service Type</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Last Updated</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($serviceAvailabilities as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>
                                <i class="bi bi-geo-alt text-primary"></i>
                                {{ $service->area->name }}
                            </td>
                            <td>
                                @if($service->serviceType->icon)
                                    <i class="bi bi-{{ $service->serviceType->icon }}"></i>
                                @endif
                                {{ $service->serviceType->name }}
                            </td>
                            <td>
                                @if($service->status == 'available')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Available
                                    </span>
                                @elseif($service->status == 'maintenance')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-tools"></i> Under Maintenance
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-exclamation-triangle"></i> Service Issue
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($service->notes)
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $service->notes }}">
                                        {{ $service->notes }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $service->last_updated ? $service->last_updated->format('Y-m-d H:i') : 'N/A' }}</td>
                            <td class="text-end table-actions">
                                <div class="btn-group" role="group">
                                    <!-- Quick Status Update Buttons -->
                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                            onclick="updateStatus({{ $service->id }}, 'available')"
                                            title="Mark as Available">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                            onclick="updateStatus({{ $service->id }}, 'maintenance')"
                                            title="Mark as Maintenance">
                                        <i class="bi bi-tools"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="updateStatus({{ $service->id }}, 'problem')"
                                            title="Mark as Problem">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </button>
                                </div>
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0">No service availability records found</p>
                                <a href="{{ route('admin.services.create') }}" class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-plus-circle"></i> Add First Service
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($serviceAvailabilities->hasPages())
        <div class="card-footer bg-white">
            {{ $serviceAvailabilities->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function updateStatus(serviceId, status) {
    if (confirm('Are you sure you want to update the status to ' + status + '?')) {
        fetch('{{ route("admin.services.quick-update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: serviceId,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to update status: ' + data.message);
            }
        })
        .catch(error => {
            alert('An error occurred while updating status');
            console.error(error);
        });
    }
}
</script>
@endpush

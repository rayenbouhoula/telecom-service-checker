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
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Service
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.services.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Area</label>
                <select name="area" class="form-select">
                    <option value="">All Areas</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Service Type</label>
                <select name="service_type" class="form-select">
                    <option value="">All Service Types</option>
                    @foreach($serviceTypes as $type)
                        <option value="{{ $type->id }}" {{ request('service_type') == $type->id ? 'selected' : '' }}>
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
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="problem" {{ request('status') == 'problem' ? 'selected' : '' }}>Problem</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Quick Status Buttons -->
<div class="d-flex gap-2 mb-3">
    <a href="{{ route('admin.services.index', ['status' => 'available']) }}" class="btn btn-sm btn-outline-success">
        <i class="bi bi-check-circle"></i> Available ({{ $statusCounts['available'] ?? 0 }})
    </a>
    <a href="{{ route('admin.services.index', ['status' => 'maintenance']) }}" class="btn btn-sm btn-outline-warning">
        <i class="bi bi-tools"></i> Maintenance ({{ $statusCounts['maintenance'] ?? 0 }})
    </a>
    <a href="{{ route('admin.services.index', ['status' => 'problem']) }}" class="btn btn-sm btn-outline-danger">
        <i class="bi bi-exclamation-triangle"></i> Problem ({{ $statusCounts['problem'] ?? 0 }})
    </a>
</div>

<!-- Services Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Service Type</th>
                        <th>Area</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th>Notes</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>
                                @if($service->serviceType->icon)
                                    <i class="bi bi-{{ $service->serviceType->icon }}"></i>
                                @endif
                                {{ $service->serviceType->name }}
                            </td>
                            <td>{{ $service->area->name }}</td>
                            <td>
                                <span class="badge bg-{{ $service->status == 'available' ? 'success' : ($service->status == 'maintenance' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($service->status) }}
                                </span>
                            </td>
                            <td>{{ $service->last_updated ? $service->last_updated->format('Y-m-d H:i') : 'N/A' }}</td>
                            <td>
                                @if($service->notes)
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $service->notes }}">
                                        {{ $service->notes }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-end table-actions">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0">No services found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($services->hasPages())
        <div class="card-footer bg-white">
            {{ $services->links() }}
        </div>
    @endif
</div>
@endsection

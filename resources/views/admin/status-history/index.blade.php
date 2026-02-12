@extends('layouts.admin')

@section('title', 'Status History')

@php
    $breadcrumbs = [
        ['title' => 'Status History', 'url' => '']
    ];
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-clock-history"></i> Status History</h2>
    <a href="{{ route('admin.status-history.export', request()->query()) }}" class="btn btn-success">
        <i class="bi bi-download"></i> Export to CSV
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filter Options</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.status-history.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" 
                       name="date_from" 
                       id="date_from" 
                       class="form-control" 
                       value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" 
                       name="date_to" 
                       id="date_to" 
                       class="form-control" 
                       value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2">
                <label for="area_id" class="form-label">Area</label>
                <select name="area_id" id="area_id" class="form-select">
                    <option value="">All Areas</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="service_type_id" class="form-label">Service Type</label>
                <select name="service_type_id" id="service_type_id" class="form-select">
                    <option value="">All Types</option>
                    @foreach($serviceTypes as $type)
                        <option value="{{ $type->id }}" {{ request('service_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="changed_by" class="form-label">Changed By</label>
                <select name="changed_by" id="changed_by" class="form-select">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('changed_by') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.status-history.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Status History Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Service Type</th>
                        <th>Area</th>
                        <th>Old Status</th>
                        <th></th>
                        <th>New Status</th>
                        <th>Changed By</th>
                        <th>Notes</th>
                        <th>Date/Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($statusHistory as $history)
                        <tr>
                            <td>{{ $history->id }}</td>
                            <td>
                                @if($history->serviceAvailability && $history->serviceAvailability->serviceType)
                                    @if($history->serviceAvailability->serviceType->icon)
                                        <i class="bi bi-{{ $history->serviceAvailability->serviceType->icon }}"></i>
                                    @endif
                                    {{ $history->serviceAvailability->serviceType->name }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($history->serviceAvailability && $history->serviceAvailability->area)
                                    <i class="bi bi-geo-alt text-primary"></i>
                                    {{ $history->serviceAvailability->area->name }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($history->old_status)
                                    @if($history->old_status == 'available')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Available
                                        </span>
                                    @elseif($history->old_status == 'maintenance')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-tools"></i> Maintenance
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-exclamation-triangle"></i> Problem
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">New</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <i class="bi bi-arrow-right text-primary"></i>
                            </td>
                            <td>
                                @if($history->new_status == 'available')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Available
                                    </span>
                                @elseif($history->new_status == 'maintenance')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-tools"></i> Maintenance
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-exclamation-triangle"></i> Problem
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($history->changedBy)
                                    <i class="bi bi-person-circle"></i>
                                    {{ $history->changedBy->name }}
                                @else
                                    <span class="text-muted">System</span>
                                @endif
                            </td>
                            <td>
                                @if($history->notes)
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $history->notes }}">
                                        {{ $history->notes }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <small>
                                    {{ $history->created_at->format('Y-m-d') }}<br>
                                    {{ $history->created_at->format('H:i:s') }}
                                </small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0">No status history records found</p>
                                @if(request()->hasAny(['date_from', 'date_to', 'area_id', 'service_type_id', 'changed_by']))
                                    <a href="{{ route('admin.status-history.index') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="bi bi-x-circle"></i> Clear Filters
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($statusHistory->hasPages())
        <div class="card-footer bg-white">
            {{ $statusHistory->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Summary Statistics -->
@if($statusHistory->total() > 0)
<div class="row mt-4">
    <div class="col-md-12">
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            Showing <strong>{{ $statusHistory->count() }}</strong> of <strong>{{ $statusHistory->total() }}</strong> status change records
            (Page {{ $statusHistory->currentPage() }} of {{ $statusHistory->lastPage() }})
        </div>
    </div>
</div>
@endif
@endsection

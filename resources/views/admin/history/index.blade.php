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
    <form action="{{ route('admin.history.export') }}" method="GET" class="d-inline">
        @foreach(request()->all() as $key => $value)
            @if($value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach
        <button type="submit" class="btn btn-success">
            <i class="bi bi-download"></i> Export to CSV
        </button>
    </form>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.history.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Date From</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Date To</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
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
                <label class="form-label">Changed By</label>
                <select name="changed_by" class="form-select">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('changed_by') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Old Status</label>
                <select name="old_status" class="form-select">
                    <option value="">Any Status</option>
                    <option value="available" {{ request('old_status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="maintenance" {{ request('old_status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="unavailable" {{ request('old_status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">New Status</label>
                <select name="new_status" class="form-select">
                    <option value="">Any Status</option>
                    <option value="available" {{ request('new_status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="maintenance" {{ request('new_status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="unavailable" {{ request('new_status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-search"></i> Apply Filters
                </button>
                <a href="{{ route('admin.history.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Statistics -->
@if(request()->hasAny(['date_from', 'date_to', 'area', 'service_type', 'changed_by', 'old_status', 'new_status']))
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Changes</h6>
                        <h3 class="mb-0">{{ $history->total() }}</h3>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-arrow-left-right" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- History Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date & Time</th>
                        <th>Service Type</th>
                        <th>Area</th>
                        <th>Status Change</th>
                        <th>Changed By</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $record)
                        <tr>
                            <td>
                                <div>{{ $record->created_at->format('Y-m-d') }}</div>
                                <small class="text-muted">{{ $record->created_at->format('H:i:s') }}</small>
                            </td>
                            <td>
                                @if($record->serviceAvailability->serviceType->icon)
                                    <i class="bi bi-{{ $record->serviceAvailability->serviceType->icon }}"></i>
                                @endif
                                {{ $record->serviceAvailability->serviceType->name }}
                            </td>
                            <td>{{ $record->serviceAvailability->area->name }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($record->old_status) }}</span>
                                <i class="bi bi-arrow-right"></i>
                                <span class="badge bg-{{ $record->new_status == 'available' ? 'success' : ($record->new_status == 'maintenance' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($record->new_status) }}
                                </span>
                            </td>
                            <td>{{ $record->changedBy->name ?? 'System' }}</td>
                            <td>
                                @if($record->notes)
                                    <span class="text-truncate d-inline-block" style="max-width: 250px;" title="{{ $record->notes }}">
                                        {{ $record->notes }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0">No status history found</p>
                                @if(request()->hasAny(['date_from', 'date_to', 'area', 'service_type', 'changed_by', 'old_status', 'new_status']))
                                    <p class="mb-0"><small>Try adjusting your filters</small></p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($history->hasPages())
        <div class="card-footer bg-white">
            {{ $history->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Summary Info -->
@if($history->total() > 0)
<div class="mt-3">
    <p class="text-muted mb-0">
        <i class="bi bi-info-circle"></i> 
        Showing {{ $history->firstItem() }} to {{ $history->lastItem() }} of {{ $history->total() }} records
    </p>
</div>
@endif
@endsection

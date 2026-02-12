@extends('layouts.admin')

@section('title', 'Edit Service Availability')

@php
    $breadcrumbs = [
        ['title' => 'Service Availability', 'url' => route('admin.services.index')],
        ['title' => 'Edit', 'url' => '']
    ];
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-pencil"></i> Edit Service Availability</h2>
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Service Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.update', $serviceAvailability) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Area (Read-only, displayed) -->
                    <div class="mb-3">
                        <label class="form-label">Area</label>
                        <div class="form-control bg-light" readonly>
                            <i class="bi bi-geo-alt text-primary"></i> {{ $serviceAvailability->area->name }}
                        </div>
                        <input type="hidden" name="area_id" value="{{ $serviceAvailability->area_id }}">
                    </div>

                    <!-- Service Type (Read-only, displayed) -->
                    <div class="mb-3">
                        <label class="form-label">Service Type</label>
                        <div class="form-control bg-light" readonly>
                            @if($serviceAvailability->serviceType->icon)
                                <i class="bi bi-{{ $serviceAvailability->serviceType->icon }}"></i>
                            @endif
                            {{ $serviceAvailability->serviceType->name }}
                        </div>
                        <input type="hidden" name="service_type_id" value="{{ $serviceAvailability->service_type_id }}">
                    </div>

                    <!-- Current Status (displayed with badge) -->
                    <div class="mb-3">
                        <label class="form-label">Current Status</label>
                        <div>
                            @if($serviceAvailability->status == 'available')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle"></i> Available
                                </span>
                            @elseif($serviceAvailability->status == 'maintenance')
                                <span class="badge bg-warning text-dark fs-6">
                                    <i class="bi bi-tools"></i> Under Maintenance
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="bi bi-exclamation-triangle"></i> Service Issue
                                </span>
                            @endif
                            <small class="text-muted ms-2">
                                Last updated: {{ $serviceAvailability->last_updated ? $serviceAvailability->last_updated->format('Y-m-d H:i:s') : 'N/A' }}
                            </small>
                        </div>
                    </div>

                    <!-- New Status (radio buttons) -->
                    <div class="mb-3">
                        <label class="form-label">
                            New Status <span class="text-danger">*</span>
                        </label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('status') is-invalid @enderror" 
                                       type="radio" 
                                       name="status" 
                                       id="status_available" 
                                       value="available" 
                                       {{ old('status', $serviceAvailability->status) == 'available' ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label" for="status_available">
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Available
                                    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('status') is-invalid @enderror" 
                                       type="radio" 
                                       name="status" 
                                       id="status_maintenance" 
                                       value="maintenance" 
                                       {{ old('status', $serviceAvailability->status) == 'maintenance' ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label" for="status_maintenance">
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-tools"></i> Under Maintenance
                                    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('status') is-invalid @enderror" 
                                       type="radio" 
                                       name="status" 
                                       id="status_problem" 
                                       value="problem" 
                                       {{ old('status', $serviceAvailability->status) == 'problem' ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label" for="status_problem">
                                    <span class="badge bg-danger">
                                        <i class="bi bi-exclamation-triangle"></i> Service Issue
                                    </span>
                                </label>
                            </div>
                        </div>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label for="notes" class="form-label">
                            Notes <small class="text-muted">(Optional)</small>
                        </label>
                        <textarea name="notes" 
                                  id="notes" 
                                  class="form-control @error('notes') is-invalid @enderror" 
                                  rows="4"
                                  placeholder="Add any additional notes or comments...">{{ old('notes', $serviceAvailability->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Service Availability
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Status Changes -->
        @if($serviceAvailability->statusHistory && $serviceAvailability->statusHistory->count() > 0)
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Status Changes</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date/Time</th>
                                <th>Status Change</th>
                                <th>Changed By</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($serviceAvailability->statusHistory->take(5) as $history)
                                <tr>
                                    <td class="text-nowrap">{{ $history->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        @if($history->old_status)
                                            <span class="badge bg-secondary">{{ ucfirst($history->old_status) }}</span>
                                        @else
                                            <span class="badge bg-secondary">New</span>
                                        @endif
                                        <i class="bi bi-arrow-right"></i>
                                        <span class="badge bg-{{ $history->new_status == 'available' ? 'success' : ($history->new_status == 'maintenance' ? 'warning text-dark' : 'danger') }}">
                                            {{ ucfirst($history->new_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $history->changedBy->name ?? 'System' }}</td>
                                    <td>{{ $history->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card bg-light">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Information</h5>
            </div>
            <div class="card-body">
                <h6 class="fw-bold">Service Information:</h6>
                <ul class="list-unstyled mb-3">
                    <li><strong>Created:</strong> {{ $serviceAvailability->created_at->format('Y-m-d H:i:s') }}</li>
                    <li><strong>Last Updated:</strong> {{ $serviceAvailability->updated_at->format('Y-m-d H:i:s') }}</li>
                    <li><strong>Status Changes:</strong> {{ $serviceAvailability->statusHistory ? $serviceAvailability->statusHistory->count() : 0 }}</li>
                </ul>

                <hr>

                <h6 class="fw-bold">Status Definitions:</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <span class="badge bg-success mb-1">Available</span>
                        <br>
                        <small>Service is fully operational.</small>
                    </li>
                    <li class="mb-2">
                        <span class="badge bg-warning text-dark mb-1">Under Maintenance</span>
                        <br>
                        <small>Scheduled maintenance.</small>
                    </li>
                    <li class="mb-2">
                        <span class="badge bg-danger mb-1">Service Issue</span>
                        <br>
                        <small>Experiencing problems.</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Edit Service')

@php
    $breadcrumbs = [
        ['title' => 'Service Availability', 'url' => route('admin.services.index')],
        ['title' => 'Edit Service', 'url' => '']
    ];
@endphp

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Edit Service</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Area</label>
                        <input type="text" class="form-control" value="{{ $service->area->name }} ({{ $service->area->code }})" readonly>
                        <div class="form-text">Area cannot be changed after creation.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Service Type</label>
                        <input type="text" class="form-control" value="{{ $service->serviceType->name }}" readonly>
                        <div class="form-text">Service type cannot be changed after creation.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Current Status</label>
                        <div class="mb-2">
                            <span class="badge bg-{{ $service->status == 'available' ? 'success' : ($service->status == 'maintenance' ? 'warning' : 'danger') }}">
                                {{ ucfirst($service->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Status <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="status_available" value="available" {{ old('status', $service->status) == 'available' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="status_available">
                                    <span class="badge bg-success">Available</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="status_maintenance" value="maintenance" {{ old('status', $service->status) == 'maintenance' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_maintenance">
                                    <span class="badge bg-warning">Maintenance</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="status_unavailable" value="unavailable" {{ old('status', $service->status) == 'unavailable' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_unavailable">
                                    <span class="badge bg-danger">Unavailable</span>
                                </label>
                            </div>
                        </div>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" rows="4" class="form-control @error('notes') is-invalid @enderror" placeholder="Enter any additional notes or comments...">{{ old('notes', $service->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="change_reason" class="form-label">Reason for Change</label>
                        <input type="text" name="change_reason" id="change_reason" class="form-control @error('change_reason') is-invalid @enderror" value="{{ old('change_reason') }}" placeholder="Brief description of why the status is changing">
                        @error('change_reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">This will be recorded in the status history.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Last Updated</label>
                        <input type="text" class="form-control" value="{{ $service->last_updated ? $service->last_updated->format('Y-m-d H:i:s') : 'Never' }}" readonly>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Service
                        </button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Status History -->
        @if($service->statusHistory->count() > 0)
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Status History</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Change</th>
                                    <th>Changed By</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($service->statusHistory()->latest('id')->limit(10)->get() as $history)
                                    <tr>
                                        <td>{{ $history->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($history->old_status) }}</span>
                                            <i class="bi bi-arrow-right"></i>
                                            <span class="badge bg-{{ $history->new_status == 'available' ? 'success' : ($history->new_status == 'maintenance' ? 'warning' : 'danger') }}">
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
</div>
@endsection

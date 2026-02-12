@extends('layouts.admin')

@section('title', 'Add New Service Availability')

@php
    $breadcrumbs = [
        ['title' => 'Service Availability', 'url' => route('admin.service-availability.index')],
        ['title' => 'Add New', 'url' => '']
    ];
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-plus-circle"></i> Add New Service Availability</h2>
    <a href="{{ route('admin.service-availability.index') }}" class="btn btn-outline-secondary">
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
                <form action="{{ route('admin.service-availability.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="area_id" class="form-label">
                            Area <span class="text-danger">*</span>
                        </label>
                        <select name="area_id" id="area_id" class="form-select @error('area_id') is-invalid @enderror" required>
                            <option value="">Select an area</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('area_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="service_type_id" class="form-label">
                            Service Type <span class="text-danger">*</span>
                        </label>
                        <select name="service_type_id" id="service_type_id" class="form-select @error('service_type_id') is-invalid @enderror" required>
                            <option value="">Select a service type</option>
                            @foreach($serviceTypes as $type)
                                <option value="{{ $type->id }}" {{ old('service_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('status') is-invalid @enderror" 
                                       type="radio" 
                                       name="status" 
                                       id="status_available" 
                                       value="available" 
                                       {{ old('status', 'available') == 'available' ? 'checked' : '' }}
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
                                       {{ old('status') == 'maintenance' ? 'checked' : '' }}
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
                                       {{ old('status') == 'problem' ? 'checked' : '' }}
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

                    <div class="mb-3">
                        <label for="notes" class="form-label">
                            Notes <small class="text-muted">(Optional)</small>
                        </label>
                        <textarea name="notes" 
                                  id="notes" 
                                  class="form-control @error('notes') is-invalid @enderror" 
                                  rows="4"
                                  placeholder="Add any additional notes or comments...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.service-availability.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Create Service Availability
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card bg-light">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Information</h5>
            </div>
            <div class="card-body">
                <h6 class="fw-bold">Status Definitions:</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <span class="badge bg-success mb-1">Available</span>
                        <br>
                        <small>Service is fully operational and available for use.</small>
                    </li>
                    <li class="mb-2">
                        <span class="badge bg-warning text-dark mb-1">Under Maintenance</span>
                        <br>
                        <small>Service is temporarily unavailable due to scheduled maintenance.</small>
                    </li>
                    <li class="mb-2">
                        <span class="badge bg-danger mb-1">Service Issue</span>
                        <br>
                        <small>Service is experiencing problems or outages.</small>
                    </li>
                </ul>

                <hr>

                <h6 class="fw-bold">Tips:</h6>
                <ul class="small text-muted">
                    <li>Make sure the area and service type combination doesn't already exist</li>
                    <li>Use notes to provide details about the service status</li>
                    <li>You can quickly update status from the main list later</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

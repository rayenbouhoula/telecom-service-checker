@extends('layouts.admin')

@section('title', 'Add Service')

@php
    $breadcrumbs = [
        ['title' => 'Service Availability', 'url' => route('admin.services.index')],
        ['title' => 'Add Service', 'url' => '']
    ];
@endphp

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Add New Service</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="area_id" class="form-label">Area <span class="text-danger">*</span></label>
                        <select name="area_id" id="area_id" class="form-select @error('area_id') is-invalid @enderror" required>
                            <option value="">Select Area</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->name }} ({{ $area->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('area_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="service_type_id" class="form-label">Service Type <span class="text-danger">*</span></label>
                        <select name="service_type_id" id="service_type_id" class="form-select @error('service_type_id') is-invalid @enderror" required>
                            <option value="">Select Service Type</option>
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
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="status_available" value="available" {{ old('status', 'available') == 'available' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="status_available">
                                    <span class="badge bg-success">Available</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="status_maintenance" value="maintenance" {{ old('status') == 'maintenance' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_maintenance">
                                    <span class="badge bg-warning">Maintenance</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="status_problem" value="problem" {{ old('status') == 'problem' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_problem">
                                    <span class="badge bg-danger">Problem</span>
                                </label>
                            </div>
                        </div>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" rows="4" class="form-control @error('notes') is-invalid @enderror" placeholder="Enter any additional notes or comments...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Optional: Add any relevant information about this service status.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Create Service
                        </button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

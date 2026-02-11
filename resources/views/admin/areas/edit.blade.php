@extends('layouts.admin')

@section('title', 'Edit Area')

@php
    $breadcrumbs = [
        ['title' => 'Areas', 'url' => route('admin.areas.index')],
        ['title' => 'Edit Area', 'url' => '']
    ];
@endphp

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Edit Area</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.areas.update', $area) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $area->name) }}" placeholder="e.g., Downtown, North District" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Enter the area name.</div>
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $area->code) }}" placeholder="e.g., DT, ND" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Enter a unique code for the area (2-10 characters).</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Associated Services</label>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> This area is currently used by <strong>{{ $area->serviceAvailabilities->count() }}</strong> service(s).
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Area
                        </button>
                        <a href="{{ route('admin.areas.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

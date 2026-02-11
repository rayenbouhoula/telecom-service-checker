@extends('layouts.admin')

@section('title', 'Add Service Type')

@php
    $breadcrumbs = [
        ['title' => 'Service Types', 'url' => route('admin.service-types.index')],
        ['title' => 'Add Service Type', 'url' => '']
    ];
@endphp

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Add New Service Type</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.service-types.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g., Mobile Network, Broadband Internet" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Enter the service type name.</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Brief description of this service type...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Optional: Provide additional details about this service type.</div>
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-palette"></i>
                            </span>
                            <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon') }}" placeholder="e.g., wifi, phone, broadcast">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Optional: Enter a Bootstrap Icon name (without 'bi-' prefix). Example: wifi, phone, broadcast</div>
                    </div>

                    <div class="mb-3" id="iconPreview" style="display: none;">
                        <label class="form-label">Icon Preview</label>
                        <div class="alert alert-light">
                            <i id="previewIcon" style="font-size: 2rem;"></i>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Create Service Type
                        </button>
                        <a href="{{ route('admin.service-types.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('icon').addEventListener('input', function() {
        const iconName = this.value.trim();
        const preview = document.getElementById('iconPreview');
        const previewIcon = document.getElementById('previewIcon');
        
        if (iconName) {
            previewIcon.className = 'bi bi-' + iconName;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });
</script>
@endpush

@extends('layouts.admin')

@section('title', 'Service Types')

@php
    $breadcrumbs = [
        ['title' => 'Service Types', 'url' => '']
    ];
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-list-task"></i> Service Types</h2>
    <a href="{{ route('admin.service-types.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Service Type
    </a>
</div>

<!-- Service Types Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Services</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($serviceTypes as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>
                                @if($type->icon)
                                    <i class="bi bi-{{ $type->icon }}" style="font-size: 1.5rem;"></i>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $type->name }}</td>
                            <td>
                                @if($type->description)
                                    <span class="text-truncate d-inline-block" style="max-width: 300px;" title="{{ $type->description }}">
                                        {{ $type->description }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $type->serviceAvailabilities->count() }}</span>
                            </td>
                            <td>{{ $type->created_at->format('Y-m-d') }}</td>
                            <td class="text-end table-actions">
                                <a href="{{ route('admin.service-types.edit', $type) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($type->serviceAvailabilities->count() == 0)
                                    <form action="{{ route('admin.service-types.destroy', $type) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service type?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-sm btn-outline-danger" disabled title="Cannot delete service type with existing services">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0">No service types found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($serviceTypes->hasPages())
        <div class="card-footer bg-white">
            {{ $serviceTypes->links() }}
        </div>
    @endif
</div>

<!-- Bootstrap Icons Reference -->
<div class="card mt-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-palette"></i> Icon Reference</h5>
    </div>
    <div class="card-body">
        <p class="mb-2">Common Bootstrap Icons for telecom services:</p>
        <div class="d-flex flex-wrap gap-3">
            <div class="text-center">
                <i class="bi bi-wifi" style="font-size: 1.5rem;"></i>
                <div><small><code>wifi</code></small></div>
            </div>
            <div class="text-center">
                <i class="bi bi-phone" style="font-size: 1.5rem;"></i>
                <div><small><code>phone</code></small></div>
            </div>
            <div class="text-center">
                <i class="bi bi-broadcast" style="font-size: 1.5rem;"></i>
                <div><small><code>broadcast</code></small></div>
            </div>
            <div class="text-center">
                <i class="bi bi-router" style="font-size: 1.5rem;"></i>
                <div><small><code>router</code></small></div>
            </div>
            <div class="text-center">
                <i class="bi bi-tv" style="font-size: 1.5rem;"></i>
                <div><small><code>tv</code></small></div>
            </div>
            <div class="text-center">
                <i class="bi bi-telephone-fill" style="font-size: 1.5rem;"></i>
                <div><small><code>telephone-fill</code></small></div>
            </div>
            <div class="text-center">
                <i class="bi bi-hdd-network" style="font-size: 1.5rem;"></i>
                <div><small><code>hdd-network</code></small></div>
            </div>
            <div class="text-center">
                <i class="bi bi-reception-4" style="font-size: 1.5rem;"></i>
                <div><small><code>reception-4</code></small></div>
            </div>
        </div>
        <p class="mt-3 mb-0 text-muted"><small>View more at <a href="https://icons.getbootstrap.com/" target="_blank">icons.getbootstrap.com</a></small></p>
    </div>
</div>
@endsection

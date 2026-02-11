@extends('layouts.admin')

@section('title', 'Areas')

@php
    $breadcrumbs = [
        ['title' => 'Areas', 'url' => '']
    ];
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-geo-alt"></i> Areas</h2>
    <a href="{{ route('admin.areas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Area
    </a>
</div>

<!-- Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.areas.index') }}" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Search by name or code..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-search"></i> Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.areas.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Areas Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Services</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($areas as $area)
                        <tr>
                            <td>{{ $area->id }}</td>
                            <td>{{ $area->name }}</td>
                            <td><code>{{ $area->code }}</code></td>
                            <td>
                                <span class="badge bg-secondary">{{ $area->serviceAvailabilities->count() }}</span>
                            </td>
                            <td>{{ $area->created_at->format('Y-m-d') }}</td>
                            <td class="text-end table-actions">
                                <a href="{{ route('admin.areas.edit', $area) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($area->serviceAvailabilities->count() == 0)
                                    <form action="{{ route('admin.areas.destroy', $area) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this area?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-sm btn-outline-danger" disabled title="Cannot delete area with existing services">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0">No areas found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($areas->hasPages())
        <div class="card-footer bg-white">
            {{ $areas->links() }}
        </div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-speedometer2"></i> Dashboard</h2>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Services</h6>
                        <h3 class="mb-0">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-broadcast-pin" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Available</h6>
                        <h3 class="mb-0 text-success">{{ $stats['available'] }}</h3>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-check-circle-fill" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Maintenance</h6>
                        <h3 class="mb-0 text-warning">{{ $stats['maintenance'] }}</h3>
                    </div>
                    <div class="text-warning">
                        <i class="bi bi-tools" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Problems</h6>
                        <h3 class="mb-0 text-danger">{{ $stats['problem'] }}</h3>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Status Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> 7-Day Status Trends</h5>
            </div>
            <div class="card-body">
                <canvas id="trendChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Status Changes -->
<div class="card mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Status Changes</h5>
        <a href="{{ route('admin.history.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Service Type</th>
                        <th>Area</th>
                        <th>Status Change</th>
                        <th>Changed By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentChanges as $change)
                        <tr>
                            <td>{{ $change->serviceAvailability->serviceType->name }}</td>
                            <td>{{ $change->serviceAvailability->area->name }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($change->old_status) }}</span>
                                <i class="bi bi-arrow-right"></i>
                                <span class="badge bg-{{ $change->new_status == 'available' ? 'success' : ($change->new_status == 'maintenance' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($change->new_status) }}
                                </span>
                            </td>
                            <td>{{ $change->changedBy->name ?? 'System' }}</td>
                            <td>{{ $change->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No recent status changes</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-lightning-fill"></i> Quick Actions</h5>
    </div>
    <div class="card-body">
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary me-2 mb-2">
            <i class="bi bi-plus-circle"></i> Add New Service
        </a>
        <a href="{{ route('admin.areas.create') }}" class="btn btn-outline-primary me-2 mb-2">
            <i class="bi bi-plus-circle"></i> Add Area
        </a>
        <a href="{{ route('admin.service-types.create') }}" class="btn btn-outline-primary me-2 mb-2">
            <i class="bi bi-plus-circle"></i> Add Service Type
        </a>
        <a href="{{ route('admin.history.index') }}" class="btn btn-outline-secondary mb-2">
            <i class="bi bi-download"></i> Export History
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Available', 'Maintenance', 'Unavailable'],
            datasets: [{
                data: [{{ $stats['available'] }}, {{ $stats['maintenance'] }}, {{ $stats['problem'] }}],
                backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // 7-Day Trend Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($statusChangesChart['labels']) !!},
            datasets: [
                {
                    label: 'Available',
                    data: {!! json_encode($statusChangesChart['available']) !!},
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Maintenance',
                    data: {!! json_encode($statusChangesChart['maintenance']) !!},
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Unavailable',
                    data: {!! json_encode($statusChangesChart['unavailable']) !!},
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush

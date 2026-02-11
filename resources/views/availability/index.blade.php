@extends('layouts.public')

@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Check Service Availability</h1>
        <p class="lead mb-0">Select your area and service type to check real-time availability</p>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Selection Form -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4 fw-bold">
                            <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                            Step 1: Select Your Area
                        </h4>
                        <div class="mb-4">
                            <label for="areaSelect" class="form-label fw-semibold">Choose your area:</label>
                            <select class="form-select form-select-lg" id="areaSelect" required>
                                <option value="">-- Select an area --</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <h4 class="card-title mb-4 fw-bold">
                            <i class="bi bi-broadcast text-primary me-2"></i>
                            Step 2: Select Service Type
                        </h4>
                        <div class="row g-3 mb-4" id="serviceTypeCards">
                            @foreach($serviceTypes as $serviceType)
                            <div class="col-md-6">
                                <div class="card service-type-card h-100 border-2" data-service-id="{{ $serviceType->id }}" style="cursor: pointer;">
                                    <div class="card-body text-center p-4">
                                        <i class="bi bi-{{ $serviceType->icon }} fs-1 text-primary mb-3"></i>
                                        <h5 class="card-title fw-bold">{{ $serviceType->name }}</h5>
                                        <p class="card-text text-muted small mb-0">{{ $serviceType->description }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="d-grid">
                            <button type="button" class="btn btn-primary btn-lg" id="checkAvailabilityBtn" disabled>
                                <i class="bi bi-search me-2"></i>Check Availability
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div class="text-center py-5" id="loadingSpinner" style="display: none;">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Checking availability...</p>
                </div>

                <!-- Results Section -->
                <div id="resultsSection" style="display: none;">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4 fw-bold">
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                Availability Results
                            </h4>
                            
                            <div id="resultContent">
                                <!-- Results will be inserted here via JavaScript -->
                            </div>

                            <div class="alert alert-info mt-4 mb-0" role="alert">
                                <i class="bi bi-clock me-2"></i>
                                <small>Status updates automatically every 30 seconds</small>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-outline-primary" id="checkAnotherBtn">
                            <i class="bi bi-arrow-clockwise me-2"></i>Check Another Service
                        </button>
                    </div>
                </div>

                <!-- Error Alert -->
                <div class="alert alert-danger alert-dismissible fade show" id="errorAlert" style="display: none;" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <span id="errorMessage"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .service-type-card {
        transition: all 0.3s ease;
        border-color: #dee2e6 !important;
    }
    .service-type-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-color: #0d6efd !important;
    }
    .service-type-card.selected {
        background-color: #e7f1ff;
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    .service-type-card.selected i {
        color: #0d6efd !important;
    }
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@push('scripts')
<script>
    let selectedAreaId = null;
    let selectedServiceTypeId = null;
    let autoRefreshInterval = null;

    document.addEventListener('DOMContentLoaded', function() {
        const areaSelect = document.getElementById('areaSelect');
        const serviceTypeCards = document.querySelectorAll('.service-type-card');
        const checkBtn = document.getElementById('checkAvailabilityBtn');
        const checkAnotherBtn = document.getElementById('checkAnotherBtn');
        const resultsSection = document.getElementById('resultsSection');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const errorAlert = document.getElementById('errorAlert');

        // Area selection
        areaSelect.addEventListener('change', function() {
            selectedAreaId = this.value;
            validateForm();
        });

        // Service type card selection
        serviceTypeCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                serviceTypeCards.forEach(c => c.classList.remove('selected'));
                // Add selected class to clicked card
                this.classList.add('selected');
                selectedServiceTypeId = this.dataset.serviceId;
                validateForm();
            });
        });

        // Check availability button
        checkBtn.addEventListener('click', function() {
            checkAvailability();
        });

        // Check another button
        checkAnotherBtn.addEventListener('click', function() {
            resetForm();
        });

        function validateForm() {
            if (selectedAreaId && selectedServiceTypeId) {
                checkBtn.disabled = false;
            } else {
                checkBtn.disabled = true;
            }
        }

        function checkAvailability() {
            // Hide previous results and errors
            resultsSection.style.display = 'none';
            errorAlert.style.display = 'none';
            loadingSpinner.style.display = 'block';

            // Stop auto-refresh if running
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
                autoRefreshInterval = null;
            }

            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Make AJAX request
            fetch('{{ route("check.availability") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    area_id: selectedAreaId,
                    service_type_id: selectedServiceTypeId
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'An error occurred');
                    });
                }
                return response.json();
            })
            .then(data => {
                displayResults(data);
                loadingSpinner.style.display = 'none';
                resultsSection.style.display = 'block';
                resultsSection.classList.add('fade-in');

                // Start auto-refresh
                startAutoRefresh();
            })
            .catch(error => {
                loadingSpinner.style.display = 'none';
                showError(error.message);
            });
        }

        function displayResults(data) {
            const resultContent = document.getElementById('resultContent');
            
            // Determine status badge color
            let badgeClass = 'bg-success';
            let statusIcon = 'check-circle-fill';
            if (data.status === 'limited') {
                badgeClass = 'bg-warning';
                statusIcon = 'exclamation-triangle-fill';
            } else if (data.status === 'unavailable') {
                badgeClass = 'bg-danger';
                statusIcon = 'x-circle-fill';
            }

            const statusText = data.status.charAt(0).toUpperCase() + data.status.slice(1);

            resultContent.innerHTML = `
                <div class="row align-items-center mb-4">
                    <div class="col-auto">
                        <i class="bi bi-${data.icon} fs-1 text-primary"></i>
                    </div>
                    <div class="col">
                        <h5 class="mb-1 fw-bold">${data.service_type_name}</h5>
                        <p class="text-muted mb-0">
                            <i class="bi bi-geo-alt me-1"></i>${data.area_name}
                        </p>
                    </div>
                    <div class="col-auto">
                        <span class="badge ${badgeClass} fs-6 px-3 py-2">
                            <i class="bi bi-${statusIcon} me-1"></i>${statusText}
                        </span>
                    </div>
                </div>

                ${data.notes ? `
                <div class="alert alert-light border mb-3">
                    <h6 class="mb-2 fw-bold">
                        <i class="bi bi-info-circle me-1"></i>Additional Information
                    </h6>
                    <p class="mb-0">${escapeHtml(data.notes)}</p>
                </div>
                ` : ''}

                <div class="text-muted small">
                    <i class="bi bi-clock me-1"></i>Last updated: ${formatDateTime(data.last_updated)}
                </div>
            `;
        }

        function startAutoRefresh() {
            autoRefreshInterval = setInterval(function() {
                // Silent refresh without showing loading spinner
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('{{ route("check.availability") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        area_id: selectedAreaId,
                        service_type_id: selectedServiceTypeId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        displayResults(data);
                    }
                })
                .catch(error => {
                    console.error('Auto-refresh error:', error);
                });
            }, 30000); // 30 seconds
        }

        function resetForm() {
            selectedAreaId = null;
            selectedServiceTypeId = null;
            areaSelect.value = '';
            serviceTypeCards.forEach(c => c.classList.remove('selected'));
            checkBtn.disabled = true;
            resultsSection.style.display = 'none';
            errorAlert.style.display = 'none';

            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
                autoRefreshInterval = null;
            }

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function showError(message) {
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.textContent = message;
            errorAlert.style.display = 'block';
            errorAlert.classList.add('fade-in');
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function formatDateTime(dateTimeString) {
            const date = new Date(dateTimeString);
            return date.toLocaleString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Clean up interval on page unload
        window.addEventListener('beforeunload', function() {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
            }
        });
    });
</script>
@endpush

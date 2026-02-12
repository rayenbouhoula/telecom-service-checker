@extends('layouts.public')

@section('content')
@php
    $logoExists = file_exists(public_path('images/tunisie-telecom-logo.png'));
@endphp
<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center text-white">
                @if($logoExists)
                    <img src="{{ asset('images/tunisie-telecom-logo.png') }}" 
                         alt="Tunisie Telecom" 
                         class="mb-4" 
                         style="max-height: 80px; filter: brightness(0) invert(1);">
                @endif
                <h1 class="display-3 fw-bold mb-4">Tunisie Telecom Service Checker</h1>
                <p class="lead mb-5">Find out if your favorite telecom services are available in your area. Real-time status updates for internet, mobile, TV, and phone services.</p>
                <a href="{{ route('check.index') }}" class="btn btn-light btn-lg px-5 py-3 shadow-lg">
                    <i class="bi bi-search me-2"></i>Check Availability Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Why Choose Tunisie Telecom?</h2>
            <p class="lead text-muted">Everything you need to find the right telecom service</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-lightning-charge fs-1 text-primary"></i>
                        </div>
                        <h5 class="card-title fw-bold">Real-time Status</h5>
                        <p class="card-text text-muted">Get up-to-date information on service availability with automatic updates every 30 seconds.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-grid-3x3-gap fs-1 text-success"></i>
                        </div>
                        <h5 class="card-title fw-bold">Multiple Services</h5>
                        <p class="card-text text-muted">Check availability for Internet, Mobile, TV, and Phone services all in one place.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-geo-alt fs-1 text-info"></i>
                        </div>
                        <h5 class="card-title fw-bold">Coverage Info</h5>
                        <p class="card-text text-muted">See detailed coverage information for your specific area with accurate status updates.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-hand-thumbs-up fs-1 text-warning"></i>
                        </div>
                        <h5 class="card-title fw-bold">Easy to Use</h5>
                        <p class="card-text text-muted">Simple and intuitive interface makes checking service availability quick and effortless.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">How It Works</h2>
            <p class="lead text-muted">Check service availability in three simple steps</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <span class="fs-1 fw-bold">1</span>
                    </div>
                    <h4 class="fw-bold">Select Your Area</h4>
                    <p class="text-muted">Choose your location from our comprehensive list of service areas.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <span class="fs-1 fw-bold">2</span>
                    </div>
                    <h4 class="fw-bold">Choose Service Type</h4>
                    <p class="text-muted">Select the type of telecom service you're interested in checking.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <span class="fs-1 fw-bold">3</span>
                    </div>
                    <h4 class="fw-bold">View Results</h4>
                    <p class="text-muted">Get instant results with detailed availability information and status.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('check.index') }}" class="btn btn-primary btn-lg px-5 py-3">
                Get Started Now <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection

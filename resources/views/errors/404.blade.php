@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 text-center">
            <div class="error-icon mb-4">
                <i class="bi bi-exclamation-triangle" style="font-size: 6rem; color: #f59e0b;"></i>
            </div>
            <h1 class="display-1 fw-bold text-warning">404</h1>
            <h2 class="mb-4">Page Not Found</h2>
            <p class="lead text-muted mb-4">
                The page you're looking for doesn't exist or has been moved.
            </p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-house-door"></i> Go Home
                </a>
                <a href="{{ route('check.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> Check Availability
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 text-center">
            <div class="error-icon mb-4">
                <i class="bi bi-x-circle" style="font-size: 6rem; color: #dc3545;"></i>
            </div>
            <h1 class="display-1 fw-bold text-danger">500</h1>
            <h2 class="mb-4">Server Error</h2>
            <p class="lead text-muted mb-4">
                Oops! Something went wrong on our end. We're working to fix it.
            </p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-house-door"></i> Go Home
                </a>
                <button onclick="window.location.reload()" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-clockwise"></i> Try Again
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

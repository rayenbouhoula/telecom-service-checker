@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 text-center">
            <div class="error-icon mb-4">
                <i class="bi bi-shield-exclamation" style="font-size: 6rem; color: #ef4444;"></i>
            </div>
            <h1 class="display-1 fw-bold text-danger">403</h1>
            <h2 class="mb-4">Access Forbidden</h2>
            <p class="lead text-muted mb-4">
                Sorry, you don't have permission to access this page.
            </p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-house-door"></i> Go Home
                </a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection

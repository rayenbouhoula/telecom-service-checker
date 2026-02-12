<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Telecom Service Checker') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
</head>
<body>
    @php
        $logoExists = file_exists(public_path('images/tunisie-telecom-logo.png'));
    @endphp
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ route('home') }}">
                @if($logoExists)
                    <img src="{{ asset('images/tunisie-telecom-logo.png') }}" 
                         alt="Tunisie Telecom" 
                         height="40" 
                         class="me-2">
                    <span>Tunisie Telecom</span>
                @else
                    <i class="bi bi-broadcast-pin fs-4"></i>
                    Tunisie Telecom
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('check.*') ? 'active' : '' }}" href="{{ route('check.index') }}">Check Availability</a>
                    </li>
                </ul>
                <div class="d-flex">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold">
                        @if($logoExists)
                            <img src="{{ asset('images/tunisie-telecom-logo.png') }}" 
                                 alt="Tunisie Telecom" 
                                 height="30" 
                                 class="me-2">
                        @else
                            <i class="bi bi-broadcast-pin"></i>
                        @endif
                        Tunisie Telecom
                    </h5>
                    <p class="text-muted mb-0">Check telecom service availability in your area.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">&copy; {{ date('Y') }} Tunisie Telecom. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>

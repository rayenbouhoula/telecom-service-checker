<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - TelecomCheck Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        body {
            min-height: 100vh;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 56px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #212529;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, .75);
            padding: .75rem 1rem;
            border-radius: 0;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, .1);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        .main-content {
            margin-left: 240px;
            padding-top: 56px;
        }
        @media (max-width: 767.98px) {
            .sidebar {
                position: relative;
                padding-top: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
        .navbar-brand {
            font-weight: 600;
        }
        .stat-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
        }
        .table-actions {
            white-space: nowrap;
        }
        .breadcrumb {
            margin-bottom: 1.5rem;
            background-color: transparent;
            padding: 0;
        }
    </style>
    @stack('styles')
</head>
<body>
    @php
$logoExists = file_exists(public_path('images/tunisie-telecom-logo.png'));
    @endphp
    
    <!-- Top Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                @if($logoExists)
                    <img src="{{ asset('images/tunisie-telecom-logo.png') }}" 
                         alt="Tunisie Telecom" 
                         height="40" 
                         class="me-2">
                @else
                    <i class="bi bi-telephone-fill me-2"></i>
                @endif
                <span>Tunisie Telecom Admin</span>
            </a>
            <div class="d-flex">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="position: absolute; right: 0; left: auto; z-index: 9999;">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person"></i> Profile</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidebar col-md-3 col-lg-2 d-md-block">
        <div class="position-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.service-availability.*') ? 'active' : '' }}" href="{{ route('admin.service-availability.index') }}">
                        <i class="bi bi-broadcast-pin"></i> Service Availability
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.areas.*') ? 'active' : '' }}" href="{{ route('admin.areas.index') }}">
                        <i class="bi bi-geo-alt"></i> Areas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.service-types.*') ? 'active' : '' }}" href="{{ route('admin.service-types.index') }}">
                        <i class="bi bi-list-task"></i> Service Types
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.status-history.*') ? 'active' : '' }}" href="{{ route('admin.status-history.index') }}">
                        <i class="bi bi-clock-history"></i> Status History
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid py-4">
            @if(isset($breadcrumbs))
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        @foreach($breadcrumbs as $breadcrumb)
                            @if($loop->last)
                                <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

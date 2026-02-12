<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tunisie Telecom - Vérification de Couverture') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 antialiased" x-data="{ mobileMenuOpen: false }">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo Section - FIXED SIZE -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="h-12 w-12 bg-tt-blue rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">TT</span>
                        </div>
                        <div class="border-l-2 border-tt-blue pl-3">
                            <div class="text-lg font-bold text-tt-blue">Tunisie Telecom</div>
                            <div class="text-xs text-gray-500">Vérification de Couverture</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-tt-blue font-medium transition-colors {{ request()->routeIs('home') ? 'text-tt-blue border-b-2 border-tt-blue' : '' }} pb-1">
                        Accueil
                    </a>
                    <a href="{{ route('coverage.public') }}" class="text-gray-700 hover:text-tt-blue font-medium transition-colors {{ request()->routeIs('coverage.public') ? 'text-tt-blue border-b-2 border-tt-blue' : '' }} pb-1">
                        Couverture
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-tt-blue text-white rounded-lg hover:bg-tt-blue-600 transition-colors font-medium shadow-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-tt-blue text-white rounded-lg hover:bg-tt-blue-600 transition-colors font-medium shadow-sm">
                            Connexion
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-gray-700 hover:text-tt-blue focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-tt-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Accueil
                </a>
                <a href="{{ route('coverage.public') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('coverage.public') ? 'bg-tt-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Couverture
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                        Connexion
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Brand -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-tt-blue rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold">Tunisie Telecom</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Vérifiez la disponibilité de nos services dans votre région.
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="font-semibold mb-4">Liens Rapides</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-tt-blue transition-colors">Accueil</a></li>
                        <li><a href="{{ route('coverage.public') }}" class="hover:text-tt-blue transition-colors">Vérifier la Couverture</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-tt-blue transition-colors">Dashboard</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-semibold mb-4">Informations</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>À propos</li>
                        <li>Contact</li>
                        <li>Conditions d'utilisation</li>
                        <li>Politique de confidentialité</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Tunisie Telecom. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

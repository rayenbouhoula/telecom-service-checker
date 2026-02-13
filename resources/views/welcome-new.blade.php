@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-tt-blue to-tt-blue-700 overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                {{ __('Welcome to Tunisie Telecom') }}
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                {{ __('Your trusted telecommunications provider in Tunisia') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('coverage.public') }}" class="inline-flex items-center px-8 py-4 bg-white dark:bg-gray-800 text-tt-blue rounded-lg hover:bg-gray-50 dark:bg-gray-900 font-semibold text-lg shadow-lg transition-all transform hover:scale-105">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    {{ __('Check Coverage Now') }}
                </a>
                @guest
                <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg hover:bg-white dark:bg-gray-800 hover:text-tt-blue font-semibold text-lg transition-all">
                    {{ __('Admin Panel') }}
                </a>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                {{ __('Our Services') }}
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400">
                {{ __('Discover service availability in your region') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1: 4G/5G Coverage -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 hover-lift">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-tt-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Couverture 4G/5G</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Profitez d'une connexion ultra-rapide avec notre réseau 4G et 5G disponible dans les principales régions.
                </p>
            </div>

            <!-- Feature 2: Service Availability -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 hover-lift">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-tt-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Disponibilité des Services</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Vérifiez la disponibilité de tous nos services : Internet, téléphonie fixe et mobile dans votre zone.
                </p>
            </div>

            <!-- Feature 3: Real-time Data -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 hover-lift">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-tt-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Données en Temps Réel</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Obtenez des informations à jour sur la qualité du réseau et les vitesses de connexion disponibles.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Speed Test Preview Section -->
<div class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                {{ __('Quick Speed Test') }}
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400">
                {{ __('Test your internet connection speed') }}
            </p>
        </div>

        <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-8 md:p-12 border border-gray-200 dark:border-gray-700 text-center">
            <svg class="w-24 h-24 mx-auto text-tt-blue mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                {{ __('Test Your Connection Speed') }}
            </h3>
            
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                {{ __('Measure your download and upload speeds, check your ping, and access router settings') }}
            </p>
            
            <a href="{{ route('speedtest') }}" class="inline-block bg-tt-blue text-white py-4 px-8 rounded-lg font-bold text-lg hover:bg-tt-blue-600 transition-all transform hover:scale-105 shadow-lg">
                {{ __('Start Speed Test') }}
            </a>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-tt-blue mb-2">24</div>
                <div class="text-gray-600 dark:text-gray-400">Gouvernorats Couverts</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-tt-blue mb-2">5G</div>
                <div class="text-gray-600 dark:text-gray-400">Technologie Disponible</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-tt-blue mb-2">99%</div>
                <div class="text-gray-600 dark:text-gray-400">Taux de Couverture</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-tt-blue mb-2">24/7</div>
                <div class="text-gray-600 dark:text-gray-400">Service Disponible</div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-br from-tt-blue to-tt-blue-700 text-white py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            {{ __('Ready to check your coverage?') }}
        </h2>
        <p class="text-xl mb-8 text-blue-100">
            {{ __('Discover available services in your region now') }}
        </p>
        <a href="{{ route('coverage.public') }}" class="inline-block bg-white text-tt-blue px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-50 transition-all transform hover:scale-105 shadow-lg">
            {{ __('Start Verification') }}
        </a>
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 1s ease-out;
}
</style>
@endsection

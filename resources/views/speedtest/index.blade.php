@extends('layouts.public')

@section('content')
<div class="bg-gradient-to-br from-tt-blue to-tt-blue-700 text-white py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-4">{{ __('Internet Speed Test') }}</h1>
        <p class="text-xl text-blue-100">{{ __('Test your connection speed and quality') }}</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Speed Test Widget -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-8">
        <div id="speedtest-container" class="text-center">
            <button onclick="startSpeedTest()" id="startBtn" class="px-12 py-6 bg-tt-blue text-white rounded-full text-2xl font-bold hover:bg-tt-blue-600 transition-all transform hover:scale-105 shadow-lg">
                {{ __('Start Test') }}
            </button>
            
            <div id="results" class="hidden mt-8">
                <!-- Download Speed -->
                <div class="mb-6">
                    <h3 class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ __('Download Speed') }}</h3>
                    <div class="text-5xl font-bold text-tt-blue" id="downloadSpeed">0</div>
                    <div class="text-gray-600 dark:text-gray-400">Mbps</div>
                </div>
                
                <!-- Upload Speed -->
                <div class="mb-6">
                    <h3 class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ __('Upload Speed') }}</h3>
                    <div class="text-5xl font-bold text-tt-blue" id="uploadSpeed">0</div>
                    <div class="text-gray-600 dark:text-gray-400">Mbps</div>
                </div>
                
                <!-- Ping -->
                <div>
                    <h3 class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ __('Ping') }}</h3>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white" id="ping">0</div>
                    <div class="text-gray-600 dark:text-gray-400">ms</div>
                </div>
            </div>
            
            <div id="loading" class="hidden">
                <div class="animate-spin rounded-full h-20 w-20 border-b-4 border-tt-blue mx-auto"></div>
                <p class="mt-4 text-gray-600 dark:text-gray-400">{{ __('Testing your connection...') }}</p>
            </div>
        </div>
    </div>
    
    <!-- Connection Info -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ __('Connection Information') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">{{ __('IP Address') }}</span>
                <span class="font-semibold text-gray-900 dark:text-white" id="ipAddress">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">{{ __('ISP') }}</span>
                <span class="font-semibold text-gray-900 dark:text-white">Tunisie Telecom</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">{{ __('Server Location') }}</span>
                <span class="font-semibold text-gray-900 dark:text-white">Tunis, Tunisia</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">{{ __('Network Type') }}</span>
                <span class="font-semibold text-gray-900 dark:text-white" id="networkType">-</span>
            </div>
        </div>
    </div>
    
    <!-- Router Management Button -->
    <div class="text-center">
        <a href="http://192.168.1.1" target="_blank" class="inline-flex items-center px-8 py-4 bg-tt-blue text-white rounded-lg hover:bg-tt-blue-600 font-semibold text-lg shadow-lg transition-all">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            {{ __('Manage Router') }}
        </a>
    </div>
</div>

@push('scripts')
<script>
    // Get IP address
    fetch('https://api.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            document.getElementById('ipAddress').textContent = data.ip;
        });
    
    // Detect network type
    const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    if (connection) {
        document.getElementById('networkType').textContent = connection.effectiveType || 'Unknown';
    }
    
    function startSpeedTest() {
        document.getElementById('startBtn').classList.add('hidden');
        document.getElementById('loading').classList.remove('hidden');
        
        // Simulate speed test (replace with real implementation)
        setTimeout(() => {
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('results').classList.remove('hidden');
            
            // Simulate results
            animateValue('downloadSpeed', 0, Math.floor(Math.random() * 100) + 20, 2000);
            animateValue('uploadSpeed', 0, Math.floor(Math.random() * 50) + 10, 2000);
            animateValue('ping', 0, Math.floor(Math.random() * 50) + 10, 1000);
        }, 3000);
    }
    
    function animateValue(id, start, end, duration) {
        const element = document.getElementById(id);
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= end) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, 16);
    }
</script>
@endpush
@endsection

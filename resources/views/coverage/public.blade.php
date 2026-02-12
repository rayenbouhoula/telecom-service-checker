@extends('layouts.public')

@section('content')
<!-- Hero Section with Tunisia Map Background -->
<div class="relative bg-gradient-to-br from-tt-red to-tt-red-dark text-white py-16">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M10 10h80v80H10z\' fill=\'none\' stroke=\'white\' stroke-width=\'1\'/%3E%3C/svg%3E'); background-size: 50px 50px;"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            Vérification de Couverture
        </h1>
        <p class="text-xl text-white/90">
            Découvrez la disponibilité des services Tunisie Telecom dans votre région
        </p>
    </div>
</div>

<!-- Main Coverage Checker -->
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Coverage Checker Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Vérifier la Couverture</h2>
            
            <div id="coverage-checker" class="space-y-6">
                
                <!-- Governorate Selection -->
                <div>
                    <label for="governorate-select" class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="inline-block w-5 h-5 mr-1 text-tt-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Sélectionnez votre Gouvernorat
                    </label>
                    <select id="governorate-select" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tt-red focus:ring-tt-red text-lg py-3">
                        <option value="">-- Choisir un gouvernorat --</option>
                    </select>
                </div>

                <!-- Service Type Selection -->
                <div>
                    <label for="service-type-select" class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="inline-block w-5 h-5 mr-1 text-tt-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Type de Service (Optionnel)
                    </label>
                    <select id="service-type-select" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tt-red focus:ring-tt-red text-lg py-3">
                        <option value="">-- Tous les services --</option>
                    </select>
                </div>

                <!-- Check Button -->
                <div>
                    <button id="check-coverage-btn" 
                            class="w-full bg-tt-gradient text-white font-bold py-4 px-6 rounded-lg transition-all transform hover:scale-105 hover:shadow-xl">
                        <svg class="inline-block w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Vérifier la Couverture
                    </button>
                </div>

                <!-- Loading Spinner -->
                <div id="loading" class="hidden text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-16 w-16 border-b-4 border-tt-red"></div>
                    <p class="mt-4 text-gray-600 font-medium">Vérification en cours...</p>
                </div>

                <!-- Results Section -->
                <div id="results" class="hidden">
                    <div class="bg-gradient-to-r from-tt-red-light to-white rounded-xl p-6 border-l-4 border-tt-red">
                        <h3 class="text-xl font-bold mb-6 text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-tt-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Résultats de la Couverture
                        </h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Signal Strength -->
                            <div class="bg-white p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-red mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 font-medium">Force du Signal</span>
                                </div>
                                <div id="signal-strength" class="text-3xl font-bold text-tt-red">--</div>
                            </div>

                            <!-- Network Type -->
                            <div class="bg-white p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-red mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                                    </svg>
                                    <span class="text-sm text-gray-600 font-medium">Type de Réseau</span>
                                </div>
                                <div id="network-type" class="text-3xl font-bold text-tt-red">--</div>
                            </div>

                            <!-- Download Speed -->
                            <div class="bg-white p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-red mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                    </svg>
                                    <span class="text-sm text-gray-600 font-medium">Téléchargement</span>
                                </div>
                                <div id="download-speed" class="text-2xl font-bold text-tt-red">--</div>
                            </div>

                            <!-- Upload Speed -->
                            <div class="bg-white p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-red mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <span class="text-sm text-gray-600 font-medium">Envoi</span>
                                </div>
                                <div id="upload-speed" class="text-2xl font-bold text-tt-red">--</div>
                            </div>

                            <!-- Latency -->
                            <div class="bg-white p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-red mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 font-medium">Latence</span>
                                </div>
                                <div id="latency" class="text-2xl font-bold text-tt-red">--</div>
                            </div>

                            <!-- Status -->
                            <div class="bg-white p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-red mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 font-medium">Statut</span>
                                </div>
                                <div id="coverage-status" class="text-xl font-bold text-green-600">--</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Recent Checks History -->
        <div id="history-section" class="bg-white rounded-2xl shadow-xl p-8">
            <h3 class="text-xl font-bold mb-6 text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-2 text-tt-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Vérifications Récentes
            </h3>
            <div id="history-list" class="space-y-3">
                <!-- History items will be inserted here -->
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Coverage Checker JavaScript
    const API_BASE = '/api/coverage';
    
    document.addEventListener('DOMContentLoaded', function() {
        loadGovernorates();
        loadServiceTypes();
        loadHistory();
        
        document.getElementById('check-coverage-btn').addEventListener('click', checkCoverage);
    });

    async function loadGovernorates() {
        try {
            const response = await fetch(`${API_BASE}/governorates`);
            const result = await response.json();
            
            if (result.success) {
                const select = document.getElementById('governorate-select');
                result.data.forEach(gov => {
                    const option = document.createElement('option');
                    option.value = gov;
                    option.textContent = gov;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Failed to load governorates:', error);
        }
    }

    async function loadServiceTypes() {
        try {
            const response = await fetch(`${API_BASE}/service-types`);
            const result = await response.json();
            
            if (result.success) {
                const select = document.getElementById('service-type-select');
                result.data.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.id;
                    option.textContent = type.name;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Failed to load service types:', error);
        }
    }

    async function checkCoverage() {
        const governorate = document.getElementById('governorate-select').value;
        const serviceType = document.getElementById('service-type-select').value;
        
        if (!governorate) {
            alert('Veuillez sélectionner un gouvernorat');
            return;
        }

        // Show loading
        document.getElementById('loading').classList.remove('hidden');
        document.getElementById('results').classList.add('hidden');

        try {
            const response = await fetch(`${API_BASE}/check`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    governorate,
                    service_type: serviceType
                })
            });

            const result = await response.json();

            if (result.success) {
                displayResults(result.coverage);
                loadHistory(); // Refresh history
            }
        } catch (error) {
            console.error('Coverage check failed:', error);
            alert('Échec de la vérification de la couverture. Veuillez réessayer.');
        } finally {
            document.getElementById('loading').classList.add('hidden');
        }
    }

    function displayResults(coverage) {
        document.getElementById('signal-strength').textContent = coverage.signal_strength + '%';
        document.getElementById('network-type').textContent = coverage.network_type;
        document.getElementById('download-speed').textContent = coverage.download_speed;
        document.getElementById('upload-speed').textContent = coverage.upload_speed;
        document.getElementById('latency').textContent = coverage.latency;
        
        const statusElement = document.getElementById('coverage-status');
        const status = coverage.coverage_status;
        statusElement.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        
        // Color code based on status
        statusElement.classList.remove('text-green-600', 'text-yellow-600', 'text-orange-600', 'text-red-600');
        if (status === 'excellent') {
            statusElement.classList.add('text-green-600');
        } else if (status === 'good') {
            statusElement.classList.add('text-yellow-600');
        } else if (status === 'fair') {
            statusElement.classList.add('text-orange-600');
        } else {
            statusElement.classList.add('text-red-600');
        }
        
        // Show results with animation
        const resultsEl = document.getElementById('results');
        resultsEl.classList.remove('hidden');
        resultsEl.classList.add('fade-in');
    }

    async function loadHistory() {
        try {
            const response = await fetch(`${API_BASE}/history?limit=5`);
            const result = await response.json();
            
            if (result.success) {
                const historyList = document.getElementById('history-list');
                historyList.innerHTML = '';
                
                if (result.data.length === 0) {
                    historyList.innerHTML = '<p class="text-gray-500 text-center py-4">Aucune vérification récente</p>';
                    return;
                }
                
                result.data.forEach(item => {
                    const historyItem = document.createElement('div');
                    historyItem.className = 'bg-gray-50 p-4 rounded-lg flex justify-between items-center hover:bg-gray-100 transition-colors border border-gray-200';
                    historyItem.innerHTML = `
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-tt-red-light rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-tt-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900">${item.area.name}</span>
                                <span class="ml-3 px-2 py-1 bg-tt-red-light text-tt-red rounded text-sm font-medium">${item.coverage_data.network_type}</span>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            ${new Date(item.created_at).toLocaleString('fr-FR')}
                        </div>
                    `;
                    historyList.appendChild(historyItem);
                });
            }
        } catch (error) {
            console.error('Failed to load history:', error);
        }
    }
</script>
@endpush
@endsection

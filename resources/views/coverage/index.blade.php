<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Coverage Checker') }}
            </h2>
            <div class="h-12 w-12 bg-tt-blue rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-xl">TT</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Coverage Checker Section -->
                    <div id="coverage-checker" class="space-y-6">
                        
                        <!-- Governorate Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Select Governorate
                            </label>
                            <select id="governorate-select" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">-- Choose a governorate --</option>
                            </select>
                        </div>

                        <!-- Service Type Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Service Type (Optional)
                            </label>
                            <select id="service-type-select" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">-- All Services --</option>
                            </select>
                        </div>

                        <!-- Check Button -->
                        <div>
                            <button id="check-coverage-btn" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-150">
                                Check Coverage
                            </button>
                        </div>

                        <!-- Loading Spinner -->
                        <div id="loading" class="hidden text-center py-8">
                            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-red-600"></div>
                            <p class="mt-4 text-gray-600">Checking coverage...</p>
                        </div>

                        <!-- Results Section -->
                        <div id="results" class="hidden">
                            <div class="bg-gradient-to-r from-red-50 to-white rounded-lg p-6 border-l-4 border-red-600">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800">Coverage Results</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <!-- Signal Strength -->
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <div class="text-sm text-gray-600">Signal Strength</div>
                                        <div id="signal-strength" class="text-2xl font-bold text-red-600 mt-1">--</div>
                                    </div>

                                    <!-- Network Type -->
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <div class="text-sm text-gray-600">Network Type</div>
                                        <div id="network-type" class="text-2xl font-bold text-red-600 mt-1">--</div>
                                    </div>

                                    <!-- Download Speed -->
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <div class="text-sm text-gray-600">Download Speed</div>
                                        <div id="download-speed" class="text-2xl font-bold text-red-600 mt-1">--</div>
                                    </div>

                                    <!-- Upload Speed -->
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <div class="text-sm text-gray-600">Upload Speed</div>
                                        <div id="upload-speed" class="text-2xl font-bold text-red-600 mt-1">--</div>
                                    </div>

                                    <!-- Latency -->
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <div class="text-sm text-gray-600">Latency</div>
                                        <div id="latency" class="text-2xl font-bold text-red-600 mt-1">--</div>
                                    </div>

                                    <!-- Status -->
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <div class="text-sm text-gray-600">Coverage Status</div>
                                        <div id="coverage-status" class="text-2xl font-bold text-green-600 mt-1">--</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Checks History -->
                        <div id="history-section" class="mt-8">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Recent Coverage Checks</h3>
                            <div id="history-list" class="space-y-2">
                                <!-- History items will be inserted here -->
                            </div>
                        </div>

                    </div>

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
                alert('Please select a governorate');
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
                alert('Failed to check coverage. Please try again.');
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
            document.getElementById('coverage-status').textContent = coverage.coverage_status;
            
            // Show results
            document.getElementById('results').classList.remove('hidden');
        }

        async function loadHistory() {
            try {
                const response = await fetch(`${API_BASE}/history?limit=5`);
                const result = await response.json();
                
                if (result.success) {
                    const historyList = document.getElementById('history-list');
                    historyList.innerHTML = '';
                    
                    result.data.forEach(item => {
                        const historyItem = document.createElement('div');
                        historyItem.className = 'bg-gray-50 p-3 rounded-lg flex justify-between items-center';
                        historyItem.innerHTML = `
                            <div>
                                <span class="font-semibold">${item.area.name}</span>
                                <span class="text-sm text-gray-600 ml-2">${item.coverage_data.network_type}</span>
                            </div>
                            <div class="text-sm text-gray-500">
                                ${new Date(item.created_at).toLocaleString()}
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
</x-app-layout>

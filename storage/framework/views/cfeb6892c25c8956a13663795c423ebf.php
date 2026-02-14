<?php $__env->startPush('styles'); ?>
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
      crossorigin=""/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section with Tunisia Map Background -->
<div class="relative bg-gradient-to-br from-tt-blue to-tt-blue-700 text-white py-16 dark:from-tt-blue-600 dark:to-tt-blue-900">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M10 10h80v80H10z\' fill=\'none\' stroke=\'white\' stroke-width=\'1\'/%3E%3C/svg%3E'); background-size: 50px 50px;"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            <?php echo e(__('Coverage Verification')); ?>

        </h1>
        <p class="text-xl text-white/90">
            <?php echo e(__('Discover service availability in your region')); ?>

        </p>
    </div>
</div>

<!-- Main Coverage Checker -->
<div class="py-12 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Left: Coverage Checker Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6"><?php echo e(__('Check Coverage')); ?></h2>
            
            <div id="coverage-checker" class="space-y-6">
                
                <!-- Governorate Selection -->
                <div>
                    <label for="governorate-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="inline-block w-5 h-5 mr-1 text-tt-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <?php echo e(__('Select your Governorate')); ?>

                    </label>
                    <select id="governorate-select" 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-tt-blue focus:ring-tt-blue text-lg py-3">
                        <option value=""><?php echo e(__('-- Choose a governorate --')); ?></option>
                    </select>
                </div>

                <!-- Service Type Selection -->
                <div>
                    <label for="service-type-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="inline-block w-5 h-5 mr-1 text-tt-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <?php echo e(__('Service Type (Optional)')); ?>

                    </label>
                    <select id="service-type-select" 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-tt-blue focus:ring-tt-blue text-lg py-3">
                        <option value=""><?php echo e(__('-- All Services --')); ?></option>
                    </select>
                </div>

                <!-- Check Button -->
                <div>
                    <button id="check-coverage-btn" 
                            class="w-full bg-tt-blue hover:bg-tt-blue-600 text-white font-bold py-4 px-6 rounded-lg transition-all transform hover:scale-105 hover:shadow-xl">
                        <svg class="inline-block w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <?php echo e(__('Check Coverage')); ?>

                    </button>
                </div>

                <!-- Loading Spinner -->
                <div id="loading" class="hidden text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-16 w-16 border-b-4 border-tt-blue"></div>
                    <p class="mt-4 text-gray-600 dark:text-gray-400 font-medium"><?php echo e(__('Checking in progress...')); ?></p>
                </div>

                <!-- Results Section -->
                <div id="results" class="hidden">
                    <div class="bg-gradient-to-r from-tt-blue-50 to-white dark:from-tt-blue-900/20 dark:to-gray-800 rounded-xl p-6 border-l-4 border-tt-blue">
                        <h3 class="text-xl font-bold mb-6 text-gray-900 dark:text-white flex items-center">
                            <svg class="w-6 h-6 mr-2 text-tt-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <?php echo e(__('Coverage Results')); ?>

                        </h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Signal Strength -->
                            <div class="bg-white dark:bg-gray-700 p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-blue mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300 font-medium"><?php echo e(__('Signal Strength')); ?></span>
                                </div>
                                <div id="signal-strength" class="text-3xl font-bold text-tt-blue">--</div>
                            </div>

                            <!-- Network Type -->
                            <div class="bg-white dark:bg-gray-700 p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-blue mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300 font-medium"><?php echo e(__('Network Type')); ?></span>
                                </div>
                                <div id="network-type" class="text-3xl font-bold text-tt-blue">--</div>
                            </div>

                            <!-- Download Speed -->
                            <div class="bg-white dark:bg-gray-700 p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-blue mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300 font-medium"><?php echo e(__('Download Speed')); ?></span>
                                </div>
                                <div id="download-speed" class="text-2xl font-bold text-tt-blue">--</div>
                            </div>

                            <!-- Upload Speed -->
                            <div class="bg-white dark:bg-gray-700 p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-blue mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300 font-medium"><?php echo e(__('Upload Speed')); ?></span>
                                </div>
                                <div id="upload-speed" class="text-2xl font-bold text-tt-blue">--</div>
                            </div>

                            <!-- Latency -->
                            <div class="bg-white dark:bg-gray-700 p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-blue mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300 font-medium"><?php echo e(__('Latency')); ?></span>
                                </div>
                                <div id="latency" class="text-2xl font-bold text-tt-blue">--</div>
                            </div>

                            <!-- Status -->
                            <div class="bg-white dark:bg-gray-700 p-5 rounded-lg shadow-md hover-lift">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-tt-blue mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300 font-medium"><?php echo e(__('Status')); ?></span>
                                </div>
                                <div id="coverage-status" class="text-xl font-bold text-green-600">--</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right: Interactive Tunisia Map -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white"><?php echo e(__('Or Click on Map')); ?></h3>
            <div id="tunisia-map" class="w-full h-96 rounded-lg shadow-lg mb-4"></div>
            <button onclick="detectLocation()" class="w-full bg-tt-blue text-white py-3 rounded-lg hover:bg-tt-blue-600 transition-colors flex items-center justify-center">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <?php echo e(__('Detect My Location')); ?>

            </button>
        </div>
    </div>

        <!-- Recent Checks History -->
        <div id="history-section" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mt-8">
            <h3 class="text-xl font-bold mb-6 text-gray-900 dark:text-white flex items-center">
                <svg class="w-6 h-6 mr-2 text-tt-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <?php echo e(__('Recent Checks')); ?>

            </h3>
            <div id="history-list" class="space-y-3">
                <!-- History items will be inserted here -->
            </div>
        </div>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Coverage Checker JavaScript
    const API_BASE = '/api/coverage';
    
    // Translations for status
    const statusTranslations = {
        'excellent': "<?php echo e(__('Excellent')); ?>",
        'good': "<?php echo e(__('Good')); ?>",
        'fair': "<?php echo e(__('Fair')); ?>",
        'poor': "<?php echo e(__('Poor')); ?>"
    };
    
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
            alert('<?php echo e(__("Please select a governorate")); ?>');
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
            alert('<?php echo e(__("Coverage check failed. Please try again.")); ?>');
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
        const status = coverage.coverage_status.toLowerCase();
        
        // Translate status
        statusElement.textContent = statusTranslations[status] || status.charAt(0).toUpperCase() + status.slice(1);
        
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
                    historyList.innerHTML = '<p class="text-gray-500 dark:text-gray-400 text-center py-4"><?php echo e(__("No recent checks")); ?></p>';
                    return;
                }
                
                result.data.forEach(item => {
                    const historyItem = document.createElement('div');
                    historyItem.className = 'bg-gray-50 dark:bg-gray-700 p-4 rounded-lg flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600';
                    historyItem.innerHTML = `
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-tt-blue/20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-tt-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 dark:text-white">${item.area.name}</span>
                                <span class="ml-3 px-2 py-1 bg-tt-blue/20 text-tt-blue rounded text-sm font-medium">${item.coverage_data.network_type}</span>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
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

    // Tunisia Map with Leaflet.js - Load after DOM
    window.addEventListener('load', function() {
        // Initialize Leaflet map
        var map = L.map('tunisia-map').setView([34.0, 9.0], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Tunisia governorate coordinates
        var governorateMarkers = {
            'Tunis': [36.8065, 10.1815],
            'Ariana': [36.8625, 10.1956],
            'Ben Arous': [36.7472, 10.2181],
            'Manouba': [36.8080, 10.0963],
            'Nabeul': [36.4516, 10.7366],
            'Zaghouan': [36.4025, 10.1432],
            'Bizerte': [37.2744, 9.8739],
            'Béja': [36.7256, 9.1817],
            'Jendouba': [36.5011, 8.7805],
            'Kef': [36.1743, 8.7049],
            'Siliana': [36.0853, 9.3706],
            'Sousse': [35.8254, 10.6369],
            'Monastir': [35.7643, 10.8113],
            'Mahdia': [35.5047, 11.0622],
            'Sfax': [34.7406, 10.7603],
            'Kairouan': [35.6781, 10.0963],
            'Kasserine': [35.1674, 8.8365],
            'Sidi Bouzid': [35.0381, 9.4858],
            'Gabès': [33.8815, 10.0982],
            'Medenine': [33.3549, 10.5055],
            'Tataouine': [32.9297, 10.4517],
            'Gafsa': [34.4250, 8.7842],
            'Tozeur': [33.9197, 8.1338],
            'Kebili': [33.7047, 8.9690]
        };

        // Add markers for each governorate
        Object.keys(governorateMarkers).forEach(function(name) {
            var coords = governorateMarkers[name];
            var marker = L.marker(coords).addTo(map);
            
            marker.bindPopup(`
                <div class="text-center">
                    <b class="text-lg">${name}</b><br>
                    <button onclick="selectGovernorateFromMap('${name}')" class="mt-2 px-4 py-2 bg-tt-blue text-white rounded hover:bg-tt-blue-600">
                        <?php echo e(__('Check Coverage')); ?>

                    </button>
                </div>
            `);
            
            marker.on('click', function() {
                map.setView(coords, 10);
            });
        });
    });

    // Select governorate from map
    function selectGovernorateFromMap(name) {
        const select = document.getElementById('governorate-select');
        // Find the option with matching text (case-insensitive)
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].text.toLowerCase().includes(name.toLowerCase())) {
                select.selectedIndex = i;
                break;
            }
        }
        // Auto-check coverage
        checkCoverage();
    }

    // Auto-detect location
    function detectLocation() {
        if (!navigator.geolocation) {
            alert('<?php echo e(__("Geolocation is not supported by your browser")); ?>');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;
                
                // Reverse geocode to find governorate
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                    .then(response => response.json())
                    .then(data => {
                        var governorate = data.address.state || data.address.county || data.address.city;
                        if (governorate) {
                            selectGovernorateFromMap(governorate);
                            // Center map on user location
                            var map = window.map || L.map('tunisia-map');
                            map.setView([lat, lon], 10);
                            L.marker([lat, lon]).addTo(map)
                                .bindPopup('<?php echo e(__("Your Location")); ?>')
                                .openPopup();
                        } else {
                            alert('<?php echo e(__("Could not determine your governorate")); ?>');
                        }
                    })
                    .catch(error => {
                        console.error('Geocoding error:', error);
                        alert('<?php echo e(__("Failed to determine location")); ?>');
                    });
            },
            function(error) {
                console.error('Geolocation error:', error);
                alert('<?php echo e(__("Failed to get your location")); ?>');
            }
        );
    }
</script>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
        crossorigin=""></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MAISON INFO\telecom-service-checker\resources\views/coverage/public.blade.php ENDPATH**/ ?>
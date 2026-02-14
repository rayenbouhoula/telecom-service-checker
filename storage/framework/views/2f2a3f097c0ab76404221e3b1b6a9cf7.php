<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Tunisie Telecom - Vérification de Couverture')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <script>
        // Apply dark mode IMMEDIATELY
        (function() {
            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.classList.add('dark');
            }
        })();
        
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }
    </script>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title><?php echo e(config('app.name', 'Tunisie Telecom - Vérification de Couverture')); ?></title>

    <!-- Add these favicon lines -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/favicon.png')); ?>">
</head>
<body class="bg-gray-50 dark:bg-gray-900 antialiased">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo Section -->
                <div class="flex items-center">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-3">
                        <img src="<?php echo e(asset('images/tt-logo.png')); ?>" 
                             alt="Tunisie Telecom" 
                             class="h-12 w-auto">
                        <div class="border-l-2 border-tt-blue pl-3">
                            <div class="text-lg font-bold text-tt-blue">Tunisie Telecom</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('Coverage Checker')); ?></div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?php echo e(route('home')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-tt-blue font-medium transition-colors <?php echo e(request()->routeIs('home') ? 'text-tt-blue border-b-2 border-tt-blue' : ''); ?> pb-1">
                        <?php echo e(__('Home')); ?>

                    </a>
                    <a href="<?php echo e(route('coverage.public')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-tt-blue font-medium transition-colors <?php echo e(request()->routeIs('coverage.public') ? 'text-tt-blue border-b-2 border-tt-blue' : ''); ?> pb-1">
                        <?php echo e(__('Coverage')); ?>

                    </a>

                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <svg class="w-6 h-6 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    <!-- Language Switcher -->
                    <div class="flex items-center space-x-2">
                        <a href="<?php echo e(route('language.switch', 'fr')); ?>" class="px-3 py-1 rounded <?php echo e(app()->getLocale() == 'fr' ? 'bg-tt-blue text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700'); ?>">
                            FR
                        </a>
                        <a href="<?php echo e(route('language.switch', 'en')); ?>" class="px-3 py-1 rounded <?php echo e(app()->getLocale() == 'en' ? 'bg-tt-blue text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700'); ?>">
                            EN
                        </a>
                    </div>

                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-6 py-2 bg-tt-blue text-white rounded-lg hover:bg-tt-blue-600 transition-colors font-medium shadow-sm">
                            <?php echo e(__('Dashboard')); ?>

                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="px-6 py-2 bg-tt-blue text-white rounded-lg hover:bg-tt-blue-600 transition-colors font-medium shadow-sm">
                            <?php echo e(__('Login')); ?>

                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-gray-700 dark:text-gray-300 hover:text-tt-blue focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-gray-200 dark:border-gray-700">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="<?php echo e(route('home')); ?>" class="block px-3 py-2 rounded-md text-base font-medium <?php echo e(request()->routeIs('home') ? 'bg-tt-blue text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'); ?>">
                    <?php echo e(__('Home')); ?>

                </a>
                <a href="<?php echo e(route('coverage.public')); ?>" class="block px-3 py-2 rounded-md text-base font-medium <?php echo e(request()->routeIs('coverage.public') ? 'bg-tt-blue text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'); ?>">
                    <?php echo e(__('Coverage')); ?>

                </a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <?php echo e(__('Dashboard')); ?>

                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <?php echo e(__('Login')); ?>

                    </a>
                <?php endif; ?>
                
                <!-- Mobile Language Switcher -->
                <div class="flex items-center space-x-2 px-3 py-2">
                    <a href="<?php echo e(route('language.switch', 'fr')); ?>" class="px-3 py-1 rounded <?php echo e(app()->getLocale() == 'fr' ? 'bg-tt-blue text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700'); ?>">
                        FR
                    </a>
                    <a href="<?php echo e(route('language.switch', 'en')); ?>" class="px-3 py-1 rounded <?php echo e(app()->getLocale() == 'en' ? 'bg-tt-blue text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700'); ?>">
                        EN
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-gray-800 text-white mt-auto border-t-2 border-gray-700">
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
                        <?php echo e(__('Check the availability of our services in your region.')); ?>

                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="font-semibold mb-4"><?php echo e(__('Quick Links')); ?></h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="<?php echo e(route('home')); ?>" class="hover:text-tt-blue transition-colors"><?php echo e(__('Home')); ?></a></li>
                        <li><a href="<?php echo e(route('coverage.public')); ?>" class="hover:text-tt-blue transition-colors"><?php echo e(__('Coverage')); ?></a></li>
                        <?php if(auth()->guard()->check()): ?>
                            <li><a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-tt-blue transition-colors"><?php echo e(__('Dashboard')); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-semibold mb-4"><?php echo e(__('Information')); ?></h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><?php echo e(__('About')); ?></li>
                        <li><?php echo e(__('Contact')); ?></li>
                        <li><?php echo e(__('Terms of Use')); ?></li>
                        <li><?php echo e(__('Privacy Policy')); ?></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 dark:border-gray-600 mt-8 pt-8 text-center text-sm text-gray-400 dark:text-gray-300">
                <p>&copy; <?php echo e(date('Y')); ?> Tunisie Telecom. <?php echo e(__('All rights reserved')); ?></p>
            </div>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\MAISON INFO\telecom-service-checker\resources\views/layouts/public.blade.php ENDPATH**/ ?>
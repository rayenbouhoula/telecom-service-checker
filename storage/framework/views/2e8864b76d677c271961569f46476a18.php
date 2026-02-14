<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-tt-blue to-tt-blue-700 overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                <?php echo e(__('Welcome to Tunisie Telecom')); ?>

            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                <?php echo e(__('Your trusted telecommunications provider in Tunisia')); ?>

            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(route('coverage.public')); ?>" class="inline-flex items-center px-8 py-4 bg-white dark:bg-gray-800 text-tt-blue rounded-lg hover:bg-gray-50 dark:bg-gray-900 font-semibold text-lg shadow-lg transition-all transform hover:scale-105">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <?php echo e(__('Check Coverage Now')); ?>

                </a>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo e(__('Our Services')); ?>

            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400">
                <?php echo e(__('Discover service availability in your region')); ?>

            </p>
        </div>

       <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

    <!-- Feature 1 -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 hover-lift">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
            <?php echo e(__('Coverage 4G/5G')); ?>

        </h3>
        <p class="text-gray-600 dark:text-gray-400">
            <?php echo e(__('Enjoy ultra-fast connectivity with our 4G and 5G network available in major regions.')); ?>

        </p>
    </div>

    <!-- Feature 2 -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 hover-lift">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
            <?php echo e(__('Service Availability')); ?>

        </h3>
        <p class="text-gray-600 dark:text-gray-400">
            <?php echo e(__('Check the availability of all our services: Internet, fixed and mobile telephony in your area.')); ?>

        </p>
    </div>

    <!-- Feature 3 -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 hover-lift">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
            <?php echo e(__('Real-time Data')); ?>

        </h3>
        <p class="text-gray-600 dark:text-gray-400">
            <?php echo e(__('Get up-to-date information on network quality and available connection speeds.')); ?>

        </p>
    </div>

</div>

<!-- Speed Test Preview Section -->
<div class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo e(__('Quick Speed Test')); ?>

            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400">
                <?php echo e(__('Test your internet connection speed')); ?>

            </p>
        </div>

        <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-8 md:p-12 border border-gray-200 dark:border-gray-700 text-center">
            <svg class="w-24 h-24 mx-auto text-tt-blue mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo e(__('Test Your Connection Speed')); ?>

            </h3>
            
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                <?php echo e(__('Measure your download and upload speeds, check your ping, and access router settings')); ?>

            </p>
            
            <a href="<?php echo e(route('speedtest')); ?>" class="inline-block bg-tt-blue text-white py-4 px-8 rounded-lg font-bold text-lg hover:bg-tt-blue-600 transition-all transform hover:scale-105 shadow-lg">
                <?php echo e(__('Start Speed Test')); ?>

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
                <div class="text-gray-600 dark:text-gray-400">
                    <?php echo e(__('Governorates Covered')); ?>

                </div>
            </div>

            <div>
                <div class="text-4xl font-bold text-tt-blue mb-2">5G</div>
                <div class="text-gray-600 dark:text-gray-400">
                    <?php echo e(__('Technology Available')); ?>

                </div>
            </div>

            <div>
                <div class="text-4xl font-bold text-tt-blue mb-2">99%</div>
                <div class="text-gray-600 dark:text-gray-400">
                    <?php echo e(__('Coverage Rate')); ?>

                </div>
            </div>

            <div>
                <div class="text-4xl font-bold text-tt-blue mb-2">24/7</div>
                <div class="text-gray-600 dark:text-gray-400">
                    <?php echo e(__('Service Available')); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-br from-tt-blue to-tt-blue-700 text-white py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            <?php echo e(__('Ready to check your coverage?')); ?>

        </h2>
        <p class="text-xl mb-8 text-blue-100">
            <?php echo e(__('Discover available services in your region now')); ?>

        </p>
        <a href="<?php echo e(route('coverage.public')); ?>"
         class="inline-block px-8 py-4 rounded-lg font-bold text-lg shadow-lg
          bg-white text-tt-blue
          hover:bg-gray-50
          dark:bg-gray-800 dark:text-tt-blue
          dark:hover:bg-gray-900
          transition-all transform hover:scale-105">
          <?php echo e(__('Start Verification')); ?>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MAISON INFO\telecom-service-checker\resources\views/welcome-new.blade.php ENDPATH**/ ?>
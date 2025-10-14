<?php get_header(); ?>

    <?php kp_breadcrumbs(); ?>
    
    <div class="max-w-2xl mx-auto text-center py-16">
        <div class="mb-8">
            <svg class="w-32 h-32 mx-auto text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h1 class="text-6xl font-bold mb-4 kp-gradient-text">
            404
        </h1>
        
        <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">
            Page Not Found
        </h2>
        
        <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
            The page you're looking for doesn't exist or has been moved.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
            <a href="<?php echo home_url('/'); ?>" class="px-6 py-3 bg-gradient-to-r bg-kp-gradient hover:from-blue-700 hover:to-teal-700 text-white rounded-lg transition-all font-medium">
                Go Home
            </a>
            <a href="<?php echo home_url('/blog'); ?>" class="px-6 py-3 border-2 border-blue-600 dark:border-blue-400 text-[#599bb8] dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-800 rounded-lg transition-all font-medium">
                View Blog
            </a>
        </div>
        
        <div class="mt-12">
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">
                Or try searching:
            </h3>
            <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="max-w-md mx-auto">
                <div class="flex gap-2">
                    <input type="search" name="s" placeholder="Search..." class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r bg-kp-gradient hover:from-blue-700 hover:to-teal-700 text-white rounded-lg transition-all">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php get_footer(); ?>
<?php get_header(); ?>

    <?php echo KPT_BreadCrumbs::get_base_breadcrumbs(); ?>
    
    <div class="mx-auto text-center py-16">
        <h1 class="text-6xl font-bold mb-4 kp-gradient-text">
            404 - Page Not Found
        </h1>        
        <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
            The page you're looking for doesn't exist or has been moved.
        </p>
        <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
            Try the links in the menus, or searching below
        </p>
        <div class="mt-12">
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
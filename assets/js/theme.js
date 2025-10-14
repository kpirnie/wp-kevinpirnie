document.addEventListener('DOMContentLoaded', function () {
    // Top header hide/show on scroll
    let lastScroll = 0;
    const topHeader = document.getElementById('top-header');

    window.addEventListener('scroll', function () {
        const currentScroll = window.pageYOffset;

        if (currentScroll > 50) {
            if (currentScroll > lastScroll) {
                topHeader.style.transform = 'translateY(-100%)';
            } else {
                topHeader.style.transform = 'translateY(0)';
            }
        } else {
            topHeader.style.transform = 'translateY(0)';
        }

        lastScroll = currentScroll;
    });

    // Search toggle
    const searchToggle = document.getElementById('search-toggle');
    const searchForm = document.getElementById('search-form');

    if (searchToggle && searchForm) {
        searchToggle.addEventListener('click', function () {
            searchForm.classList.toggle('hidden');
            if (!searchForm.classList.contains('hidden')) {
                searchForm.querySelector('input[type="search"]').focus();
            }
        });
    }

    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Scroll to top button
    const scrollToTopBtn = document.getElementById('scroll-to-top');

    if (scrollToTopBtn) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.remove('opacity-0', 'invisible');
                scrollToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                scrollToTopBtn.classList.add('opacity-0', 'invisible');
                scrollToTopBtn.classList.remove('opacity-100', 'visible');
            }
        });

        // Scroll to top when clicked
        scrollToTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
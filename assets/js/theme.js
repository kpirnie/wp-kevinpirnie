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

    // Dark mode toggle
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const htmlElement = document.documentElement;
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    // Check for saved theme preference or default to light mode
    const currentTheme = localStorage.getItem('theme') || 'light';
    if (currentTheme === 'dark') {
        htmlElement.classList.add('dark');
        sunIcon.classList.remove('hidden');
        moonIcon.classList.add('hidden');
    }

    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function () {
            htmlElement.classList.toggle('dark');

            if (htmlElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            } else {
                localStorage.setItem('theme', 'light');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            }
        });
    }
});
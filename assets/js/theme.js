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

    // Desktop dropdown menu toggles
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const parentLi = this.closest('li');
            const submenu = parentLi.querySelector('.submenu');
            const arrow = this.querySelector('svg');
            const isOpen = submenu && !submenu.classList.contains('hidden');

            // Close all other dropdowns
            document.querySelectorAll('.submenu').forEach(menu => {
                if (menu !== submenu) {
                    menu.classList.add('hidden');
                }
            });

            document.querySelectorAll('.dropdown-toggle svg').forEach(otherArrow => {
                if (otherArrow !== arrow) {
                    otherArrow.classList.remove('rotate-180');
                }
            });

            document.querySelectorAll('.dropdown-toggle').forEach(otherToggle => {
                if (otherToggle !== toggle) {
                    otherToggle.setAttribute('aria-expanded', 'false');
                }
            });

            // Toggle current dropdown
            if (submenu) {
                if (isOpen) {
                    submenu.classList.add('hidden');
                    arrow.classList.remove('rotate-180');
                    this.setAttribute('aria-expanded', 'false');
                } else {
                    submenu.classList.remove('hidden');
                    arrow.classList.add('rotate-180');
                    this.setAttribute('aria-expanded', 'true');
                }
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.has-dropdown')) {
            document.querySelectorAll('.submenu').forEach(menu => {
                menu.classList.add('hidden');
            });
            document.querySelectorAll('.dropdown-toggle svg').forEach(arrow => {
                arrow.classList.remove('rotate-180');
            });
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                toggle.setAttribute('aria-expanded', 'false');
            });
        }
    });

    // Search toggle - Desktop
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

    // Search toggle - Mobile
    const searchToggleMobile = document.getElementById('search-toggle-mobile');
    if (searchToggleMobile && searchForm) {
        searchToggleMobile.addEventListener('click', function () {
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
            
            // Ensure all mobile submenus are hidden when menu opens
            if (!mobileMenu.classList.contains('hidden')) {
                document.querySelectorAll('.submenu-mobile').forEach(submenu => {
                    submenu.classList.add('hidden');
                });
                document.querySelectorAll('.submenu-toggle svg').forEach(arrow => {
                    arrow.classList.remove('rotate-180');
                });
            }
        });
    }

    // Mobile submenu toggles - both button and parent link
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const submenu = this.closest('li').querySelector('.submenu-mobile');
            const arrow = this.querySelector('svg');
            
            if (submenu) {
                submenu.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            }
        });
    });
    
    // Make parent links in mobile menu toggle submenus instead of navigating
    const mobileParentLinks = document.querySelectorAll('.mobile-menu-list .has-submenu > div > a');
    mobileParentLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const submenu = this.closest('li').querySelector('.submenu-mobile');
            const arrow = this.closest('div').querySelector('.submenu-toggle svg');
            
            if (submenu) {
                submenu.classList.toggle('hidden');
                if (arrow) {
                    arrow.classList.toggle('rotate-180');
                }
            }
        });
    });

    // Scroll to top button
    const scrollToTopBtn = document.getElementById('scroll-to-top');

    if (scrollToTopBtn) {
        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.remove('opacity-0', 'invisible');
                scrollToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                scrollToTopBtn.classList.add('opacity-0', 'invisible');
                scrollToTopBtn.classList.remove('opacity-100', 'visible');
            }
        });

        scrollToTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
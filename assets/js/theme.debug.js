document.addEventListener('DOMContentLoaded', function () {

    // ========================================
    // Cookie Notice Functions
    // ========================================
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/`;
    }

    function disableScroll() {
        document.body.style.overflow = 'hidden';
        document.body.style.paddingRight = (window.innerWidth - document.documentElement.clientWidth) + 'px';
    }

    function enableScroll() {
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }

    // Cookie Notice Elements
    const notice = document.getElementById('kp-cookie-notice');
    const overlay = document.getElementById('kp-cookie-overlay');
    const acceptBtn = document.getElementById('kp-cookie-accept');
    const declineBtn = document.getElementById('kp-cookie-decline');
    const learnMoreBtn = document.getElementById('kp-cookie-learn-more');
    const modal = document.getElementById('kp-cookie-modal');
    const modalClose = document.getElementById('kp-modal-close');
    const modalOverlay = document.getElementById('kp-modal-overlay');

    // Show cookie notice ONLY if NOT accepted (check for 'accepted' value specifically)
    if (notice && overlay && getCookie('kp_cookie_consent') !== 'accepted') {
        notice.style.display = 'block';
        notice.classList.remove('hidden');
        overlay.style.display = 'block';
        overlay.classList.remove('hidden');
        disableScroll();
    }

    // Accept cookies - ONLY this hides the notice permanently
    if (acceptBtn) {
        acceptBtn.addEventListener('click', function () {
            setCookie('kp_cookie_consent', 'accepted', 365);
            notice.style.display = 'none';
            overlay.style.display = 'none';
            enableScroll();
        });
    }

    // Decline cookies - redirect WITHOUT setting any cookie
    if (declineBtn) {
        declineBtn.addEventListener('click', function () {
            // Do NOT set a cookie - notice will show again on next visit
            window.location.href = 'https://www.google.com/search?q=why+do+I+need+cookies';
        });
    }

    // Learn more modal
    if (learnMoreBtn && modal) {
        learnMoreBtn.addEventListener('click', function (e) {
            e.preventDefault();
            modal.classList.remove('hidden');
        });
    }

    // Close modal
    if (modalClose && modal) {
        modalClose.addEventListener('click', function () {
            modal.classList.add('hidden');
        });
    }

    // Close modal on overlay click
    if (modalOverlay && modal) {
        modalOverlay.addEventListener('click', function () {
            modal.classList.add('hidden');
        });
    }

    // ========================================
    // Top header hide/show on scroll
    // ========================================
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

    // ========================================
    // Desktop dropdown menu toggles
    // ========================================
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

    // ========================================
    // Search toggle - Desktop
    // ========================================
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

    // ========================================
    // Mobile menu toggle
    // ========================================
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

    // ========================================
    // Mobile submenu toggles
    // ========================================
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

    // ========================================
    // Scroll to top button
    // ========================================
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
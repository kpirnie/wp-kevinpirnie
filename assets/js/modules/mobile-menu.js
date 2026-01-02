// DOM ready event
DOMReady( function( ) {

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

            const parentLi = this.closest('li');
            const submenu = parentLi.querySelector(':scope > .submenu-mobile');
            const arrow = this.querySelector('svg');

            if (submenu) {
                const isOpen = !submenu.classList.contains('hidden');

                // Get all ancestor submenus (parent chain)
                const ancestors = [];
                let current = parentLi.parentElement;
                while (current) {
                    if (current.classList && current.classList.contains('submenu-mobile')) {
                        ancestors.push(current);
                    }
                    current = current.parentElement;
                }

                // Close ALL mobile dropdowns except ancestors and the current one
                document.querySelectorAll('.submenu-mobile').forEach(menu => {
                    if (menu !== submenu && !ancestors.includes(menu)) {
                        menu.classList.add('hidden');
                    }
                });

                // Reset ALL arrows except those in ancestor chain
                document.querySelectorAll('.submenu-toggle svg').forEach(otherArrow => {
                    const otherParentLi = otherArrow.closest('li');
                    const otherSubmenu = otherParentLi?.querySelector(':scope > .submenu-mobile');

                    if (otherArrow !== arrow && !ancestors.includes(otherSubmenu)) {
                        otherArrow.classList.remove('rotate-180');
                    }
                });

                // Toggle current submenu
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

            const parentLi = this.closest('li');
            const submenu = parentLi.querySelector(':scope > .submenu-mobile');
            const arrow = this.closest('div').querySelector('.submenu-toggle svg');

            if (submenu) {
                const isOpen = !submenu.classList.contains('hidden');

                // Get all ancestor submenus (parent chain)
                const ancestors = [];
                let current = parentLi.parentElement;
                while (current) {
                    if (current.classList && current.classList.contains('submenu-mobile')) {
                        ancestors.push(current);
                    }
                    current = current.parentElement;
                }

                // Close ALL mobile dropdowns except ancestors and the current one
                document.querySelectorAll('.submenu-mobile').forEach(menu => {
                    if (menu !== submenu && !ancestors.includes(menu)) {
                        menu.classList.add('hidden');
                    }
                });

                // Reset ALL arrows except those in ancestor chain
                document.querySelectorAll('.submenu-toggle svg').forEach(otherArrow => {
                    const otherParentLi = otherArrow.closest('li');
                    const otherSubmenu = otherParentLi?.querySelector(':scope > .submenu-mobile');

                    if (otherArrow !== arrow && !ancestors.includes(otherSubmenu)) {
                        otherArrow.classList.remove('rotate-180');
                    }
                });

                // Toggle current submenu
                submenu.classList.toggle('hidden');
                if (arrow) {
                    arrow.classList.toggle('rotate-180');
                }
            }
        });
    });
    
} );

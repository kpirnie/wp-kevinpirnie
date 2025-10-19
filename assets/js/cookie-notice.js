// DOM ready event
DOMReady( function( ) {

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

} );

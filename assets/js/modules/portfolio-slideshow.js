// DOM ready event
DOMReady(function() {

    // ========================================
    // Portfolio Slideshow
    // ========================================
    const slideshow = document.querySelector('.kpt-portfolio-slideshow');
    if (!slideshow) return;

    const slides = slideshow.querySelectorAll('.kpt-portfolio-slide');
    const dots = slideshow.querySelectorAll('.kpt-portfolio-dot');
    const prevBtn = slideshow.querySelector('.kpt-portfolio-prev');
    const nextBtn = slideshow.querySelector('.kpt-portfolio-next');

    if (slides.length <= 1) return;

    let currentSlide = 0;
    let autoplayInterval;
    const slideDuration = 8000;

    function goToSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        currentSlide = (index + slides.length) % slides.length;

        slides[currentSlide].classList.add('active');
        if (dots[currentSlide]) {
            dots[currentSlide].classList.add('active');
        }

        resetProgress();
    }

    function nextSlide() {
        goToSlide(currentSlide + 1);
    }

    function prevSlide() {
        goToSlide(currentSlide - 1);
    }

    function resetProgress() {
        slideshow.classList.remove('playing');
        void slideshow.offsetWidth;
        slideshow.classList.add('playing');
    }

    function startAutoplay() {
        stopAutoplay();
        slideshow.classList.add('playing');
        autoplayInterval = setInterval(nextSlide, slideDuration);
    }

    function stopAutoplay() {
        clearInterval(autoplayInterval);
        slideshow.classList.remove('playing');
    }

    // Navigation buttons
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            prevSlide();
            startAutoplay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            nextSlide();
            startAutoplay();
        });
    }

    // Dots navigation
    dots.forEach(function(dot, index) {
        dot.addEventListener('click', function() {
            goToSlide(index);
            startAutoplay();
        });
    });

    // Pause on hover
    slideshow.addEventListener('mouseenter', stopAutoplay);
    slideshow.addEventListener('mouseleave', startAutoplay);

    // Touch support
    let touchStartX = 0;
    let touchEndX = 0;

    slideshow.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoplay();
    }, { passive: true });

    slideshow.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        startAutoplay();
    }, { passive: true });

    function handleSwipe() {
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) > 50) {
            if (diff > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }
    }

    // Keyboard navigation
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return rect.top < window.innerHeight && rect.bottom > 0;
    }

    document.addEventListener('keydown', function(e) {
        if (!isInViewport(slideshow)) return;

        if (e.key === 'ArrowLeft') {
            prevSlide();
            startAutoplay();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
            startAutoplay();
        }
    });

    // Start autoplay
    startAutoplay();

});
// DOM ready event
DOMReady( function( ) {

    // ========================================
    // Hero Slider
    // ========================================
    const slideshow = document.querySelector('.kpt-hero-slideshow');

    if (slideshow) {
        const slides = slideshow.querySelectorAll('.kpt-hero-slide');
        const prevBtn = slideshow.querySelector('.kpt-hero-prev');
        const nextBtn = slideshow.querySelector('.kpt-hero-next');

        let currentSlide = 0;
        let autoplayInterval;

        function goToSlide(n) {
            // Remove all classes from all slides
            slides.forEach(slide => {
                slide.classList.remove('active', 'prev');
            });
            
            // Mark current slide as previous
            slides[currentSlide].classList.add('prev');
            
            currentSlide = (n + slides.length) % slides.length;

            slides[currentSlide].classList.add('active');
        }

        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        function prevSlide() {
            goToSlide(currentSlide - 1);
        }

        // Event listeners
        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        // Autoplay
        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, 7000);
        }

        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }

        // Pause autoplay on hover
        slideshow.addEventListener('mouseenter', stopAutoplay);
        slideshow.addEventListener('mouseleave', startAutoplay);

        // Start autoplay
        startAutoplay();

        // Keyboard navigation
        document.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft') prevSlide();
            if (e.key === 'ArrowRight') nextSlide();
        });
    }


} );

DOMReady(function() {
    var slideshow = document.querySelector('.kpt-portfolio-slideshow');
    if (!slideshow) return;

    var slides = slideshow.querySelectorAll('.kpt-portfolio-slide');
    var dots = slideshow.querySelectorAll('.kpt-portfolio-dot');
    var prevBtn = slideshow.querySelector('.kpt-portfolio-prev');
    var nextBtn = slideshow.querySelector('.kpt-portfolio-next');
    var progressBar = slideshow.querySelector('.kpt-portfolio-progress-bar');

    if (slides.length <= 1) return;

    var currentSlide = 0;
    var isPaused = false;
    var startTime = Date.now();
    var slideDuration = 8000;
    var rafId = null;

    function setProgress(percent) {
        if (progressBar) progressBar.style.width = percent + '%';
    }

    function goToSlide(index) {
        slides.forEach(function(s) { s.classList.remove('active'); });
        dots.forEach(function(d) { d.classList.remove('active'); });
        currentSlide = (index + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
        if (dots[currentSlide]) dots[currentSlide].classList.add('active');
        startTime = Date.now();
        setProgress(0);
    }

    function tick() {
        if (!isPaused) {
            var elapsed = Date.now() - startTime;
            var progress = Math.min((elapsed / slideDuration) * 100, 100);
            setProgress(progress);
            if (elapsed >= slideDuration) {
                goToSlide(currentSlide + 1);
            }
        }
        rafId = requestAnimationFrame(tick);
    }

    function pause() { isPaused = true; }
    function resume() { 
        isPaused = false; 
        startTime = Date.now() - (parseFloat(progressBar.style.width || 0) / 100 * slideDuration);
    }

    if (prevBtn) prevBtn.addEventListener('click', function() { goToSlide(currentSlide - 1); });
    if (nextBtn) nextBtn.addEventListener('click', function() { goToSlide(currentSlide + 1); });
    dots.forEach(function(dot, i) { dot.addEventListener('click', function() { goToSlide(i); }); });

    slideshow.addEventListener('mouseenter', pause);
    slideshow.addEventListener('mouseleave', resume);

    var touchStartX = 0;
    slideshow.addEventListener('touchstart', function(e) { touchStartX = e.changedTouches[0].screenX; pause(); }, {passive:true});
    slideshow.addEventListener('touchend', function(e) {
        var diff = touchStartX - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 50) goToSlide(currentSlide + (diff > 0 ? 1 : -1));
        resume();
    }, {passive:true});

    rafId = requestAnimationFrame(tick);
});
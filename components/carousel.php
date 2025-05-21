<section class="relative w-full overflow-hidden ">
    <div class="carousel-container relative">
        <!-- Carousel Track -->
        <div id="carousel-track" class="flex transition-transform duration-300 ease-out">
            <?php

            $stmt = $conn->query("SELECT * FROM carousel WHERE status = 1 ORDER BY id ASC LIMIT 4");
            $slides = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $slideCount = count($slides);

            foreach ($slides as $index => $s):
            ?>
            <div class="carousel-slide w-full flex-shrink-0 aspect-[16/9]  relative">
                <img src="images/slide/<?= htmlspecialchars($s['image']) ?>" class="w-full h-full "
                    alt="Slide <?= $index + 1 ?>">
            </div>
            <?php
            endforeach;
            ?>
        </div>

        <!-- Navigation Arrows -->
        <button id="prev-button"
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-800 p-2 rounded-full shadow-md z-10 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button id="next-button"
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-800 p-2 rounded-full shadow-md z-10 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Dots Navigation -->
        <div class="absolute bottom-4 left-0 right-0">
            <div id="carousel-dots" class="flex justify-center space-x-2">
                <?php for ($i = 0; $i < $slideCount; $i++): ?>
                <button
                    class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 focus:outline-none transition-colors <?= $i === 0 ? 'bg-white' : '' ?>"
                    data-index="<?= $i ?>"></button>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('carousel-track');
    const slides = track.querySelectorAll('.carousel-slide');
    const dotsContainer = document.getElementById('carousel-dots');
    const dots = dotsContainer.querySelectorAll('.carousel-dot');
    const prevButton = document.getElementById('prev-button');
    const nextButton = document.getElementById('next-button');

    let currentIndex = 0;
    const slideCount = slides.length;

    if (slideCount === 0) return;

    // Set initial width for all slides
    function setSlideWidth() {
        const containerWidth = track.parentElement.clientWidth;
        slides.forEach(slide => {
            slide.style.width = `${containerWidth}px`;
        });
        // Update track position after resize
        goToSlide(currentIndex);
    }

    // Initialize slide widths
    setSlideWidth();

    // Handle window resize
    window.addEventListener('resize', setSlideWidth);

    // Go to specific slide
    function goToSlide(index) {
        if (index < 0) index = slideCount - 1;
        if (index >= slideCount) index = 0;

        currentIndex = index;
        const offset = -index * track.parentElement.clientWidth;
        track.style.transform = `translateX(${offset}px)`;

        // Update active dot
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-white', i === currentIndex);
            dot.classList.toggle('bg-white/50', i !== currentIndex);
        });
    }

    // Event listeners for buttons
    prevButton.addEventListener('click', () => goToSlide(currentIndex - 1));
    nextButton.addEventListener('click', () => goToSlide(currentIndex + 1));

    // Event listeners for dots
    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.getAttribute('data-index'));
            goToSlide(index);
        });
    });

    // Auto-advance slides every 5 seconds
    let interval = setInterval(() => goToSlide(currentIndex + 1), 5000);

    // Pause auto-advance on hover
    track.parentElement.addEventListener('mouseenter', () => clearInterval(interval));
    track.parentElement.addEventListener('mouseleave', () => {
        clearInterval(interval);
        interval = setInterval(() => goToSlide(currentIndex + 1), 5000);
    });

    // Touch support
    let touchStartX = 0;
    let touchEndX = 0;

    track.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
        clearInterval(interval);
    }, {
        passive: true
    });

    track.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        interval = setInterval(() => goToSlide(currentIndex + 1), 5000);
    }, {
        passive: true
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        if (touchEndX < touchStartX - swipeThreshold) {
            // Swipe left, go to next slide
            goToSlide(currentIndex + 1);
        }
        if (touchEndX > touchStartX + swipeThreshold) {
            // Swipe right, go to previous slide
            goToSlide(currentIndex - 1);
        }
    }
});
</script>
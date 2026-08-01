<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('components/apply_now_panel') ?>
<?= view('components/hero_section', ['ticker' => $ticker ?? []]) ?>

<style>
/* Slider Container */
.slider-container {
    position: relative;
    overflow: hidden;
}

.slider-wrapper {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.slider-wrapper > div {
    flex: 0 0 100%;
    min-width: 100%;
}

.slider-wrapper img {
    width: 100%;
    height: auto;
    max-height: 500px;
    object-fit: contain;
    border-radius: 16px;
}

.slide-content {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    padding: 0 50px;
}

/* Navigation Buttons */
.slider-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.6);
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 20;
    backdrop-filter: blur(4px);
}

.slider-nav:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: translateY(-50%) scale(1.05);
}

.slider-nav-prev {
    left: 60px;
}

.slider-nav-next {
    right: 60px;
}

/* Dot Navigation */
.slider-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 24px;
}

.slider-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.3);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.slider-dot.active {
    width: 24px;
    border-radius: 4px;
    background: hsl(var(--primary));
}

.slider-dot:hover {
    background: hsl(var(--primary));
}

/* Slide Content Overlay */
.slide-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    padding: 20px;
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .slider-container {
        padding: 0 40px;
    }
    
    .slider-nav {
        width: 36px;
        height: 36px;
    }
    
    .slider-wrapper img {
        max-height: 300px;
        object-fit: cover;
    }
    
    .slide-overlay {
        padding: 12px;
    }
    
    .slide-overlay h2 {
        font-size: 14px;
        margin-bottom: 4px;
    }
    
    .slide-overlay p {
        font-size: 11px;
    }
    
    .slide-overlay a {
        font-size: 11px;
        margin-top: 4px;
    }
}
</style>

<!-- ========== SLIDER SECTION ========== -->
<?php if (!empty($homeSliders)): ?>
<section class="py-8 bg-background">
    <div class="container-bank">
        <div class="slider-container">
            <!-- Previous Button -->
            <button id="sliderPrev" class="slider-nav slider-nav-prev" aria-label="Previous slide">
                <i data-lucide="chevron-left" class="w-6 h-6"></i>
            </button>

            <!-- Slider Wrapper -->
            <div class="slider-wrapper">
                <?php foreach ($homeSliders as $index => $slide): ?>
                    <div class="slide-content" data-index="<?= $index ?>">
                        <img src="<?= base_url($slide['image']) ?>"
                             alt="<?= esc($slide['title']) ?>"
                             loading="lazy">
                        <?php if (!empty($slide['title']) || !empty($slide['subtitle'])): ?>
                            <div class="slide-overlay">
                                <?php if (!empty($slide['title'])): ?>
                                    <h2 class="text-xl md:text-2xl font-bold mb-1"><?= esc($slide['title']) ?></h2>
                                <?php endif; ?>
                                <?php if (!empty($slide['subtitle'])): ?>
                                    <p class="text-sm md:text-base opacity-90"><?= esc($slide['subtitle']) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($slide['button_link'])): ?>
                                    <a href="<?= site_url(ltrim($slide['button_link'], '/')) ?>"
                                       class="inline-block mt-2 text-sm font-semibold underline">
                                        <?= esc($slide['button_text'] ?? 'Learn More') ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Next Button -->
            <button id="sliderNext" class="slider-nav slider-nav-next" aria-label="Next slide">
                <i data-lucide="chevron-right" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Dots Navigation -->
        <div class="slider-dots">
            <?php foreach ($homeSliders as $index => $slide): ?>
                <button class="slider-dot <?= $index == 0 ? 'active' : '' ?>" data-slide="<?= $index ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const wrapper = document.querySelector('.slider-wrapper');
    const slides = document.querySelectorAll('.slider-wrapper > div');
    const prevBtn = document.getElementById('sliderPrev');
    const nextBtn = document.getElementById('sliderNext');
    const dots = document.querySelectorAll('.slider-dot');

    if (!wrapper || slides.length === 0) return;

    let currentIndex = 0;
    let autoInterval = null;

    const totalSlides = slides.length;
    const AUTO_DELAY = 5000;

    // =========================
    // UPDATE SLIDER
    // =========================
    function updateSlider() {

        wrapper.style.transform =
            `translateX(-${currentIndex * 100}%)`;

        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentIndex);
        });
    }

    // =========================
    // NEXT SLIDE
    // =========================
    function nextSlide() {

        currentIndex++;

        if (currentIndex >= totalSlides) {
            currentIndex = 0;
        }

        updateSlider();
    }

    // =========================
    // PREV SLIDE
    // =========================
    function prevSlide() {

        currentIndex--;

        if (currentIndex < 0) {
            currentIndex = totalSlides - 1;
        }

        updateSlider();
    }

    // =========================
    // GO TO SLIDE
    // =========================
    function goToSlide(index) {

        currentIndex = index;

        updateSlider();

        restartAutoPlay();
    }

    // =========================
    // AUTOPLAY
    // =========================
    function startAutoPlay() {

        stopAutoPlay();

        autoInterval = setInterval(() => {

            nextSlide();

        }, AUTO_DELAY);
    }

    function stopAutoPlay() {

        if (autoInterval) {

            clearInterval(autoInterval);

            autoInterval = null;
        }
    }

    function restartAutoPlay() {

        stopAutoPlay();

        startAutoPlay();
    }

    // =========================
    // BUTTON EVENTS
    // =========================
    if (nextBtn) {

        nextBtn.addEventListener('click', () => {

            nextSlide();

            restartAutoPlay();
        });
    }

    if (prevBtn) {

        prevBtn.addEventListener('click', () => {

            prevSlide();

            restartAutoPlay();
        });
    }

    // =========================
    // DOT EVENTS
    // =========================
    dots.forEach((dot, index) => {

        dot.addEventListener('click', () => {

            goToSlide(index);
        });
    });

    // =========================
    // HOVER PAUSE
    // =========================
    const container = document.querySelector('.slider-container');

    if (container) {

        container.addEventListener('mouseenter', stopAutoPlay);

        container.addEventListener('mouseleave', startAutoPlay);
    }

    // =========================
    // INIT
    // =========================
    updateSlider();

    startAutoPlay();

    // =========================
    // ICONS
    // =========================
    if (typeof lucide !== 'undefined') {

        lucide.createIcons();
    }

});
</script>

<?php else: ?>
<!-- Debug: No sliders found. Please add sliders in admin panel -->
<?php endif; ?>
<!-- ========== END SLIDER SECTION ========== -->

 
<?= view('components/quick_actions', ['quickActions' => $quickActions]) ?>
<?= view('components/products_section', ['products' => $products]) ?>
<?= view('components/notices_section', ['notices' => $notices, 'ticker' => $ticker]) ?>
<?= view('components/safety_section') ?>
<?= view('components/grievance_section', ['grievanceSteps' => $grievanceSteps]) ?>
<?= view('components/branch_locator', ['branches' => $branches]) ?>
<?= view('components/trust_section') ?>

<?php if (!empty($popupBanners)): ?>
<div id="popupOverlay" class="popup-overlay" style="display: none;">
    <div class="popup-container">
        <div class="popup-content">
            <button class="popup-close" id="closePopup">&times;</button>
            <div id="popupContentWrapper"></div>
            <?php if (count($popupBanners) > 1): ?>
                <div class="popup-controls">
                    <div class="popup-counter" id="popupCounter"></div>
                    <button id="closeAllBtn" class="popup-close-all">Close All</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.85);
    backdrop-filter: blur(5px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
}
.popup-container {
    max-width: 90vw;
    max-height: 90vh;
    width: auto;
    height: auto;
    display: flex;
    flex-direction: column;
}
.popup-content {
    background: #fff;
    border-radius: 20px;
    overflow: auto;
    position: relative;
    box-shadow: 0 20px 35px rgba(0,0,0,0.3);
    max-width: 100%;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}
.popup-image {
    width: auto;
    max-width: 100%;
    height: auto;
    max-height: calc(90vh - 100px);
    display: block;
    margin: 0 auto;
    object-fit: contain;
}
.popup-text {
    padding: 20px;
    text-align: center;
    flex-shrink: 0;
}
.popup-text h3 {
    margin: 0 0 10px;
    font-size: 1.5rem;
    color: #1e293b;
}
.popup-text p {
    margin: 0;
    color: #475569;
}
.popup-close {
    position: absolute;
    top: 10px;
    right: 15px;
    background: white;
    border: none;
    font-size: 28px;
    font-weight: bold;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    transition: 0.2s;
    z-index: 10;
}
.popup-close:hover {
    background: #f1f1f1;
    transform: scale(1.05);
}
.popup-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    border-top: 1px solid #eee;
    background: #f9f9f9;
}
.popup-counter {
    font-size: 0.85rem;
    color: #666;
}
.popup-close-all {
    background: none;
    border: none;
    color: #dc2626;
    cursor: pointer;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 6px;
    transition: 0.2s;
}
.popup-close-all:hover {
    background: #fee2e2;
    text-decoration: underline;
}
@media (max-width: 640px) {
    .popup-image {
        max-height: calc(90vh - 80px);
    }
    .popup-text {
        padding: 12px;
    }
    .popup-text h3 {
        font-size: 1.2rem;
    }
    .popup-controls {
        padding: 8px 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const banners = <?= json_encode($popupBanners) ?>;
    if (!banners.length) return;

    const popupOverlay = document.getElementById('popupOverlay');
    const contentWrapper = document.getElementById('popupContentWrapper');
    const counterDiv = document.getElementById('popupCounter');
    const closeAllBtn = document.getElementById('closeAllBtn');
    
    // Session keys
    const SESSION_STARTED_KEY = 'jpcb_popup_session_started';
    const SESSION_INDEX_KEY = 'jpcb_popup_index';
    const SESSION_CLOSED_ALL_KEY = 'jpcb_popup_closed_all';
    
    // Check if user has already closed all banners
    if (sessionStorage.getItem(SESSION_CLOSED_ALL_KEY) === 'true') {
        popupOverlay.style.display = 'none';
        return;
    }
    
    let currentIndex = parseInt(sessionStorage.getItem(SESSION_INDEX_KEY) || '0');
    
    function renderBanner(index) {
        if (index >= banners.length) {
            // No more banners – close & reset
            popupOverlay.style.display = 'none';
            sessionStorage.removeItem(SESSION_INDEX_KEY);
            sessionStorage.removeItem(SESSION_STARTED_KEY);
            return;
        }
        
        const banner = banners[index];
        let html = '';
        if (banner.image) {
            html += `<img src="<?= base_url('') ?>${banner.image}" class="popup-image" alt="${escapeHtml(banner.title || 'Popup Banner')}">`;
        }
        if (banner.title || banner.description) {
            html += `<div class="popup-text">`;
            if (banner.title) html += `<h3>${escapeHtml(banner.title)}</h3>`;
            if (banner.description) html += `<p>${escapeHtml(banner.description)}</p>`;
            html += `</div>`;
        }
        contentWrapper.innerHTML = html;
        
        if (counterDiv && banners.length > 1) {
            counterDiv.innerHTML = `${index+1} / ${banners.length}`;
        }
        
        sessionStorage.setItem(SESSION_INDEX_KEY, index);
        popupOverlay.style.display = 'flex';
    }
    
    function nextBanner() {
        currentIndex++;
        renderBanner(currentIndex);
    }
    
    function closeAll() {
        // Mark that user has closed all banners in this session
        sessionStorage.setItem(SESSION_CLOSED_ALL_KEY, 'true');
        sessionStorage.removeItem(SESSION_INDEX_KEY);
        sessionStorage.removeItem(SESSION_STARTED_KEY);
        popupOverlay.style.display = 'none';
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    const sessionStarted = sessionStorage.getItem(SESSION_STARTED_KEY);
    if (!sessionStarted) {
        sessionStorage.setItem(SESSION_STARTED_KEY, 'true');
        sessionStorage.setItem(SESSION_INDEX_KEY, '0');
        renderBanner(0);
    } else {
        const storedIndex = parseInt(sessionStorage.getItem(SESSION_INDEX_KEY) || '0');
        if (storedIndex < banners.length) {
            renderBanner(storedIndex);
        } else {
            popupOverlay.style.display = 'none';
        }
    }
    
    const closeBtn = document.getElementById('closePopup');
    if (closeBtn) {
        closeBtn.addEventListener('click', nextBanner);
    }
    
    if (closeAllBtn) {
        closeAllBtn.addEventListener('click', closeAll);
    }
    
    popupOverlay.addEventListener('click', function(e) {
        if (e.target === popupOverlay) {
            nextBanner();
        }
    });
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>
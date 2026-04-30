<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= view('components/hero_section') ?>
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
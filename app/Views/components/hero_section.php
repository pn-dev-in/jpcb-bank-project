<section id="home" class="relative overflow-hidden" aria-labelledby="hero-heading" style="background-color: hsl(var(--background));">
  <!-- Decorative blobs -->
  <div class="absolute inset-0" aria-hidden="true">
    <div class="absolute top-0 right-0 w-[200px] h-[200px] sm:w-[320px] sm:h-[320px] lg:w-[500px] lg:h-[500px] rounded-full blur-3xl translate-x-1/3 -translate-y-1/3" style="background-color: hsl(var(--primary) / 0.05);"></div>
    <div class="absolute bottom-0 left-0 w-[160px] h-[160px] sm:w-[260px] sm:h-[260px] lg:w-[400px] lg:h-[400px] rounded-full blur-3xl -translate-x-1/3 translate-y-1/3" style="background-color: hsl(var(--secondary) / 0.05);"></div>
  </div>

  <div class="container-bank relative py-10 md:py-10 lg:py-20">
    <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">

      <!-- Left content -->
      <div>
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium mb-6"
          style="background-color: hsl(var(--primary) / 0.08); color: hsl(var(--primary));">
          <i data-lucide="shield" class="w-4 h-4" aria-hidden="true"></i>
          <?= esc($hero['badge_text']) ?>
        </div>

        <h1 id="hero-heading" class="font-heading text-3xl sm:text-4xl md:text-5xl mb-5 leading-tight" style="color: hsl(var(--foreground));">
          <?= esc($hero['heading_main']) ?>
          <br />
          <span style="color: hsl(var(--primary));"><?= esc($hero['heading_highlight']) ?></span>
        </h1>

        <p class="text-lg max-w-xl mb-8 leading-relaxed" style="color: hsl(var(--muted-foreground));">
          <?= esc($hero['description']) ?>
        </p>

        <div class="flex flex-col sm:flex-row gap-3 mb-8">
          <a href="<?= site_url($hero['button1_link']) ?>" class="btn-primary flex items-center justify-center gap-2">
            <?= esc($hero['button1_text']) ?> <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
          </a>
          <a href="<?= site_url($hero['button2_link']) ?>" class="btn-outline flex items-center justify-center gap-2">
            <i data-lucide="map-pin" class="w-4 h-4" aria-hidden="true"></i> <?= esc($hero['button2_text']) ?>
          </a>
        </div>

        <!-- Hero Search -->
        <form id="hero-search-form" action="<?= site_url('search') ?>" method="get" role="search" class="max-w-lg">
          <label for="hero-search" class="sr-only">Search products, forms, rates, branches</label>
          <div class="relative">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 pointer-events-none" style="color: hsl(var(--muted-foreground));" aria-hidden="true"></i>
            <input id="hero-search" type="search" name="q"
              placeholder="<?= esc($hero['search_placeholder']) ?>"
              maxlength="200"
              class="w-full pl-12 pr-24 py-3.5 rounded-lg border shadow-sm text-base focus:outline-none focus:ring-2"
              style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); color: hsl(var(--foreground));"
              autocomplete="off">
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 rounded-md font-medium tap-target text-sm transition-opacity hover:opacity-90"
              style="background-color: hsl(var(--primary)); color: hsl(var(--primary-foreground));">
              Search
            </button>
          </div>
        </form>
      </div>

      <!-- Right – Trust cards (desktop only) -->
      <div class="hidden lg:grid grid-cols-2 gap-4">
        <?php foreach ($trustCards as $card): ?>
          <div class="bank-card p-5 group">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-3" style="background-color: hsl(var(--primary) / 0.1);">
              <i data-lucide="<?= esc($card['icon_name']) ?>" class="w-5 h-5" style="color: hsl(var(--primary));"></i>
            </div>
            <h3 class="font-semibold text-sm mb-1" style="color: hsl(var(--foreground));"><?= esc($card['title']) ?></h3>
            <p class="text-xs" style="color: hsl(var(--muted-foreground));"><?= esc($card['description']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php if (!empty($alertBanners)): ?>
  <?php foreach ($alertBanners as $banner): ?>
    <?php if (empty($banner['is_popup'])): ?>

      <div class="w-full py-6 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 text-center">

          <img src="<?= base_url($banner['image']) ?>"
               class="mx-auto rounded-lg shadow-md"
               style="max-width: 900px; width: 100%; height: auto;"
               alt="<?= esc($banner['title'] ?? 'Alert') ?>">

        </div>
      </div>

    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($ticker)): ?>

<!-- ================================================================
     WHAT'S NEW — RBI / COOPERATIVE BANK STYLE FLOATING NOTICE CARD
     Auto-scrolling vertically, infinite loop, pause on hover
================================================================ -->
<div id="wnCard" class="wn-card" role="complementary" aria-label="What's New Notices">

  <!-- Header -->
  <div class="wn-header">
    <div class="wn-header-left">
      <span class="wn-new-badge" aria-hidden="true">NEW</span>
      <span class="wn-heading">What's New</span>
    </div>
    <button class="wn-close-btn" id="wnCloseBtn" aria-label="Close What's New notices" title="Close">
      &#x2715;
    </button>
  </div>

  <!-- Scroll viewport -->
  <div class="wn-viewport" id="wnViewport"
       aria-live="polite"
       onmouseenter="wnPause()" onmouseleave="wnResume()"
       onfocus="wnPause()"    onblur="wnResume()">

    <div class="wn-track" id="wnTrack">

      <?php foreach ($ticker as $notice): ?>
        <div class="wn-notice">
          <span class="wn-bullet" aria-hidden="true">&#9679;</span>
          <p class="wn-para"><?= esc($notice) ?></p>
        </div>
      <?php endforeach; ?>

      <?php /* Duplicate set for seamless infinite loop */ ?>
      <?php foreach ($ticker as $notice): ?>
        <div class="wn-notice wn-clone" aria-hidden="true">
          <span class="wn-bullet">&#9679;</span>
          <p class="wn-para"><?= esc($notice) ?></p>
        </div>
      <?php endforeach; ?>

    </div>
  </div>

  <!-- Footer -->
  <div class="wn-footer">
    <span class="wn-live-dot" aria-hidden="true"></span>
    <span class="wn-live-label">Live Updates</span>
    <span class="wn-footer-divider" aria-hidden="true">|</span>
    <span class="wn-count"><?= count($ticker) ?> Notice<?= count($ticker) !== 1 ? 's' : '' ?></span>
  </div>

</div>

<!-- Re-open tab (visible after close) -->
<button id="wnTab" class="wn-tab" aria-label="Open What's New notices" style="display:none">
  <span class="wn-tab-badge">NEW</span>
  <span class="wn-tab-label">What's New</span>
</button>

<!-- ================================================================
     STYLES
================================================================ -->
<style>
/* ----- Card shell ----- */
.wn-card {
  position: fixed;
  bottom: 30px;
  right: 28px;
  width: 310px;
  border-radius: 12px;
  background: #fff;
  border: 1px solid #d1e7d8;
  box-shadow: 0 8px 32px rgba(0,90,40,0.13), 0 2px 6px rgba(0,0,0,0.06);
  z-index: 10000;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  animation: wnEnter 0.4s cubic-bezier(0.22,1,0.36,1) both;
  font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
}

/* Green left accent stripe */
.wn-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0;
  width: 5px; height: 100%;
  background: linear-gradient(180deg,#15803d,#16a34a 60%,#166534);
  border-radius: 12px 0 0 12px;
}

/* ----- Header ----- */
.wn-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 11px 13px 10px 17px;
  background: #f0fdf4;
  border-bottom: 1px solid #d1fae5;
  flex-shrink: 0;
}

.wn-header-left {
  display: flex;
  align-items: center;
  gap: 9px;
}

.wn-new-badge {
  background: #dc2626;
  color: #fff;
  font-size: 9.5px;
  font-weight: 800;
  letter-spacing: 0.09em;
  padding: 3px 7px;
  border-radius: 4px;
  animation: wnBadgePulse 2.2s ease-in-out infinite;
}

.wn-heading {
  font-size: 13.5px;
  font-weight: 700;
  color: #14532d;
  letter-spacing: 0.01em;
}

.wn-close-btn {
  width: 24px; height: 24px;
  border-radius: 50%;
  border: 1px solid #bbf7d0;
  background: #fff;
  color: #166534;
  font-size: 13px;
  line-height: 1;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background 0.18s, transform 0.2s;
  padding: 0;
  flex-shrink: 0;
}
.wn-close-btn:hover {
  background: #dcfce7;
  transform: rotate(90deg);
}

/* ----- Scroll viewport ----- */
.wn-viewport {
  height: 190px;
  overflow: hidden;
  position: relative;
  flex-shrink: 0;
}

/* Fade mask top + bottom for polished look */
.wn-viewport::before,
.wn-viewport::after {
  content: '';
  position: absolute;
  left: 0; right: 0;
  height: 28px;
  z-index: 2;
  pointer-events: none;
}
.wn-viewport::before {
  top: 0;
  background: linear-gradient(to bottom, #fff 0%, transparent 100%);
}
.wn-viewport::after {
  bottom: 0;
  background: linear-gradient(to top, #fff 0%, transparent 100%);
}

/* ----- Scrolling track ----- */
.wn-track {
  display: flex;
  flex-direction: column;
  animation: wnScroll var(--wn-duration, 18s) linear infinite;
  will-change: transform;
}

.wn-track.wn-paused {
  animation-play-state: paused;
}

/* ----- Individual notice ----- */
.wn-notice {
  display: flex;
  align-items: flex-start;
  gap: 9px;
  padding: 11px 14px 11px 17px;
  border-bottom: 1px solid #f0fdf4;
}
.wn-notice:last-child { border-bottom: none; }

.wn-bullet {
  color: #16a34a;
  font-size: 7px;
  margin-top: 6px;
  flex-shrink: 0;
  line-height: 1;
}

.wn-para {
  margin: 0;
  font-size: 12.5px;
  color: #1e293b;
  line-height: 1.6;
  font-weight: 400;
}

/* ----- Footer ----- */
.wn-footer {
  display: flex;
  align-items: center;
  gap: 7px;
  padding: 8px 14px 9px 17px;
  background: #f8fff9;
  border-top: 1px solid #d1fae5;
  flex-shrink: 0;
}

.wn-live-dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  background: #16a34a;
  flex-shrink: 0;
  position: relative;
}
.wn-live-dot::after {
  content: '';
  position: absolute;
  inset: -3px;
  border-radius: 50%;
  border: 2px solid #16a34a;
  animation: wnRipple 1.8s ease-out infinite;
}

.wn-live-label {
  font-size: 10.5px;
  color: #16a34a;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.wn-footer-divider {
  color: #86efac;
  font-size: 11px;
}

.wn-count {
  font-size: 10.5px;
  color: #6b7280;
  font-weight: 500;
}

/* ----- Re-open tab ----- */
.wn-tab {
  position: fixed;
  bottom: 30px;
  right: 28px;
  display: flex;
  align-items: center;
  gap: 8px;
  background: #15803d;
  color: #fff;
  border: none;
  border-radius: 9px;
  padding: 9px 15px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  z-index: 10000;
  box-shadow: 0 4px 14px rgba(21,128,61,0.38);
  animation: wnEnter 0.3s cubic-bezier(0.22,1,0.36,1) both;
  transition: transform 0.2s, box-shadow 0.2s;
}
.wn-tab:hover {
  transform: translateY(-2px);
  box-shadow: 0 7px 20px rgba(21,128,61,0.42);
}

.wn-tab-badge {
  background: #dc2626;
  font-size: 9px;
  padding: 2px 5px;
  border-radius: 3px;
  letter-spacing: 0.07em;
}

/* ----- Keyframes ----- */
@keyframes wnScroll {
  0%   { transform: translateY(0); }
  100% { transform: translateY(-50%); }
}

@keyframes wnEnter {
  from { opacity: 0; transform: translateY(22px) scale(0.96); }
  to   { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes wnBadgePulse {
  0%,100% { box-shadow: 0 0 0 0 rgba(220,38,38,0.45); }
  50%     { box-shadow: 0 0 0 5px rgba(220,38,38,0); }
}

@keyframes wnRipple {
  0%   { transform: scale(1); opacity: 0.9; }
  100% { transform: scale(2.4); opacity: 0; }
}

/* ----- Mobile ----- */
@media (max-width: 500px) {
  .wn-card {
    bottom: 0; right: 0; left: 0;
    width: 100%;
    border-radius: 16px 16px 0 0;
    animation: wnEnterMobile 0.38s cubic-bezier(0.22,1,0.36,1) both;
  }
  .wn-card::before {
    width: 100%; height: 5px;
    background: linear-gradient(90deg,#15803d,#16a34a 50%,#166534);
    border-radius: 16px 16px 0 0;
  }
  .wn-viewport { height: 200px; }
  .wn-tab { bottom: 16px; right: 16px; }

  @keyframes wnEnterMobile {
    from { opacity: 0; transform: translateY(100%); }
    to   { opacity: 1; transform: translateY(0); }
  }
}
</style>

<!-- ================================================================
     JAVASCRIPT — scroll speed, pause/resume, show/hide
================================================================ -->
<script>
(function () {
  var track    = document.getElementById('wnTrack');
  var viewport = document.getElementById('wnViewport');
  var card     = document.getElementById('wnCard');
  var closeBtn = document.getElementById('wnCloseBtn');
  var tab      = document.getElementById('wnTab');

  if (!track || !card || !closeBtn || !tab) return;

  /* ---- Calibrate scroll speed based on total content height ----
     More content → longer duration so reading pace stays comfortable.
     Base: ~40px/second.                                            */
  function calibrate() {
    var totalH = track.scrollHeight;
    var halfH  = totalH / 2;           /* only the original set */
    var speed  = 38;                   /* px per second          */
    var dur    = Math.max(12, halfH / speed);
    track.style.setProperty('--wn-duration', dur.toFixed(1) + 's');
    /* Override the CSS variable on the card level too */
    card.style.setProperty('--wn-duration', dur.toFixed(1) + 's');
  }

  /* ---- Pause / Resume (called from inline onmouseenter/leave) -- */
  window.wnPause  = function () { track.classList.add('wn-paused'); };
  window.wnResume = function () { track.classList.remove('wn-paused'); };

  /* ---- Close card → show tab ---- */
  function hideCard() {
    card.style.transition = 'opacity 0.25s ease, transform 0.28s ease';
    card.style.opacity    = '0';
    card.style.transform  = 'translateY(18px) scale(0.96)';
    setTimeout(function () {
      card.style.display = 'none';
      tab.style.display  = 'flex';
    }, 270);
    try { sessionStorage.setItem('wn_hidden', '1'); } catch(e) {}
  }

  /* ---- Open card → hide tab ---- */
  function showCard() {
    tab.style.display  = 'none';
    card.style.display = 'flex';
    card.style.opacity = '0';
    card.style.transform = 'translateY(18px) scale(0.96)';
    setTimeout(function () {
      card.style.transition = 'opacity 0.3s ease, transform 0.32s ease';
      card.style.opacity    = '1';
      card.style.transform  = 'translateY(0) scale(1)';
    }, 20);
    try { sessionStorage.removeItem('wn_hidden'); } catch(e) {}
  }

  /* ---- Session: keep hidden if user already closed it ---- */
  try {
    if (sessionStorage.getItem('wn_hidden') === '1') {
      card.style.display = 'none';
      tab.style.display  = 'flex';
    }
  } catch(e) {}

  closeBtn.addEventListener('click', hideCard);
  tab.addEventListener('click', showCard);

  /* ---- Run calibration after fonts/layout settle ---- */
  if (document.readyState === 'complete') {
    calibrate();
  } else {
    window.addEventListener('load', calibrate);
  }
})();
</script>

<?php endif; ?>
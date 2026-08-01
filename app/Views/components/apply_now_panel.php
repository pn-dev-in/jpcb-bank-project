<?php
/**
 * JPCB Bank – Apply Now / Quick Services Floating Panel
 * File: app/Views/components/apply_now_panel.php
 * 
 * CMS-DRIVEN VERSION: All content comes from database tables:
 * - apply_panel_settings
 * - apply_panel_items
 *
 * PLACEMENT: Include this file in app/Views/layouts/main.php
 * AFTER the closing </header> tag and BEFORE </body>.
 *
 * Example: <?= $this->include('components/apply_now_panel') ?>
 */

// Get CMS data passed from Home controller
$settings = $applyPanelSettings ?? null;
$applyItems = $applyPanelItems ?? [];

// If panel is disabled or no settings, don't render
if (!$settings || !($settings['is_enabled'] ?? false)) {
    return;
}

$position = $settings['position'] ?? 'left';
$positionStyle = $position === 'left' ? 'left: 0;' : 'right: 0;';
$tabBorderRadius = $position === 'left' ? '0 var(--an-radius) var(--an-radius) 0' : 'var(--an-radius) 0 0 var(--an-radius)';
$drawerBorderRadius = $position === 'left' ? '0 var(--an-radius) var(--an-radius) 0' : 'var(--an-radius) 0 0 var(--an-radius)';
$drawerBorder = $position === 'left' ? 'border-left: none;' : 'border-right: none;';
$tabDirection = $position === 'left' ? 'chevron-right' : 'chevron-left';
?>

<!-- ================================================================
     APPLY NOW FLOATING PANEL  —  CMS-DRIVEN VERSION
================================================================ -->

<!-- ── Desktop & Tablet: Left/Right slide-out panel ── -->
<aside id="applyPanel"
       class="an-panel an-panel--<?= $position ?>"
       role="complementary"
       aria-label="Quick Apply shortcuts"
       aria-expanded="false"
       style="<?= $positionStyle ?>">

  <!-- Vertical tab (always visible, acts as handle) -->
  <button class="an-tab" id="applyTab"
          aria-label="Open Quick Apply panel"
          aria-controls="applyPanel"
          aria-expanded="false">
    <span class="an-tab-stripe" aria-hidden="true"></span>
    <span class="an-tab-text" aria-hidden="true"><?= esc($settings['button_text'] ?? 'Apply Now') ?></span>
    <span class="an-tab-arrow" aria-hidden="true">
      <i data-lucide="<?= $tabDirection ?>" class="w-3.5 h-3.5"></i>
    </span>
  </button>

  <!-- Slide-out drawer content -->
  <div class="an-drawer" id="applyDrawer" aria-hidden="true">

    <!-- Drawer header -->
    <div class="an-drawer-header">
      <div class="an-drawer-title-wrap">
        <span class="an-drawer-icon-wrap" aria-hidden="true">
          <i data-lucide="zap" class="w-4 h-4"></i>
        </span>
        <span class="an-drawer-title"><?= esc($settings['panel_title'] ?? 'Quick Apply') ?></span>
      </div>
      <button class="an-drawer-close" id="applyClose"
              aria-label="Close Quick Apply panel">
        <i data-lucide="x" class="w-3.5 h-3.5"></i>
      </button>
    </div>

    <!-- Subtitle -->
    <p class="an-drawer-sub"><?= esc($settings['panel_subtitle'] ?? 'Open an account instantly') ?></p>

    <!-- Items -->
    <nav class="an-items" aria-label="Account types">
      <?php foreach ($applyItems as $item): ?>
      <a href="<?= site_url($item['link']) ?>"
         class="an-item an-item--<?= esc($item['color']) ?>"
         data-color="<?= esc($item['color']) ?>">
        <span class="an-item-icon" aria-hidden="true">
          <i data-lucide="<?= esc($item['icon']) ?>" class="w-4 h-4"></i>
        </span>
        <span class="an-item-label"><?= esc($item['label']) ?></span>
        <span class="an-item-arrow" aria-hidden="true">
          <i data-lucide="arrow-right" class="w-3 h-3"></i>
        </span>
      </a>
      <?php endforeach; ?>
    </nav>

    <!-- Footer CTA -->
    <div class="an-drawer-footer">
      <a href="<?= site_url($settings['footer_link'] ?? 'contact') ?>" class="an-footer-cta">
        <i data-lucide="phone" class="w-3.5 h-3.5" aria-hidden="true"></i>
        <?= esc($settings['footer_text'] ?? 'Talk to an advisor') ?>
      </a>
    </div>

  </div><!-- /drawer -->

</aside>

<!-- ── Mobile: Floating bottom-left button + bottom sheet ── -->
<button id="applyMobileBtn"
        class="an-mobile-btn"
        aria-label="Quick Apply"
        aria-controls="applyMobileSheet"
        aria-expanded="false">
  <i data-lucide="zap" class="w-5 h-5" aria-hidden="true"></i>
  <span class="an-mobile-btn-label"><?= esc($settings['button_text'] ?? 'Apply Now') ?></span>
</button>

<!-- Mobile bottom sheet -->
<div id="applyMobileSheet"
     class="an-mobile-sheet"
     role="dialog"
     aria-modal="true"
     aria-label="Quick Apply"
     aria-hidden="true">

  <div class="an-sheet-handle" aria-hidden="true"></div>

  <div class="an-sheet-header">
    <div class="an-drawer-title-wrap">
      <span class="an-drawer-icon-wrap" aria-hidden="true">
        <i data-lucide="zap" class="w-4 h-4"></i>
      </span>
      <span class="an-drawer-title"><?= esc($settings['panel_title'] ?? 'Quick Apply') ?></span>
    </div>
    <button class="an-drawer-close" id="applySheetClose"
            aria-label="Close Quick Apply">
      <i data-lucide="x" class="w-3.5 h-3.5"></i>
    </button>
  </div>

  <p class="an-drawer-sub" style="padding: 0 16px 12px;"><?= esc($settings['panel_subtitle'] ?? 'Open an account instantly') ?></p>

  <nav class="an-sheet-items" aria-label="Account types">
    <?php foreach ($applyItems as $item): ?>
    <a href="<?= site_url($item['link']) ?>"
       class="an-item an-item--<?= esc($item['color']) ?>">
      <span class="an-item-icon" aria-hidden="true">
        <i data-lucide="<?= esc($item['icon']) ?>" class="w-4 h-4"></i>
      </span>
      <span class="an-item-label"><?= esc($item['label']) ?></span>
      <span class="an-item-arrow" aria-hidden="true">
        <i data-lucide="arrow-right" class="w-3 h-3"></i>
      </span>
    </a>
    <?php endforeach; ?>
  </nav>

  <div class="an-drawer-footer" style="border-top: 1px solid hsl(152 40% 88%); margin-top: 4px;">
    <a href="<?= site_url($settings['footer_link'] ?? 'contact') ?>" class="an-footer-cta">
      <i data-lucide="phone" class="w-3.5 h-3.5" aria-hidden="true"></i>
      <?= esc($settings['footer_text'] ?? 'Talk to an advisor') ?>
    </a>
  </div>

</div>

<!-- Mobile sheet backdrop -->
<div id="applyMobileBackdrop" class="an-backdrop" aria-hidden="true"></div>


<!-- ================================================================
     STYLES (Updated for CMS positioning)
================================================================ -->
<style>
/* ───────────────────────────────────────────────────────────────
   DESIGN TOKENS — uses JPCB CSS variables from custom.css
─────────────────────────────────────────────────────────────────*/
:root {
  --an-w:          240px;
  --an-tab-w:       36px;
  --an-radius:       10px;
  --an-shadow: 0 8px 30px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.07);
  --an-green:   hsl(152 58% 24%);
  --an-green-lt: hsl(152 58% 95%);
  --an-gold:    hsl(40 80% 50%);
  --an-teal:    hsl(170 45% 30%);
  --an-blue:    hsl(215 70% 40%);
  --an-purple:  hsl(262 52% 44%);
  --an-red:     hsl(0 72% 51%);
  --an-orange:  hsl(30 80% 50%);
  --an-pink:    hsl(330 70% 55%);
  --an-transition: 0.28s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ───────────────────────────────────────────────────────────────
   PANEL WRAPPER — positioned left or right
─────────────────────────────────────────────────────────────────*/
.an-panel {
  position: fixed;
  top: 50%;
  transform: translateY(-50%);
  z-index: 9000;
  display: flex;
  align-items: stretch;
  pointer-events: none;
}

.an-panel--left {
  left: 0;
}

.an-panel--right {
  right: 0;
}

/* ───────────────────────────────────────────────────────────────
   VERTICAL TAB
─────────────────────────────────────────────────────────────────*/
.an-tab {
  pointer-events: all;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 6px;
  width: var(--an-tab-w);
  padding: 14px 0;
  background: var(--an-green);
  border: none;
  cursor: pointer;
  box-shadow: var(--an-shadow);
  position: relative;
  z-index: 1;
  transition: background var(--an-transition), width var(--an-transition);
  overflow: hidden;
}

.an-panel--left .an-tab {
  border-radius: 0 var(--an-radius) var(--an-radius) 0;
}

.an-panel--right .an-tab {
  border-radius: var(--an-radius) 0 0 var(--an-radius);
}

.an-tab:hover,
.an-tab:focus-visible {
  background: hsl(152 58% 20%);
  outline: none;
}

.an-tab-stripe {
  display: block;
  width: 20px;
  height: 3px;
  background: var(--an-gold);
  border-radius: 2px;
  flex-shrink: 0;
}

.an-tab-text {
  writing-mode: vertical-rl;
  text-orientation: mixed;
  transform: rotate(180deg);
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: #fff;
  white-space: nowrap;
  line-height: 1;
}

.an-tab-arrow {
  color: hsl(40 80% 75%);
  display: flex;
  align-items: center;
  transition: transform var(--an-transition);
  flex-shrink: 0;
}

.an-panel[aria-expanded="true"] .an-tab-arrow {
  transform: rotate(180deg);
}

/* ───────────────────────────────────────────────────────────────
   SLIDE-OUT DRAWER
─────────────────────────────────────────────────────────────────*/
.an-drawer {
  pointer-events: all;
  width: var(--an-w);
  background: #fff;
  box-shadow: var(--an-shadow);
  border: 1px solid hsl(152 40% 88%);
  display: flex;
  flex-direction: column;
  overflow: hidden;

  /* Hidden state */
  transform: translateX(calc(-1 * var(--an-w)));
  opacity: 0;
  visibility: hidden;
  transition:
    transform var(--an-transition),
    opacity   var(--an-transition),
    visibility 0s linear 0.28s;
}

.an-panel--left .an-drawer {
  border-left: none;
  border-radius: 0 var(--an-radius) var(--an-radius) 0;
}

.an-panel--right .an-drawer {
  border-right: none;
  border-radius: var(--an-radius) 0 0 var(--an-radius);
  transform: translateX(calc(1 * var(--an-w)));
}

/* Open state */
.an-panel[aria-expanded="true"] .an-drawer {
  transform: translateX(0);
  opacity: 1;
  visibility: visible;
  transition:
    transform var(--an-transition),
    opacity   var(--an-transition),
    visibility 0s linear 0s;
}

/* Drawer Header */
.an-drawer-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 13px 12px 10px 14px;
  background: hsl(152 58% 96%);
  border-bottom: 1px solid hsl(152 40% 88%);
  flex-shrink: 0;
}

.an-drawer-title-wrap {
  display: flex;
  align-items: center;
  gap: 8px;
}

.an-drawer-icon-wrap {
  width: 28px;
  height: 28px;
  border-radius: 7px;
  background: var(--an-green);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.an-drawer-title {
  font-size: 13.5px;
  font-weight: 700;
  color: hsl(152 58% 18%);
  letter-spacing: 0.01em;
}

.an-drawer-close {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  border: 1px solid hsl(152 40% 82%);
  background: #fff;
  color: hsl(152 30% 35%);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.18s, transform 0.2s;
  padding: 0;
  flex-shrink: 0;
}

.an-drawer-close:hover { background: hsl(152 58% 93%); transform: rotate(90deg); }

.an-drawer-sub {
  margin: 0;
  padding: 8px 14px 4px;
  font-size: 11px;
  color: hsl(152 20% 50%);
  font-style: italic;
  flex-shrink: 0;
}

/* Nav Items */
.an-items {
  display: flex;
  flex-direction: column;
  padding: 6px 10px 6px;
  gap: 3px;
  overflow-y: auto;
  flex: 1;
  scrollbar-width: thin;
}

.an-items::-webkit-scrollbar { width: 4px; }
.an-items::-webkit-scrollbar-thumb { background: hsl(152 40% 82%); border-radius: 2px; }

.an-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 10px;
  border-radius: 8px;
  text-decoration: none;
  color: hsl(210 20% 18%);
  font-size: 12.5px;
  font-weight: 600;
  transition: background 0.15s, transform 0.15s, color 0.15s;
  position: relative;
}

.an-item::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 8px;
  z-index: 0;
}

.an-item-icon,
.an-item-label,
.an-item-arrow {
  position: relative;
  z-index: 1;
}

.an-item:hover {
  transform: translateX(3px);
}

/* Colour modifiers */
.an-item--green  .an-item-icon { background: hsl(152 58% 93%); color: var(--an-green); }
.an-item--green::before        { background: hsl(152 58% 96%); }
.an-item--green:hover          { color: var(--an-green); }

.an-item--teal   .an-item-icon { background: hsl(170 45% 92%); color: var(--an-teal); }
.an-item--teal::before         { background: hsl(170 45% 95%); }
.an-item--teal:hover           { color: var(--an-teal); }

.an-item--gold   .an-item-icon { background: hsl(40 80% 92%); color: hsl(40 80% 38%); }
.an-item--gold::before         { background: hsl(40 80% 96%); }
.an-item--gold:hover           { color: hsl(40 80% 38%); }

.an-item--blue   .an-item-icon { background: hsl(215 70% 93%); color: var(--an-blue); }
.an-item--blue::before         { background: hsl(215 70% 96%); }
.an-item--blue:hover           { color: var(--an-blue); }

.an-item--purple .an-item-icon { background: hsl(262 52% 93%); color: var(--an-purple); }
.an-item--purple::before       { background: hsl(262 52% 96%); }
.an-item--purple:hover         { color: var(--an-purple); }

.an-item--red    .an-item-icon { background: hsl(0 72% 93%); color: var(--an-red); }
.an-item--red::before          { background: hsl(0 72% 95%); }
.an-item--red:hover            { color: var(--an-red); }

.an-item--orange .an-item-icon { background: hsl(30 80% 93%); color: var(--an-orange); }
.an-item--orange::before       { background: hsl(30 80% 95%); }
.an-item--orange:hover         { color: var(--an-orange); }

.an-item--pink   .an-item-icon { background: hsl(330 70% 93%); color: var(--an-pink); }
.an-item--pink::before         { background: hsl(330 70% 95%); }
.an-item--pink:hover           { color: var(--an-pink); }

.an-item-icon {
  width: 30px;
  height: 30px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: transform 0.15s;
}

.an-item:hover .an-item-icon { transform: scale(1.08); }

.an-item-label { flex: 1; line-height: 1.3; }

.an-item-arrow {
  color: currentColor;
  opacity: 0;
  transform: translateX(-4px);
  transition: opacity 0.15s, transform 0.15s;
  flex-shrink: 0;
}

.an-item:hover .an-item-arrow { opacity: 0.6; transform: translateX(0); }

/* Drawer Footer */
.an-drawer-footer {
  padding: 10px 12px 12px;
  flex-shrink: 0;
  border-top: 1px solid hsl(152 40% 92%);
}

.an-footer-cta {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  width: 100%;
  padding: 9px 12px;
  background: var(--an-green);
  color: #fff;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 700;
  text-decoration: none;
  letter-spacing: 0.02em;
  transition: background 0.18s, transform 0.18s;
}

.an-footer-cta:hover { background: hsl(152 58% 20%); transform: translateY(-1px); }

/* Gold accent line */
.an-panel::after {
  content: '';
  position: absolute;
  bottom: -2px;
  width: var(--an-tab-w);
  height: 3px;
  background: var(--an-gold);
  pointer-events: none;
}

.an-panel--left::after {
  left: 0;
  border-radius: 0 0 4px 0;
}

.an-panel--right::after {
  right: 0;
  border-radius: 0 0 0 4px;
}

/* ───────────────────────────────────────────────────────────────
   MOBILE BUTTON
─────────────────────────────────────────────────────────────────*/
.an-mobile-btn {
  display: none;
  position: fixed;
  bottom: 24px;
  left: 20px;
  z-index: 9000;
  align-items: center;
  gap: 7px;
  padding: 11px 18px 11px 14px;
  background: var(--an-green);
  color: #fff;
  border: none;
  border-radius: 50px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 4px 20px hsl(152 58% 20% / 0.4);
  border-left: 4px solid var(--an-gold);
}

.an-mobile-btn:hover {
  transform: translateY(-2px);
}

/* MOBILE BOTTOM SHEET */
.an-mobile-sheet {
  display: none;
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 9500;
  background: #fff;
  border-radius: 20px 20px 0 0;
  box-shadow: 0 -8px 40px rgba(0,0,0,0.14);
  border-top: 3px solid var(--an-green);
  padding-bottom: env(safe-area-inset-bottom, 16px);
  transform: translateY(100%);
  transition: transform 0.32s cubic-bezier(0.4, 0, 0.2, 1);
}

.an-mobile-sheet.an-sheet-open {
  transform: translateY(0);
}

.an-sheet-handle {
  width: 38px;
  height: 4px;
  background: hsl(0 0% 85%);
  border-radius: 2px;
  margin: 10px auto 0;
}

.an-sheet-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 16px 8px;
  border-bottom: 1px solid hsl(152 40% 90%);
}

.an-sheet-items {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  padding: 12px 16px;
}

.an-sheet-items .an-item {
  flex-direction: column;
  align-items: flex-start;
  padding: 12px 10px;
  border: 1px solid hsl(152 40% 90%);
  border-radius: 10px;
  gap: 8px;
}

.an-sheet-items .an-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.an-sheet-items .an-item-arrow { display: none; }
.an-sheet-items .an-item-label { font-size: 11.5px; flex: unset; }
.an-sheet-items .an-item-icon { width: 36px; height: 36px; }

/* BACKDROP */
.an-backdrop {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.45);
  z-index: 9400;
  backdrop-filter: blur(2px);
  opacity: 0;
  transition: opacity 0.25s ease;
}

.an-backdrop.an-backdrop-visible { opacity: 1; }

/* RESPONSIVE */
@media (min-width: 1024px) {
  .an-panel        { display: flex; }
  .an-mobile-btn   { display: none !important; }
  .an-mobile-sheet { display: none !important; }
  .an-backdrop     { display: none !important; }
}

@media (max-width: 1023px) {
  .an-panel        { display: none !important; }
  .an-mobile-btn   { display: flex; }
  .an-mobile-sheet { display: flex; flex-direction: column; }
  .an-backdrop     { display: block; }
}

@media (max-width: 500px) {
  .an-mobile-btn { bottom: 72px; left: 12px; padding: 10px 14px 10px 12px; font-size: 12px; }
}

@media (hover: hover) and (min-width: 1024px) {
  .an-panel:hover .an-drawer,
  .an-panel:focus-within .an-drawer {
    transform: translateX(0);
    opacity: 1;
    visibility: visible;
    transition: transform var(--an-transition), opacity var(--an-transition), visibility 0s linear 0s;
  }
}

@media (prefers-reduced-motion: reduce) {
  .an-drawer, .an-mobile-sheet, .an-mobile-btn, .an-tab, .an-footer-cta, .an-item, .an-backdrop {
    transition: none !important;
    animation: none !important;
  }
}
</style>


<!-- ================================================================
     JAVASCRIPT
================================================================ -->
<script>
(function () {
  'use strict';

  function $(id) { return document.getElementById(id); }
  function isMobile() { return window.innerWidth < 1024; }

  var panel    = $('applyPanel');
  var tab      = $('applyTab');
  var drawer   = $('applyDrawer');
  var closeBtn = $('applyClose');

  var mobileBtn      = $('applyMobileBtn');
  var mobileSheet    = $('applyMobileSheet');
  var mobileClose    = $('applySheetClose');
  var backdrop       = $('applyMobileBackdrop');

  /* DESKTOP */
  function desktopOpen() {
    if (!panel) return;
    panel.setAttribute('aria-expanded', 'true');
    if (drawer) drawer.setAttribute('aria-hidden', 'false');
    if (tab)    tab.setAttribute('aria-expanded', 'true');
  }

  function desktopClose() {
    if (!panel) return;
    panel.setAttribute('aria-expanded', 'false');
    if (drawer) drawer.setAttribute('aria-hidden', 'true');
    if (tab)    tab.setAttribute('aria-expanded', 'false');
  }

  function desktopToggle() {
    var isOpen = panel && panel.getAttribute('aria-expanded') === 'true';
    isOpen ? desktopClose() : desktopOpen();
  }

  if (tab) {
    tab.addEventListener('click', function (e) {
      e.stopPropagation();
      desktopToggle();
    });
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      desktopClose();
    });
  }

  if (panel) {
    panel.addEventListener('mouseenter', function () { if (!isMobile()) desktopOpen(); });
    panel.addEventListener('mouseleave', function () { if (!isMobile()) desktopClose(); });
    panel.addEventListener('focusin', function () { if (!isMobile()) desktopOpen(); });
    panel.addEventListener('focusout', function (e) {
      if (!isMobile() && !panel.contains(e.relatedTarget)) desktopClose();
    });
  }

  document.addEventListener('click', function (e) {
    if (!isMobile() && panel && !panel.contains(e.target)) { desktopClose(); }
  });

  /* MOBILE */
  function sheetOpen() {
    if (!mobileSheet || !backdrop) return;
    mobileSheet.style.display = 'flex';
    backdrop.style.display = 'block';
    void mobileSheet.offsetHeight;
    mobileSheet.classList.add('an-sheet-open');
    backdrop.classList.add('an-backdrop-visible');
    mobileSheet.setAttribute('aria-hidden', 'false');
    if (mobileBtn) mobileBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    var first = mobileSheet.querySelector('button, a[href]');
    if (first) setTimeout(function () { first.focus(); }, 50);
  }

  function sheetClose() {
    if (!mobileSheet || !backdrop) return;
    mobileSheet.classList.remove('an-sheet-open');
    backdrop.classList.remove('an-backdrop-visible');
    mobileSheet.setAttribute('aria-hidden', 'true');
    if (mobileBtn) mobileBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
    setTimeout(function () {
      if (!mobileSheet.classList.contains('an-sheet-open')) {
        mobileSheet.style.display = 'none';
        backdrop.style.display = 'none';
      }
    }, 340);
  }

  if (mobileBtn)   mobileBtn.addEventListener('click', sheetOpen);
  if (mobileClose) mobileClose.addEventListener('click', sheetClose);
  if (backdrop)    backdrop.addEventListener('click', sheetClose);

  if (mobileSheet) {
    mobileSheet.querySelectorAll('a[href]').forEach(function (a) {
      a.addEventListener('click', sheetClose);
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    if (isMobile()) { sheetClose(); } else { desktopClose(); }
  });

  if (window.lucide) { lucide.createIcons(); }

}());
</script>
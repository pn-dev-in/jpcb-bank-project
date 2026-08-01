<?php
/**
 * Products & Services Section
 * JPCB Bank — CMS-Compatible Expandable Cards
 * ─────────────────────────────────────────────────────────
 * THEME  : Uses JPCB custom.css design tokens exclusively.
 * FONTS  : Merriweather (heading) + Source Sans 3 (body)
 * DATA   : Expects $products array with: name, icon, features, href,
 *          intro, benefits, cta_apply, cta_details, cta_target
 * ─────────────────────────────────────────────────────────
 */
?>

<section id="products" class="section-padding" aria-labelledby="products-heading">
  <div class="container-bank">

    <!-- ── Section Header ── -->
    <div class="products-header">
      <h2 id="products-heading" class="products-title">
        <?= esc($productsSection['heading'] ?? 'Our Products & Services') ?>
      </h2>
      <p class="readable products-sub">
        <?= esc($productsSection['subheading'] ?? 'Comprehensive banking solutions for individuals, farmers, and businesses. Trusted by generations.') ?>
      </p>
    </div>

    <!-- ── Products Grid ── -->
    <div class="products-grid" id="products-grid" role="list">
      
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $index => $product): ?>
          
          <article class="bank-card-elevated product-card"
            role="listitem"
            tabindex="0"
            aria-expanded="false"
            data-product-card="<?= $index ?>"
            onclick="toggleProductCard(this)"
            onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();toggleProductCard(this);}"
            aria-label="<?= esc($product['name']) ?> — click to expand">

            <!-- ── Always-visible card header ── -->
            <div class="card-body">
              <div class="card-top-row">
                <div class="card-icon-title">
                  <div class="product-icon-wrap gradient-primary" aria-hidden="true">
                    <i data-lucide="<?= esc($product['icon'] ?? 'circle') ?>" class="product-icon-svg"></i>
                  </div>
                  <h3 class="card-title"><?= esc($product['name']) ?></h3>
                </div>
                <svg class="card-chevron" width="18" height="18" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </div>

              <!-- Features list -->
              <ul class="feature-list" aria-label="<?= esc($product['name']) ?> features">
                <?php foreach ($product['features'] as $feature): ?>
                  <li class="feature-item">
                    <span class="feature-dot" aria-hidden="true"></span>
                    <?= esc($feature) ?>
                  </li>
                <?php endforeach; ?>
              </ul>

              <!-- Collapsed hint -->
              <div class="collapse-hint" aria-hidden="true">
                <span>Explore</span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </div>
            </div>

            <!-- ── Expandable Panel ── -->
            <div class="expand-panel" id="expand-<?= $index ?>" aria-hidden="true">
              <div class="expand-inner">

                <!-- Intro paragraph -->
                <?php if (!empty($product['intro'])): ?>
                  <p class="expand-intro"><?= esc($product['intro']) ?></p>
                <?php endif; ?>

                <!-- Benefits list -->
                <?php if (!empty($product['benefits']) && is_array($product['benefits'])): ?>
                  <ul class="benefit-list" role="list" aria-label="Key benefits of <?= esc($product['name']) ?>">
                    <?php foreach ($product['benefits'] as $benefit): ?>
                      <li class="benefit-item" role="listitem">
                        <span class="benefit-check gradient-primary" aria-hidden="true">
                          <svg width="10" height="10" viewBox="0 0 12 12" fill="none">
                            <polyline points="2 6 5 9 10 3" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                          </svg>
                        </span>
                        <span class="benefit-text"><?= esc($benefit) ?></span>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>

                <!-- CTA Buttons -->
                <div class="cta-row">

                  <!-- Apply Now Button -->
                  <?php if (!empty($product['cta_apply'])): ?>
                    <a href="<?= esc($product['cta_apply']) ?>"
                       target="<?= esc($product['cta_target'] ?? '_self') ?>"
                       class="btn-primary cta-btn tap-target"
                       onclick="event.stopPropagation();"
                       rel="noopener noreferrer"
                       aria-label="Apply Now for <?= esc($product['name']) ?>">
                      Apply Now
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                      </svg>
                    </a>
                  <?php endif; ?>

                  <!-- View Details Button -->
                  <?php if (!empty($product['cta_details'])): ?>
                    <a href="<?= esc($product['cta_details']) ?>"
                       target="<?= esc($product['cta_target'] ?? '_self') ?>"
                       class="btn-outline cta-btn tap-target"
                       onclick="event.stopPropagation();"
                       rel="noopener noreferrer"
                       aria-label="View Details for <?= esc($product['name']) ?>">
                      View Details
                    </a>
                  <?php endif; ?>

                  <!-- Know More Link -->
                  <?php if (!empty($product['href'])): ?>
                    <a href="<?= esc($product['href']) ?>"
                       target="<?= esc($product['cta_target'] ?? '_self') ?>"
                       class="product-learn-more know-more-link tap-target"
                       onclick="event.stopPropagation();"
                       rel="noopener noreferrer"
                       aria-label="Know more about <?= esc($product['name']) ?>">
                      Know More
                      <i data-lucide="arrow-right" style="width:14px;height:14px;" aria-hidden="true"></i>
                    </a>
                  <?php endif; ?>

                </div>

              </div>
            </div>

          </article>

        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center" style="color: hsl(var(--muted-foreground));">No products found.</p>
      <?php endif; ?>

    </div>

  </div>
</section>

<style>
/* Products & Services — Section-scoped CSS */
.products-header {
  text-align: center;
  margin-bottom: 2.5rem;
}
@media (min-width: 768px) {
  .products-header { margin-bottom: 3rem; }
}

.products-title {
  font-family: var(--font-heading);
  font-size: clamp(1.5rem, 3.5vw, 2.25rem);
  font-weight: 700;
  color: hsl(var(--foreground));
  margin: 0 0 0.75rem;
  line-height: 1.25;
}

.products-sub {
  color: hsl(var(--muted-foreground));
  max-width: 600px;
  margin: 0 auto;
}

.products-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
}
@media (min-width: 640px) {
  .products-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 1024px) {
  .products-grid { grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
}

.product-card {
  cursor: pointer;
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: box-shadow 0.2s ease, transform 0.22s ease, border-color 0.2s ease;
}

.product-card::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 3px;
  background-color: hsl(var(--primary));
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.3s ease;
  border-radius: 0 0 var(--radius) var(--radius);
}

.product-card:hover {
  transform: translateY(-2px);
  border-color: hsl(var(--primary) / 0.25);
}
.product-card:hover::after { transform: scaleX(1); }

.product-card.is-active {
  border-color: hsl(var(--primary) / 0.35);
  box-shadow: 0 8px 24px 0 rgba(0,0,0,0.12);
  transform: translateY(-1px);
}
.product-card.is-active::after { transform: scaleX(1); }

.product-card:focus-visible {
  outline: none;
  box-shadow: 0 0 0 2px hsl(var(--background)), 0 0 0 4px hsl(var(--ring));
}

.card-body {
  padding: 1.5rem;
  flex: 1;
  display: flex;
  flex-direction: column;
}
@media (min-width: 768px) {
  .card-body { padding: 1.75rem; }
}

.card-top-row {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 0.75rem;
  margin-bottom: 1rem;
}
.card-icon-title {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  flex: 1;
}

.product-icon-wrap {
  width: 48px;
  height: 48px;
  border-radius: var(--radius);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 2px 8px hsl(var(--primary) / 0.25);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.product-card:hover .product-icon-wrap,
.product-card.is-active .product-icon-wrap {
  transform: scale(1.06);
  box-shadow: 0 4px 14px hsl(var(--primary) / 0.32);
}

.product-icon-svg {
  width: 22px;
  height: 22px;
  color: hsl(var(--primary-foreground));
}

.card-title {
  font-family: var(--font-heading);
  font-size: 1.0625rem;
  font-weight: 700;
  color: hsl(var(--foreground));
  line-height: 1.3;
  margin: 0;
  padding-top: 0.25rem;
}

.card-chevron {
  flex-shrink: 0;
  margin-top: 0.25rem;
  color: hsl(var(--muted-foreground));
  transition: transform 0.3s ease, color 0.2s ease;
}
.product-card.is-active .card-chevron {
  transform: rotate(180deg);
  color: hsl(var(--primary));
}

.feature-list {
  list-style: none;
  margin: 0 0 1rem;
  padding: 0;
  flex: 1;
}
.feature-item {
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;
  font-family: var(--font-body);
  font-size: 0.875rem;
  color: hsl(var(--muted-foreground));
  line-height: 1.55;
  margin-bottom: 0.375rem;
}
.feature-dot {
  width: 5px;
  height: 5px;
  border-radius: 9999px;
  background-color: hsl(var(--primary));
  flex-shrink: 0;
  margin-top: 0.45rem;
}

.collapse-hint {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  font-family: var(--font-body);
  font-size: 0.8125rem;
  font-weight: 600;
  color: hsl(var(--primary));
  margin-top: auto;
}

.expand-panel {
  max-height: 0;
  overflow: hidden;
  opacity: 0;
  transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
}
.expand-panel.is-open { opacity: 1; }

.expand-inner {
  border-top: 1px solid hsl(var(--border));
  padding: 1.25rem 1.5rem 1.5rem;
  animation: jpcbSlideDown 0.32s ease both;
}
@media (min-width: 768px) {
  .expand-inner { padding: 1.25rem 1.75rem 1.75rem; }
}

@keyframes jpcbSlideDown {
  from { opacity: 0; transform: translateY(-6px); }
  to   { opacity: 1; transform: translateY(0); }
}

.expand-intro {
  font-family: var(--font-body);
  font-size: 0.9375rem;
  color: hsl(var(--foreground));
  line-height: 1.7;
  margin: 0 0 1rem;
}

.benefit-list {
  list-style: none;
  margin: 0 0 1.25rem;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
.benefit-item {
  display: flex;
  align-items: flex-start;
  gap: 0.625rem;
  padding: 0.625rem 0.875rem;
  background-color: hsl(var(--primary) / 0.06);
  border: 1px solid hsl(var(--primary) / 0.12);
  border-radius: var(--radius);
}
.benefit-check {
  width: 20px;
  height: 20px;
  border-radius: 9999px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  margin-top: 1px;
}
.benefit-text {
  font-family: var(--font-body);
  font-size: 0.875rem;
  font-weight: 500;
  color: hsl(var(--foreground));
  line-height: 1.5;
}

.cta-row {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.625rem;
}

.cta-btn {
  font-size: 0.8125rem;
  padding: 0.5rem 1rem;
}

.know-more-link {
  display: inline-flex;
  align-items: center;
  font-family: var(--font-body);
  font-size: 0.8125rem;
  font-weight: 600;
  padding: 0.5rem 0.25rem;
  transition: gap 0.15s ease;
}
.know-more-link:hover { gap: 0.5rem; }

@media (max-width: 639px) {
  .card-body { padding: 1.25rem; }
  .expand-inner { padding: 1rem 1.25rem 1.25rem; }
  .cta-row { gap: 0.5rem; }
  .cta-btn { font-size: 0.75rem; padding: 0.4rem 0.75rem; }
}
</style>

<script>
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    if (typeof lucide !== 'undefined') lucide.createIcons();
  });

  window.toggleProductCard = function (card) {
    var index    = card.getAttribute('data-product-card');
    var panel    = document.getElementById('expand-' + index);
    var isActive = card.classList.contains('is-active');
    var allCards = document.querySelectorAll('[data-product-card]');

    allCards.forEach(function (c) {
      var i = c.getAttribute('data-product-card');
      var p = document.getElementById('expand-' + i);
      if (p) {
        p.style.maxHeight = '0px';
        p.classList.remove('is-open');
        p.setAttribute('aria-hidden', 'true');
      }
      c.classList.remove('is-active');
      c.setAttribute('aria-expanded', 'false');
      var hint = c.querySelector('.collapse-hint');
      if (hint) hint.style.display = '';
    });

    if (isActive) return;

    card.classList.add('is-active');
    card.setAttribute('aria-expanded', 'true');

    if (panel) {
      panel.classList.add('is-open');
      panel.setAttribute('aria-hidden', 'false');
      panel.style.maxHeight = panel.scrollHeight + 'px';
      if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    var activeHint = card.querySelector('.collapse-hint');
    if (activeHint) activeHint.style.display = 'none';

    if (window.innerWidth < 768) {
      setTimeout(function () {
        var offset = card.getBoundingClientRect().top + window.scrollY - 80;
        window.scrollTo({ top: offset, behavior: 'smooth' });
      }, 80);
    }
  };

  var resizeTimer;
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      var openPanel = document.querySelector('.expand-panel.is-open');
      if (openPanel) {
        openPanel.style.maxHeight = openPanel.scrollHeight + 'px';
      }
    }, 150);
  });

})();
</script>
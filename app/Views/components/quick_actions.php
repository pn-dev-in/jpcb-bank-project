<section class="section-padding section-alt" aria-labelledby="quick-actions-heading">
  <div class="container-bank">
    <!-- HEADING -->
    <div class="text-center mb-10">
      <h2 id="quick-actions-heading"
          class="font-heading text-3xl md:text-4xl mb-3"
          style="color: hsl(var(--foreground));">
        <?= esc($quickActionsSection['heading'] ?? 'What are you looking for?') ?>
      </h2>
      <p class="text-base"
         style="color: hsl(var(--muted-foreground));">
        <?= esc($quickActionsSection['subheading'] ?? 'Quick access to banking services & support') ?>
      </p>
    </div>

    <!-- TOP TABS -->
    <div class="quick-tabs-wrapper">
      <div class="quick-tabs">
        <?php foreach ($quickActions as $index => $action): ?>
          <?php
            $isActive = $index === 0;
            $isAlert = $action['is_alert'] ?? 0;
          ?>
          <button
              class="quick-tab-btn <?= $isActive ? 'active' : '' ?> <?= $isAlert ? 'quick-tab-alert' : '' ?>"
              data-tab="tab<?= $index ?>">
              <div class="quick-tab-icon <?= $isAlert ? 'quick-tab-icon-alert' : '' ?>">
                <i data-lucide="<?= esc($action['icon']) ?>"
                   class="w-6 h-6"></i>
              </div>
              <span>
                <?= esc($action['title']) ?>
              </span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- CONTENT -->
    <div class="quick-tab-content-wrapper">
      <?php foreach ($quickActions as $index => $action): ?>
        <?php $isActive = $index === 0; ?>
        <div
            class="quick-tab-content <?= $isActive ? 'active' : '' ?>"
            id="tab<?= $index ?>">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <!-- IMAGE - Fixed Size -->
                <div class="flex justify-center">
                    <?php if (!empty($action['image'])): ?>
                        <img src="<?= base_url($action['image']) ?>" 
                             alt="<?= esc($action['title']) ?>" 
                             class="quick-content-image"
                             style="width: 100%; max-width: 450px; height: 280px; object-fit: cover; border-radius: 16px;">
                    <?php else: ?>
                        <div class="quick-placeholder-image"
                             style="width: 100%; max-width: 450px; height: 280px; display: flex; align-items: center; justify-content: center; background: hsl(var(--primary) / 0.05); border-radius: 16px;">
                            <i data-lucide="<?= esc($action['icon']) ?>" class="w-16 h-16" style="color: hsl(var(--primary));"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- TEXT -->
                <div>
                    <h3 class="quick-content-title">
                        <?= esc($action['title']) ?>
                    </h3>
                    <p class="quick-content-desc">
                        <?= esc($action['description'] ?? 'Banking services designed for your convenience and financial growth.') ?>
                    </p>
                    <a href="<?= esc($action['link'] ?? '#') ?>"
                       class="quick-content-btn">
                        Know More
                        <i data-lucide="arrow-right"
                           class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<style>
/* =========================
   TABS
========================= */
.quick-tabs-wrapper {
    overflow-x: auto;
    margin-bottom: 0;
}
.quick-tabs {
    display: flex;
    gap: 14px;
    min-width: max-content;
    padding-bottom: 10px;
}
.quick-tab-btn {
    min-width: 145px;
    background: hsl(var(--background));
    border: 1px solid hsl(var(--border));
    border-radius: 18px 18px 0 0;
    padding: 16px 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: hsl(var(--foreground));
    position: relative;
}
.quick-tab-btn:hover {
    transform: translateY(-4px);
}
.quick-tab-btn.active {
    border-top: 5px solid hsl(var(--primary));
    background: hsl(var(--background));
    box-shadow: 0 -5px 25px rgba(0,0,0,0.05);
}
.quick-tab-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: hsl(var(--primary) / 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    color: hsl(var(--primary));
}
.quick-tab-btn.active .quick-tab-icon {
    background: hsl(var(--primary));
    color: white;
}
.quick-tab-btn span {
    font-size: 14px;
    font-weight: 600;
    text-align: center;
}

/* =========================
   CONTENT
========================= */
.quick-tab-content-wrapper {
    background: hsl(var(--background));
    border-radius: 0 16px 16px 16px;
    padding: 32px;
    border: 1px solid hsl(var(--border));
    box-shadow: 0 4px 14px rgba(0,0,0,0.04);
}
.quick-tab-content {
    display: none;
    animation: fadeTab 0.35s ease;
}
.quick-tab-content.active {
    display: block;
}
@keyframes fadeTab {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* =========================
   IMAGES - FIXED SIZE
========================= */
.quick-content-image {
    width: 100%;
    max-width: 450px;
    height: 280px;
    object-fit: cover;
    border-radius: 16px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.08);
}

.quick-placeholder-image {
    width: 100%;
    max-width: 450px;
    height: 280px;
    background: hsl(var(--primary) / 0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    color: hsl(var(--primary));
}

/* Responsive adjustments for smaller screens */
@media (max-width: 768px) {
    .quick-content-image,
    .quick-placeholder-image {
        height: 220px;
    }
}

@media (max-width: 640px) {
    .quick-content-image,
    .quick-placeholder-image {
        height: 200px;
    }
}

/* =========================
   TEXT STYLES
========================= */
.quick-content-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 16px;
    color: hsl(var(--foreground));
}
.quick-content-desc {
    font-size: 15px;
    line-height: 1.7;
    color: hsl(var(--muted-foreground));
    margin-bottom: 26px;
}
.quick-content-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: hsl(var(--primary));
    color: white;
    padding: 12px 18px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}
.quick-content-btn:hover {
    transform: translateY(-2px);
    opacity: 0.92;
}

/* =========================
   ALERT SUPPORT
========================= */
.quick-tab-alert {
    border-top: 4px solid #dc2626;
}
.quick-tab-alert.active {
    border-top: 5px solid #dc2626;
    box-shadow: 0 -5px 30px rgba(220,38,38,0.15);
}
.quick-tab-icon-alert {
    background: rgba(220,38,38,0.08);
    color: #dc2626;
}
.quick-tab-alert.active .quick-tab-icon-alert {
    background: #dc2626;
    color: white;
}
.quick-alert-badge {
    margin-top: 4px;
    background: rgba(220,38,38,0.1);
    color: #dc2626;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 999px;
}

/* =========================
   MOBILE RESPONSIVE
========================= */
@media (max-width: 768px) {
    .quick-tab-btn {
        min-width: 130px;
        padding: 14px 12px;
    }
    .quick-tab-content-wrapper {
        padding: 24px;
        border-radius: 0 18px 18px 18px;
    }
    .quick-tab-btn,
    .quick-tab-content-wrapper {
        transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
    }
    .quick-content-title {
        font-size: 26px;
    }
    .quick-content-desc {
        font-size: 15px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.quick-tab-btn');
    const tabContents = document.querySelectorAll('.quick-tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            const target = this.dataset.tab;
            
            // REMOVE ACTIVE
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            tabContents.forEach(content => {
                content.classList.remove('active');
            });
            
            // ADD ACTIVE
            this.classList.add('active');
            document.getElementById(target).classList.add('active');
            
            // Re-initialize Lucide icons after tab change
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    });
});
</script>
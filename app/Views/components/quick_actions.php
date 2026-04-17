<section class="section-padding section-alt" aria-labelledby="quick-actions-heading">
  <div class="container-bank">
    <div class="text-center mb-8">
      <h2 id="quick-actions-heading" class="font-heading text-2xl md:text-3xl mb-2" style="color: hsl(var(--foreground));">
        <?= esc($quickActionsSection['heading'] ?? 'Quick Actions') ?>
      </h2>
      <p style="color: hsl(var(--muted-foreground));">
        <?= esc($quickActionsSection['subheading'] ?? 'Frequently used banking services at your fingertips') ?>
      </p>
    </div>

    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 md:gap-4">
      <?php foreach ($quickActions as $action): ?>
        <?php $isAlert = $action['is_alert'] ?? 0; ?>
        <a href="<?= esc($action['link'] ?? '#') ?>"
           class="bank-card p-3 md:p-4 text-center group tap-target flex flex-col items-center justify-center quick-action-card<?= $isAlert ? ' quick-action-alert' : '' ?>"
           aria-label="<?= esc($action['title']) ?>: <?= esc($action['description'] ?? '') ?>">

          <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center mb-2 transition-colors quick-action-icon<?= $isAlert ? ' quick-action-icon-alert' : '' ?>">
            <i data-lucide="<?= esc($action['icon']) ?>" class="w-5 h-5 md:w-6 md:h-6 quick-action-svg<?= $isAlert ? ' quick-action-svg-alert' : '' ?>"></i>
          </div>

          <h3 class="font-semibold text-xs md:text-sm leading-tight" style="color: hsl(var(--foreground));"><?= esc($action['title']) ?></h3>
          <p class="text-[10px] md:text-xs mt-0.5 hidden sm:block" style="color: hsl(var(--muted-foreground));"><?= esc($action['description'] ?? '') ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
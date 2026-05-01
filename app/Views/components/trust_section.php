<section id="trust" class="section-padding section-alt" aria-labelledby="trust-heading">
  <div class="container-bank">
    <div class="text-center mb-10 md:mb-14">
      <h2 id="trust-heading" class="font-heading text-2xl md:text-3xl lg:text-4xl mb-3" style="color: hsl(var(--foreground));">
        <?= esc($trustSection['heading']) ?>
      </h2>
      <p class="readable max-w-2xl mx-auto" style="color: hsl(var(--muted-foreground));">
        <?= esc($trustSection['subheading']) ?>
      </p>
    </div>

    <!-- Stats Grid -->
    <div class="flex justify-between items-center gap-6 mb-10 w-full">
  <?php foreach ($trustStats as $stat): ?>
    <?php if (!empty($stat['link'])): ?>
      <a href="<?= esc($stat['link']) ?>" target="_blank" rel="noopener noreferrer" class="text-center flex-1 min-w-[120px] block transition-transform hover:scale-105">
    <?php else: ?>
      <div class="text-center flex-1 min-w-[120px]">
    <?php endif; ?>
    
    <div class="w-14 h-14 md:w-16 md:h-16 rounded-full gradient-primary flex items-center justify-center mx-auto mb-3">
      <i data-lucide="<?= esc($stat['icon']) ?>" class="w-7 h-7 md:w-8 md:h-8" style="color: hsl(var(--primary-foreground));"></i>
    </div>
    <div class="font-heading text-2xl md:text-3xl font-bold" style="color: hsl(var(--primary));">
      <?= esc($stat['value']) ?>
    </div>
    <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));">
      <?= esc($stat['label']) ?>
    </p>

    <?php if (!empty($stat['link'])): ?>
      </a>
    <?php else: ?>
      </div>
    <?php endif; ?>
  <?php endforeach; ?>
</div>

    <!-- Accessibility card -->
    <div class="bank-card p-6 md:p-8 mb-8">
      <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0"
             style="background-color: hsl(var(--primary) / 0.1);">
          <i data-lucide="accessibility" class="w-6 h-6" style="color: hsl(var(--primary));"></i>
        </div>
        <div class="flex-1">
          <h3 class="font-heading text-lg mb-1" style="color: hsl(var(--foreground));"><?= esc($trustAccessibility['heading']) ?></h3>
          <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($trustAccessibility['description']) ?></p>
        </div>
        <a href="<?= site_url($trustAccessibility['button_link']) ?>" class="btn-outline text-sm py-2 px-4 flex-shrink-0">
          <?= esc($trustAccessibility['button_text']) ?>
        </a>
      </div>
    </div>

    <!-- Regulatory badge -->
    <div class="bank-card p-6 text-center max-w-2xl mx-auto">
      <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));"><?= esc($trustRegulatory['description']) ?></p>
      <div class="flex flex-wrap items-center justify-center gap-3">
        <?php foreach ($trustBadges as $badge): ?>
          <span class="trust-badge">
            <i data-lucide="<?= esc($badge['icon']) ?>" class="w-4 h-4" style="color: hsl(var(--<?= $badge['color_class'] ?? 'primary' ?>));"></i>
            <?= esc($badge['label']) ?>
          </span>
        <?php endforeach; ?>
      </div>
      <p class="text-xs mt-3" style="color: hsl(var(--muted-foreground));"><?= esc($trustRegulatory['disclaimer']) ?></p>
    </div>

  </div>
</section>
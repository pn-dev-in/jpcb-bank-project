<section id="safety" class="section-padding" aria-labelledby="safety-heading" style="background-color: hsl(var(--background));">
  <div class="container-bank">
    <div class="bank-card-elevated p-6 md:p-10" style="border-color: hsl(var(--destructive) / 0.3);">
      <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6 lg:gap-10">

        <!-- Alert icon -->
        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center flex-shrink-0"
             style="background-color: hsl(var(--destructive) / 0.1);">
          <i data-lucide="shield-alert" class="w-8 h-8 md:w-10 md:h-10" style="color: hsl(var(--destructive));"></i>
        </div>

        <div class="flex-1">
          <h2 id="safety-heading" class="font-heading text-xl md:text-2xl lg:text-3xl mb-3" style="color: hsl(var(--foreground));">
            <?= esc($safetySection['heading']) ?>
          </h2>

          <div class="rounded-lg p-4 mb-4 border" style="background-color: hsl(var(--destructive) / 0.1); border-color: hsl(var(--destructive) / 0.2);">
            <p class="font-semibold text-lg" style="color: hsl(var(--foreground));">
              <?= esc($safetySection['warning_text']) ?>
            </p>
          </div>

          <p class="readable mb-4" style="color: hsl(var(--muted-foreground));">
            <?= esc($safetySection['description']) ?>
          </p>

          <div class="flex flex-wrap gap-3">
            <a href="<?= site_url($safetySection['button1_link']) ?>" class="btn-outline flex items-center gap-2 text-sm">
              <i data-lucide="file-warning" class="w-4 h-4" aria-hidden="true"></i><?= esc($safetySection['button1_text']) ?>
            </a>
            <a href="<?= esc($safetySection['button2_link']) ?>" class="btn-secondary flex items-center gap-2 text-sm">
              <i data-lucide="phone" class="w-4 h-4" aria-hidden="true"></i><?= esc($safetySection['button2_text']) ?>
            </a>
            <a href="<?= esc($safetySection['button3_link']) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 font-medium tap-target text-sm" style="color: hsl(var(--destructive));">
              <?= esc($safetySection['button3_text']) ?> <i data-lucide="external-link" class="w-4 h-4" aria-hidden="true"></i>
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
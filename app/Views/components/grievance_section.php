<section id="grievance" class="section-padding section-alt" aria-labelledby="grievance-heading">
  <div class="container-bank">
    <div class="text-center mb-10 md:mb-14">
      <h2 id="grievance-heading" class="font-heading text-2xl md:text-3xl lg:text-4xl mb-3" style="color: hsl(var(--foreground));">
        <?= esc($grievanceSection['heading']) ?>
      </h2>
      <p class="readable max-w-2xl mx-auto" style="color: hsl(var(--muted-foreground));">
        <?= esc($grievanceSection['subheading']) ?>
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
      <?php foreach ($grievanceSteps as $index => $item): ?>
        <!-- rest of the loop remains exactly the same -->
        <article class="bank-card-elevated p-6 md:p-8 relative">
          <div class="absolute -top-3 -left-3 w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg"
               style="background-color: hsl(var(--primary)); color: hsl(var(--primary-foreground));">
            <?= esc((string)$item['step']) ?>
          </div>

          <?php if ($index < count($grievanceSteps) - 1): ?>
            <div class="hidden md:block absolute top-1/2 -right-5 -translate-y-1/2 z-10">
              <i data-lucide="arrow-right" class="w-8 h-8" style="color: hsl(var(--primary) / 0.3);" aria-hidden="true"></i>
            </div>
          <?php endif; ?>

          <div class="pt-4">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-4"
                 style="background-color: hsl(var(--primary) / 0.1);">
              <i data-lucide="<?= esc($item['icon']) ?>" class="w-6 h-6" style="color: hsl(var(--primary));"></i>
            </div>
            <h3 class="font-heading text-lg md:text-xl mb-2" style="color: hsl(var(--foreground));"><?= esc($item['title']) ?></h3>
            <p class="readable text-sm mb-4" style="color: hsl(var(--muted-foreground));"><?= esc($item['description']) ?></p>

            <div class="rounded-lg px-3 py-2 text-sm mb-4"
                 style="background-color: hsl(var(--muted)); color: hsl(var(--muted-foreground));">
              ⏱️ <?= esc($item['timeline']) ?>
            </div>

            <a href="<?= esc($item['href']) ?>"
               class="inline-flex items-center gap-2 font-medium tap-target text-sm"
               style="color: hsl(var(--primary));"
               <?= $item['external'] ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>
              <?= esc($item['action']) ?>
              <?php if ($item['external']): ?>
                <i data-lucide="external-link" class="w-4 h-4" aria-hidden="true"></i>
              <?php else: ?>
                <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
              <?php endif; ?>
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

  </div>
</section>
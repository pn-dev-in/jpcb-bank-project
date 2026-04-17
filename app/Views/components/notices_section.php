<section id="notices" class="section-padding section-alt" aria-labelledby="notices-heading">
  <div class="container-bank">
    
    <!-- Scrolling Ticker -->
    <div class="rounded-lg p-3 mb-8 overflow-hidden" style="background-color: hsl(var(--primary) / 0.1);" role="marquee" aria-label="Important announcements">
      <div class="flex items-center gap-4">
        <span class="flex-shrink-0 px-3 py-1 rounded text-sm font-semibold"
              style="background-color: hsl(var(--primary)); color: hsl(var(--primary-foreground));">
          Updates
        </span>
        <div class="overflow-hidden flex-1">
          <div class="ticker-animate whitespace-nowrap flex gap-16">
            <?php foreach (array_merge($ticker, $ticker) as $item): ?>
              <span style="color: hsl(var(--foreground));">• <?= esc($item) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Header row -->
    <div class="flex items-center justify-between mb-8">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: hsl(var(--secondary));">
          <i data-lucide="bell" class="w-5 h-5" style="color: hsl(var(--secondary-foreground));"></i>
        </div>
        <h2 id="notices-heading" class="font-heading text-2xl md:text-3xl" style="color: hsl(var(--foreground));">
          Important Notices
        </h2>
      </div>
      <a href="#all-notices" class="font-medium tap-target hidden sm:inline-flex items-center gap-1" style="color: hsl(var(--primary));">
        View all <i data-lucide="external-link" class="w-4 h-4" aria-hidden="true"></i>
      </a>
    </div>

    <!-- Notice list -->
    <div class="space-y-3">

<?php if(!empty($notices)): ?>

    <?php foreach ($notices as $notice): ?>

        <a href="#"
           class="bank-card p-4 md:p-5 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6 transition-colors tap-target block notice-item">

            <!-- DATE -->
            <div class="flex items-center gap-2 text-sm flex-shrink-0"
                 style="color: hsl(var(--muted-foreground));">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <time><?= date('d M Y', strtotime($notice['date'])) ?></time>
            </div>

            <!-- CONTENT -->
            <div class="flex-1">

                <!-- TYPE BADGE -->
                <span class="inline-block text-xs px-2 py-0.5 rounded mb-1"
                      style="background-color: hsl(var(--muted)); color: hsl(var(--muted-foreground));">
                    <?= esc($notice['type']) ?>
                </span>

                <!-- TITLE -->
                <p class="font-medium text-sm md:text-base"
                   style="color: hsl(var(--foreground));">
                    <?= esc($notice['title']) ?>
                </p>

            </div>

            <!-- ARROW ICON -->
            <i data-lucide="arrow-right"
               class="w-5 h-5 hidden sm:block flex-shrink-0"
               style="color: hsl(var(--primary));"></i>

        </a>

    <?php endforeach; ?>

<?php else: ?>

    <p>No notices available</p>

<?php endif; ?>

</div>

  </div>
</section>

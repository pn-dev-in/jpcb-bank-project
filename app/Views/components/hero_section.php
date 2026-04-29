<section id="home" class="relative overflow-hidden" aria-labelledby="hero-heading" style="background-color: hsl(var(--background));">
  <!-- Decorative blobs -->
  <div class="absolute inset-0" aria-hidden="true">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full blur-3xl translate-x-1/3 -translate-y-1/3" style="background-color: hsl(var(--primary) / 0.05);"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full blur-3xl -translate-x-1/3 translate-y-1/3" style="background-color: hsl(var(--secondary) / 0.05);"></div>
  </div>

  <div class="container-bank relative py-12 md:py-20 lg:py-24">
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
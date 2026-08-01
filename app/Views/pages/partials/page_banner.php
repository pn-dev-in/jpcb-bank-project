<div class="bg-primary text-primary-foreground">
  <div class="container-bank py-8 md:py-12">
    <?php if (! empty($breadcrumbs)): ?>
    <nav aria-label="Breadcrumb" class="mb-3">
      <ol class="flex flex-wrap items-center gap-1 text-sm" style="color: rgba(255,255,255,0.72);">
        <li><a href="<?= site_url('/') ?>" class="transition-colors" style="color: inherit;">Home</a></li>
        <?php foreach ($breadcrumbs as $breadcrumb): ?>
        <li class="flex items-center gap-1">
          <i data-lucide="chevron-right" class="w-3 h-3" aria-hidden="true"></i>
          <?php if (! empty($breadcrumb['href'])): ?>
          <a href="<?= site_url(ltrim($breadcrumb['href'], '/')) ?>" class="transition-colors" style="color: inherit;"><?= esc($breadcrumb['label']) ?></a>
          <?php else: ?>
          <span aria-current="page"><?= esc($breadcrumb['label']) ?></span>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ol>
    </nav>
    <?php endif; ?>

    <h1 class="font-heading text-2xl md:text-4xl font-bold"><?= esc($title) ?></h1>
  </div>
</div>

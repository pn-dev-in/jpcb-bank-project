<?php
$downloadCategories = ['All', 'Forms', 'Policies', 'Reports', 'Notices', 'Secured Assets'];
$downloadSearch = trim($query['q'] ?? '');
$downloadCategory = $query['category'] ?? 'All';

if (!in_array($downloadCategory, $downloadCategories, true)) {
  $downloadCategory = 'All';
}

$filteredDownloads = array_values(array_filter($allDownloads ?? [], function ($doc) use ($downloadSearch, $downloadCategory) {
  $matchesSearch = $downloadSearch === '' || str_contains(strtolower($doc['title'] . ' ' . $doc['category']), strtolower($downloadSearch));
  $matchesCategory = $downloadCategory === 'All' || $doc['category'] === $downloadCategory;
  return $matchesSearch && $matchesCategory;
}));
?>

<section class="section-padding bg-background">
  <div class="container-bank">
    <div class="flex flex-col md:flex-row gap-4 mb-8">
      <form method="get" action="<?= current_url() ?>" class="relative flex-1">
        <?php if ($downloadCategory !== 'All'): ?>
          <input type="hidden" name="category" value="<?= esc($downloadCategory) ?>">
        <?php endif; ?>
        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" style="color: hsl(var(--muted-foreground));"></i>
        <input type="search" name="q" value="<?= esc($downloadSearch) ?>" placeholder="Search forms, policies, reports..." class="w-full pl-10 pr-4 py-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));">
      </form>

      <div class="flex flex-wrap gap-2">
        <?php foreach ($downloadCategories as $category): ?>
          <?php
          $params = [];
          if ($downloadSearch !== '') $params['q'] = $downloadSearch;
          if ($category === 'All') {
            $params['category'] = 'All';
          } else {
            $params['category'] = $category;
          }
          $href = current_url() . ($params ? '?' . http_build_query($params) : '');
          ?>
          <a href="<?= esc($href) ?>"
            class="px-4 py-2 rounded-full text-sm font-medium transition-colors tap-target <?= $downloadCategory === $category ? 'bg-primary text-primary-foreground' : 'bg-muted' ?>"
            style="<?= $downloadCategory === $category ? '' : 'color: hsl(var(--muted-foreground));' ?>">
            <?= esc($category) ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));"><?= count($filteredDownloads) ?> document(s)</p>

    <div class="space-y-2">
      <?php foreach ($filteredDownloads as $doc): ?>
        <div class="bank-card p-4 flex items-center justify-between gap-4">
          <div class="flex items-center gap-3 flex-1 min-w-0">
            <i data-lucide="file-text" class="w-8 h-8 text-primary flex-shrink-0"></i>
            <div class="min-w-0">
              <h3 class="font-medium text-foreground text-sm truncate"><?= esc($doc['title']) ?></h3>
              <div class="flex flex-wrap items-center gap-3 text-xs" style="color: hsl(var(--muted-foreground));">
                <span><?= esc($doc['category']) ?></span>
                <span><?= esc($doc['file_type']) ?></span>
                <span><?= esc(number_format($doc['file_size'] / 1024, 1) . ' KB') ?></span>
                <span>Updated: <?= esc(date('d M Y', strtotime($doc['updated_date']))) ?></span>
              </div>
            </div>
          </div>
          <a href="<?= base_url($doc['file_path']) ?>" download class="btn-outline text-xs flex items-center gap-1 flex-shrink-0">
            <i data-lucide="download" class="w-3 h-3"></i> Download
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
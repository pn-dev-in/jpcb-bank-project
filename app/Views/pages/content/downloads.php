<?php
$documents = [
    ['name' => 'Account Opening Form (Individual)', 'category' => 'Forms', 'type' => 'PDF', 'size' => '245 KB', 'updated' => '2026-01-15'],
    ['name' => 'Account Opening Form (Entity / Trust)', 'category' => 'Forms', 'type' => 'PDF', 'size' => '312 KB', 'updated' => '2026-01-15'],
    ['name' => 'KYC Update Form', 'category' => 'Forms', 'type' => 'PDF', 'size' => '156 KB', 'updated' => '2025-12-01'],
    ['name' => 'RTGS / NEFT Application Form', 'category' => 'Forms', 'type' => 'PDF', 'size' => '198 KB', 'updated' => '2025-10-20'],
    ['name' => 'Locker Application Form', 'category' => 'Forms', 'type' => 'PDF', 'size' => '180 KB', 'updated' => '2025-09-15'],
    ['name' => 'Positive Pay Mandate Form', 'category' => 'Forms', 'type' => 'PDF', 'size' => '120 KB', 'updated' => '2025-11-01'],
    ['name' => 'DEAF Claim Form', 'category' => 'Forms', 'type' => 'PDF', 'size' => '165 KB', 'updated' => '2025-08-20'],
    ['name' => 'Loan Application Form', 'category' => 'Forms', 'type' => 'PDF', 'size' => '290 KB', 'updated' => '2026-02-01'],
    ['name' => 'Insurance Enrolment Form (PMSBY / PMJJBY)', 'category' => 'Forms', 'type' => 'PDF', 'size' => '140 KB', 'updated' => '2025-04-01'],
    ['name' => 'Deposit Interest Rate Schedule', 'category' => 'Policies', 'type' => 'PDF', 'size' => '95 KB', 'updated' => '2026-04-01'],
    ['name' => 'Service Charges Schedule', 'category' => 'Policies', 'type' => 'PDF', 'size' => '112 KB', 'updated' => '2026-04-01'],
    ['name' => 'Fair Practice Code', 'category' => 'Policies', 'type' => 'PDF', 'size' => '340 KB', 'updated' => '2025-06-15'],
    ['name' => 'Grievance Redressal Policy', 'category' => 'Policies', 'type' => 'PDF', 'size' => '220 KB', 'updated' => '2025-06-15'],
    ['name' => 'Cheque Collection Policy', 'category' => 'Policies', 'type' => 'PDF', 'size' => '185 KB', 'updated' => '2025-06-15'],
    ['name' => 'Privacy Policy', 'category' => 'Policies', 'type' => 'PDF', 'size' => '210 KB', 'updated' => '2025-06-15'],
    ['name' => 'Locker Policy', 'category' => 'Policies', 'type' => 'PDF', 'size' => '175 KB', 'updated' => '2025-09-01'],
    ['name' => 'Annual Report 2024-25', 'category' => 'Reports', 'type' => 'PDF', 'size' => '4.2 MB', 'updated' => '2025-09-30'],
    ['name' => 'Annual Report 2023-24', 'category' => 'Reports', 'type' => 'PDF', 'size' => '3.8 MB', 'updated' => '2024-09-30'],
    ['name' => 'Annual Report 2022-23', 'category' => 'Reports', 'type' => 'PDF', 'size' => '3.5 MB', 'updated' => '2023-09-30'],
    ['name' => 'Board Election Notice 2026', 'category' => 'Notices', 'type' => 'PDF', 'size' => '85 KB', 'updated' => '2026-03-15'],
    ['name' => 'Service Advisory - UPI Limit Change', 'category' => 'Notices', 'type' => 'PDF', 'size' => '45 KB', 'updated' => '2026-03-01'],
    ['name' => 'SARFAESI Notice - Property XYZ', 'category' => 'Secured Assets', 'type' => 'PDF', 'size' => '120 KB', 'updated' => '2026-02-20'],
];

$downloadCategories = ['All', 'Forms', 'Policies', 'Reports', 'Notices', 'Secured Assets'];
$downloadSearch = trim((string) ($query['q'] ?? ''));
$downloadCategory = (string) ($query['category'] ?? ($defaultCategory ?? 'All'));

if (! in_array($downloadCategory, $downloadCategories, true)) {
    $downloadCategory = 'All';
}

$filteredDocuments = array_values(array_filter($documents, static function (array $document) use ($downloadSearch, $downloadCategory): bool {
    $matchesSearch = $downloadSearch === '' || str_contains(strtolower($document['name'] . ' ' . $document['category']), strtolower($downloadSearch));
    $matchesCategory = $downloadCategory === 'All' || $document['category'] === $downloadCategory;
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
        if ($downloadSearch !== '') {
            $params['q'] = $downloadSearch;
        }
        if ($category !== 'All') {
            $params['category'] = $category;
        }
        $href = current_url();
        if ($params !== []) {
            $href .= '?' . http_build_query($params);
        }
        ?>
        <a
          href="<?= esc($href) ?>"
          class="px-4 py-2 rounded-full text-sm font-medium transition-colors tap-target <?= $downloadCategory === $category ? 'bg-primary text-primary-foreground' : 'bg-muted' ?>"
          style="<?= $downloadCategory === $category ? '' : 'color: hsl(var(--muted-foreground));' ?>"
        ><?= esc($category) ?></a>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));"><?= count($filteredDocuments) ?> document(s)</p>

    <div class="space-y-2">
      <?php foreach ($filteredDocuments as $document): ?>
      <div class="bank-card p-4 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3 flex-1 min-w-0">
          <i data-lucide="file-text" class="w-8 h-8 text-primary flex-shrink-0"></i>
          <div class="min-w-0">
            <h3 class="font-medium text-foreground text-sm truncate"><?= esc($document['name']) ?></h3>
            <div class="flex flex-wrap items-center gap-3 text-xs" style="color: hsl(var(--muted-foreground));">
              <span><?= esc($document['category']) ?></span>
              <span><?= esc($document['type']) ?></span>
              <span><?= esc($document['size']) ?></span>
              <span>Updated: <?= esc($document['updated']) ?></span>
            </div>
          </div>
        </div>
        <button type="button" class="btn-outline text-xs flex items-center gap-1 flex-shrink-0"><i data-lucide="download" class="w-3 h-3"></i> Download</button>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
// Safety fallbacks – in case controller misses them
$categories = $categories ?? [];
$selectedCategorySlug = $selectedCategorySlug ?? 'all';
$filteredDownloads = $filteredDownloads ?? [];
?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <!-- Category Tabs -->
    <div class="flex flex-wrap gap-2 mb-8">
      <a href="<?= site_url('downloads/overview') ?>" class="px-4 py-2 rounded-full text-sm font-medium <?= $selectedCategorySlug === 'all' ? 'bg-primary text-primary-foreground' : 'bg-muted' ?>">
        All
      </a>
      <?php foreach ($categories as $cat): ?>
        <a href="<?= site_url('downloads/' . $cat['slug']) ?>" class="px-4 py-2 rounded-full text-sm font-medium <?= $selectedCategorySlug === $cat['slug'] ? 'bg-primary text-primary-foreground' : 'bg-muted' ?>">
          <?= esc($cat['name']) ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Downloads Grid -->
<?php if (!empty($filteredDownloads)): ?>
  <style>
    .dl-grid { display:grid; grid-template-columns:1fr; gap:1.5rem; }
    @media(min-width:640px)  { .dl-grid { grid-template-columns:repeat(2,1fr); } }
    @media(min-width:1024px) { .dl-grid { grid-template-columns:repeat(4,1fr); } }
    .dl-card { background:hsl(var(--background)); border:1px solid hsl(var(--border)); border-radius:1rem; overflow:hidden; transition:transform .2s,box-shadow .2s; }
    .dl-card:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(0,0,0,.1); }
    .dl-thumb {
    height:180px;
    overflow:hidden;
    background:hsl(var(--muted));
    display:flex;
    align-items:center;
    justify-content:center;
}
    .dl-thumb img {
    width:auto;
    height:100%;
    max-width:100%;
    object-fit:contain;
}
    .dl-card:hover .dl-thumb img { transform:scale(1.04); }
    .dl-thumb-placeholder { display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; gap:.5rem; color:hsl(var(--muted-foreground)); }
    .dl-body { padding:1rem 1.1rem 1.2rem; }
    .dl-title { display:flex; align-items:flex-start; gap:.5rem; font-size:.92rem; font-weight:600; color:hsl(var(--foreground)); line-height:1.4; margin-bottom:.5rem; }
    .dl-meta { font-size:.72rem; color:hsl(var(--muted-foreground)); margin-bottom:.75rem; }
    .dl-btn { display:inline-flex; align-items:center; gap:.35rem; font-size:.78rem; font-weight:700; color:hsl(var(--primary)); text-decoration:none; }
    .dl-btn:hover { opacity:.75; }
  </style>
  <div class="dl-grid">
    <?php foreach ($filteredDownloads as $doc): ?>
      <?php $pdfUrl = base_url($doc['file_path']); ?>
      <div class="dl-card">
        <!-- Thumbnail — clicking opens the PDF -->
        <a href="<?= $pdfUrl ?>" target="_blank" class="dl-thumb">
          <?php if (!empty($doc['thumbnail'])): ?>
            <img src="<?= base_url($doc['thumbnail']) ?>" alt="<?= esc($doc['title']) ?>">
          <?php else: ?>
            <div class="dl-thumb-placeholder">
              <i data-lucide="file-text" style="width:40px;height:40px;"></i>
              <span style="font-size:.7rem;">No Preview</span>
            </div>
          <?php endif; ?>
        </a>
        <div class="dl-body">
          <!-- Title with PDF icon -->
          <div class="dl-title">
            <i data-lucide="file-text" style="width:15px;height:15px;flex-shrink:0;margin-top:2px;color:hsl(var(--primary));"></i>
            <a href="<?= $pdfUrl ?>" target="_blank" style="color:inherit;text-decoration:none;">
              <?= esc($doc['title']) ?>
            </a>
          </div>
          <div class="dl-meta">
            <?= date('d M Y', strtotime($doc['updated_date'])) ?>
            · <?= round($doc['file_size'] / 1024) ?> KB
            · <?= esc($doc['file_type']) ?>
          </div>
          <!-- Download button -->
          <a href="<?= $pdfUrl ?>" class="dl-btn" target="_blank" download>
            <i data-lucide="download" style="width:13px;height:13px;"></i> Download
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <p class="text-center py-8 text-muted-foreground">No documents available in this category.</p>
<?php endif; ?>
  </div>
</section>
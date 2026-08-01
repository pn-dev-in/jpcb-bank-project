<?php
/* gallery.php — Photo Gallery ───────────────────────────────────────────── */
$galleryGradients = [
    'linear-gradient(135deg,hsl(var(--primary)/.18),hsl(var(--primary)/.05))',
    'linear-gradient(135deg,hsl(var(--secondary)/.18),hsl(var(--secondary)/.05))',
    'linear-gradient(135deg,hsl(var(--accent)/.18),hsl(var(--accent)/.05))',
    'linear-gradient(135deg,hsl(var(--primary)/.12),hsl(var(--secondary)/.08))',
];
$galleryIconColors = ['hsl(var(--primary)/.35)','hsl(var(--secondary)/.35)','hsl(var(--accent)/.35)','hsl(var(--primary)/.25)'];
$totalPhotos = 0;
foreach (($galleryItems ?? []) as $gi) {
    $totalPhotos += 1 + count($gi['sub_images'] ?? []);
}
?>
<style>
/* ── Gallery page ────────────────────────────────────────────────────────── */
.gl-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
}

@media (min-width: 640px) {
  .gl-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (min-width: 1024px) {
  .gl-grid { grid-template-columns: repeat(3, 1fr); }
}

.gl-img-wrap {
  height: 240px;
}

.gl-card {
  background: white;
  border-radius: 1.25rem;
  border: 1px solid #eee;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: all .25s ease;
  box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}

.gl-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 18px 40px rgba(0,0,0,0.12);
}


.gl-img-wrap {
  position: relative;
  width: 100%;
  height: 240px; /* 🔥 FIXED HEIGHT */
  overflow: hidden;
  cursor: pointer;
}

.gl-img-wrap > * { position: absolute; inset: 0; }
.gl-img-wrap img {
  width: 100%; height: 100%;
  object-fit: cover; }

.gl-card:hover .gl-img-wrap img { transform: scale(1.05); }
.gl-img-placeholder {
  display: flex; flex-direction: column;
  align-items: center; justify-content: center; gap: .75rem;
}

/* Filter pills */
.gl-pill {
  display: inline-flex; align-items: center; gap: .4rem;
  padding: .55rem 1.1rem; border-radius: 99px;
  font-size: .82rem; font-weight: 600;
  text-decoration: none; transition: all .2s ease;
}
.gl-pill-inactive {
  background: hsl(var(--muted)); color: hsl(var(--muted-foreground));
}
.gl-pill-active {
  background: linear-gradient(135deg,hsl(var(--primary)),hsl(var(--primary)/.8));
  color: white; box-shadow: 0 2px 10px hsl(var(--primary)/.3);
}

/* Lightbox */
#gl-lightbox {
  position: fixed; inset: 0; z-index: 9999;
  background: rgba(0,0,0,.93);
  backdrop-filter: blur(8px);
  display: none;
}
#gl-lightbox.open { display: flex; flex-direction: column; }
</style>

<!-- ── Hero ── (unchanged) -->
<section style="background:linear-gradient(150deg,hsl(var(--primary)) 0%,hsl(var(--primary)/.7) 50%,hsl(var(--accent)/.6) 100%);padding:4.5rem 0 3rem;">
  <div class="container-bank">
    <a href="<?= base_url('about') ?>" style="display:inline-flex;align-items:center;gap:.4rem;color:rgba(255,255,255,.6);font-size:.85rem;text-decoration:none;margin-bottom:1.5rem;">
      <i data-lucide="arrow-left" style="width:15px;height:15px;"></i> About Us
    </a>
    <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:2rem;">
      <div>
        <span style="display:inline-flex;align-items:center;gap:.5rem;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);padding:.35rem .9rem;border-radius:99px;margin-bottom:1.1rem;">
          <i data-lucide="images" style="width:13px;height:13px;"></i> Events &amp; Community
        </span>
        <h1 style="font-size:clamp(2rem,5vw,3.25rem);font-weight:700;color:white;line-height:1.15;margin:0 0 1rem;text-shadow:0 2px 16px rgba(0,0,0,.2);">Photo Gallery</h1>
        <p style="color:rgba(255,255,255,.78);font-size:1.05rem;line-height:1.72;max-width:520px;margin:0;">
          A growing collection of events, branch moments, awards, community outreach, and milestones captured through the years.
        </p>
      </div>
      <!-- Stats pill -->
      <div style="display:flex;align-items:center;gap:2.5rem;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:1.25rem;padding:1.25rem 2.25rem;flex-shrink:0;">
        <div style="text-align:center;">
          <div style="font-size:2.75rem;font-weight:700;color:white;line-height:1;"><?= count($galleryItems ?? []) ?>+</div>
          <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.6);margin-top:.3rem;">Albums</div>
        </div>
        <div style="width:1px;height:3rem;background:rgba(255,255,255,.25);"></div>
        <div style="text-align:center;">
          <div style="font-size:2.75rem;font-weight:700;color:white;line-height:1;"><?= $totalPhotos ?>+</div>
          <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.6);margin-top:.3rem;">Photos</div>
        </div>
        <div style="width:1px;height:3rem;background:rgba(255,255,255,.25);"></div>
        <div style="text-align:center;">
          <div style="font-size:2.75rem;font-weight:700;color:white;line-height:1;"><?= count($galleryCategories ?? []) ?></div>
          <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.6);margin-top:.3rem;">Categories</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Filter + Grid ──────────────────────────────────────────────────────── -->
<section class="section-padding bg-background">
  <div class="container-bank">

    <!-- Category filter pills (unchanged) -->
    <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:2.5rem;" role="tablist">
      <?php $isAll = $galleryCategorySlug === 'all'; ?>
      <a href="<?= base_url('about/gallery') ?>" class="gl-pill <?= $isAll ? 'gl-pill-active' : 'gl-pill-inactive' ?>" role="tab" aria-selected="<?= $isAll ? 'true' : 'false' ?>">
        <i data-lucide="grid-2x2" style="width:13px;height:13px;"></i> All
        <span style="font-size:.7rem;font-weight:700;padding:.15rem .5rem;border-radius:99px;background:rgba(255,255,255,.22);"><?= count($galleryItems ?? []) ?></span>
      </a>
      <?php foreach (($galleryCategories ?? []) as $cat): ?>
        <?php
          $isActive = $galleryCategorySlug === strtolower((string)$cat['slug']);
          $catCount = count(array_filter($galleryItems ?? [], fn($gi) => strtolower((string)($gi['category_slug'] ?? '')) === strtolower((string)$cat['slug'])));
        ?>
        <a href="<?= base_url('about/gallery') . '?category=' . rawurlencode($cat['slug']) ?>"
           class="gl-pill <?= $isActive ? 'gl-pill-active' : 'gl-pill-inactive' ?>"
           role="tab" aria-selected="<?= $isActive ? 'true' : 'false' ?>">
          <?= esc($cat['name']) ?>
          <?php if ($catCount > 0): ?>
            <span style="font-size:.7rem;font-weight:700;padding:.15rem .5rem;border-radius:99px;background:<?= $isActive ? 'rgba(255,255,255,.22)' : 'hsl(var(--border))' ?>;"><?= $catCount ?></span>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Count -->
    <p style="font-size:.85rem;color:hsl(var(--muted-foreground));margin-bottom:1.5rem;">
      Showing <strong style="color:hsl(var(--foreground));"><?= count($filteredGalleryItems) ?></strong> album<?= count($filteredGalleryItems) !== 1 ? 's' : '' ?><?= $galleryCategorySlug !== 'all' ? ' in this category' : '' ?>
    </p>

    <!-- ========== UNIFORM GALLERY GRID (NO SEPARATE FEATURED SECTION) ========== -->
    <div class="gl-grid">
      <?php if (!empty($filteredGalleryItems)): ?>
        <?php foreach ($filteredGalleryItems as $gi => $item): ?>
          <?php
            // Determine if this item should be marked as "featured"
            // First item becomes featured (adjust as needed)
            $isFeatured = ($gi === 0);

            // Build list of all images (main + sub) for lightbox
            $allImages = [];
            if (!empty($item['image'])) $allImages[] = ['path' => $item['image'], 'title' => $item['title']];
            foreach (($item['sub_images'] ?? []) as $sub) {
                if (!empty($sub['image_path'])) $allImages[] = ['path' => $sub['image_path'], 'title' => $sub['title'] ?? $item['title']];
            }
            $imageCount = count($allImages);
            $iconColor = $galleryIconColors[$gi % count($galleryIconColors)];
          ?>
          <article class="gl-card">
            <!-- MAIN IMAGE BUTTON: keeps .gallery-preview to open lightbox -->
            <button type="button" class="gl-img-wrap gallery-preview" data-gallery-id="<?= (int)$item['id'] ?>" aria-label="Open <?= esc($item['title']) ?> gallery" style="width:100%;border:none;padding:0;cursor:pointer;">
              <!-- Placeholder if no images exist -->
              <?php if (empty($allImages)): ?>
                <div class="gl-img-placeholder">
                  <i data-lucide="image" style="width:52px;height:52px;"></i>
                  <span style="font-size:.7rem;font-weight:600;color:hsl(var(--muted-foreground));">
                    <?= esc($item['category_name'] ?? 'Gallery') ?>
                  </span>
                </div>
              <?php endif; ?>
              <!-- Main image with unique ID for thumbnail swapping -->
              <img 
                id="main-image-<?= (int)$item['id'] ?>"
                src="<?= $mediaUrl($allImages[0]['path']) ?>" 
                alt="<?= esc($item['title']) ?>"
                loading="lazy"
                style="opacity:0;transition:opacity .3s ease;"
                onload="this.style.opacity='1'" 
                onerror="this.style.display='none'"
              >
              <!-- Photo count badge -->
              <?php if ($imageCount > 1 && !$isFeatured): ?>
                <div style="position:absolute;top:.75rem;right:.75rem;">
                  <span style="display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .65rem;border-radius:99px;font-size:.65rem;font-weight:700;color:white;background:rgba(0,0,0,.6);backdrop-filter:blur(4px);">
                    <i data-lucide="images" style="width:11px;height:11px;"></i> <?= $imageCount ?>
                  </span>
                </div>
              <?php elseif ($imageCount > 1 && $isFeatured): ?>
                <div style="position:absolute;bottom:.75rem;left:.75rem;">
                  <span style="display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .65rem;border-radius:99px;font-size:.65rem;font-weight:700;color:white;background:rgba(0,0,0,.6);backdrop-filter:blur(4px);">
                    <i data-lucide="images" style="width:11px;height:11px;"></i> <?= $imageCount ?>
                  </span>
                </div>
              <?php endif; ?>
            </button>

            <!-- Card body -->
            <div style="padding:1.5rem;flex:1;display:flex;flex-direction:column;">
              <div style="display:flex;align-items:center;gap:.9rem;font-size:.75rem;color:hsl(var(--muted-foreground));margin-bottom:.65rem;flex-wrap:wrap;">
                <?php if (!empty($item['event_date'])): ?>
                  <span style="display:inline-flex;align-items:center;gap:.35rem;">
                    <i data-lucide="calendar" style="width:13px;height:13px;"></i>
                    <?= esc($dateLabel($item['event_date'])) ?>
                  </span>
                <?php endif; ?>
                <?php if ($imageCount > 0): ?>
                  <span style="display:inline-flex;align-items:center;gap:.35rem;">
                    <i data-lucide="image" style="width:13px;height:13px;"></i>
                    <?= $imageCount ?> photo<?= $imageCount !== 1 ? 's' : '' ?>
                  </span>
                <?php endif; ?>
              </div>
              <h3 style="font-size:.97rem;font-weight:700;color:hsl(var(--foreground));margin:0 0 .4rem;line-height:1.35;"><?= esc($item['title']) ?></h3>
              <?php if (!empty($item['description'])): ?>
                <p style="font-size:.82rem;color:hsl(var(--muted-foreground));line-height:1.65;margin:.25rem 0 0;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?= esc($plainText($item['description'])) ?></p>
              <?php endif; ?>

              <!-- Thumbnail strip: now with .gallery-thumb (changes main image) -->
              <?php $subThumbs = array_values(array_filter($item['sub_images'] ?? [], fn($s) => !empty($s['image_path']))); ?>
              <?php if (!empty($subThumbs)): ?>
                <div style="display:flex;gap:.4rem;margin-top:1rem;flex-wrap:wrap;">
                  <?php foreach (array_slice($subThumbs, 0, 5) as $st): ?>
                    <button 
                      type="button"
                      class="gallery-thumb"
                      data-target="main-image-<?= (int)$item['id'] ?>"
                      data-image="<?= $mediaUrl($st['image_path']) ?>"
                      style="width:44px;height:36px;border-radius:6px;overflow:hidden;border:1px solid hsl(var(--border));padding:0;cursor:pointer;position:relative;background:hsl(var(--muted));"
                    >
                      <img 
                        src="<?= $mediaUrl($st['image_path']) ?>" 
                        alt=""
                        loading="lazy"
                        style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0;transition:opacity .3s;"
                        onload="this.style.opacity='1'" 
                        onerror="this.style.display='none'"
                      >
                    </button>
                  <?php endforeach; ?>
                  <?php $remaining = count($subThumbs) - 5; ?>
                  <?php if ($remaining > 0): ?>
                    <button type="button" class="gallery-preview" data-gallery-id="<?= (int)$item['id'] ?>"
                            style="width:44px;height:36px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;background:hsl(var(--muted));color:hsl(var(--muted-foreground));border:none;cursor:pointer;">
                      +<?= $remaining ?>
                    </button>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

              <!-- View album button (keeps .gallery-preview to open lightbox) -->
              <button type="button" class="gallery-preview" data-gallery-id="<?= (int)$item['id'] ?>"
                      style="display:inline-flex;align-items:center;gap:.4rem;margin-top:1rem;font-size:.82rem;font-weight:700;color:hsl(var(--primary));background:none;border:none;cursor:pointer;padding:0;">
                <i data-lucide="play-circle" style="width:15px;height:15px;"></i> View album
              </button>
            </div>

            <!-- Lightbox data (unchanged) -->
            <script type="application/json" id="gallery-data-<?= (int)$item['id'] ?>"><?= json_encode(array_map(static fn($img) => ['src' => $mediaUrl($img['path']), 'title' => $img['title']], $allImages), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="grid-column:1/-1;text-align:center;padding:5rem 1rem;">
          <div style="width:80px;height:80px;border-radius:50%;background:hsl(var(--muted));display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
            <i data-lucide="image-off" style="width:36px;height:36px;color:hsl(var(--muted-foreground));"></i>
          </div>
          <p style="font-size:1.1rem;font-weight:600;color:hsl(var(--foreground));margin:0 0 .5rem;">No photos in this category</p>
          <p style="color:hsl(var(--muted-foreground));margin:0 0 1.5rem;">Try a different category or check back later.</p>
          <a href="<?= base_url('about/gallery') ?>" style="display:inline-flex;align-items:center;gap:.5rem;padding:.6rem 1.4rem;border-radius:.75rem;font-size:.85rem;font-weight:600;color:hsl(var(--primary));background:hsl(var(--primary)/.1);text-decoration:none;">
            <i data-lucide="grid-2x2" style="width:15px;height:15px;"></i> View all albums
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ── Lightbox ───────────────────────────────────────────────────────────── -->
<div id="gl-lightbox" role="dialog" aria-modal="true" aria-label="Image viewer">
  <!-- Header -->
  <div style="position:absolute;top:0;left:0;right:0;display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;z-index:20;background:linear-gradient(to bottom,rgba(0,0,0,.6),transparent);">
    <div>
      <p id="gl-lb-title" style="color:white;font-weight:600;font-size:.95rem;margin:0;line-height:1.3;"></p>
      <p id="gl-lb-counter" style="color:rgba(255,255,255,.5);font-size:.78rem;margin:.2rem 0 0;"></p>
    </div>
    <button id="gl-close" type="button" aria-label="Close" style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,.12);border:none;color:white;display:flex;align-items:center;justify-content:center;cursor:pointer;">
      <i data-lucide="x" style="width:20px;height:20px;"></i>
    </button>
  </div>
  <!-- Prev / Next -->
  <button id="gl-prev" type="button" aria-label="Previous" style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);z-index:20;width:48px;height:48px;border-radius:50%;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);color:white;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .2s;">
    <i data-lucide="chevron-left" style="width:24px;height:24px;"></i>
  </button>
  <button id="gl-next" type="button" aria-label="Next" style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);z-index:20;width:48px;height:48px;border-radius:50%;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);color:white;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .2s;">
    <i data-lucide="chevron-right" style="width:24px;height:24px;"></i>
  </button>
  <!-- Main image -->
  <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;padding:5rem 4rem 6rem;">
    <img id="gl-lb-img" src="" alt="" style="max-height:100%;max-width:100%;object-fit:contain;border-radius:.75rem;box-shadow:0 8px 40px rgba(0,0,0,.5);transition:opacity .25s ease;">
  </div>
  <!-- Thumb strip -->
  <div style="position:absolute;bottom:0;left:0;right:0;padding:.75rem 1rem;background:linear-gradient(to top,rgba(0,0,0,.7),transparent);">
    <div id="gl-thumbs" style="display:flex;justify-content:center;gap:.4rem;overflow-x:auto;scrollbar-width:thin;scrollbar-color:rgba(255,255,255,.3) transparent;"></div>
  </div>
</div>
<style>
#gl-thumbs::-webkit-scrollbar { height: 4px; }
#gl-thumbs::-webkit-scrollbar-thumb { background: rgba(255,255,255,.3); border-radius: 2px; }
</style>

<script>
(() => {
  const lb      = document.getElementById('gl-lightbox');
  const img     = document.getElementById('gl-lb-img');
  const title   = document.getElementById('gl-lb-title');
  const counter = document.getElementById('gl-lb-counter');
  const closeBtn= document.getElementById('gl-close');
  const prevBtn = document.getElementById('gl-prev');
  const nextBtn = document.getElementById('gl-next');
  const thumbs  = document.getElementById('gl-thumbs');
  if (!lb) return;

  let images = [], idx = 0;

  const render = () => {
    const cur = images[idx] || {};
    img.style.opacity = '0';
    img.onload  = () => { img.style.opacity = '1'; };
    img.onerror = () => { img.style.opacity = '.3'; };
    img.src = cur.src || ''; img.alt = cur.title || '';
    title.textContent   = cur.title || '';
    counter.textContent = images.length > 1 ? `${idx + 1} of ${images.length}` : '';
    prevBtn.style.visibility = images.length > 1 ? 'visible' : 'hidden';
    nextBtn.style.visibility = images.length > 1 ? 'visible' : 'hidden';
    thumbs.innerHTML = '';
    images.forEach((t, i) => {
      const w = document.createElement('div');
      w.style.cssText = `position:relative;width:52px;height:40px;border-radius:6px;overflow:hidden;cursor:pointer;flex-shrink:0;border:2px solid ${i===idx?'white':'transparent'};opacity:${i===idx?'1':'.5'};transform:${i===idx?'scale(1.1)':'scale(1)'};transition:all .2s;`;
      w.onclick = () => { idx = i; render(); };
      const ti = document.createElement('img');
      ti.src = t.src; ti.alt = '';
      ti.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0;transition:opacity .3s;';
      ti.onload = () => { ti.style.opacity = '1'; };
      w.appendChild(ti);
      thumbs.appendChild(w);
    });
    const at = thumbs.children[idx];
    if (at) at.scrollIntoView({ inline: 'center', behavior: 'smooth' });
  };

  const open = (id) => {
    const d = document.getElementById(`gallery-data-${id}`);
    if (!d) return;
    try { images = JSON.parse(d.textContent || '[]'); } catch(e) { images = []; }
    if (!images.length) return;
    idx = 0; render();
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
    if (window.lucide) lucide.createIcons();
  };
  const close = () => {
    lb.classList.remove('open');
    document.body.style.overflow = '';
    img.src = ''; thumbs.innerHTML = '';
  };

  // Lightbox trigger: all .gallery-preview buttons (main image + view album + extra thumb button)
  document.querySelectorAll('.gallery-preview').forEach(b => 
    b.addEventListener('click', () => open(b.dataset.galleryId))
  );
  closeBtn.addEventListener('click', close);
  prevBtn.addEventListener('click',  () => { idx = (idx - 1 + images.length) % images.length; render(); });
  nextBtn.addEventListener('click',  () => { idx = (idx + 1) % images.length; render(); });
  lb.addEventListener('click', e => { if (e.target === lb) close(); });
  document.addEventListener('keydown', e => {
    if (!lb.classList.contains('open')) return;
    if (e.key === 'Escape')     close();
    if (e.key === 'ArrowLeft')  { idx = (idx - 1 + images.length) % images.length; render(); }
    if (e.key === 'ArrowRight') { idx = (idx + 1) % images.length; render(); }
  });

  // NEW: Thumbnail click changes main image without opening lightbox
  document.querySelectorAll('.gallery-thumb').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();

      const targetId = btn.dataset.target;
      const newImage = btn.dataset.image;

      const mainImage = document.getElementById(targetId);

      if (mainImage && newImage) {
        mainImage.style.opacity = '0';

        setTimeout(() => {
          mainImage.src = newImage;
        }, 120);

        mainImage.onload = () => {
          mainImage.style.opacity = '1';
        };
      }
    });
  });
})();
</script>
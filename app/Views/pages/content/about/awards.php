<?php
/* awards.php — Awards & Recognition (gallery-style grid + lightbox) */
$awardsList  = $awards ?? [];
$awardsCount = count($awardsList);

// Helper: fetch all award IDs that have an image (for the lightbox data)
$awardImageMap = [];
foreach ($awardsList as $a) {
    if (!empty($a['image'])) {
        $awardImageMap[$a['id']] = [
            'src'   => $mediaUrl($a['image']),
            'title' => $a['title'] ?? ''
        ];
    }
}
?>
<style>
/* ── Awards grid (gallery-like) ── */
.aw-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
}
@media (min-width: 640px) {
  .aw-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 1024px) {
  .aw-grid { grid-template-columns: repeat(3, 1fr); }
}

.aw-card {
  background: hsl(var(--background));
  border: 1px solid hsl(var(--border));
  border-radius: 1.25rem;
  overflow: hidden;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}
.aw-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 18px 40px rgba(0,0,0,0.12);
}

.aw-img-wrap {
  position: relative;
  width: 100%;
  height: 240px;
  overflow: hidden;
  cursor: pointer;
  background: hsl(var(--muted));
}
.aw-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.25s ease;
}
.aw-card:hover .aw-img-wrap img {
  transform: scale(1.05);
}

.aw-placeholder {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  color: hsl(var(--muted-foreground));
}

.aw-body {
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  flex: 1;
}

/* year badge */
.aw-year {
  display: inline-block;
  font-size: 0.72rem;
  font-weight: 700;
  padding: 0.2rem 0.7rem;
  border-radius: 99px;
  background: hsl(var(--primary) / 0.12);
  color: hsl(var(--primary));
  margin-bottom: 0.5rem;
  width: fit-content;
}

.aw-title {
  font-size: 1rem;
  font-weight: 700;
  color: hsl(var(--foreground));
  margin: 0 0 0.25rem;
  line-height: 1.35;
}

.aw-org {
  font-size: 0.85rem;
  font-weight: 600;
  color: hsl(var(--muted-foreground));
  margin: 0 0 0.5rem;
}

.aw-desc {
  font-size: 0.82rem;
  color: hsl(var(--muted-foreground));
  line-height: 1.65;
  margin: 0.25rem 0 0;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.aw-view-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  margin-top: 1rem;
  font-size: 0.82rem;
  font-weight: 700;
  color: hsl(var(--primary));
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
}
.aw-view-btn:hover {
  text-decoration: underline;
}
</style>

<!-- ── Hero (unchanged) ── -->
<section style="background:linear-gradient(150deg,hsl(var(--accent)/.9) 0%,hsl(var(--primary)/.85) 60%,hsl(var(--secondary)/.7) 100%);padding:4.5rem 0 3.5rem;">
  <div class="container-bank">
    <a href="<?= base_url('about') ?>" style="display:inline-flex;align-items:center;gap:.4rem;color:rgba(255,255,255,.6);font-size:.85rem;text-decoration:none;margin-bottom:1.5rem;">
      <i data-lucide="arrow-left" style="width:15px;height:15px;"></i> About Us
    </a>
    <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:2rem;">
      <div>
        <span style="display:inline-flex;align-items:center;gap:.5rem;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);padding:.35rem .9rem;border-radius:99px;margin-bottom:1.1rem;">
          <i data-lucide="trophy" style="width:13px;height:13px;"></i> Recognition
        </span>
        <h1 style="font-size:clamp(2rem,5vw,3.25rem);font-weight:700;color:white;line-height:1.15;margin:0 0 1rem;text-shadow:0 2px 16px rgba(0,0,0,.2);">Awards &amp; Recognition</h1>
        <p style="color:rgba(255,255,255,.78);font-size:1.05rem;line-height:1.72;max-width:520px;margin:0;">
          These recognitions reflect our commitment to service quality, innovation, inclusion, and governance across the communities we serve.
        </p>
      </div>
      <div style="text-align:center;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:1.25rem;padding:1.25rem 2.5rem;flex-shrink:0;">
        <div style="font-size:2.75rem;font-weight:700;color:white;line-height:1;"><?= $awardsCount ?></div>
        <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.6);margin-top:.3rem;">Awards</div>
      </div>
    </div>
  </div>
</section>

<!-- ── Awards Grid ── -->
<section class="section-padding bg-background">
  <div class="container-bank">
    <?php if (!empty($awardsList)): ?>
      <div class="aw-grid">
        <?php foreach ($awardsList as $award): ?>
          <div class="aw-card">
            <!-- Image area -->
            <?php if (!empty($award['image'])): ?>
              <button type="button" class="aw-img-wrap gallery-preview"
                      data-gallery-id="award-<?= (int)$award['id'] ?>"
                      aria-label="View <?= esc($award['title']) ?>">
                <img src="<?= $mediaUrl($award['image']) ?>" alt="<?= esc($award['title']) ?>" loading="lazy">
              </button>
            <?php else: ?>
              <div class="aw-img-wrap aw-placeholder">
                <i data-lucide="trophy" style="width:52px;height:52px;"></i>
                <span style="font-size:.75rem;font-weight:600;">No image</span>
              </div>
            <?php endif; ?>

            <!-- Card body -->
            <div class="aw-body">
              <?php if (!empty($award['year'])): ?>
                <span class="aw-year"><?= esc($award['year']) ?></span>
              <?php endif; ?>
              <h3 class="aw-title"><?= esc($award['title']) ?></h3>
              <?php if (!empty($award['organization'])): ?>
                <p class="aw-org"><?= esc($award['organization']) ?></p>
              <?php endif; ?>
              <?php if (!empty($award['description'])): ?>
                <p class="aw-desc"><?= esc($award['description']) ?></p>
              <?php endif; ?>

              <!-- View button (only if image exists) -->
              <?php if (!empty($award['image'])): ?>
                <button type="button" class="aw-view-btn gallery-preview"
                        data-gallery-id="award-<?= (int)$award['id'] ?>">
                  <i data-lucide="eye" style="width:15px;height:15px;"></i> View award
                </button>
              <?php endif; ?>
            </div>

            <!-- Lightbox data script -->
            <?php if (!empty($award['image'])): ?>
              <script type="application/json" id="gallery-data-award-<?= (int)$award['id'] ?>">
                [{"src":"<?= $mediaUrl($award['image']) ?>", "title":"<?= esc($award['title']) ?>"}]
              </script>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div style="text-align:center;padding:5rem 1rem;">
        <div style="width:80px;height:80px;border-radius:50%;background:hsl(var(--muted));display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
          <i data-lucide="trophy" style="width:36px;height:36px;color:hsl(var(--muted-foreground));"></i>
        </div>
        <p style="font-size:1.1rem;font-weight:600;color:hsl(var(--foreground));margin:0 0 .5rem;">No awards found</p>
        <p style="color:hsl(var(--muted-foreground));margin:0;">Award entries will appear here once added from the admin panel.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ── Shared Lightbox (identical to gallery) ── -->
<div id="gl-lightbox" role="dialog" aria-modal="true" aria-label="Image viewer">
  <div style="position:absolute;top:0;left:0;right:0;display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;z-index:20;background:linear-gradient(to bottom,rgba(0,0,0,.6),transparent);">
    <div>
      <p id="gl-lb-title" style="color:white;font-weight:600;font-size:.95rem;margin:0;line-height:1.3;"></p>
      <p id="gl-lb-counter" style="color:rgba(255,255,255,.5);font-size:.78rem;margin:.2rem 0 0;"></p>
    </div>
    <button id="gl-close" type="button" aria-label="Close" style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,.12);border:none;color:white;display:flex;align-items:center;justify-content:center;cursor:pointer;">
      <i data-lucide="x" style="width:20px;height:20px;"></i>
    </button>
  </div>
  <button id="gl-prev" type="button" aria-label="Previous" style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);z-index:20;width:48px;height:48px;border-radius:50%;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);color:white;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .2s;">
    <i data-lucide="chevron-left" style="width:24px;height:24px;"></i>
  </button>
  <button id="gl-next" type="button" aria-label="Next" style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);z-index:20;width:48px;height:48px;border-radius:50%;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);color:white;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .2s;">
    <i data-lucide="chevron-right" style="width:24px;height:24px;"></i>
  </button>
  <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;padding:5rem 4rem 6rem;">
    <img id="gl-lb-img" src="" alt="" style="max-height:100%;max-width:100%;object-fit:contain;border-radius:.75rem;box-shadow:0 8px 40px rgba(0,0,0,.5);transition:opacity .25s ease;">
  </div>
  <div style="position:absolute;bottom:0;left:0;right:0;padding:.75rem 1rem;background:linear-gradient(to top,rgba(0,0,0,.7),transparent);">
    <div id="gl-thumbs" style="display:flex;justify-content:center;gap:.4rem;overflow-x:auto;scrollbar-width:thin;scrollbar-color:rgba(255,255,255,.3) transparent;"></div>
  </div>
</div>
<style>
#gl-lightbox { position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,.93); backdrop-filter: blur(8px); display: none; }
#gl-lightbox.open { display: flex; flex-direction: column; }
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
})();
</script>
<?php
/* management.php — Management Team ───────────────────────────────────────── */
$mgmtCols = ['var(--primary)','var(--secondary)','var(--accent)'];
$featured = $managementTeam[0] ?? null;
$rest     = array_slice($managementTeam ?? [], 1);
?>
<style>
/* ── Management page ─────────────────────────────────────────────────────── */
.mt-feat-photo {
  position: relative;
  overflow: hidden;
  min-height: 320px;
  flex-shrink: 0;
}
.mt-feat-photo .mt-fallback,
.mt-feat-photo img {
  position: absolute;
  inset: 0;
}
.mt-feat-photo .mt-fallback {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: .75rem;
}
.mt-feat-photo img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  object-position: center top;
  opacity: 0;
  transition: opacity .4s ease;
}

/* grid card photo — fixed 5:6 portrait aspect, image contained (no crop) */
.mt-card-photo {
  position: relative;
  width: 100%;
  padding-top: 120%;         /* 5:6 portrait ratio */
  overflow: hidden;
  flex-shrink: 0;
}
.mt-card-photo .mt-fallback,
.mt-card-photo img {
  position: absolute;
  inset: 0;
}
.mt-card-photo .mt-fallback {
  display: flex;
  align-items: center;
  justify-content: center;
}
.mt-card-photo img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  object-position: center top;
  opacity: 0;
  transition: opacity .4s ease;
}

.mt-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}
@media (min-width: 600px)  { .mt-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 960px)  { .mt-grid { grid-template-columns: repeat(3, 1fr); } }

.mt-feat-grid {
  display: flex;
  flex-direction: column;
}
@media (min-width: 820px) {
  .mt-feat-grid { flex-direction: row; }
  .mt-feat-photo { width: 38%; min-height: 380px; }
  .mt-feat-info  { flex: 1; }
}

.mt-card { transition: transform .25s, box-shadow .25s; }
.mt-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,.1); }
</style>

<!-- ── Hero ──────────────────────────────────────────────────────────────── -->
<section style="background:linear-gradient(150deg,hsl(var(--secondary)/.85) 0%,hsl(var(--primary)/.9) 100%);padding:4.5rem 0 3.5rem;">
  <div class="container-bank">
    <a href="<?= base_url('about') ?>" style="display:inline-flex;align-items:center;gap:.4rem;color:rgba(255,255,255,.6);font-size:.85rem;text-decoration:none;margin-bottom:1.5rem;">
      <i data-lucide="arrow-left" style="width:15px;height:15px;"></i> About Us
    </a>
    <span style="display:inline-flex;align-items:center;gap:.5rem;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);padding:.35rem .9rem;border-radius:99px;margin-bottom:1.1rem;">
      <i data-lucide="briefcase" style="width:13px;height:13px;"></i> Executive Leadership
    </span>
    <h1 style="font-size:clamp(2rem,5vw,3.25rem);font-weight:700;color:white;line-height:1.15;margin:0 0 1rem;text-shadow:0 2px 16px rgba(0,0,0,.2);">Management Team</h1>
    <p style="color:rgba(255,255,255,.78);font-size:1.05rem;line-height:1.72;max-width:520px;margin:0;">
      Decades of combined banking expertise driving innovation, financial inclusion, and excellence across every product and service.
    </p>
  </div>
</section>

<!-- ── Team ───────────────────────────────────────────────────────────────── -->
<section class="section-padding bg-background">
  <div class="container-bank">
    <?php if (!empty($managementTeam)): ?>

      <?php if ($featured): ?>
      <!-- Featured leader card -->
      <div class="mt-feat-grid" style="background:hsl(var(--background));border-radius:1.25rem;border:1px solid hsl(var(--border));overflow:hidden;margin-bottom:3rem;box-shadow:0 4px 20px rgba(0,0,0,.06);">
        <!-- Accent bar top -->
        <div style="height:4px;background:linear-gradient(to right,hsl(var(--primary)),hsl(var(--secondary)));grid-column:1/-1;"></div>
        <!-- Photo -->
        <div class="mt-feat-photo" style="background:linear-gradient(145deg,hsl(var(--primary)/.12),hsl(var(--muted)));">
          <div class="mt-fallback">
            <div style="width:96px;height:96px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2.25rem;font-weight:700;background:hsl(var(--primary)/.2);color:hsl(var(--primary));border:3px solid hsl(var(--primary)/.3);">
              <?= esc($initials($featured['name'])) ?>
            </div>
            <span style="font-size:.8rem;font-weight:600;color:hsl(var(--primary)/.7);"><?= esc($featured['role']) ?></span>
          </div>
          <?php if (!empty($featured['image'])): ?>
            <img src="<?= $mediaUrl($featured['image']) ?>" alt="<?= esc($featured['name']) ?>"
                 onload="this.style.opacity='1'" onerror="this.style.display='none'">
          <?php endif; ?>
          <!-- Bottom gradient on desktop photo -->
          <div style="position:absolute;bottom:0;left:0;right:0;height:80px;background:linear-gradient(to top,rgba(0,0,0,.15),transparent);pointer-events:none;"></div>
        </div>
        <!-- Info -->
        <div class="mt-feat-info" style="padding:2.25rem 2.5rem;display:flex;flex-direction:column;justify-content:center;">
          <span style="display:inline-flex;align-items:center;gap:.5rem;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:hsl(var(--primary));background:hsl(var(--primary)/.1);padding:.3rem .8rem;border-radius:99px;margin-bottom:1.25rem;width:fit-content;">
            <i data-lucide="star" style="width:12px;height:12px;"></i> Head of Management
          </span>
          <h2 style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;color:hsl(var(--foreground));margin:0 0 .4rem;line-height:1.2;"><?= esc($featured['name']) ?></h2>
          <p style="font-size:1.1rem;font-weight:600;color:hsl(var(--primary));margin:0 0 .75rem;"><?= esc($featured['role']) ?></p>
          <?php if (!empty($featured['department'])): ?>
            <span style="display:inline-flex;align-items:center;gap:.4rem;font-size:.75rem;font-weight:600;background:hsl(var(--muted));color:hsl(var(--muted-foreground));padding:.35rem .85rem;border-radius:99px;margin-bottom:1.25rem;width:fit-content;">
              <i data-lucide="building-2" style="width:13px;height:13px;"></i><?= esc($featured['department']) ?>
            </span>
          <?php endif; ?>
          <?php if (!empty($featured['bio'])): ?>
            <p style="color:hsl(var(--muted-foreground));line-height:1.8;font-size:.97rem;margin:0;"><?= esc($featured['bio']) ?></p>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>

      <!-- Executive grid -->
      <?php if (!empty($rest)): ?>
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.75rem;">
          <h3 style="font-size:1.15rem;font-weight:700;color:hsl(var(--foreground));margin:0;white-space:nowrap;">Executive Team</h3>
          <div style="flex:1;height:1px;background:linear-gradient(to right,hsl(var(--border)),transparent);"></div>
        </div>
        <div class="mt-grid">
          <?php foreach ($rest as $ri => $member): ?>
            <?php $col = $mgmtCols[$ri % count($mgmtCols)]; ?>
            <article class="mt-card" style="background:hsl(var(--background));border-radius:1rem;border:1px solid hsl(var(--border));overflow:hidden;display:flex;flex-direction:column;">
              <div style="height:3px;background:linear-gradient(to right,hsl(<?= $col ?>),hsl(<?= $col ?>/.5));"></div>
              <!-- Fixed-ratio photo -->
              <div class="mt-card-photo" style="background:linear-gradient(145deg,hsl(<?= $col ?>/.1),hsl(var(--muted)));">
                <div class="mt-fallback">
                  <div style="width:68px;height:68px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;background:hsl(<?= $col ?>/.18);color:hsl(<?= $col ?>);border:2px solid hsl(<?= $col ?>/.25);">
                    <?= esc($initials($member['name'])) ?>
                  </div>
                </div>
                <?php if (!empty($member['image'])): ?>
                  <img src="<?= $mediaUrl($member['image']) ?>" alt="<?= esc($member['name']) ?>"
                       onload="this.style.opacity='1'" onerror="this.style.display='none'">
                <?php endif; ?>
              </div>
              <!-- Info -->
              <div style="padding:1.25rem 1.4rem 1.5rem;flex:1;display:flex;flex-direction:column;">
                <h3 style="font-size:1rem;font-weight:700;color:hsl(var(--foreground));margin:0 0 .25rem;line-height:1.3;"><?= esc($member['name']) ?></h3>
                <p style="font-size:.875rem;font-weight:600;color:hsl(<?= $col ?>);margin:0 0 .5rem;"><?= esc($member['role']) ?></p>
                <?php if (!empty($member['department'])): ?>
                  <span style="display:inline-block;font-size:.7rem;font-weight:600;background:hsl(var(--muted));color:hsl(var(--muted-foreground));padding:.25rem .7rem;border-radius:99px;margin-bottom:.75rem;width:fit-content;"><?= esc($member['department']) ?></span>
                <?php endif; ?>
                <?php if (!empty($member['bio'])): ?>
                  <p style="font-size:.82rem;color:hsl(var(--muted-foreground));line-height:1.65;margin:auto 0 0;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;"><?= esc($member['bio']) ?></p>
                <?php endif; ?>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    <?php else: ?>
      <div style="text-align:center;padding:5rem 1rem;">
        <div style="width:80px;height:80px;border-radius:50%;background:hsl(var(--muted));display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
          <i data-lucide="briefcase" style="width:36px;height:36px;color:hsl(var(--muted-foreground));"></i>
        </div>
        <p style="font-size:1.1rem;font-weight:600;color:hsl(var(--foreground));margin:0 0 .5rem;">No management members found</p>
        <p style="color:hsl(var(--muted-foreground));margin:0;">Management profiles will appear here once added from the admin panel.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

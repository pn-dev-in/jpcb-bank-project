<?php
/* board.php — Board of Directors ─────────────────────────────────────────── */
$accentCols  = ['var(--primary)','var(--secondary)','var(--accent)','var(--primary)','var(--secondary)'];
$totalMembers = array_sum(array_map('count', $directorsByCategory ?? []));
?>
<style>
/* ── Board page ─────────────────────────────────────────────────────────── */
.bd-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.25rem;
}
@media (min-width: 580px)  { .bd-grid { grid-template-columns: repeat(3, 1fr); } }
@media (min-width: 900px)  { .bd-grid { grid-template-columns: repeat(4, 1fr); } }

.bd-card {
  background: hsl(var(--background));
  border-radius: 1rem;
  border: 1px solid hsl(var(--border));
  overflow: hidden;
  transition: transform .25s ease, box-shadow .25s ease;
}
.bd-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,0.1); }

/* Fixed-size photo wrapper — ALL images same size regardless of upload dimensions */
.bd-photo-wrap {
  position: relative;
  width: 100%;
  padding-top: 120%;          /* 5:6 portrait aspect ratio */
  overflow: hidden;
}
.bd-photo-wrap .bd-fallback,
.bd-photo-wrap img {
  position: absolute;
  inset: 0;
}
.bd-photo-wrap .bd-fallback {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: .5rem;
}
.bd-photo-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center top;  /* show face even on landscape photos */
  opacity: 0;
  transition: opacity .4s ease;
}
.bd-photo-overlay {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  background: linear-gradient(to top, rgba(0,0,0,.72) 0%, transparent 100%);
  padding: 2.5rem 1rem .75rem;
}
</style>

<!-- ── Hero ──────────────────────────────────────────────────────────────── -->
<section style="background:linear-gradient(150deg,hsl(var(--primary)) 0%,hsl(var(--primary)/.78) 55%,hsl(var(--secondary)/.6) 100%);padding:4.5rem 0 3.5rem;">
  <div class="container-bank">
    <a href="<?= base_url('about') ?>" style="display:inline-flex;align-items:center;gap:.4rem;color:rgba(255,255,255,.6);font-size:.85rem;text-decoration:none;margin-bottom:1.5rem;">
      <i data-lucide="arrow-left" style="width:15px;height:15px;"></i> About Us
    </a>
    <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:2rem;">
      <div>
        <span style="display:inline-flex;align-items:center;gap:.5rem;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);padding:.35rem .9rem;border-radius:99px;margin-bottom:1.1rem;">
          <i data-lucide="shield-check" style="width:13px;height:13px;"></i> Governance &amp; Leadership
        </span>
        <h1 style="font-size:clamp(2rem,5vw,3.25rem);font-weight:700;color:white;line-height:1.15;margin:0 0 1rem;text-shadow:0 2px 16px rgba(0,0,0,.2);">Board of Directors</h1>
        <p style="color:rgba(255,255,255,.78);font-size:1.05rem;line-height:1.72;max-width:500px;margin:0;">
          Strategic oversight and governance — ensuring transparency, accountability, and community-focused banking since 1933.
        </p>
      </div>
      <!-- Stats pill -->
      <div style="display:flex;align-items:center;gap:2.5rem;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:1.25rem;padding:1.25rem 2.25rem;flex-shrink:0;">
        <div style="text-align:center;">
          <div style="font-size:2.75rem;font-weight:700;color:white;line-height:1;"><?= $totalMembers ?></div>
          <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.6);margin-top:.3rem;">Members</div>
        </div>
        <div style="width:1px;height:3rem;background:rgba(255,255,255,.25);"></div>
        <div style="text-align:center;">
          <div style="font-size:2.75rem;font-weight:700;color:white;line-height:1;"><?= count($directorsByCategory ?? []) ?></div>
          <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.6);margin-top:.3rem;">Groups</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Members ────────────────────────────────────────────────────────────── -->
<section class="section-padding bg-background">
  <div class="container-bank">
    <?php if (!empty($directorsByCategory)): ?>
      <?php foreach ($directorsByCategory as $category => $members): ?>
        <div style="margin-bottom:3.5rem;">

          <!-- Category header -->
          <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,hsl(var(--primary)),hsl(var(--primary)/.7));display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 14px hsl(var(--primary)/.28);">
              <i data-lucide="users" style="width:20px;height:20px;color:white;"></i>
            </div>
            <div>
              <h2 style="font-size:1.25rem;font-weight:700;color:hsl(var(--foreground));margin:0;line-height:1.2;"><?= esc($category) ?></h2>
              <p style="font-size:.75rem;color:hsl(var(--muted-foreground));margin:.2rem 0 0;"><?= count($members) ?> member<?= count($members) !== 1 ? 's' : '' ?></p>
            </div>
            <div style="flex:1;height:1px;background:linear-gradient(to right,hsl(var(--border)),transparent);margin-left:.5rem;"></div>
          </div>

          <div class="bd-grid">
            <?php foreach ($members as $mi => $member): ?>
              <?php
                $col  = $accentCols[$mi % count($accentCols)];
                $init = $initials($member['name']);
              ?>
              <article class="bd-card">
                <!-- Photo area (fixed portrait ratio) -->
                <div class="bd-photo-wrap" style="background:linear-gradient(145deg,hsl(<?= $col ?>/.12),hsl(var(--muted)));">
                  <!-- Fallback: always behind the photo -->
                  <div class="bd-fallback">
                    <div style="width:70px;height:70px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;background:hsl(<?= $col ?>/.18);color:hsl(<?= $col ?>);border:2.5px solid hsl(<?= $col ?>/.28);">
                      <?= esc($init) ?>
                    </div>
                    <span style="font-size:.68rem;color:hsl(<?= $col ?>/.65);font-weight:600;padding:0 .75rem;text-align:center;line-height:1.3;"><?= esc($member['role']) ?></span>
                  </div>
                  <!-- Real photo: fades in on load, hidden on error -->
                  <?php if (!empty($member['image'])): ?>
                    <img src="<?= $mediaUrl($member['image']) ?>"
                         alt="<?= esc($member['name']) ?>"
                         onload="this.style.opacity='1'"
                         onerror="this.style.display='none'">
                  <?php endif; ?>
                  <!-- Role badge overlay -->
                  <div class="bd-photo-overlay">
                    <span style="display:inline-block;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:white;background:hsl(<?= $col ?>/.82);padding:.2rem .65rem;border-radius:99px;backdrop-filter:blur(4px);">
                      <?= esc($member['role']) ?>
                    </span>
                  </div>
                </div>
                <!-- Info -->
                <div style="padding:.9rem 1rem 1.1rem;border-top:3px solid hsl(<?= $col ?>);">
                  <h3 style="font-size:.9rem;font-weight:700;color:hsl(var(--foreground));margin:0;line-height:1.35;"><?= esc($member['name']) ?></h3>
                  <?php if (!empty($member['bio'])): ?>
                    <p style="font-size:.72rem;color:hsl(var(--muted-foreground));margin:.4rem 0 0;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?= esc($member['bio']) ?></p>
                  <?php endif; ?>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>

    <?php else: ?>
      <div style="text-align:center;padding:5rem 1rem;">
        <div style="width:80px;height:80px;border-radius:50%;background:hsl(var(--muted));display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
          <i data-lucide="users" style="width:36px;height:36px;color:hsl(var(--muted-foreground));"></i>
        </div>
        <p style="font-size:1.1rem;font-weight:600;color:hsl(var(--foreground));margin:0 0 .5rem;">No board members found</p>
        <p style="color:hsl(var(--muted-foreground));margin:0;">Board member profiles will appear here once added from the admin panel.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php
/* branches.php — Branch Locator ─────────────────────────────────────────── */
$search = trim($query['q'] ?? '');
$allBranches = $branches ?? [];
$filteredBranches = $allBranches;
if ($search !== '') {
  $needle = strtolower($search);
  $filteredBranches = array_values(array_filter($allBranches, static function ($branch) use ($needle) {
    $hay = strtolower(
      ($branch['branch_name'] ?? '') . ' ' .
      ($branch['city'] ?? '') . ' ' .
      ($branch['area'] ?? '') . ' ' .
      ($branch['pincode'] ?? '') . ' ' .
      ($branch['ifsc'] ?? '')
    );
    return str_contains($hay, $needle);
  }));
}
$totalBranches = count($allBranches);
$found = count($filteredBranches);
?>
<style>
  /* ── Branches page ───────────────────────────────────────────────────────── */
  .br-card {
    background: hsl(var(--background));
    border-radius: 1rem;
    border: 1px solid hsl(var(--border));
    border-left: 4px solid hsl(var(--primary));
    padding: 1.25rem 1.5rem;
    transition: transform .25s ease, box-shadow .25s ease;
  }

  .br-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(0, 0, 0, .08);
  }

  .br-inner {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  @media (min-width: 700px) {
    .br-inner {
      flex-direction: row;
      align-items: flex-start;
    }
  }

  .br-meta {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem 1.25rem;
    margin-top: .5rem;
  }

  .br-badge {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    font-size: .78rem;
    color: hsl(var(--muted-foreground));
  }

  .br-badge a {
    color: hsl(var(--muted-foreground));
    text-decoration: none;
  }

  .br-badge a:hover {
    color: hsl(var(--primary));
  }
</style>

<!-- ── Hero ──────────────────────────────────────────────────────────────── -->
<section
  style="background:linear-gradient(150deg,hsl(var(--primary)) 0%,hsl(var(--primary)/.75) 55%,hsl(var(--secondary)/.5) 100%);padding:4.5rem 0 3.5rem;">
  <div class="container-bank">
    <a href="<?= base_url('about') ?>"
      style="display:inline-flex;align-items:center;gap:.4rem;color:rgba(255,255,255,.6);font-size:.85rem;text-decoration:none;margin-bottom:1.5rem;">
      <i data-lucide="arrow-left" style="width:15px;height:15px;"></i> About Us
    </a>
    <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:2rem;">
      <div>
        <span
          style="display:inline-flex;align-items:center;gap:.5rem;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);padding:.35rem .9rem;border-radius:99px;margin-bottom:1.1rem;">
          <i data-lucide="map-pin" style="width:13px;height:13px;"></i> Network
        </span>
        <h1
          style="font-size:clamp(2rem,5vw,3.25rem);font-weight:700;color:white;line-height:1.15;margin:0 0 1rem;text-shadow:0 2px 16px rgba(0,0,0,.2);">
          Branch Locator</h1>
        <p style="color:rgba(255,255,255,.78);font-size:1.05rem;line-height:1.72;max-width:520px;margin:0;">
          Find your nearest JPCB branch by searching name, city, area, pincode, or IFSC code.
        </p>
      </div>
      <!-- Count pill -->
      <div
        style="text-align:center;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:1.25rem;padding:1.25rem 2.5rem;flex-shrink:0;">
        <div style="font-size:2.75rem;font-weight:700;color:white;line-height:1;"><?= $totalBranches ?></div>
        <div
          style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.6);margin-top:.3rem;">
          Branches</div>
      </div>
    </div>
  </div>
</section>

<!-- ── Search + List ──────────────────────────────────────────────────────── -->
<section class="section-padding bg-background">
  <div class="container-bank">

    <!-- Search box -->
    <div style="max-width:560px;margin-bottom:2rem;">
      <form method="get" action="<?= base_url('about/branches') ?>">
        <label for="branch-search"
          style="display:block;font-size:.85rem;font-weight:600;color:hsl(var(--foreground));margin-bottom:.5rem;">
          Search by name, city, area, IFSC, or pincode
        </label>
        <div style="position:relative;">
          <i data-lucide="search"
            style="position:absolute;left:.85rem;top:50%;transform:translateY(-50%);width:18px;height:18px;color:hsl(var(--muted-foreground));pointer-events:none;"></i>
          <input id="branch-search" type="search" name="q" value="<?= esc($search) ?>"
            placeholder="e.g. Nashik, 425001, JPCB0000001"
            style="width:100%;padding:.75rem 1rem .75rem 2.5rem;border-radius:.75rem;border:1.5px solid hsl(var(--border));background:hsl(var(--background));color:hsl(var(--foreground));font-size:.9rem;outline:none;transition:border-color .2s;"
            onfocus="this.style.borderColor='hsl(var(--primary))'" onblur="this.style.borderColor='hsl(var(--border))'">
        </div>
      </form>
    </div>

    <!-- Result count -->
    <p style="font-size:.85rem;color:hsl(var(--muted-foreground));margin-bottom:1.25rem;">
      <?php if ($search !== ''): ?>
        Found <strong style="color:hsl(var(--foreground));"><?= $found ?></strong> result<?= $found !== 1 ? 's' : '' ?>
        for &ldquo;<em><?= esc($search) ?></em>&rdquo;
        &nbsp;&mdash;&nbsp;<a href="<?= base_url('about/branches') ?>"
          style="color:hsl(var(--primary));text-decoration:none;font-weight:600;">Clear</a>
      <?php else: ?>
        Showing all <strong style="color:hsl(var(--foreground));"><?= $totalBranches ?></strong>
        branch<?= $totalBranches !== 1 ? 'es' : '' ?>
      <?php endif; ?>
    </p>

    <!-- List -->
    <?php if (!empty($filteredBranches)): ?>
      <div style="display:flex;flex-direction:column;gap:.9rem;">
        <?php foreach ($filteredBranches as $bi => $branch): ?>
          <div class="br-card">
            <div class="br-inner">
              <!-- Icon -->
              <div
                style="width:44px;height:44px;border-radius:.75rem;background:hsl(var(--primary)/.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i data-lucide="landmark" style="width:20px;height:20px;color:hsl(var(--primary));"></i>
              </div>
              <!-- Details -->
              <div style="flex:1;">
                <div
                  style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.5rem;margin-bottom:.35rem;">
                  <h3 style="font-size:1rem;font-weight:700;color:hsl(var(--foreground));margin:0;line-height:1.3;">
                    <?= esc($branch['branch_name']) ?></h3>
                  <?php if (!empty($branch['ifsc'])): ?>
                    <code
                      style="font-size:.72rem;font-weight:600;background:hsl(var(--muted));color:hsl(var(--foreground));padding:.2rem .6rem;border-radius:.4rem;letter-spacing:.04em;"><?= esc($branch['ifsc']) ?></code>
                  <?php endif; ?>
                </div>
                <div class="br-meta">
                  <?php if (!empty($branch['address'])): ?>
                    <span class="br-badge">
                      <i data-lucide="map-pin" style="width:13px;height:13px;"></i>
                      <?= esc($branch['address']) ?>      <?= !empty($branch['area']) ? ', ' . esc($branch['area']) : '' ?>
                      <?php if (!empty($branch['city'])): ?>, <?= esc($branch['city']) ?><?php endif; ?>
                      <?php if (!empty($branch['pincode'])): ?> &ndash; <?= esc($branch['pincode']) ?><?php endif; ?>
                    </span>
                  <?php endif; ?>
                  <?php if (!empty($branch['phone'])): ?>
                    <span class="br-badge">
                      <i data-lucide="phone" style="width:13px;height:13px;"></i>
                      <a href="tel:<?= preg_replace('/[^0-9+]/', '', $branch['phone']) ?>"><?= esc($branch['phone']) ?></a>
                    </span>
                  <?php endif; ?>
                  <?php if (!empty($branch['timings'])): ?>
                    <span class="br-badge">
                      <i data-lucide="clock" style="width:13px;height:13px;"></i>
                      <?= esc($branch['timings']) ?>
                    </span>
                  <?php endif; ?>
                  <?php if (!empty($branch['latitude']) && !empty($branch['longitude'])): ?>
                    <span class="br-badge">
                      <i data-lucide="external-link" style="width:13px;height:13px;"></i>

                      <a href="https://www.google.com/maps?q=<?= esc($branch['latitude']) ?>,<?= esc($branch['longitude']) ?>"
                        target="_blank" rel="noopener noreferrer">
                        View on map
                      </a>
                    </span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div style="text-align:center;padding:4rem 1rem;">
        <div
          style="width:72px;height:72px;border-radius:50%;background:hsl(var(--muted));display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;">
          <i data-lucide="map-pin-off" style="width:30px;height:30px;color:hsl(var(--muted-foreground));"></i>
        </div>
        <p style="font-size:1rem;font-weight:600;color:hsl(var(--foreground));margin:0 0 .4rem;">No branches found</p>
        <p style="color:hsl(var(--muted-foreground));margin:0 0 1.25rem;font-size:.9rem;">Try a different search term.</p>
        <a href="<?= base_url('about/branches') ?>"
          style="display:inline-flex;align-items:center;gap:.5rem;padding:.55rem 1.25rem;border-radius:.75rem;font-size:.85rem;font-weight:600;color:hsl(var(--primary));background:hsl(var(--primary)/.1);text-decoration:none;">
          <i data-lucide="refresh-cw" style="width:14px;height:14px;"></i> Show all branches
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>
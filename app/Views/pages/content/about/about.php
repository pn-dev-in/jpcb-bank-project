<?php
/* index.php — About the Bank main page ──────────────────────────────────── */
$statIcons  = ['trending-up','git-branch','users','piggy-bank','bar-chart-2','award'];
$statColors = ['var(--primary)','var(--secondary)','var(--accent)','var(--primary)','var(--secondary)'];
$vcols      = ['var(--primary)','var(--secondary)','var(--accent)','var(--primary)'];
?>
<style>
/* ── About index responsive layout ─────────────────────────────────────── */
.ab-hero-wrap { display:flex; flex-direction:column; gap:2.5rem; }
@media(min-width:900px){
  .ab-hero-wrap { flex-direction:row; align-items:center; gap:4rem; }
  .ab-hero-copy { flex:1 1 55%; }
  .ab-hero-vis  { flex:1 1 40%; }
}
.ab-stats-grid {
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:1rem;
}
@media(min-width:640px)  { .ab-stats-grid { grid-template-columns:repeat(3,1fr); } }
@media(min-width:1024px) { .ab-stats-grid { grid-template-columns:repeat(5,1fr); } }

.ab-story-wrap { display:flex; flex-direction:column; gap:2.5rem; }
@media(min-width:900px){
  .ab-story-wrap { flex-direction:row; align-items:flex-start; gap:4rem; }
  .ab-story-l { flex:0 0 42%; }
  .ab-story-r { flex:1 1 auto; }
}
.ab-mv-grid { display:grid; grid-template-columns:1fr; gap:1.5rem; }
@media(min-width:700px){ .ab-mv-grid { grid-template-columns:repeat(2,1fr); } }

.ab-val-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:1.25rem; }
@media(min-width:900px){ .ab-val-grid { grid-template-columns:repeat(4,1fr); } }

/* Timeline */
.ab-timeline { position:relative; max-width:780px; margin:0 auto; }
.ab-tl-item  { display:flex; align-items:stretch; }
.ab-tl-spine { display:flex; flex-direction:column; align-items:center; flex-shrink:0; width:76px; }
.ab-tl-dot   { width:46px; height:46px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; color:white; flex-shrink:0; background:linear-gradient(135deg,hsl(var(--primary)),hsl(var(--primary)/.7)); box-shadow:0 2px 10px hsl(var(--primary)/.3); z-index:2; }
.ab-tl-line  { width:2px; flex:1; min-height:1.5rem; background:linear-gradient(to bottom,hsl(var(--primary)/.35),hsl(var(--primary)/.06)); }
.ab-tl-card  { flex:1; padding:0 0 1.75rem 1.25rem; }

.ab-hover { transition:transform .22s,box-shadow .22s; }
.ab-hover:hover { transform:translateY(-4px); box-shadow:0 14px 36px rgba(0,0,0,.1); }
</style>

<!-- ① HERO ──────────────────────────────────────────────────────────────── -->
<section style="background:linear-gradient(150deg,hsl(var(--primary)) 0%,hsl(var(--primary)/.82) 55%,hsl(var(--secondary)/.65) 100%);padding:5rem 0 4.5rem;">
  <div class="container-bank">
    <div class="ab-hero-wrap">
      <!-- Copy -->
      <div class="ab-hero-copy">
        <span style="display:inline-flex;align-items:center;gap:.5rem;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:white;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);padding:.35rem .9rem;border-radius:99px;margin-bottom:1.25rem;">
          <i data-lucide="shield-check" style="width:13px;height:13px;"></i> Multi-State Scheduled Co-operative Bank
        </span>
        <h1 style="font-size:clamp(2rem,5.5vw,3.5rem);font-weight:700;color:white;line-height:1.13;margin:0 0 1.1rem;text-shadow:0 2px 18px rgba(0,0,0,.18);">
          <?= esc($aboutContent['hero_title'] ?? 'The Jalgaon Peoples Co-operative Bank Ltd.') ?>
        </h1>
        <p style="color:rgba(255,255,255,.8);font-size:1.1rem;line-height:1.75;max-width:500px;margin:0 0 2rem;">
          <?= esc($aboutContent['hero_subtitle'] ?? 'Trusted by communities since 1933 — delivering safe, accessible, and transparent banking across Maharashtra.') ?>
        </p>
        <div style="display:flex;flex-wrap:wrap;gap:.75rem;">
          <a href="<?= base_url('about/board') ?>" style="display:inline-flex;align-items:center;gap:.5rem;background:white;color:hsl(var(--primary));font-weight:700;font-size:.9rem;padding:.8rem 1.5rem;border-radius:.875rem;text-decoration:none;box-shadow:0 4px 16px rgba(0,0,0,.14);">
            <i data-lucide="users" style="width:16px;height:16px;"></i> Meet Our Board
          </a>
          <a href="<?= base_url('about/gallery') ?>" style="display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,255,255,.15);color:white;font-weight:600;font-size:.9rem;padding:.8rem 1.5rem;border-radius:.875rem;text-decoration:none;border:1.5px solid rgba(255,255,255,.3);backdrop-filter:blur(4px);">
            <i data-lucide="images" style="width:16px;height:16px;"></i> Gallery
          </a>
        </div>
      </div>
      <!-- Trust badges -->
      <div class="ab-hero-vis">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
          <?php
            $badges = [
              ['icon'=>'landmark','value'=>'1933','label'=>'Established'],
              ['icon'=>'shield-check','value'=>'RBI','label'=>'Scheduled Bank'],
              ['icon'=>'map-pin','value'=>'43+','label'=>'Branches'],
              ['icon'=>'heart-handshake','value'=>'2L+','label'=>'Happy Customers'],
            ];
          ?>
          <?php foreach ($badges as $b): ?>
            <div style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);border-radius:1.25rem;padding:1.4rem;text-align:center;">
              <i data-lucide="<?= $b['icon'] ?>" style="width:28px;height:28px;color:rgba(255,255,255,.7);display:block;margin:0 auto .6rem;"></i>
              <div style="font-size:1.55rem;font-weight:700;color:white;line-height:1;"><?= $b['value'] ?></div>
              <div style="font-size:.67rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.58);margin-top:.3rem;"><?= $b['label'] ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ② STATS ─────────────────────────────────────────────────────────────── -->
<?php if (!empty($stats)): ?>
<section style="background:hsl(var(--muted)/.3);padding:3.5rem 0;">
  <div class="container-bank">
    <div style="text-align:center;margin-bottom:2.25rem;">
      <span style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:hsl(var(--primary));">By the Numbers</span>
      <h2 style="font-size:clamp(1.4rem,3vw,1.9rem);font-weight:700;color:hsl(var(--foreground));margin:.4rem 0 0;">Our Impact at a Glance</h2>
    </div>
    <div class="ab-stats-grid">
      <?php foreach ($stats as $si => $stat): ?>
        <?php
          $sc  = $statColors[$si % count($statColors)];
          $ico = $statIcons[$si % count($statIcons)];
        ?>
        <div class="ab-hover" style="background:hsl(var(--background));border-radius:1.25rem;border:1px solid hsl(var(--border));border-top:4px solid hsl(<?= $sc ?>);padding:1.75rem 1.25rem;text-align:center;">
          <div style="width:46px;height:46px;border-radius:12px;background:hsl(<?= $sc ?>/.12);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
            <i data-lucide="<?= $ico ?>" style="width:22px;height:22px;color:hsl(<?= $sc ?>);"></i>
          </div>
          <div style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;color:hsl(<?= $sc ?>);line-height:1.05;"><?= esc($stat['number']) ?></div>
          <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:hsl(var(--muted-foreground));margin-top:.5rem;"><?= esc($stat['label']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ③ OUR STORY ──────────────────────────────────────────────────────────── -->
<section style="background:hsl(var(--background));padding:4.5rem 0;">
  <div class="container-bank">
    <div class="ab-story-wrap">
      <!-- Left -->
      <div class="ab-story-l">
        <span style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:hsl(var(--primary));">Our Story</span>
        <h2 style="font-size:clamp(1.6rem,3vw,2.4rem);font-weight:700;color:hsl(var(--foreground));margin:.6rem 0 1.2rem;line-height:1.22;">
          <?= esc($aboutContent['intro_title'] ?? 'A Legacy of Trust and Community Banking') ?>
        </h2>
        <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:2rem;">
          <div style="height:4px;width:48px;border-radius:99px;background:hsl(var(--primary));"></div>
          <div style="height:4px;width:16px;border-radius:99px;background:hsl(var(--primary)/.35);"></div>
          <div style="height:4px;width:8px;border-radius:99px;background:hsl(var(--primary)/.15);"></div>
        </div>
        <!-- Fact pills -->
        <div style="display:flex;flex-direction:column;gap:.75rem;">
          <?php
            $facts = [
              ['icon'=>'calendar','color'=>'var(--primary)','title'=>'Est. 1933','sub'=>'Over 90 years of service'],
              ['icon'=>'shield-check','color'=>'var(--secondary)','title'=>'RBI Scheduled Bank','sub'=>'Regulated &amp; trusted'],
              ['icon'=>'map-pin','color'=>'var(--accent)','title'=>'Multi-State Operations','sub'=>'Serving communities across states'],
            ];
          ?>
          <?php foreach ($facts as $f): ?>
            <div style="display:flex;align-items:center;gap:.85rem;padding:.9rem 1rem;border-radius:.875rem;background:hsl(<?= $f['color'] ?>/.08);border-left:3px solid hsl(<?= $f['color'] ?>);">
              <i data-lucide="<?= $f['icon'] ?>" style="width:20px;height:20px;color:hsl(<?= $f['color'] ?>);flex-shrink:0;"></i>
              <div>
                <div style="font-size:.85rem;font-weight:700;color:hsl(<?= $f['color'] ?>);"><?= $f['title'] ?></div>
                <div style="font-size:.73rem;color:hsl(var(--muted-foreground));"><?= $f['sub'] ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div style="display:flex;gap:1.5rem;flex-wrap:wrap;margin-top:1.75rem;">
          <a href="<?= base_url('about/board') ?>" style="display:inline-flex;align-items:center;gap:.4rem;font-size:.875rem;font-weight:700;color:hsl(var(--primary));text-decoration:none;">
            <i data-lucide="arrow-right" style="width:15px;height:15px;"></i> Meet Leadership
          </a>
          <a href="<?= base_url('about/gallery') ?>" style="display:inline-flex;align-items:center;gap:.4rem;font-size:.875rem;font-weight:700;color:hsl(var(--secondary));text-decoration:none;">
            <i data-lucide="images" style="width:15px;height:15px;"></i> View Gallery
          </a>
        </div>
      </div>
      <!-- Right: paragraphs -->
      <div class="ab-story-r">
        <?php
          $intro = (string) ($aboutContent['intro_description'] ?? "The Jalgaon Peoples Co-operative Bank Ltd. has been a cornerstone of community banking in Maharashtra for over seven decades. Established with the vision of providing accessible, transparent, and customer-centric banking services, we have grown to serve families, businesses, and farmers across the region.\n\nAs a Multi-State Scheduled Co-operative Bank regulated by the Reserve Bank of India, we combine personalized service with the strength, discipline, and confidence customers expect from a scheduled banking institution.\n\nOur commitment extends beyond transactions — we believe in financial inclusion, digital literacy, and accessible banking for senior citizens, persons with disabilities, and first-time digital users.");
        ?>
        <div style="display:flex;flex-direction:column;gap:1.25rem;">
          <?php foreach (preg_split('/\R+/', $intro) as $para): ?>
            <?php if (trim($para) !== ''): ?>
              <p style="color:hsl(var(--muted-foreground));line-height:1.85;font-size:1.02rem;margin:0;"><?= esc($para) ?></p>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
/* ── Heritage section layout ────────────────────────────────────────────── */

/*
  .ab-heritage-wrap
  Two-column flex layout on desktop (left: heading + badges, right: prose).
  Mirrors the exact pattern used by .ab-story-wrap for visual consistency.
*/
.ab-heritage-wrap {
  display: flex;
  flex-direction: column;
  gap: 2.5rem;
}
@media (min-width: 900px) {
  .ab-heritage-wrap {
    flex-direction: row;
    align-items: flex-start;
    gap: 4rem;
  }
  .ab-heritage-l { flex: 0 0 38%; }
  .ab-heritage-r { flex: 1 1 auto; }
}

/*
  .ab-heritage-img
  Full-width banner image with aspect-ratio sizing (no fixed px heights).
  16:7 on desktop, 16:9 on mobile — feels cinematic without being tall.
*/
.ab-heritage-img{

    width:100%;
    border-radius:20px;
    overflow:hidden;
    background:#fff;
    margin-bottom:3rem;

}

.ab-heritage-img img{

    width:100%;
    height:auto;
    display:block;
    object-fit:contain;

}
@media (max-width: 640px) {
  .ab-heritage-img { aspect-ratio: 16 / 9; }
}
.ab-heritage-img img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    display: block;
    transition: transform 0.6s ease;
}
.ab-heritage-img:hover img {
  transform: scale(1.025);
}

/*
  .ab-heritage-badge
  Pill badges — follow the same token palette (primary/secondary/accent)
  as the fact pills in Our Story. No new colors introduced.
*/
.ab-heritage-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  padding: 0.4rem 0.9rem;
  border-radius: 99px;
}

/*
  .ab-heritage-highlight
  Inline emphasis for years, founder names, and key milestones.
  Uses primary color at low opacity so it reads as brand-native, not foreign.
*/
.ab-heritage-highlight {
  color: hsl(var(--primary));
  font-weight: 700;
}

/*
  .ab-heritage-accent-bar
  The three-dot divider already used in Our Story — copied verbatim
  to keep section language consistent.
*/
.ab-heritage-accent-bar {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 2rem;
}

/*
  .ab-heritage-more
  Collapsed container for paragraphs 3–5 and milestone chips.
  max-height:0 hides the content; overflow:hidden clips it.
  The CSS transition on max-height creates the smooth scroll-reveal
  effect when .ab-heritage-expanded is toggled via JS.
  A large max-height (9999px) is used in the expanded state because
  the exact content height is unknown at CSS authoring time.
*/
.ab-heritage-more {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.45s ease;
}
.ab-heritage-more.ab-heritage-expanded {
  max-height: 9999px; /* tall enough for any content; transition still feels natural */
}

/*
  .ab-heritage-toggle
  "Read more / Show less" button — matches the text-link style already
  used for "Meet Leadership" and "View Gallery" in Our Story.
  No new color tokens; uses --primary only.
*/
.ab-heritage-toggle {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  font-size: 0.875rem;
  font-weight: 700;
  color: hsl(var(--primary));
  background: none;
  border: none;
  padding: 0;
  cursor: pointer;
  text-decoration: none;
  transition: opacity 0.2s;
}
.ab-heritage-toggle:hover { opacity: 0.75; }
</style>

<?php if (!empty($heritageSettings)): ?>
<section style="background: hsl(var(--muted)/.18); padding: 4.5rem 0;">
  <div class="container-bank">

    <!-- Section eyebrow & title -->
    <div style="text-align: center; margin-bottom: 2.5rem;">
      <span style="font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: hsl(var(--primary));">
        <?= esc($heritageSettings['eyebrow'] ?? 'Heritage & Legacy') ?>
      </span>
      <h2 style="font-size: clamp(1.6rem, 3vw, 2.4rem); font-weight: 700; color: hsl(var(--foreground)); margin: .4rem 0 0; line-height: 1.22;">
        <?= esc($heritageSettings['title'] ?? 'People Tree to Bodhi Tree') ?>
      </h2>
    </div>

    <!-- Heritage Banner Image -->
    <?php if (!empty($heritageSettings['image'])): ?>
    <div class="ab-heritage-img">
      <img src="<?= base_url($heritageSettings['image']) ?>"
           alt="JPC Bank Heritage – <?= esc($heritageSettings['title']) ?>"
           loading="lazy">
    </div>
    <?php endif; ?>

    <!-- Two-column body -->
    <div class="ab-heritage-wrap">

      <!-- LEFT COLUMN: Heading + trust badges -->
      <div class="ab-heritage-l">
        <span style="font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: hsl(var(--primary));">
          <?= esc($heritageSettings['subheading_left'] ?? 'Eternal Bond of Trust') ?>
        </span>
        <h3 style="font-size: clamp(1.35rem, 2.5vw, 2rem); font-weight: 700; color: hsl(var(--foreground)); margin: .6rem 0 1.1rem; line-height: 1.25;">
          <?= $heritageSettings['heading_left'] ?? 'A Banyan Rooted in 1933' ?>
        </h3>

        <!-- Accent divider -->
        <div class="ab-heritage-accent-bar">
          <div style="height: 4px; width: 48px; border-radius: 99px; background: hsl(var(--primary));"></div>
          <div style="height: 4px; width: 16px; border-radius: 99px; background: hsl(var(--primary)/.35);"></div>
          <div style="height: 4px; width: 8px; border-radius: 99px; background: hsl(var(--primary)/.15);"></div>
        </div>

        <!-- Dynamic badges -->
        <div style="display: flex; flex-direction: column; gap: .75rem;">
          <?php if (!empty($heritageBadges)): ?>
            <?php foreach ($heritageBadges as $badge): ?>
              <div style="display: flex; align-items: center; gap: .85rem; padding: .9rem 1rem; border-radius: .875rem; 
                          background: hsl(var(--<?= $badge['color_theme'] == 'primary-light' ? 'primary' : $badge['color_theme'] ?>)/.08); 
                          border-left: 3px solid hsl(var(--<?= $badge['color_theme'] == 'primary-light' ? 'primary' : $badge['color_theme'] ?>));">
                <i data-lucide="<?= esc($badge['icon']) ?>" style="width: 20px; height: 20px; color: hsl(var(--<?= $badge['color_theme'] == 'primary-light' ? 'primary' : $badge['color_theme'] ?>)); flex-shrink: 0;"></i>
                <div>
                  <div style="font-size: .85rem; font-weight: 700; color: hsl(var(--<?= $badge['color_theme'] == 'primary-light' ? 'primary' : $badge['color_theme'] ?>));">
                    <?= esc($badge['label']) ?>
                  </div>
                  <div style="font-size: .73rem; color: hsl(var(--muted-foreground));">
                    <?= esc($badge['description']) ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div><!-- /.ab-heritage-l -->

      <!-- RIGHT COLUMN: Narrative -->
      <div class="ab-heritage-r">
        <div style="display: flex; flex-direction: column; gap: 1.25rem;">

          <!-- Intro paragraph (always visible) -->
          <?php if (!empty($heritageSettings['intro_paragraph'])): ?>
            <div style="color: hsl(var(--muted-foreground)); line-height: 1.85; font-size: 1.02rem; margin: 0;">
              <?= $heritageSettings['intro_paragraph'] ?>
            </div>
          <?php endif; ?>

          <!-- Founding paragraph (always visible) -->
          <?php if (!empty($heritageSettings['founding_paragraph'])): ?>
            <div style="color: hsl(var(--muted-foreground)); line-height: 1.85; font-size: 1.02rem; margin: 0;">
              <?= $heritageSettings['founding_paragraph'] ?>
            </div>
          <?php endif; ?>

          <!-- Expandable paragraphs (hidden behind "Read more") -->
          <?php if (!empty($heritageSettings['expandable_paragraphs'])): ?>
            <div class="ab-heritage-more" id="heritageMore">
              <?= $heritageSettings['expandable_paragraphs'] ?>
            </div>
            <div style="margin-top: .25rem;">
              <button class="ab-heritage-toggle" onclick="
                const more = document.getElementById('heritageMore');
                const isOpen = more.classList.toggle('ab-heritage-expanded');
                this.querySelector('.ab-toggle-label').textContent = isOpen ? 'Show less' : 'Read more';
                this.querySelector('[data-lucide]').style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
              " aria-expanded="false" aria-controls="heritageMore">
                <span class="ab-toggle-label">Read more</span>
                <i data-lucide="chevron-down" style="width: 15px; height: 15px; transition: transform .25s;"></i>
              </button>
            </div>
          <?php endif; ?>

        </div>
      </div><!-- /.ab-heritage-r -->

    </div><!-- /.ab-heritage-wrap -->
  </div><!-- /.container-bank -->
</section>
<?php endif; ?>


<!-- ④ MISSION & VISION ──────────────────────────────────────────────────── -->
<section style="background:hsl(var(--muted)/.32);padding:4.5rem 0;">
  <div class="container-bank">
    <div style="text-align:center;margin-bottom:2.5rem;">
      <span style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:hsl(var(--primary));">Purpose</span>
      <h2 style="font-size:clamp(1.4rem,3vw,1.9rem);font-weight:700;color:hsl(var(--foreground));margin:.4rem 0 0;">Mission &amp; Vision</h2>
    </div>
    <div class="ab-mv-grid">
      <?php
        $mvCards = [
          ['icon'=>'target','color'=>'var(--primary)','num'=>'01',
           'title'=>$aboutContent['mission_title'] ?? 'Our Mission',
           'text'=>$aboutContent['mission_description'] ?? 'To provide safe, accessible, and innovative banking services to every section of society, fostering financial inclusion and sustainable growth in the communities we serve.'],
          ['icon'=>'telescope','color'=>'var(--secondary)','num'=>'02',
           'title'=>$aboutContent['vision_title'] ?? 'Our Vision',
           'text'=>$aboutContent['vision_description'] ?? 'To be the most trusted and accessible co-operative bank in India, recognized for customer-centric innovation, transparent governance, and inclusive banking practices.'],
        ];
      ?>
      <?php foreach ($mvCards as $mv): ?>
        <div class="ab-hover" style="background:hsl(var(--background));border-radius:1.25rem;border:1px solid hsl(var(--border));overflow:hidden;">
          <div style="height:5px;background:linear-gradient(to right,hsl(<?= $mv['color'] ?>),hsl(<?= $mv['color'] ?>/.4));"></div>
          <div style="padding:2rem 2.25rem;">
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
              <div style="width:56px;height:56px;border-radius:14px;background:hsl(<?= $mv['color'] ?>/.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i data-lucide="<?= $mv['icon'] ?>" style="width:26px;height:26px;color:hsl(<?= $mv['color'] ?>);"></i>
              </div>
              <div>
                <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:hsl(<?= $mv['color'] ?>);"><?= $mv['num'] ?></div>
                <h3 style="font-size:1.35rem;font-weight:700;color:hsl(var(--foreground));margin:0;"><?= esc($mv['title']) ?></h3>
              </div>
            </div>
            <p style="color:hsl(var(--muted-foreground));line-height:1.8;font-size:.97rem;margin:0;"><?= esc($mv['text']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ⑤ CORE VALUES ────────────────────────────────────────────────────────── -->
<?php if (!empty($values)): ?>
<section style="background:hsl(var(--background));padding:4.5rem 0;">
  <div class="container-bank">
    <div style="text-align:center;margin-bottom:2.75rem;">
      <span style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:hsl(var(--primary));">Our Principles</span>
      <h2 style="font-size:clamp(1.4rem,3vw,1.9rem);font-weight:700;color:hsl(var(--foreground));margin:.4rem 0 .6rem;">Core Values</h2>
      <p style="color:hsl(var(--muted-foreground));font-size:.9rem;max-width:480px;margin:0 auto;">The principles that guide every decision, interaction, and service we deliver.</p>
    </div>
    <div class="ab-val-grid">
      <?php foreach ($values as $vi => $value): ?>
        <?php $vc = $vcols[$vi % count($vcols)]; ?>
        <div class="ab-hover" style="background:hsl(var(--background));border-radius:1.25rem;border:1px solid hsl(var(--border));border-top:4px solid hsl(<?= $vc ?>);padding:1.75rem;">
          <div style="width:52px;height:52px;border-radius:14px;background:hsl(<?= $vc ?>/.12);display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
            <i data-lucide="<?= esc($value['icon']) ?>" style="width:24px;height:24px;color:hsl(<?= $vc ?>);"></i>
          </div>
          <h3 style="font-size:1.05rem;font-weight:700;color:hsl(var(--foreground));margin:0 0 .5rem;"><?= esc($value['title']) ?></h3>
          <p style="font-size:.85rem;color:hsl(var(--muted-foreground));line-height:1.7;margin:0;"><?= esc($value['description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ⑥ OUR JOURNEY ────────────────────────────────────────────────────────── -->
<?php if (!empty($milestones)): ?>
<section style="background:hsl(var(--muted)/.28);padding:4.5rem 0;">
  <div class="container-bank">
    <div style="text-align:center;margin-bottom:3rem;">
      <span style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:hsl(var(--primary));">Since 1933</span>
      <h2 style="font-size:clamp(1.4rem,3vw,1.9rem);font-weight:700;color:hsl(var(--foreground));margin:.4rem 0 .6rem;">Our Journey</h2>
      <p style="color:hsl(var(--muted-foreground));font-size:.9rem;max-width:460px;margin:0 auto;">Over nine decades of growth, trust, and community service — milestone by milestone.</p>
    </div>
    <div class="ab-timeline">
      <?php foreach ($milestones as $mi => $ms): ?>
        <div class="ab-tl-item">
          <div class="ab-tl-spine">
            <div class="ab-tl-dot"><?= esc($ms['year']) ?></div>
            <?php if ($mi < count($milestones) - 1): ?>
              <div class="ab-tl-line"></div>
            <?php endif; ?>
          </div>
          <div class="ab-tl-card">
            <div class="ab-hover" style="background:hsl(var(--background));border:1px solid hsl(var(--border));border-radius:1rem;padding:1.1rem 1.4rem;">
              <div style="display:flex;align-items:center;gap:.65rem;flex-wrap:wrap;margin-bottom:.4rem;">
                <span style="font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:hsl(var(--primary));background:hsl(var(--primary)/.1);padding:.25rem .7rem;border-radius:99px;"><?= esc($ms['year']) ?></span>
                <h3 style="font-size:.97rem;font-weight:700;color:hsl(var(--foreground));margin:0;"><?= esc($ms['title']) ?></h3>
              </div>
              <p style="font-size:.85rem;color:hsl(var(--muted-foreground));line-height:1.62;margin:0;"><?= esc($ms['description']) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

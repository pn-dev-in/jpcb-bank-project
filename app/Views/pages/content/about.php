<?php
// For gallery filtering
$galleryCategorySlug = $query['category'] ?? 'all';
$filteredGalleryItems = $galleryItems ?? [];
if ($galleryCategorySlug !== 'all') {
  $filteredGalleryItems = array_values(array_filter($galleryItems, function ($item) use ($galleryCategorySlug) {
    return $item['category_name'] === $galleryCategorySlug;
  }));
}
?>

<?php if ($pageKey === 'about'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div>
          <h2 class="font-heading text-2xl md:text-3xl text-foreground mb-4">A Legacy of Trust &amp; Community Banking</h2>
          <div class="space-y-4 readable" style="color: hsl(var(--muted-foreground));">
            <p>The Jalgaon Peoples Co-operative Bank Ltd. has been a cornerstone of community banking in Maharashtra for over seven decades. Established with the vision of providing accessible, transparent, and customer-centric banking services, we have grown to serve families, businesses, and farmers across the region.</p>
            <p>As a Multi-State Scheduled Co-operative Bank regulated by the Reserve Bank of India, we combine personalized service with the strength, discipline, and confidence customers expect from a scheduled banking institution.</p>
            <p>Our commitment extends beyond transactions. We believe in financial inclusion, digital literacy, and accessible banking experiences for senior citizens, persons with disabilities, and first-time digital users.</p>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <?php if (!empty($stats)): ?>
            <?php foreach ($stats as $stat): ?>
              <div class="bank-card p-6 text-center">
                <div class="text-3xl md:text-4xl font-heading font-bold text-primary mb-1"><?= esc($stat['number']) ?></div>
                <div class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($stat['label']) ?></div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <section class="section-padding section-alt">
    <div class="container-bank">
      <div class="grid md:grid-cols-2 gap-8">
        <div class="bank-card p-8">
          <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background-color: hsl(var(--primary) / 0.1);">
            <i data-lucide="target" class="w-6 h-6 text-primary"></i>
          </div>
          <h3 class="font-heading text-xl text-foreground mb-3">Our Mission</h3>
          <p class="readable" style="color: hsl(var(--muted-foreground));">To provide safe, accessible, and innovative banking services to every section of society, fostering financial inclusion and sustainable growth in the communities we serve.</p>
        </div>
        <div class="bank-card p-8">
          <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background-color: hsl(var(--secondary) / 0.1);">
            <i data-lucide="eye" class="w-6 h-6" style="color: hsl(var(--secondary));"></i>
          </div>
          <h3 class="font-heading text-xl text-foreground mb-3">Our Vision</h3>
          <p class="readable" style="color: hsl(var(--muted-foreground));">To be the most trusted and accessible co-operative bank in India, recognized for customer-centric innovation, transparent governance, and inclusive banking practices.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section-padding bg-background">
    <div class="container-bank">
      <h2 class="font-heading text-2xl md:text-3xl text-foreground text-center mb-8">Our Core Values</h2>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php if (!empty($values)): ?>
          <?php foreach ($values as $value): ?>
            <div class="bank-card p-6 text-center">
              <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: hsl(var(--primary) / 0.1);">
                <i data-lucide="<?= esc($value['icon']) ?>" class="w-7 h-7 text-primary"></i>
              </div>
              <h3 class="font-semibold text-foreground mb-2"><?= esc($value['title']) ?></h3>
              <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($value['description']) ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="section-padding section-alt">
    <div class="container-bank">
      <h2 class="font-heading text-2xl md:text-3xl text-foreground text-center mb-10">Our Journey</h2>
      <div class="relative">
        <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-border md:-translate-x-px" aria-hidden="true"></div>
        <div class="space-y-8">
          <?php if (!empty($milestones)): ?>
            <?php foreach ($milestones as $index => $milestone): ?>
              <div class="relative flex items-start gap-6 <?= $index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' ?>">
                <div class="hidden md:block md:w-1/2"></div>
                <div class="absolute left-4 md:left-1/2 w-4 h-4 rounded-full bg-primary border-4 border-background -translate-x-1/2 mt-1.5 z-10" aria-hidden="true"></div>
                <div class="ml-10 md:ml-0 md:w-1/2 bank-card p-5">
                  <span class="text-sm font-bold text-primary"><?= esc($milestone['year']) ?></span>
                  <h3 class="font-semibold text-foreground mt-1"><?= esc($milestone['title']) ?></h3>
                  <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($milestone['description']) ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'board'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank">
      <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">The Board of Directors provides strategic direction and governance oversight, ensuring the bank operates with transparency, accountability, and a strong customer focus.</p>
      <?php if (!empty($directorsByCategory)): ?>
        <?php foreach ($directorsByCategory as $category => $members): ?>
          <div class="mb-12 last:mb-0">
            <h2 class="font-heading text-xl text-foreground mb-6 pb-2 border-b" style="border-color: hsl(var(--border));"><?= esc($category) ?></h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
              <?php foreach ($members as $member): ?>
                <div class="bank-card p-6 text-center">
                  <div class="w-20 h-20 rounded-full bg-muted flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="user" class="w-10 h-10" style="color: hsl(var(--muted-foreground));"></i>
                  </div>
                  <h3 class="font-semibold text-foreground"><?= esc($member['name']) ?></h3>
                  <p class="text-sm text-primary font-medium mt-1"><?= esc($member['role']) ?></p>
                  <p class="text-sm mt-2" style="color: hsl(var(--muted-foreground));"><?= esc($member['bio']) ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

<?php elseif ($pageKey === 'management'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank">
      <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">Our management team brings decades of combined experience in banking, technology, operations, and customer service to deliver dependable outcomes for customers and communities.</p>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($managementTeam)): ?>
          <?php foreach ($managementTeam as $member): ?>
            <div class="bank-card p-6">
              <div class="flex items-start gap-4">
                <div class="w-16 h-16 rounded-full bg-muted flex items-center justify-center flex-shrink-0">
                  <i data-lucide="user" class="w-8 h-8" style="color: hsl(var(--muted-foreground));"></i>
                </div>
                <div>
                  <h3 class="font-semibold text-foreground"><?= esc($member['name']) ?></h3>
                  <p class="text-sm text-primary font-medium"><?= esc($member['role']) ?></p>
                  <p class="text-xs" style="color: hsl(var(--muted-foreground));"><?= esc($member['department']) ?></p>
                </div>
              </div>
              <p class="text-sm mt-4" style="color: hsl(var(--muted-foreground));"><?= esc($member['bio']) ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'awards'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank">
      <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">These recognitions reflect our commitment to service quality, innovation, inclusion, and governance across the communities we serve.</p>
      <div class="space-y-6">
        <?php if (!empty($awards)): ?>
          <?php foreach ($awards as $award): ?>
            <div class="bank-card p-6 flex flex-col sm:flex-row items-start gap-4">
              <div class="w-16 h-16 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: hsl(var(--accent) / 0.12);">
                <i data-lucide="trophy" class="w-8 h-8" style="color: hsl(var(--accent));"></i>
              </div>
              <div class="flex-1">
                <div class="flex flex-wrap items-center gap-3 mb-1">
                  <span class="text-sm font-bold text-primary px-2 py-0.5 rounded" style="background-color: hsl(var(--primary) / 0.1);"><?= esc($award['year']) ?></span>
                  <h3 class="font-semibold text-foreground"><?= esc($award['title']) ?></h3>
                </div>
                <p class="text-sm font-medium" style="color: hsl(var(--muted-foreground));"><?= esc($award['organization']) ?></p>
                <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($award['description']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'gallery'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank">
      <div class="flex flex-wrap gap-2 mb-8" role="tablist" aria-label="Gallery categories">
        <?php if (!empty($galleryCategories)): ?>
          <?php foreach ($galleryCategories as $cat): ?>
            <a href="<?= current_url() . '?category=' . rawurlencode($cat['slug']) ?>"
              class="px-4 py-2 rounded-full text-sm font-medium transition-colors tap-target <?= $galleryCategorySlug === $cat['slug'] ? 'bg-primary text-primary-foreground' : 'bg-muted' ?>"
              style="<?= $galleryCategorySlug === $cat['slug'] ? '' : 'color: hsl(var(--muted-foreground));' ?>">
              <?= esc($cat['name']) ?>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <?php
      // Get the selected category slug from URL (default: 'all')
      $galleryCategorySlug = $query['category'] ?? 'all';
      // Convert to lowercase for consistent comparison
      $galleryCategorySlug = strtolower($galleryCategorySlug);

      $filteredGalleryItems = $galleryItems ?? [];
      if ($galleryCategorySlug !== 'all') {
        $filteredGalleryItems = array_values(array_filter($galleryItems, function ($item) use ($galleryCategorySlug) {
          // Compare using category slug (you need to pass slug from controller)
          return strtolower($item['category_slug'] ?? '') === $galleryCategorySlug;
        }));
      }
      ?>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($filteredGalleryItems)): ?>
          <?php foreach ($filteredGalleryItems as $item): ?>
            <article class="bank-card overflow-hidden">
              <?php if (!empty($item['image'])): ?>
                <img src="<?= base_url($item['image']) ?>" alt="<?= esc($item['title']) ?>" class="w-full h-48 object-cover">
              <?php else: ?>
                <div class="aspect-video bg-muted flex items-center justify-center">
                  <i data-lucide="image" class="w-12 h-12" style="color: hsl(var(--muted-foreground) / 0.4);"></i>
                </div>
              <?php endif; ?>
              <div class="p-4">
                <span class="text-xs text-primary font-medium"><?= esc($item['category_name']) ?></span>
                <h3 class="font-semibold text-foreground mt-1"><?= esc($item['title']) ?></h3>
                <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($item['description']) ?></p>
              </div>
            </article>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center col-span-full" style="color: hsl(var(--muted-foreground));">No gallery items found.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'branches'): ?>
  <!-- Branches section remains as previously dynamic -->
  <section class="section-padding bg-background">
    <div class="container-bank">
      <div class="max-w-xl mb-8">
        <form method="get" action="<?= current_url() ?>">
          <label for="branch-search-page" class="text-sm font-medium text-foreground mb-2 block">Search branches by name, city, area, IFSC, or pincode</label>
          <div class="relative">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" style="color: hsl(var(--muted-foreground));"></i>
            <input id="branch-search-page" type="search" name="q" value="<?= esc($query['q'] ?? '') ?>" placeholder="e.g. Nashik, 425001, JPCB0000001" class="w-full pl-10 pr-4 py-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));" />
          </div>
        </form>
      </div>

      <?php
      $filteredBranches = $branches ?? [];
      $search = trim($query['q'] ?? '');
      if ($search !== '') {
        $needle = strtolower($search);
        $filteredBranches = array_values(array_filter($branches, function ($branch) use ($needle) {
          $haystack = strtolower($branch['branch_name'] . ' ' . $branch['city'] . ' ' . ($branch['area'] ?? '') . ' ' . $branch['pincode'] . ' ' . ($branch['ifsc'] ?? ''));
          return str_contains($haystack, $needle);
        }));
      }
      ?>

      <p class="text-sm mb-6" style="color: hsl(var(--muted-foreground));"><?= count($filteredBranches) ?> branch(es) found</p>

      <div class="space-y-4">
        <?php foreach ($filteredBranches as $branch): ?>
          <div class="bank-card p-5 md:p-6">
            <div class="flex flex-col md:flex-row md:items-start gap-4">
              <div class="flex-1">
                <h3 class="font-semibold text-foreground text-lg"><?= esc($branch['branch_name']) ?></h3>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-sm" style="color: hsl(var(--muted-foreground));">
                  <span class="flex items-center gap-1"><i data-lucide="map-pin" class="w-4 h-4"></i><?= esc($branch['address']) ?><?= $branch['area'] ? ', ' . esc($branch['area']) : '' ?></span>
                  <span class="flex items-center gap-1"><i data-lucide="phone" class="w-4 h-4"></i><a href="tel:<?= preg_replace('/[^0-9]/', '', $branch['phone']) ?>" class="hover-primary"><?= esc($branch['phone']) ?></a></span>
                  <span class="flex items-center gap-1"><i data-lucide="clock" class="w-4 h-4"></i><?= esc($branch['timings']) ?></span>
                </div>
                <?php if ($branch['has_atm']): ?>
                  <span class="inline-block mt-2 text-xs px-2 py-1 rounded" style="background-color: hsl(var(--primary) / 0.1); color: hsl(var(--primary));">ATM Available</span>
                <?php endif; ?>
                <?php
                $services = [];
                if (!empty($branch['services']) && is_string($branch['services'])) {
                  $decoded = json_decode($branch['services'], true);
                  if (is_array($decoded)) $services = $decoded;
                }
                ?>
                <?php if (!empty($services)): ?>
                  <div class="flex flex-wrap gap-1.5 mt-3">
                    <?php foreach ($services as $service): ?>
                      <span class="text-xs px-2 py-1 rounded" style="background-color: hsl(var(--muted)); color: hsl(var(--muted-foreground));"><?= esc($service) ?></span>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
              <div class="flex flex-col gap-2 text-sm">
                <?php if (!empty($branch['ifsc'])): ?>
                  <div class="flex items-center gap-2">
                    <span style="color: hsl(var(--muted-foreground));">IFSC:</span>
                    <code class="font-mono text-foreground px-2 py-0.5 rounded" style="background-color: hsl(var(--muted));"><?= esc($branch['ifsc']) ?></code>
                    <button type="button" class="tap-target p-1 rounded text-xs" style="background-color: hsl(var(--muted)); color: hsl(var(--foreground));" onclick="navigator.clipboard.writeText('<?= esc($branch['ifsc'], 'js') ?>'); this.textContent='Copied'; setTimeout(() => this.textContent='Copy', 1500);">Copy</button>
                  </div>
                <?php endif; ?>
                <span style="color: hsl(var(--muted-foreground));">Pincode: <code class="font-mono text-foreground"><?= esc($branch['pincode']) ?></code></span>
                <?php if (!empty($branch['micr'])): ?>
                  <span style="color: hsl(var(--muted-foreground));">MICR: <code class="font-mono text-foreground"><?= esc($branch['micr']) ?></code></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

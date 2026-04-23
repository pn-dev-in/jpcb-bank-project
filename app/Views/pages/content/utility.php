<?php
// Prepare FAQ filtering
$faqSearch = trim($query['q'] ?? '');
$faqCategorySlug = $query['category'] ?? '';
$faqs = $faqs ?? [];
$faqCategories = $faqCategories ?? [];

$filteredFaqs = $faqs;
if ($faqSearch !== '') {
  $filteredFaqs = array_values(array_filter($faqs, function ($item) use ($faqSearch) {
    return str_contains(strtolower($item['question'] . ' ' . $item['answer']), strtolower($faqSearch));
  }));
} elseif ($faqCategorySlug !== '') {
  $filteredFaqs = array_values(array_filter($faqs, function ($item) use ($faqCategorySlug) {
    return ($item['category_slug'] ?? '') === $faqCategorySlug;
  }));
}

// Fallback hardcoded data for privacy, accessibility, sitemap (in case DB is empty)
$defaultPrivacySections = [
  ['title' => 'Information We Collect', 'content' => 'We collect personal information necessary for banking services including name, address, PAN, Aadhaar, contact details, and financial information as required by RBI KYC norms.'],
  ['title' => 'How We Use Information', 'content' => 'Your information is used for account management, transaction processing, regulatory compliance, fraud prevention, and service improvement.'],
  ['title' => 'Data Security', 'content' => 'We implement industry-standard security measures including encryption, access controls, and regular security audits to protect your data.'],
  ['title' => 'Information Sharing', 'content' => 'We do not sell or share your personal information with third parties except as required by law, regulatory bodies, or with your explicit consent.'],
  ['title' => 'Your Rights', 'content' => 'You have the right to access, correct, or update your personal information by visiting your branch or contacting our customer service.'],
  ['title' => 'Contact Us', 'content' => 'For privacy-related queries, contact our Data Protection Officer at privacy@jpcb.in or call 0257-2220055.'],
];
$privacySections = !empty($privacySections) ? $privacySections : $defaultPrivacySections;

$defaultAccessibilityFeatures = [
  'Text resize controls (A-, A, A+)',
  'High contrast mode',
  'Dark mode / Light mode',
  'Grayscale mode',
  'Reader mode',
  'Read aloud / Text-to-speech',
  'Focus reading strip',
  'Highlight links',
  'Highlight headings',
  'Text spacing adjustment',
  'Pause all animations',
  'Keyboard navigation support',
  'Skip to content links',
  'Screen-reader optimized structure',
  'Large touch targets (44px minimum)',
  'Semantic HTML and ARIA labels',
];
$accessibilityFeatures = !empty($accessibilityFeatures) ? $accessibilityFeatures : $defaultAccessibilityFeatures;

// Sitemap fallback is more complex; we'll handle inside the sitemap section with a hardcoded array if empty.
?>

<?php if ($pageKey === 'contact'): ?>
  <!-- CONTACT PAGE (uses $siteSettings from BaseController) -->
  <section class="section-padding bg-background">
    <div class="container-bank">
      <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
          <h2 class="font-heading text-xl text-foreground mb-6">Send Us a Message</h2>
          <form class="space-y-4 bank-card p-6" onsubmit="event.preventDefault();">
            <div class="grid sm:grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium text-foreground block mb-1">Full Name *</label>
                <input class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));" />
              </div>
              <div>
                <label class="text-sm font-medium text-foreground block mb-1">Email *</label>
                <input type="email" class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));" />
              </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium text-foreground block mb-1">Mobile</label>
                <input class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));" />
              </div>
              <div>
                <label class="text-sm font-medium text-foreground block mb-1">Subject</label>
                <select class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));">
                  <option>General Enquiry</option>
                  <option>Account Opening</option>
                  <option>Loan Enquiry</option>
                  <option>Complaint</option>
                  <option>Feedback</option>
                </select>
              </div>
            </div>
            <div>
              <label class="text-sm font-medium text-foreground block mb-1">Message *</label>
              <textarea rows="5" class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));"></textarea>
            </div>
            <button type="submit" class="btn-primary">Send Message</button>
          </form>
        </div>

        <div class="space-y-4">
          <div class="bank-card p-6">
            <h3 class="font-semibold text-foreground mb-4">Head Office</h3>
            <div class="space-y-3 text-sm" style="color: hsl(var(--muted-foreground));">
              <p class="flex items-start gap-2"><i data-lucide="map-pin" class="w-4 h-4 mt-0.5 flex-shrink-0"></i><?= esc($siteSettings['footer_address'] ?? $siteSettings['address'] ?? 'Near Railway Station, Jalgaon – 425001, Maharashtra') ?></p>
              <a href="tel:<?= preg_replace('/[^0-9]/', '', $siteSettings['phone'] ?? '02572220055') ?>" class="flex items-center gap-2 hover-primary"><i data-lucide="phone" class="w-4 h-4"></i><?= esc($siteSettings['phone'] ?? '0257-2220055') ?></a>
              <a href="mailto:<?= esc($siteSettings['email'] ?? 'info@jpcb.in') ?>" class="flex items-center gap-2 hover-primary"><i data-lucide="mail" class="w-4 h-4"></i><?= esc($siteSettings['email'] ?? 'info@jpcb.in') ?></a>
              <p class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4"></i><?= esc($siteSettings['business_hours'] ?? 'Mon-Sat: 10:00 AM – 4:00 PM') ?></p>
            </div>
          </div>
          <a href="<?= site_url('complaints') ?>" class="bank-card p-5 flex items-center gap-3 transition-colors">
            <i data-lucide="alert-triangle" class="w-8 h-8" style="color: hsl(var(--destructive));"></i>
            <div>
              <h3 class="font-semibold text-foreground text-sm">Lodge Complaint</h3>
              <p class="text-xs" style="color: hsl(var(--muted-foreground));">File a grievance online</p>
            </div>
          </a>
          <a href="<?= site_url('about/branches') ?>" class="bank-card p-5 flex items-center gap-3 transition-colors">
            <i data-lucide="map-pin" class="w-8 h-8 text-primary"></i>
            <div>
              <h3 class="font-semibold text-foreground text-sm">Find a Branch</h3>
              <p class="text-xs" style="color: hsl(var(--muted-foreground));">Locate nearest branch</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'faq'): ?>
  <!-- FAQ PAGE -->
  <section class="section-padding bg-background">
    <div class="container-bank max-w-4xl">
      <form class="max-w-xl mb-8" method="get" action="<?= current_url() ?>">
        <div class="relative">
          <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" style="color: hsl(var(--muted-foreground));"></i>
          <input type="search" name="q" value="<?= esc($faqSearch) ?>" placeholder="Search FAQs..." class="w-full pl-10 pr-4 py-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));" />
        </div>
      </form>

      <?php if ($faqSearch === ''): ?>
        <div class="flex flex-wrap gap-2 mb-8">
          <!-- "All" button: active when no 'category' parameter is present -->
          <a href="<?= current_url() ?>"
            class="px-4 py-2 rounded-full text-sm font-medium transition-colors tap-target <?= !isset($query['category']) ? 'bg-primary text-primary-foreground' : 'bg-muted' ?>"
            style="<?= !isset($query['category']) ? '' : 'color: hsl(var(--muted-foreground));' ?>">
            All
          </a>
          <?php foreach ($faqCategories as $cat): ?>
            <a href="<?= current_url() . '?category=' . rawurlencode($cat['slug']) ?>"
              class="px-4 py-2 rounded-full text-sm font-medium transition-colors tap-target <?= (isset($query['category']) && $query['category'] === $cat['slug']) ? 'bg-primary text-primary-foreground' : 'bg-muted' ?>"
              style="<?= (isset($query['category']) && $query['category'] === $cat['slug']) ? '' : 'color: hsl(var(--muted-foreground));' ?>">
              <?= esc($cat['name']) ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="space-y-3">
        <?php if (!empty($filteredFaqs)): ?>
          <?php foreach ($filteredFaqs as $item): ?>
            <details class="bank-card">
              <summary class="flex items-center gap-3 p-4 cursor-pointer font-medium text-foreground tap-target">
                <i data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i>
                <span><?= esc($item['question']) ?></span>
              </summary>
              <div class="px-4 pb-4 pl-12">
                <p class="text-xs font-medium text-primary mb-2"><?= esc($item['category_name']) ?></p>
                <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc((string)$item['answer'])) ?></p>
              </div>
            </details>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center" style="color: hsl(var(--muted-foreground));">No FAQs found.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'accessibility'): ?>
  <!-- ACCESSIBILITY PAGE -->
  <section class="section-padding bg-background">
    <div class="container-bank max-w-4xl">
      <div class="bank-card p-8 mb-8">
        <i data-lucide="accessibility" class="w-12 h-12 text-primary mb-4"></i>
        <h2 class="font-heading text-xl text-foreground mb-3">Our Commitment</h2>
        <p class="readable" style="color: hsl(var(--muted-foreground));">JPC Bank is committed to ensuring digital accessibility for people of all abilities. We continually improve the user experience for everyone and apply relevant accessibility standards including WCAG 2.2 AA and GIGW 3.0.</p>
      </div>
      <div class="bank-card p-6 mb-8">
        <h2 class="font-heading text-lg text-foreground mb-4">Accessibility Features</h2>
        <div class="grid sm:grid-cols-2 gap-2">
          <?php foreach ($accessibilityFeatures as $feature): ?>
            <div class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));">
              <i data-lucide="circle-check" class="w-4 h-4 flex-shrink-0" style="color: hsl(var(--success, var(--primary)));"></i>
              <?= esc($feature) ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="bank-card p-6">
        <h2 class="font-heading text-lg text-foreground mb-3">Report an Issue</h2>
        <p class="text-sm mb-2" style="color: hsl(var(--muted-foreground));">If you encounter any accessibility barriers, please contact us:</p>
        <p class="text-sm" style="color: hsl(var(--muted-foreground));">Email: <a href="mailto:accessibility@jpcb.in" class="text-primary">accessibility@jpcb.in</a> | Phone: <a href="tel:02572220055" class="text-primary">0257-2220055</a></p>
        <p class="text-xs mt-3" style="color: hsl(var(--muted-foreground));">Last accessibility audit: March 2026</p>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'privacy'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <div class="bank-card p-8">
      <p class="readable mb-6" style="color: hsl(var(--muted-foreground));">JPC Bank respects your privacy and is committed to protecting your personal data. This policy explains how we collect, use, and safeguard your information.</p>
      <?php foreach ($privacySections as $section): ?>
          <div class="mb-6">
            <h2 class="font-heading text-lg text-foreground mb-2"><?= esc($section['title']) ?></h2>
            <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc($section['content'])) ?></p>
          </div>
        <?php endforeach; ?>
        <p class="text-xs mt-8" style="color: hsl(var(--muted-foreground));">Last updated: April 2026</p>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'sitemap'): ?>
  <!-- SITEMAP PAGE -->
  <?php
  // If database sitemap is empty, use hardcoded fallback
  if (empty($sitemapSections)) {
    $sitemapSections = [
      ['title' => 'About', 'links' => [
        ['label' => 'About the Bank', 'href' => '/about'],
        ['label' => 'Board of Directors', 'href' => '/about/board'],
        ['label' => 'Management', 'href' => '/about/management'],
        ['label' => 'Awards', 'href' => '/about/awards'],
        ['label' => 'Gallery', 'href' => '/about/gallery'],
        ['label' => 'Branches', 'href' => '/about/branches'],
      ]],
      ['title' => 'Deposits', 'links' => [
        ['label' => 'Overview', 'href' => '/deposits'],
        ['label' => 'Products', 'href' => '/deposits/products'],
        ['label' => 'Savings & Current', 'href' => '/deposits/savings-current'],
        ['label' => 'Interest Rates', 'href' => '/deposits/interest-rates'],
        ['label' => 'DICGC', 'href' => '/deposits/dicgc'],
        ['label' => 'DEAF', 'href' => '/deposits/deaf'],
      ]],
      // ... add all other sections as in your original static array
    ];
  }
  ?>
  <section class="section-padding bg-background">
    <div class="container-bank">
      <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <?php foreach ($sitemapSections as $section): ?>
          <div>
            <h2 class="font-semibold text-foreground mb-3 text-lg"><?= esc($section['title']) ?></h2>
            <ul class="space-y-1.5">
              <?php foreach ($section['links'] as $link): ?>
                <li><a href="<?= site_url(ltrim($link['href'], '/')) ?>" class="text-sm transition-colors" style="color: hsl(var(--muted-foreground));"><?= esc($link['label']) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
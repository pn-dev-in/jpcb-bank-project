<?php
// For ATM search
$atmSearch = trim($query['q'] ?? '');
$filteredAtmLocations = $atmLocations ?? [];
if ($atmSearch !== '') {
    $needle = strtolower($atmSearch);
    $filteredAtmLocations = array_values(array_filter($atmLocations, function($loc) use ($needle) {
        $haystack = strtolower($loc['name'] . ' ' . $loc['city'] . ' ' . ($loc['area'] ?? '') . ' ' . $loc['pin']);
        return str_contains($haystack, $needle);
    }));
}

// For IFSC/MICR search
$codeSearch = trim($query['q'] ?? '');
$filteredBranchCodes = $branchCodes ?? [];
if ($codeSearch !== '') {
    $needle = strtolower($codeSearch);
    $filteredBranchCodes = array_values(array_filter($branchCodes, function($code) use ($needle) {
        $haystack = strtolower($code['branch_name'] . ' ' . $code['city'] . ' ' . ($code['ifsc'] ?? '') . ' ' . ($code['micr'] ?? ''));
        return str_contains($haystack, $needle);
    }));
}

// ATM search logic (same as before, but search also in address and location_type if desired)
$atmSearch = trim($query['q'] ?? '');
$filteredAtmLocations = $atmLocations ?? [];
if ($atmSearch !== '') {
    $needle = strtolower($atmSearch);
    $filteredAtmLocations = array_values(array_filter($atmLocations, function($loc) use ($needle) {
        $haystack = strtolower(($loc['name'] ?? '') . ' ' . 
                              ($loc['address'] ?? '') . ' ' .
                              ($loc['city'] ?? '') . ' ' . 
                              ($loc['area'] ?? '') . ' ' . 
                              ($loc['pin'] ?? ''));
        return str_contains($haystack, $needle);
    }));
}

?>

<?php if ($pageKey === 'overview'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">Experience secure and convenient digital banking with modern payment services, transfer rails, self-service account access, and customer assistance resources.</p>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
      <?php if (!empty($digitalServices)): ?>
        <?php foreach ($digitalServices as $service): ?>
        <a href="<?= site_url(ltrim($service['href'], '/')) ?>" class="bank-card p-6 group transition-colors">
          <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background-color: hsl(var(--primary) / 0.1);">
            <i data-lucide="<?= esc($service['icon']) ?>" class="w-6 h-6 text-primary"></i>
          </div>
          <h3 class="font-semibold text-foreground mb-2 group-hover:text-primary"><?= esc($service['title']) ?></h3>
          <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($service['description']) ?></p>
          <span class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-3">Learn more <i data-lucide="arrow-right" class="w-4 h-4"></i></span>
        </a>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No digital services found.</p>
      <?php endif; ?>
    </div>

    <div class="bank-card p-6" style="border-left: 4px solid hsl(var(--destructive));">
      <div class="flex items-start gap-3">
        <i data-lucide="alert-triangle" class="w-6 h-6 flex-shrink-0 mt-0.5" style="color: hsl(var(--destructive));"></i>
        <div>
          <h3 class="font-semibold text-foreground mb-1">Emergency: Block ATM Card</h3>
          <p class="text-sm mb-2" style="color: hsl(var(--muted-foreground));">If your ATM or debit card is lost, stolen, or compromised, block it immediately.</p>
          <a href="<?= site_url('digital/block-card') ?>" class="btn-primary text-sm" style="background-color: hsl(var(--destructive)); color: hsl(var(--destructive-foreground));">Block Card Now</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'mobile-banking'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-5xl">
    <div class="grid md:grid-cols-2 gap-10 items-center mb-12">
      <div>
        <h2 class="font-heading text-2xl text-foreground mb-4">Bank on Your Phone</h2>
        <p class="readable mb-6" style="color: hsl(var(--muted-foreground));">Access your accounts, transfer funds, pay bills, request services, and manage your finances directly from your mobile phone.</p>
        <div class="flex gap-3">
          <button type="button" class="btn-primary text-sm flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Google Play</button>
          <button type="button" class="btn-outline text-sm flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> App Store</button>
        </div>
      </div>
      <div class="bank-card p-6">
        <h3 class="font-semibold text-foreground mb-4">App Features</h3>
        <ul class="space-y-2">
          <?php if (!empty($mobileFeatures)): ?>
            <?php foreach ($mobileFeatures as $feature): ?>
            <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i><?= esc($feature) ?></li>
            <?php endforeach; ?>
          <?php else: ?>
            <li>No features listed.</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <h2 class="font-heading text-xl text-foreground mb-6">How to Register</h2>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
      <?php if (!empty($mobileSteps)): ?>
        <?php foreach ($mobileSteps as $step): ?>
        <div class="bank-card p-5 text-center">
          <span class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-3"><?= esc($step['step_number']) ?></span>
          <h3 class="font-semibold text-foreground text-sm"><?= esc($step['title']) ?></h3>
          <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($step['description']) ?></p>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No registration steps available.</p>
      <?php endif; ?>
    </div>

    <div class="bank-card p-6">
      <h3 class="font-heading text-lg text-foreground mb-4">FAQs</h3>
      <div class="space-y-3">
        <?php if (!empty($mobileFaqs)): ?>
          <?php foreach ($mobileFaqs as $faq): ?>
          <details>
            <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i><?= esc($faq['question']) ?></summary>
            <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc((string) $faq['answer'])) ?></p>
          </details>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No FAQs available.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'atm'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <div class="max-w-xl mb-8">
      <form method="get" action="<?= current_url() ?>">
        <label for="atm-search-page" class="text-sm font-medium text-foreground mb-2 block">Search by city, area, PIN, or ATM name</label>
        <div class="relative">
          <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" style="color: hsl(var(--muted-foreground));"></i>
          <input id="atm-search-page" type="search" name="q" value="<?= esc($atmSearch) ?>" placeholder="e.g. Jalgaon, 425001, Head Office" class="w-full pl-10 pr-4 py-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));">
        </div>
      </form>
    </div>

    <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));"><?= count($filteredAtmLocations) ?> ATM(s) found</p>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <?php if (!empty($filteredAtmLocations)): ?>
        <?php foreach ($filteredAtmLocations as $location): ?>
        <div class="bank-card p-5">
          <div class="flex items-start justify-between mb-2">
            <h3 class="font-semibold text-foreground"><?= esc($location['name']) ?></h3>
            <span class="text-xs px-2 py-0.5 rounded-full font-medium" style="background-color: <?= $location['atm_status'] === 'Active' ? 'hsl(var(--primary) / 0.1)' : 'hsl(var(--accent) / 0.15)' ?>; color: <?= $location['atm_status'] === 'Active' ? 'hsl(var(--primary))' : 'hsl(var(--accent-foreground))' ?>;">
              <?= esc($location['atm_status']) ?>
            </span>
          </div>
          <p class="text-sm flex items-center gap-1" style="color: hsl(var(--muted-foreground));">
            <i data-lucide="map-pin" class="w-4 h-4"></i>
            <?= esc($location['address'] ?: ($location['area'] . ', ' . $location['city'])) ?>
            <?php if ($location['pin']): ?> - <?= esc($location['pin']) ?><?php endif; ?>
          </p>
          <?php if ($location['location_type']): ?>
            <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));">
              <?= esc($location['location_type']) ?>
            </p>
          <?php endif; ?>
          <p class="text-sm flex items-center gap-1 mt-1" style="color: hsl(var(--muted-foreground));">
            <i data-lucide="clock" class="w-4 h-4"></i><?= esc($location['hours']) ?>
          </p>
          <?php if (!empty($location['latitude']) && !empty($location['longitude'])): ?>
            <a href="https://www.google.com/maps?q=<?= $location['latitude'] ?>,<?= $location['longitude'] ?>" target="_blank" class="text-xs mt-2 inline-block text-primary">
              <i data-lucide="map"></i> View on map
            </a>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="col-span-3">No ATMs found.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'block-card'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-3xl">
    <div class="bank-card p-8 mb-8 text-center" style="border: 2px solid hsl(var(--destructive));">
      <i data-lucide="alert-triangle" class="w-16 h-16 mx-auto mb-4" style="color: hsl(var(--destructive));"></i>
      <h2 class="font-heading text-2xl text-foreground mb-3">Emergency Card Block</h2>
      <p class="readable mb-6" style="color: hsl(var(--muted-foreground));">If your ATM or debit card is lost, stolen, or compromised, block it immediately using one of the options below.</p>
      <a href="tel:02572220055" class="btn-primary text-lg inline-flex items-center gap-2 px-8 py-4" style="background-color: hsl(var(--destructive)); color: hsl(var(--destructive-foreground));"><i data-lucide="phone" class="w-5 h-5"></i> Call: 0257-2220055</a>
      <p class="text-sm mt-3" style="color: hsl(var(--muted-foreground));">Available 24x7 for card blocking support</p>
    </div>

    <h2 class="font-heading text-xl text-foreground mb-4">How to Block Your Card</h2>
    <div class="space-y-4 mb-8">
      <?php if (!empty($blockCardMethods)): ?>
        <?php foreach ($blockCardMethods as $method): ?>
        <div class="bank-card p-5 flex items-start gap-4">
          <span class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: hsl(var(--destructive) / 0.1);">
            <i data-lucide="<?= esc($method['icon']) ?>" class="w-5 h-5" style="color: hsl(var(--destructive));"></i>
          </span>
          <div>
            <h3 class="font-semibold text-foreground"><?= esc($method['title']) ?></h3>
            <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($method['description']) ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No blocking methods available.</p>
      <?php endif; ?>
    </div>

    <div class="bank-card p-6">
      <h3 class="font-semibold text-foreground mb-3">After Blocking Your Card</h3>
      <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
        <?php if (!empty($blockCardAfterSteps)): ?>
          <?php foreach ($blockCardAfterSteps as $step): ?>
          <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full flex-shrink-0 mt-2" style="background-color: hsl(var(--destructive));"></span><?= esc($step) ?></li>
          <?php endforeach; ?>
        <?php else: ?>
          <li>No information available.</li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'ifsc-micr'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <div class="max-w-xl mb-8">
      <form method="get" action="<?= current_url() ?>">
        <label for="code-search-page" class="text-sm font-medium text-foreground mb-2 block">Search by branch name, city, or code</label>
        <div class="relative">
          <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" style="color: hsl(var(--muted-foreground));"></i>
          <input id="code-search-page" type="search" name="q" value="<?= esc($codeSearch) ?>" placeholder="e.g. Bhusawal, JPCB0000003" class="w-full pl-10 pr-4 py-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));">
        </div>
      </form>
    </div>

    <div class="bank-card overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full" role="table">
          <thead>
            <tr class="bg-primary text-primary-foreground">
              <th class="text-left p-4 font-semibold text-sm">Branch</th>
              <th class="text-left p-4 font-semibold text-sm">City</th>
              <th class="text-left p-4 font-semibold text-sm">IFSC Code</th>
              <th class="text-left p-4 font-semibold text-sm">MICR Code</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($filteredBranchCodes)): ?>
              <?php foreach ($filteredBranchCodes as $index => $code): ?>
              <tr class="border-b" style="border-color: hsl(var(--border)); background-color: <?= $index % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
                <td class="p-4 text-sm font-medium text-foreground"><?= esc($code['branch_name']) ?></td>
                <td class="p-4 text-sm text-foreground"><?= esc($code['city']) ?></td>
                <td class="p-4 text-sm">
                  <?php if (!empty($code['ifsc'])): ?>
                  <span class="flex items-center gap-2">
                    <code class="font-mono text-foreground"><?= esc($code['ifsc']) ?></code>
                    <button type="button" class="tap-target p-1 rounded text-xs" style="background-color: hsl(var(--muted));" onclick="navigator.clipboard.writeText('<?= esc($code['ifsc'], 'js') ?>'); this.textContent='Copied'; setTimeout(() => this.textContent='Copy', 1500);">Copy</button>
                  </span>
                  <?php else: ?>
                  —
                  <?php endif; ?>
                </td>
                <td class="p-4 text-sm">
                  <?php if (!empty($code['micr'])): ?>
                  <span class="flex items-center gap-2">
                    <code class="font-mono text-foreground"><?= esc($code['micr']) ?></code>
                    <button type="button" class="tap-target p-1 rounded text-xs" style="background-color: hsl(var(--muted));" onclick="navigator.clipboard.writeText('<?= esc($code['micr'], 'js') ?>'); this.textContent='Copied'; setTimeout(() => this.textContent='Copy', 1500);">Copy</button>
                  </span>
                  <?php else: ?>
                  —
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="4" class="p-4 text-center">No branches with IFSC/MICR codes found.<?php if ($codeSearch !== ''): ?> Try a different search.<?php endif; ?></td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'rtgs-neft'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-5xl">
    <div class="grid md:grid-cols-2 gap-6 mb-10">
      <div class="bank-card p-6">
        <h2 class="font-heading text-xl text-foreground mb-3">RTGS</h2>
        <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));"><?= esc($rtgsDescription ?? 'Real Time Gross Settlement for high-value, real-time transfers.') ?></p>
        <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
          <?php if (!empty($rtgsFeatures)): ?>
            <?php foreach ($rtgsFeatures as $feature): ?>
            <li class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-primary"></i><?= esc($feature) ?></li>
            <?php endforeach; ?>
          <?php else: ?>
            <li>Settlement: real-time</li>
            <li>Minimum: ₹2,00,000</li>
            <li>Availability: 24x7x365</li>
          <?php endif; ?>
        </ul>
      </div>
      <div class="bank-card p-6">
        <h2 class="font-heading text-xl text-foreground mb-3">NEFT</h2>
        <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));"><?= esc($neftDescription ?? 'National Electronic Funds Transfer for batch-processed transfers.') ?></p>
        <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
          <?php if (!empty($neftFeatures)): ?>
            <?php foreach ($neftFeatures as $feature): ?>
            <li class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-primary"></i><?= esc($feature) ?></li>
            <?php endforeach; ?>
          <?php else: ?>
            <li>Settlement: half-hourly batches</li>
            <li>Minimum: no minimum</li>
            <li>Availability: 24x7x365</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <div class="bank-card p-6 mb-8">
      <h2 class="font-heading text-lg text-foreground mb-4">How to Initiate a Transfer</h2>
      <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4">
        <?php if (!empty($transferSteps)): ?>
          <?php foreach ($transferSteps as $step): ?>
          <div class="text-center">
            <span class="w-8 h-8 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-2 text-sm"><?= esc($step['step']) ?></span>
            <h3 class="font-semibold text-foreground text-sm"><?= esc($step['title']) ?></h3>
            <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($step['desc']) ?></p>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No steps available.</p>
        <?php endif; ?>
      </div>
    </div>

    <div class="flex flex-wrap gap-3">
      <a href="<?= site_url('downloads/forms') ?>" class="btn-primary text-sm flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Download RTGS/NEFT Form</a>
      <a href="<?= site_url('digital/ifsc-micr') ?>" class="btn-outline text-sm">Search IFSC Codes</a>
      <a href="<?= site_url('services/charges') ?>" class="btn-outline text-sm">View Charges</a>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'upi'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <div class="bank-card p-8 text-center mb-10">
      <i data-lucide="qr-code" class="w-16 h-16 text-primary mx-auto mb-4"></i>
      <h2 class="font-heading text-2xl text-foreground mb-3">Unified Payments Interface</h2>
      <p class="readable max-w-2xl mx-auto" style="color: hsl(var(--muted-foreground));">Send and receive money instantly using your mobile phone, UPI ID, or QR code through real-time bank-to-bank transfers.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-10">
      <div class="bank-card p-6">
        <h3 class="font-semibold text-foreground mb-4 flex items-center gap-2"><i data-lucide="circle-check" class="w-5 h-5 text-primary"></i> Key Benefits</h3>
        <ul class="space-y-2">
          <?php if (!empty($upiBenefits)): ?>
            <?php foreach ($upiBenefits as $benefit): ?>
            <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><?= esc($benefit) ?></li>
            <?php endforeach; ?>
          <?php else: ?>
            <li>No benefits listed.</li>
          <?php endif; ?>
        </ul>
      </div>
      <div class="bank-card p-6">
        <h3 class="font-semibold text-foreground mb-4 flex items-center gap-2"><i data-lucide="shield" class="w-5 h-5" style="color: hsl(var(--destructive));"></i> Safety Tips</h3>
        <ul class="space-y-2">
          <?php if (!empty($upiSafetyTips)): ?>
            <?php foreach ($upiSafetyTips as $tip): ?>
            <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><i data-lucide="alert-triangle" class="w-4 h-4 flex-shrink-0" style="color: hsl(var(--accent));"></i><?= esc($tip) ?></li>
            <?php endforeach; ?>
          <?php else: ?>
            <li>No safety tips available.</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <div class="bank-card p-6">
      <h3 class="font-heading text-lg text-foreground mb-4">How to Link Your Account</h3>
      <div class="grid sm:grid-cols-3 gap-4">
        <?php if (!empty($upiLinkingSteps)): ?>
          <?php foreach ($upiLinkingSteps as $step): ?>
          <div class="text-center">
            <span class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-3"><?= esc($step['step_number']) ?></span>
            <h4 class="font-semibold text-foreground text-sm"><?= esc($step['title']) ?></h4>
            <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($step['description']) ?></p>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No linking steps available.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'digisaathi'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <div class="bank-card p-8 text-center mb-10">
      <i data-lucide="circle-help" class="w-16 h-16 text-primary mx-auto mb-4"></i>
      <h2 class="font-heading text-2xl text-foreground mb-3">Digital Payments Assistance</h2>
      <p class="readable max-w-2xl mx-auto" style="color: hsl(var(--muted-foreground));">DigiSaathi helps customers with digital payment queries around UPI, mobile banking, ATM cards, fraud prevention, and electronic transfers.</p>
    </div>

    <h2 class="font-heading text-xl text-foreground mb-6">How Can We Help?</h2>
    <div class="grid sm:grid-cols-2 gap-4 mb-10">
      <?php if (!empty($digisaathiCategories)): ?>
        <?php foreach ($digisaathiCategories as $category): ?>
        <div class="bank-card p-5">
          <h3 class="font-semibold text-foreground"><?= esc($category['title']) ?></h3>
          <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($category['description']) ?></p>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No categories available.</p>
      <?php endif; ?>
    </div>

    <div class="bank-card p-6">
      <h3 class="font-semibold text-foreground mb-4">Contact DigiSaathi</h3>
      <div class="grid sm:grid-cols-3 gap-4">
        <?php if (!empty($digisaathiContacts)): ?>
          <?php foreach ($digisaathiContacts as $contact): ?>
          <a href="<?= esc($contact['link']) ?>" <?= $contact['is_external'] ? 'target="_blank" rel="noopener"' : '' ?> class="flex items-center gap-3 p-4 rounded-lg transition-colors tap-target" style="background-color: hsl(var(--muted));">
            <i data-lucide="<?= esc($contact['icon']) ?>" class="w-6 h-6 text-primary"></i>
            <div>
              <p class="font-medium text-foreground"><?= esc($contact['title']) ?></p>
              <?php if (!empty($contact['subtitle'])): ?>
              <p class="text-xs" style="color: hsl(var(--muted-foreground));"><?= esc($contact['subtitle']) ?></p>
              <?php endif; ?>
            </div>
          </a>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No contact methods available.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
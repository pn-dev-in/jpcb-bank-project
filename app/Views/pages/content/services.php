<?php if ($pageKey === 'overview'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">Explore our range of banking services designed for safety, convenience, and compliance.</p>
    <div class="grid sm:grid-cols-2 gap-6">
      <?php if (!empty($serviceCards)): ?>
        <?php foreach ($serviceCards as $service): ?>
        <a href="<?= site_url(ltrim($service['href'], '/')) ?>" class="bank-card p-6 transition-colors">
          <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background-color: hsl(var(--primary) / 0.1);">
            <i data-lucide="<?= esc($service['icon']) ?>" class="w-6 h-6 text-primary"></i>
          </div>
          <h3 class="font-semibold text-foreground mb-2"><?= esc($service['title']) ?></h3>
          <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($service['description']) ?></p>
          <span class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-3">View details <i data-lucide="arrow-right" class="w-4 h-4"></i></span>
        </a>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No service cards found.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'charges'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
      <div class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));">
        <i data-lucide="calendar" class="w-4 h-4"></i><span>Effective from: <strong class="text-foreground">01 April 2026</strong></span>
      </div>
      <div class="flex gap-2">
        <button class="btn-outline text-sm flex items-center gap-1" type="button" onclick="window.print()"><i data-lucide="printer" class="w-4 h-4"></i> Print</button>
        <button class="btn-primary text-sm flex items-center gap-1" type="button"><i data-lucide="download" class="w-4 h-4"></i> Download PDF</button>
      </div>
    </div>
    <div class="space-y-8">
      <?php if (!empty($serviceCharges)): ?>
        <?php
        // Group by category
        $grouped = [];
        foreach ($serviceCharges as $charge) {
            $grouped[$charge['category']][] = $charge;
        }
        ?>
        <?php foreach ($grouped as $category => $items): ?>
        <div class="bank-card overflow-hidden">
          <div class="bg-primary text-primary-foreground p-4"><h3 class="font-semibold"><?= esc($category) ?></h3></div>
          <table class="w-full" role="table">
            <tbody>
              <?php foreach ($items as $index => $item): ?>
              <tr class="border-b" style="border-color: hsl(var(--border)); background-color: <?= $index % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
                <td class="p-4 text-sm text-foreground"><?= esc($item['service_name']) ?></td>
                <td class="p-4 text-sm text-right font-semibold text-foreground"><?= esc($item['charge']) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No service charges available.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'lockers'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <div class="bank-card p-8 text-center mb-10">
      <i data-lucide="lock" class="w-16 h-16 text-primary mx-auto mb-4"></i>
      <h2 class="font-heading text-2xl text-foreground mb-3">Secure Your Valuables</h2>
      <p class="readable" style="color: hsl(var(--muted-foreground));">Our safe deposit locker facility offers maximum security for your important documents, jewellery, and valuables.</p>
    </div>
    <h2 class="font-heading text-xl text-foreground mb-4">Locker Sizes & Charges</h2>
    <div class="grid sm:grid-cols-3 gap-4 mb-10">
      <?php if (!empty($lockerSizes)): ?>
        <?php foreach ($lockerSizes as $size): ?>
        <div class="bank-card p-5 text-center">
          <h3 class="font-semibold text-foreground text-lg mb-2"><?= esc($size['size']) ?></h3>
          <p class="text-xs mb-2" style="color: hsl(var(--muted-foreground));"><?= esc($size['dimensions']) ?></p>
          <p class="text-xl font-bold text-primary"><?= esc($size['rent']) ?></p>
          <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));">Key Deposit: <?= esc($size['deposit']) ?></p>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="col-span-3 text-center">No locker sizes available.</p>
      <?php endif; ?>
    </div>
    <div class="bank-card p-6 mb-8">
      <h3 class="font-semibold text-foreground mb-3">Eligibility & Process</h3>
      <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
        <?php if (!empty($lockerEligibility)): ?>
          <?php foreach ($lockerEligibility as $item): ?>
          <li class="flex items-center gap-2"><i data-lucide="circle-check" class="w-4 h-4 flex-shrink-0" style="color: hsl(var(--success, var(--primary)));"></i><?= esc($item) ?></li>
          <?php endforeach; ?>
        <?php else: ?>
          <li>No eligibility information available.</li>
        <?php endif; ?>
      </ul>
    </div>
    <div class="bank-card p-6 mb-8">
      <h3 class="font-heading text-lg text-foreground mb-4">FAQs</h3>
      <div class="space-y-3">
        <?php if (!empty($lockerFaqs)): ?>
          <?php foreach ($lockerFaqs as $faq): ?>
          <details>
            <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i><?= esc($faq['question']) ?></summary>
            <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));"><?= esc($faq['answer']) ?></p>
          </details>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No FAQs available.</p>
        <?php endif; ?>
      </div>
    </div>
    <div class="flex gap-3">
      <a href="<?= site_url('downloads/forms') ?>" class="btn-primary text-sm flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Download Locker Form</a>
      <a href="<?= site_url('contact') ?>" class="btn-outline text-sm">Enquire at Branch</a>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'insurance'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <p class="readable mb-10" style="color: hsl(var(--muted-foreground));">We offer government-backed insurance schemes to protect you and your family at affordable premiums.</p>
    <div class="space-y-6">
      <?php if (!empty($insuranceProducts)): ?>
        <?php foreach ($insuranceProducts as $product): ?>
        <div class="bank-card p-6">
          <h3 class="font-heading text-lg text-foreground mb-3"><?= esc($product['name']) ?></h3>
          <div class="grid sm:grid-cols-3 gap-4 mb-4">
            <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Premium</span><span class="text-lg font-bold text-primary"><?= esc($product['premium']) ?></span></div>
            <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Coverage</span><span class="text-sm font-medium text-foreground"><?= esc($product['cover']) ?></span></div>
            <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Eligibility</span><span class="text-sm font-medium text-foreground"><?= esc($product['eligibility']) ?></span></div>
          </div>
          <?php if (!empty($product['features'])): ?>
          <ul class="grid sm:grid-cols-2 gap-1">
            <?php foreach ($product['features'] as $feature): ?>
            <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><i data-lucide="circle-check" class="w-4 h-4 flex-shrink-0" style="color: hsl(var(--success, var(--primary)));"></i><?= esc($feature) ?></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No insurance products available.</p>
      <?php endif; ?>
    </div>
    <div class="flex gap-3 mt-8">
      <a href="<?= site_url('downloads/forms') ?>" class="btn-primary text-sm flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Download Forms</a>
      <a href="<?= site_url('contact') ?>" class="btn-outline text-sm">Enquire at Branch</a>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'positive-pay'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <div class="bank-card p-6 mb-8" style="border-left: 4px solid hsl(var(--primary));">
      <div class="flex items-start gap-3">
        <i data-lucide="shield" class="w-6 h-6 text-primary flex-shrink-0 mt-0.5"></i>
        <div>
          <h2 class="font-semibold text-foreground mb-1">What is Positive Pay?</h2>
          <p class="readable" style="color: hsl(var(--muted-foreground));">Positive Pay is a fraud prevention system mandated by RBI for cheques of ₹50,000 and above. The issuer provides key cheque details electronically, which are cross-verified before clearing.</p>
        </div>
      </div>
    </div>
    <div class="bank-card p-6 mb-8">
      <h3 class="font-semibold text-foreground mb-4">Details Required for Submission</h3>
      <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-3">
        <?php if (!empty($positivePayFields)): ?>
          <?php foreach ($positivePayFields as $field): ?>
          <div class="flex items-center gap-2 p-3 rounded-lg" style="background-color: hsl(var(--muted));">
            <i data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i>
            <span class="text-sm text-foreground"><?= esc($field) ?></span>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No field information available.</p>
        <?php endif; ?>
      </div>
    </div>
    <h2 class="font-heading text-xl text-foreground mb-4">How to Submit</h2>
    <div class="grid sm:grid-cols-2 gap-4 mb-8">
      <?php if (!empty($positivePayMethods)): ?>
        <?php foreach ($positivePayMethods as $method): ?>
        <div class="bank-card p-5">
          <h3 class="font-semibold text-foreground"><?= esc($method['title']) ?></h3>
          <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($method['desc']) ?></p>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No submission methods available.</p>
      <?php endif; ?>
    </div>
    <?php if (!empty($positivePayImportantNote)): ?>
    <div class="bank-card p-6 mb-8" style="border-left: 4px solid hsl(var(--warning, var(--accent)));">
      <div class="flex items-start gap-3">
        <i data-lucide="alert-circle" class="w-6 h-6 flex-shrink-0 mt-0.5" style="color: hsl(var(--warning, var(--accent)));"></i>
        <div>
          <h3 class="font-semibold text-foreground mb-1">Important</h3>
          <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc($positivePayImportantNote)) ?></p>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <a href="<?= site_url('downloads/forms') ?>" class="btn-primary text-sm flex items-center gap-2 w-fit"><i data-lucide="download" class="w-4 h-4"></i> Download Mandate Form</a>
  </div>
</section>
<?php endif; ?>
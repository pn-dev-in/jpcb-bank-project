<?php
$serviceCards = [
    ['icon' => 'wallet', 'title' => 'Service Charges', 'desc' => 'View fee schedule for all banking services.', 'href' => '/services/charges'],
    ['icon' => 'lock', 'title' => 'Safe Deposit Lockers', 'desc' => 'Secure locker facility at select branches.', 'href' => '/services/lockers'],
    ['icon' => 'shield', 'title' => 'Insurance Services', 'desc' => 'PMSBY, PMJJBY and other insurance products.', 'href' => '/services/insurance'],
    ['icon' => 'file-text', 'title' => 'Positive Pay System', 'desc' => 'Enhanced cheque security for high-value transactions.', 'href' => '/services/positive-pay'],
];

$chargeCategories = [
    ['category' => 'Savings Account', 'items' => [
        ['service' => 'Non-maintenance of minimum balance', 'charge' => '₹100 per quarter'],
        ['service' => 'Cheque book (20 leaves)', 'charge' => '₹50'],
        ['service' => 'Duplicate passbook', 'charge' => '₹50'],
        ['service' => 'Account closure (within 1 year)', 'charge' => '₹200'],
        ['service' => 'ATM card annual fee', 'charge' => '₹150'],
    ]],
    ['category' => 'Current Account', 'items' => [
        ['service' => 'Non-maintenance of minimum balance', 'charge' => '₹250 per quarter'],
        ['service' => 'Cheque book (50 leaves)', 'charge' => '₹100'],
        ['service' => 'Cash handling (above ₹5L/month)', 'charge' => '₹1 per ₹1000'],
    ]],
    ['category' => 'Remittances', 'items' => [
        ['service' => 'NEFT (up to ₹10,000)', 'charge' => '₹2.50 + GST'],
        ['service' => 'NEFT (₹10,001 to ₹1L)', 'charge' => '₹5 + GST'],
        ['service' => 'NEFT (₹1L to ₹2L)', 'charge' => '₹15 + GST'],
        ['service' => 'NEFT (above ₹2L)', 'charge' => '₹25 + GST'],
        ['service' => 'RTGS (₹2L to ₹5L)', 'charge' => '₹25 + GST'],
        ['service' => 'RTGS (above ₹5L)', 'charge' => '₹50 + GST'],
    ]],
    ['category' => 'Locker Charges', 'items' => [
        ['service' => 'Small locker (annual rent)', 'charge' => '₹1,500'],
        ['service' => 'Medium locker (annual rent)', 'charge' => '₹3,000'],
        ['service' => 'Large locker (annual rent)', 'charge' => '₹5,000'],
        ['service' => 'Key deposit', 'charge' => '₹500'],
    ]],
];

$insuranceProducts = [
    ['name' => 'PMSBY (Pradhan Mantri Suraksha Bima Yojana)', 'premium' => '₹20/year', 'cover' => '₹2 lakh accident insurance', 'eligibility' => 'Age 18-70, savings account holder', 'features' => ['Accidental death & disability cover', 'Auto-debit from account', 'Annual renewal', 'Government-backed scheme']],
    ['name' => 'PMJJBY (Pradhan Mantri Jeevan Jyoti Bima Yojana)', 'premium' => '₹436/year', 'cover' => '₹2 lakh life insurance', 'eligibility' => 'Age 18-50, savings account holder', 'features' => ['Life insurance cover', 'Death due to any cause', 'Auto-debit from account', 'Government-backed scheme']],
];

$lockerSizes = [
    ['size' => 'Small', 'dimensions' => '6" x 12" x 24"', 'rent' => '₹1,500/year', 'deposit' => '₹500'],
    ['size' => 'Medium', 'dimensions' => '12" x 12" x 24"', 'rent' => '₹3,000/year', 'deposit' => '₹500'],
    ['size' => 'Large', 'dimensions' => '18" x 12" x 24"', 'rent' => '₹5,000/year', 'deposit' => '₹500'],
];

$lockerFaqs = [
    ['q' => 'Who is eligible for a locker?', 'a' => 'Any individual or joint account holder with a savings or current account at the branch.'],
    ['q' => 'Is there a waiting period?', 'a' => 'Subject to availability. You may register on the waiting list at your branch.'],
    ['q' => 'What if I lose the key?', 'a' => 'Report immediately to the branch. A duplicate key will be arranged with applicable charges.'],
];

$positivePayFields = ['Account Number', 'Cheque Number', 'Cheque Date', 'Payee Name', 'Amount', 'Transaction Code'];
?>

<?php if ($pageKey === 'overview'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">Explore our range of banking services designed for safety, convenience, and compliance.</p>
    <div class="grid sm:grid-cols-2 gap-6">
      <?php foreach ($serviceCards as $service): ?>
      <a href="<?= site_url(ltrim($service['href'], '/')) ?>" class="bank-card p-6 transition-colors">
        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background-color: hsl(var(--primary) / 0.1);">
          <i data-lucide="<?= esc($service['icon']) ?>" class="w-6 h-6 text-primary"></i>
        </div>
        <h3 class="font-semibold text-foreground mb-2"><?= esc($service['title']) ?></h3>
        <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($service['desc']) ?></p>
        <span class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-3">View details <i data-lucide="arrow-right" class="w-4 h-4"></i></span>
      </a>
      <?php endforeach; ?>
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
      <?php foreach ($chargeCategories as $category): ?>
      <div class="bank-card overflow-hidden">
        <div class="bg-primary text-primary-foreground p-4"><h3 class="font-semibold"><?= esc($category['category']) ?></h3></div>
        <table class="w-full" role="table">
          <tbody>
            <?php foreach ($category['items'] as $index => $item): ?>
            <tr class="border-b" style="border-color: hsl(var(--border)); background-color: <?= $index % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
              <td class="p-4 text-sm text-foreground"><?= esc($item['service']) ?></td>
              <td class="p-4 text-sm text-right font-semibold text-foreground"><?= esc($item['charge']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endforeach; ?>
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
      <?php foreach ($lockerSizes as $size): ?>
      <div class="bank-card p-5 text-center">
        <h3 class="font-semibold text-foreground text-lg mb-2"><?= esc($size['size']) ?></h3>
        <p class="text-xs mb-2" style="color: hsl(var(--muted-foreground));"><?= esc($size['dimensions']) ?></p>
        <p class="text-xl font-bold text-primary"><?= esc($size['rent']) ?></p>
        <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));">Key Deposit: <?= esc($size['deposit']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="bank-card p-6 mb-8">
      <h3 class="font-semibold text-foreground mb-3">Eligibility & Process</h3>
      <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
        <?php foreach (['Savings or Current account at the branch', 'KYC documents (Aadhaar, PAN)', 'Passport-size photograph', 'Signed locker agreement', 'Annual rent payment in advance', 'Nomination form'] as $item): ?>
        <li class="flex items-center gap-2"><i data-lucide="circle-check" class="w-4 h-4 flex-shrink-0" style="color: hsl(var(--success, var(--primary)));"></i><?= esc($item) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="bank-card p-6 mb-8">
      <h3 class="font-heading text-lg text-foreground mb-4">FAQs</h3>
      <div class="space-y-3">
        <?php foreach ($lockerFaqs as $faq): ?>
        <details>
          <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i><?= esc($faq['q']) ?></summary>
          <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));"><?= esc($faq['a']) ?></p>
        </details>
        <?php endforeach; ?>
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
      <?php foreach ($insuranceProducts as $product): ?>
      <div class="bank-card p-6">
        <h3 class="font-heading text-lg text-foreground mb-3"><?= esc($product['name']) ?></h3>
        <div class="grid sm:grid-cols-3 gap-4 mb-4">
          <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Premium</span><span class="text-lg font-bold text-primary"><?= esc($product['premium']) ?></span></div>
          <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Coverage</span><span class="text-sm font-medium text-foreground"><?= esc($product['cover']) ?></span></div>
          <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Eligibility</span><span class="text-sm font-medium text-foreground"><?= esc($product['eligibility']) ?></span></div>
        </div>
        <ul class="grid sm:grid-cols-2 gap-1">
          <?php foreach ($product['features'] as $feature): ?>
          <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><i data-lucide="circle-check" class="w-4 h-4 flex-shrink-0" style="color: hsl(var(--success, var(--primary)));"></i><?= esc($feature) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endforeach; ?>
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
        <?php foreach ($positivePayFields as $field): ?>
        <div class="flex items-center gap-2 p-3 rounded-lg" style="background-color: hsl(var(--muted));">
          <i data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i>
          <span class="text-sm text-foreground"><?= esc($field) ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <h2 class="font-heading text-xl text-foreground mb-4">How to Submit</h2>
    <div class="grid sm:grid-cols-2 gap-4 mb-8">
      <?php foreach ([['title' => 'Mobile Banking App', 'desc' => 'Go to Services → Positive Pay → Enter cheque details → Submit.'], ['title' => 'Visit Branch', 'desc' => 'Fill the Positive Pay mandate form and submit at your branch before issuing the cheque.']] as $method): ?>
      <div class="bank-card p-5">
        <h3 class="font-semibold text-foreground"><?= esc($method['title']) ?></h3>
        <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($method['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="bank-card p-6 mb-8" style="border-left: 4px solid hsl(var(--warning, var(--accent)));">
      <div class="flex items-start gap-3">
        <i data-lucide="alert-circle" class="w-6 h-6 flex-shrink-0 mt-0.5" style="color: hsl(var(--warning, var(--accent)));"></i>
        <div>
          <h3 class="font-semibold text-foreground mb-1">Important</h3>
          <p class="text-sm" style="color: hsl(var(--muted-foreground));">Submit Positive Pay details before the cheque is presented for clearing. Cheques without Positive Pay confirmation for amounts of ₹50,000 or more may be returned unpaid.</p>
        </div>
      </div>
    </div>
    <a href="<?= site_url('downloads/forms') ?>" class="btn-primary text-sm flex items-center gap-2 w-fit"><i data-lucide="download" class="w-4 h-4"></i> Download Mandate Form</a>
  </div>
</section>
<?php endif; ?>

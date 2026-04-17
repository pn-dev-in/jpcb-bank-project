<?php
$loanCards = [
    ['icon' => 'car', 'title' => 'Vehicle Loan', 'desc' => 'Personal and commercial vehicle financing with flexible EMIs.', 'href' => '/loans/products', 'rate' => 'From 9.50% p.a.'],
    ['icon' => 'coins', 'title' => 'Gold Loan', 'desc' => 'Quick disbursement against gold ornaments.', 'href' => '/loans/products', 'rate' => 'From 8.50% p.a.'],
    ['icon' => 'building', 'title' => 'Business Loan', 'desc' => 'Working capital and term support for MSMEs.', 'href' => '/loans/products', 'rate' => 'From 10.50% p.a.'],
    ['icon' => 'tractor', 'title' => 'Agri Finance', 'desc' => 'Crop loans, KCC, and farm equipment finance.', 'href' => '/loans/products', 'rate' => 'From 7.00% p.a.'],
    ['icon' => 'briefcase', 'title' => 'Term Loan', 'desc' => 'Secured medium and long-term finance for multiple needs.', 'href' => '/loans/products', 'rate' => 'From 10.00% p.a.'],
];

$loanProducts = [
    ['name' => 'Vehicle Loan', 'rate' => '9.50% - 12.00%', 'tenure' => 'Up to 7 years', 'margin' => '15-25%', 'security' => 'Hypothecation of vehicle', 'eligibility' => 'Salaried / self-employed, age 21-65', 'docs' => ['ID proof', 'Address proof', 'Income proof', 'Quotation or invoice', 'Driving license'], 'features' => ['New & used vehicles', 'Quick processing', 'Flexible EMI', 'Minimal documentation']],
    ['name' => 'Gold Loan', 'rate' => '8.50% - 11.00%', 'tenure' => 'Up to 12 months', 'margin' => '25%', 'security' => 'Pledge of gold ornaments', 'eligibility' => 'Any individual with gold collateral', 'docs' => ['ID proof', 'Address proof', 'Gold for assessment'], 'features' => ['Same-day disbursement', 'No income proof needed', 'Secure vault storage', 'Bullet repayment option']],
    ['name' => 'Business / MSME Loan', 'rate' => '10.50% - 13.50%', 'tenure' => 'Up to 5 years', 'margin' => '20-30%', 'security' => 'Collateral / CGTMSE', 'eligibility' => 'Registered business with 2+ years of operations', 'docs' => ['Business registration', 'ITR (3 years)', 'Bank statements', 'Property documents', 'GST certificate'], 'features' => ['Working capital', 'Term loan', 'CC/OD facility', 'CGTMSE support']],
    ['name' => 'Kisan Credit Card (KCC)', 'rate' => '7.00% - 9.00%', 'tenure' => 'Annual renewal', 'margin' => 'As per RBI norms', 'security' => 'Agricultural land', 'eligibility' => 'Farmers with cultivable land', 'docs' => ['7/12 extract', 'ID and address proof', 'Crop details', 'Land records'], 'features' => ['Subsidized interest', 'Crop and allied activities', 'Accident cover', 'Easy renewal']],
    ['name' => 'Term Loan (Secured)', 'rate' => '10.00% - 13.00%', 'tenure' => 'Up to 7 years', 'margin' => '25-30%', 'security' => 'Immovable property', 'eligibility' => 'Salaried / self-employed', 'docs' => ['ID proof', 'Income proof', 'Property documents', 'Valuation report'], 'features' => ['Competitive rates', 'Flexible repayment', 'Part-prepayment allowed', 'Top-up facility']],
];

$loanRates = [
    ['product' => 'Vehicle Loan (New)', 'rate' => '9.50% - 11.50%', 'processing' => '0.50%', 'prepayment' => '2%'],
    ['product' => 'Vehicle Loan (Used)', 'rate' => '10.50% - 12.00%', 'processing' => '0.75%', 'prepayment' => '2%'],
    ['product' => 'Gold Loan', 'rate' => '8.50% - 11.00%', 'processing' => '0.25%', 'prepayment' => 'Nil'],
    ['product' => 'Business Loan (Secured)', 'rate' => '10.50% - 13.00%', 'processing' => '1.00%', 'prepayment' => '2%'],
    ['product' => 'Business Loan (CGTMSE)', 'rate' => '11.00% - 13.50%', 'processing' => '1.00%', 'prepayment' => '2%'],
    ['product' => 'Kisan Credit Card', 'rate' => '7.00% - 9.00%', 'processing' => 'Nil', 'prepayment' => 'Nil'],
    ['product' => 'Crop Loan', 'rate' => '7.00% - 9.00%', 'processing' => 'Nil', 'prepayment' => 'Nil'],
    ['product' => 'Term Loan (Secured)', 'rate' => '10.00% - 13.00%', 'processing' => '1.00%', 'prepayment' => '2%'],
    ['product' => 'Working Capital (CC/OD)', 'rate' => '11.00% - 14.00%', 'processing' => '0.50%', 'prepayment' => 'N/A'],
    ['product' => 'Staff Loan', 'rate' => '6.50% - 8.00%', 'processing' => 'Nil', 'prepayment' => 'Nil'],
];
?>

<?php if ($pageKey === 'overview'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">We offer credit facilities for personal, business, and agricultural needs with competitive rates, practical documentation requirements, and flexible repayment structures.</p>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
      <?php foreach ($loanCards as $card): ?>
      <a href="<?= site_url(ltrim($card['href'], '/')) ?>" class="bank-card p-6 group transition-colors">
        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background-color: hsl(var(--primary) / 0.1);">
          <i data-lucide="<?= esc($card['icon']) ?>" class="w-6 h-6 text-primary"></i>
        </div>
        <h3 class="font-semibold text-foreground mb-1 group-hover:text-primary"><?= esc($card['title']) ?></h3>
        <p class="text-sm text-primary font-medium mb-2"><?= esc($card['rate']) ?></p>
        <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($card['desc']) ?></p>
        <span class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-3">Learn more <i data-lucide="arrow-right" class="w-4 h-4"></i></span>
      </a>
      <?php endforeach; ?>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
      <a href="<?= site_url('loans/interest-rates') ?>" class="bank-card p-6 flex items-center gap-4 transition-colors">
        <i data-lucide="trending-up" class="w-10 h-10 text-primary"></i>
        <div>
          <h3 class="font-semibold text-foreground">Loan Interest Rates</h3>
          <p class="text-sm" style="color: hsl(var(--muted-foreground));">View current rates for all loan products</p>
        </div>
      </a>
      <a href="<?= site_url('loans/emi-calculator') ?>" class="bank-card p-6 flex items-center gap-4 transition-colors">
        <i data-lucide="calculator" class="w-10 h-10 text-primary"></i>
        <div>
          <h3 class="font-semibold text-foreground">EMI Calculator</h3>
          <p class="text-sm" style="color: hsl(var(--muted-foreground));">Plan repayments before applying</p>
        </div>
      </a>
    </div>
  </div>
</section>
<?php elseif ($pageKey === 'products'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <div class="space-y-8">
      <?php foreach ($loanProducts as $product): ?>
      <div class="bank-card p-6">
        <h3 class="font-heading text-xl text-foreground mb-4"><?= esc($product['name']) ?></h3>
        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
          <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Interest Rate</span><span class="text-sm font-semibold text-primary"><?= esc($product['rate']) ?></span></div>
          <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Max Tenure</span><span class="text-sm font-medium text-foreground"><?= esc($product['tenure']) ?></span></div>
          <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Margin</span><span class="text-sm font-medium text-foreground"><?= esc($product['margin']) ?></span></div>
          <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Security</span><span class="text-sm font-medium text-foreground"><?= esc($product['security']) ?></span></div>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
          <div>
            <h4 class="text-sm font-semibold text-foreground mb-2">Eligibility</h4>
            <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($product['eligibility']) ?></p>
          </div>
          <div>
            <h4 class="text-sm font-semibold text-foreground mb-2">Key Features</h4>
            <ul class="space-y-1">
              <?php foreach ($product['features'] as $feature): ?>
              <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><?= esc($feature) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div>
            <h4 class="text-sm font-semibold text-foreground mb-2">Documents Required</h4>
            <ul class="space-y-1">
              <?php foreach ($product['docs'] as $document): ?>
              <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><span class="w-1.5 h-1.5 rounded-full" style="background-color: hsl(var(--muted-foreground));"></span><?= esc($document) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <div class="flex gap-3 mt-4 pt-4 border-t" style="border-color: hsl(var(--border));">
          <a href="<?= site_url('loans/emi-calculator') ?>" class="btn-primary text-sm">Calculate EMI</a>
          <a href="<?= site_url('downloads/forms') ?>" class="btn-outline text-sm flex items-center gap-1"><i data-lucide="download" class="w-4 h-4"></i> Application Form</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php elseif ($pageKey === 'interest-rates'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
      <div class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));">
        <i data-lucide="calendar" class="w-4 h-4"></i>
        <span>Effective from: <strong class="text-foreground">01 April 2026</strong></span>
      </div>
      <div class="flex gap-2">
        <button class="btn-outline text-sm flex items-center gap-1" type="button" onclick="window.print()"><i data-lucide="printer" class="w-4 h-4"></i> Print</button>
        <button class="btn-primary text-sm flex items-center gap-1" type="button"><i data-lucide="download" class="w-4 h-4"></i> Download PDF</button>
      </div>
    </div>

    <div class="bank-card overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full" role="table">
          <thead>
            <tr class="bg-primary text-primary-foreground">
              <th class="text-left p-4 font-semibold text-sm">Loan Product</th>
              <th class="text-center p-4 font-semibold text-sm">Interest Rate (% p.a.)</th>
              <th class="text-center p-4 font-semibold text-sm">Processing Fee</th>
              <th class="text-center p-4 font-semibold text-sm">Prepayment Charge</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($loanRates as $index => $rate): ?>
            <tr class="border-b" style="border-color: hsl(var(--border)); background-color: <?= $index % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
              <td class="p-4 text-sm font-medium text-foreground"><?= esc($rate['product']) ?></td>
              <td class="p-4 text-sm text-center font-semibold text-primary"><?= esc($rate['rate']) ?></td>
              <td class="p-4 text-sm text-center text-foreground"><?= esc($rate['processing']) ?></td>
              <td class="p-4 text-sm text-center text-foreground"><?= esc($rate['prepayment']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-6 bank-card p-4">
      <h3 class="font-semibold text-foreground text-sm mb-2">Notes</h3>
      <ul class="text-sm space-y-1" style="color: hsl(var(--muted-foreground));">
        <li>Rates depend on loan amount, tenure, borrower profile, and security offered.</li>
        <li>Agricultural loan rates may include government subsidy or scheme-linked benefits.</li>
        <li>Processing fees are one-time and non-refundable.</li>
        <li>Please contact your branch for exact pricing and eligibility.</li>
      </ul>
    </div>
  </div>
</section>
<?php elseif ($pageKey === 'emi-calculator'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <div class="grid lg:grid-cols-5 gap-8">
      <div class="lg:col-span-2">
        <div class="bank-card p-6 sticky top-24">
          <h2 class="font-heading text-lg text-foreground mb-6">Calculate Your EMI</h2>
          <div class="space-y-6" id="emi-calculator-root">
            <div>
              <label for="emi-principal" class="text-sm font-medium text-foreground block mb-2">Loan Amount: <strong class="text-primary" id="emi-principal-display">₹5,00,000</strong></label>
              <input id="emi-principal" type="range" min="10000" max="10000000" step="10000" value="500000" class="w-full accent-primary">
              <div class="flex justify-between text-xs mt-1" style="color: hsl(var(--muted-foreground));"><span>₹10K</span><span>₹1Cr</span></div>
            </div>
            <div>
              <label for="emi-rate" class="text-sm font-medium text-foreground block mb-2">Interest Rate: <strong class="text-primary" id="emi-rate-display">10%</strong> p.a.</label>
              <input id="emi-rate" type="range" min="1" max="24" step="0.25" value="10" class="w-full accent-primary">
              <div class="flex justify-between text-xs mt-1" style="color: hsl(var(--muted-foreground));"><span>1%</span><span>24%</span></div>
            </div>
            <div>
              <label for="emi-tenure" class="text-sm font-medium text-foreground block mb-2">Tenure: <strong class="text-primary" id="emi-tenure-display">36 months</strong> <span style="color: hsl(var(--muted-foreground));">(<span id="emi-years-display">3.0</span> years)</span></label>
              <input id="emi-tenure" type="range" min="1" max="120" step="1" value="36" class="w-full accent-primary">
              <div class="flex justify-between text-xs mt-1" style="color: hsl(var(--muted-foreground));"><span>1 mo</span><span>10 yrs</span></div>
            </div>
            <button type="button" id="emi-reset" class="btn-outline text-sm w-full flex items-center justify-center gap-2"><i data-lucide="rotate-ccw" class="w-4 h-4"></i> Reset</button>
          </div>
        </div>
      </div>

      <div class="lg:col-span-3">
        <div class="grid sm:grid-cols-3 gap-4 mb-8">
          <div class="bank-card p-5 text-center">
            <p class="text-xs mb-1" style="color: hsl(var(--muted-foreground));">Monthly EMI</p>
            <p class="text-2xl font-heading font-bold text-primary" id="emi-monthly-value">₹16,134</p>
          </div>
          <div class="bank-card p-5 text-center">
            <p class="text-xs mb-1" style="color: hsl(var(--muted-foreground));">Total Interest</p>
            <p class="text-2xl font-heading font-bold text-foreground" id="emi-interest-value">₹80,823</p>
          </div>
          <div class="bank-card p-5 text-center">
            <p class="text-xs mb-1" style="color: hsl(var(--muted-foreground));">Total Payable</p>
            <p class="text-2xl font-heading font-bold text-foreground" id="emi-total-value">₹5,80,823</p>
          </div>
        </div>

        <div class="bank-card p-5 mb-8">
          <h3 class="text-sm font-semibold text-foreground mb-3">Payment Breakdown</h3>
          <div class="flex rounded-full overflow-hidden h-6" aria-hidden="true">
            <div id="emi-principal-bar" class="bg-primary" style="width: 86%;"></div>
            <div id="emi-interest-bar" style="width: 14%; background-color: hsl(var(--accent));"></div>
          </div>
          <div class="flex gap-6 mt-2 text-xs">
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-primary"></span>Principal: <strong id="emi-principal-summary">₹5,00,000</strong></span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded" style="background-color: hsl(var(--accent));"></span>Interest: <strong id="emi-interest-summary">₹80,823</strong></span>
          </div>
        </div>

        <div class="bank-card overflow-hidden">
          <div class="p-4 border-b flex items-center justify-between" style="border-color: hsl(var(--border));">
            <h3 class="font-semibold text-foreground text-sm">Amortization Schedule</h3>
            <button type="button" onclick="window.print()" class="text-sm text-primary flex items-center gap-1"><i data-lucide="printer" class="w-4 h-4"></i> Print</button>
          </div>
          <div class="overflow-x-auto max-h-[400px] overflow-y-auto">
            <table class="w-full text-sm" role="table">
              <thead class="sticky top-0">
                <tr class="bg-muted">
                  <th class="p-3 text-left font-medium" style="color: hsl(var(--muted-foreground));">Month</th>
                  <th class="p-3 text-right font-medium" style="color: hsl(var(--muted-foreground));">EMI</th>
                  <th class="p-3 text-right font-medium" style="color: hsl(var(--muted-foreground));">Principal</th>
                  <th class="p-3 text-right font-medium" style="color: hsl(var(--muted-foreground));">Interest</th>
                  <th class="p-3 text-right font-medium" style="color: hsl(var(--muted-foreground));">Balance</th>
                </tr>
              </thead>
              <tbody id="emi-schedule-body"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

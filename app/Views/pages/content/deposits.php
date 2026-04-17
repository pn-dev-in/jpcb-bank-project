<?php
$depositCards = [
    ['icon' => 'piggy-bank', 'title' => 'Savings Account', 'desc' => 'Regular, BSBDA, kids, and premium savings accounts.', 'href' => '/deposits/savings-current'],
    ['icon' => 'landmark', 'title' => 'Current Account', 'desc' => 'Business-ready accounts with transaction flexibility.', 'href' => '/deposits/savings-current'],
    ['icon' => 'trending-up', 'title' => 'Fixed Deposit', 'desc' => 'Flexible tenures from 7 days to 10 years.', 'href' => '/deposits/products'],
    ['icon' => 'wallet', 'title' => 'Recurring Deposit', 'desc' => 'Monthly savings plans with assured returns.', 'href' => '/deposits/products'],
];

$depositQuickLinks = [
    ['icon' => 'trending-up', 'label' => 'Deposit Interest Rates', 'href' => '/deposits/interest-rates'],
    ['icon' => 'calculator', 'label' => 'EMI Calculator', 'href' => '/loans/emi-calculator'],
    ['icon' => 'shield', 'label' => 'DICGC Insurance', 'href' => '/deposits/dicgc'],
    ['icon' => 'building', 'label' => 'DEAF Deposits', 'href' => '/deposits/deaf'],
    ['icon' => 'download', 'label' => 'Account Opening Forms', 'href' => '/downloads/forms'],
];

$depositProducts = [
    ['name' => 'Fixed Deposit', 'tenure' => '7 days to 10 years', 'minAmount' => '₹1,000', 'interest' => 'Up to 8.50% p.a.', 'payout' => 'Monthly / Quarterly / Maturity', 'features' => ['Loan against FD available', 'Auto-renewal facility', 'Nomination facility', 'Senior citizen bonus rate']],
    ['name' => 'Recurring Deposit', 'tenure' => '6 months to 10 years', 'minAmount' => '₹100/month', 'interest' => 'Up to 8.00% p.a.', 'payout' => 'At maturity', 'features' => ['Flexible monthly installments', 'Pre-mature withdrawal allowed', 'Nomination facility', 'Standing instruction facility']],
    ['name' => 'Cumulative Deposit', 'tenure' => '1 year to 5 years', 'minAmount' => '₹5,000', 'interest' => 'Up to 8.25% p.a.', 'payout' => 'Compounded quarterly', 'features' => ['Higher returns on lump sum', 'Interest compounded quarterly', 'Nomination facility', 'Suitable for long-term goals']],
    ['name' => 'Tax Saving Deposit', 'tenure' => '5 years (lock-in)', 'minAmount' => '₹10,000', 'interest' => 'Up to 7.75% p.a.', 'payout' => 'At maturity', 'features' => ['Tax deduction under 80C', 'Maximum ₹1.5 lakh per year', 'Lock-in period of 5 years', 'Nomination facility']],
    ['name' => 'Daily Deposit Scheme', 'tenure' => '1 to 5 years', 'minAmount' => '₹50/day', 'interest' => 'Up to 7.50% p.a.', 'payout' => 'At maturity', 'features' => ['Door-step collection', 'Ideal for small businesses', 'Flexible daily amounts', 'Maturity benefit']],
];

$depositRates = [
    ['tenure' => '7 days to 14 days', 'general' => '4.00%', 'senior' => '4.50%'],
    ['tenure' => '15 days to 29 days', 'general' => '4.50%', 'senior' => '5.00%'],
    ['tenure' => '30 days to 45 days', 'general' => '5.00%', 'senior' => '5.50%'],
    ['tenure' => '46 days to 90 days', 'general' => '5.50%', 'senior' => '6.00%'],
    ['tenure' => '91 days to 180 days', 'general' => '6.50%', 'senior' => '7.00%'],
    ['tenure' => '181 days to 364 days', 'general' => '7.25%', 'senior' => '7.75%'],
    ['tenure' => '1 year to 2 years', 'general' => '7.75%', 'senior' => '8.25%'],
    ['tenure' => '2 years to 3 years', 'general' => '8.00%', 'senior' => '8.50%'],
    ['tenure' => '3 years to 5 years', 'general' => '7.75%', 'senior' => '8.25%'],
    ['tenure' => '5 years to 10 years', 'general' => '7.50%', 'senior' => '8.00%'],
];

$savingsAccounts = [
    ['name' => 'Regular Savings Account', 'minBalance' => '₹500', 'interest' => '3.50% p.a.', 'features' => ['ATM / Debit Card', 'Mobile Banking', 'UPI Access', 'Cheque Book']],
    ['name' => 'BSBDA (Basic Savings)', 'minBalance' => 'Zero', 'interest' => '3.00% p.a.', 'features' => ['No minimum balance', 'ATM Card', 'Limited transactions', 'Financial inclusion']],
    ['name' => 'Bal Bachat (Kids Account)', 'minBalance' => '₹100', 'interest' => '4.00% p.a.', 'features' => ['For minors below 18', 'Joint with parent / guardian', 'ATM Card at 10+', 'Savings habit building']],
    ['name' => 'Premium Savings Account', 'minBalance' => '₹25,000', 'interest' => '4.50% p.a.', 'features' => ['Higher interest', 'Priority service', 'Free RTGS/NEFT', 'Locker preference']],
];

$currentAccounts = [
    ['name' => 'Regular Current Account', 'minBalance' => '₹5,000', 'features' => ['Unlimited transactions', 'Cheque book', 'Internet banking', 'RTGS/NEFT']],
    ['name' => 'MSME Current Account', 'minBalance' => '₹2,500', 'features' => ['Lower minimum balance', 'Business loan access', 'CC/OD facility', 'Trade finance support']],
    ['name' => 'Trust / Society Account', 'minBalance' => '₹5,000', 'features' => ['Multiple signatories', 'Resolution-based operations', 'Audit records support', 'Dedicated service desk']],
];

$dicgcFaqs = [
    ['q' => 'What is the coverage limit?', 'a' => 'Each depositor is insured up to ₹5,00,000 across all eligible deposits held in the same bank.'],
    ['q' => 'What types of deposits are covered?', 'a' => 'Savings, fixed, current, recurring, and other eligible deposits are covered, subject to DICGC rules.'],
    ['q' => 'Is there any cost to the depositor?', 'a' => 'No. The insurance premium is paid by the bank and not by the depositor.'],
    ['q' => 'When is the insurance claim paid?', 'a' => 'The claim is processed in accordance with DICGC and RBI directions if a bank is liquidated or reconstructed.'],
];

$deafSteps = [
    ['step' => '1', 'title' => 'Identify your deposit', 'desc' => 'Check whether you have an unclaimed or inoperative deposit with the bank.'],
    ['step' => '2', 'title' => 'Visit the branch', 'desc' => 'Visit the branch where the account was held with valid identity proof.'],
    ['step' => '3', 'title' => 'Submit claim form', 'desc' => 'Fill and submit the DEAF claim form with required documents.'],
    ['step' => '4', 'title' => 'Verification & credit', 'desc' => 'After verification, the amount will be credited to your account.'],
];
?>

<?php if ($pageKey === 'overview'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">Grow your savings with deposit products designed for individuals, families, and businesses. Eligible deposits up to ₹5 lakh are insured under DICGC.</p>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
      <?php foreach ($depositCards as $card): ?>
      <a href="<?= site_url(ltrim($card['href'], '/')) ?>" class="bank-card p-6 group transition-colors">
        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background-color: hsl(var(--primary) / 0.1);">
          <i data-lucide="<?= esc($card['icon']) ?>" class="w-6 h-6 text-primary"></i>
        </div>
        <h3 class="font-semibold text-foreground mb-2 group-hover:text-primary"><?= esc($card['title']) ?></h3>
        <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($card['desc']) ?></p>
        <span class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-3">Learn more <i data-lucide="arrow-right" class="w-4 h-4"></i></span>
      </a>
      <?php endforeach; ?>
    </div>

    <div class="bank-card p-6">
      <h2 class="font-heading text-xl text-foreground mb-4">Quick Links</h2>
      <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
        <?php foreach ($depositQuickLinks as $link): ?>
        <a href="<?= site_url(ltrim($link['href'], '/')) ?>" class="flex items-center gap-2 p-3 rounded-lg hover-bg-muted transition-colors tap-target">
          <i data-lucide="<?= esc($link['icon']) ?>" class="w-5 h-5 text-primary flex-shrink-0"></i>
          <span class="text-sm font-medium text-foreground"><?= esc($link['label']) ?></span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="section-padding section-alt">
  <div class="container-bank text-center">
    <i data-lucide="shield" class="w-12 h-12 text-primary mx-auto mb-4"></i>
    <h2 class="font-heading text-2xl text-foreground mb-3">Your Deposits Are Safe</h2>
    <p class="readable max-w-2xl mx-auto" style="color: hsl(var(--muted-foreground));">All eligible deposits up to ₹5,00,000 per depositor are insured under the Deposit Insurance and Credit Guarantee Corporation scheme.</p>
    <a href="<?= site_url('deposits/dicgc') ?>" class="btn-primary inline-block mt-6">Learn About DICGC Insurance</a>
  </div>
</section>
<?php elseif ($pageKey === 'products'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">Choose from a range of deposit products tailored for short-term liquidity, steady monthly savings, or long-term wealth building.</p>
    <div class="space-y-6">
      <?php foreach ($depositProducts as $product): ?>
      <div class="bank-card p-6">
        <div class="flex flex-col lg:flex-row lg:items-start gap-6">
          <div class="flex-1">
            <h3 class="font-heading text-lg text-foreground mb-3"><?= esc($product['name']) ?></h3>
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
              <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Tenure</span><span class="text-sm font-medium text-foreground"><?= esc($product['tenure']) ?></span></div>
              <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Min. Amount</span><span class="text-sm font-medium text-foreground"><?= esc($product['minAmount']) ?></span></div>
              <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Interest Rate</span><span class="text-sm font-medium text-primary"><?= esc($product['interest']) ?></span></div>
              <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Payout</span><span class="text-sm font-medium text-foreground"><?= esc($product['payout']) ?></span></div>
            </div>
            <ul class="grid sm:grid-cols-2 gap-1">
              <?php foreach ($product['features'] as $feature): ?>
              <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><span class="w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span><?= esc($feature) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="flex flex-col gap-2 lg:min-w-[160px]">
            <a href="<?= site_url('deposits/interest-rates') ?>" class="btn-primary text-sm text-center">View Rates</a>
            <a href="<?= site_url('downloads/forms') ?>" class="btn-outline text-sm text-center flex items-center justify-center gap-1"><i data-lucide="download" class="w-4 h-4"></i> Application Form</a>
          </div>
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
              <th class="text-left p-4 font-semibold text-sm">Tenure</th>
              <th class="text-center p-4 font-semibold text-sm">General Rate (% p.a.)</th>
              <th class="text-center p-4 font-semibold text-sm">Senior Citizen Rate (% p.a.)</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($depositRates as $index => $rate): ?>
            <tr class="border-b" style="border-color: hsl(var(--border)); background-color: <?= $index % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
              <td class="p-4 text-sm text-foreground"><?= esc($rate['tenure']) ?></td>
              <td class="p-4 text-sm text-center font-semibold text-foreground"><?= esc($rate['general']) ?></td>
              <td class="p-4 text-sm text-center font-semibold text-primary"><?= esc($rate['senior']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-6 bank-card p-4">
      <h3 class="font-semibold text-foreground text-sm mb-2">Notes</h3>
      <ul class="text-sm space-y-1" style="color: hsl(var(--muted-foreground));">
        <li>Senior citizen rates apply for depositors aged 60 years and above.</li>
        <li>Rates are subject to change without prior notice.</li>
        <li>For deposits above ₹2 crore, please contact your branch for special pricing.</li>
        <li>Interest is compounded quarterly for cumulative deposits.</li>
      </ul>
    </div>
  </div>
</section>
<?php elseif ($pageKey === 'savings-current'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <h2 class="font-heading text-2xl text-foreground mb-6">Savings Accounts</h2>
    <div class="grid md:grid-cols-2 gap-6 mb-12">
      <?php foreach ($savingsAccounts as $account): ?>
      <div class="bank-card p-6">
        <h3 class="font-semibold text-foreground text-lg mb-2"><?= esc($account['name']) ?></h3>
        <div class="flex gap-6 mb-3 text-sm">
          <div><span style="color: hsl(var(--muted-foreground));">Min Balance: </span><strong class="text-foreground"><?= esc($account['minBalance']) ?></strong></div>
          <div><span style="color: hsl(var(--muted-foreground));">Interest: </span><strong class="text-primary"><?= esc($account['interest']) ?></strong></div>
        </div>
        <ul class="space-y-1">
          <?php foreach ($account['features'] as $feature): ?>
          <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><i data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i><?= esc($feature) ?></li>
          <?php endforeach; ?>
        </ul>
        <a href="<?= site_url('downloads/forms') ?>" class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-4"><i data-lucide="download" class="w-4 h-4"></i> Download Form</a>
      </div>
      <?php endforeach; ?>
    </div>

    <h2 class="font-heading text-2xl text-foreground mb-6">Current Accounts</h2>
    <div class="grid md:grid-cols-3 gap-6 mb-8">
      <?php foreach ($currentAccounts as $account): ?>
      <div class="bank-card p-6">
        <h3 class="font-semibold text-foreground mb-2"><?= esc($account['name']) ?></h3>
        <div class="text-sm mb-3"><span style="color: hsl(var(--muted-foreground));">Min Balance: </span><strong class="text-foreground"><?= esc($account['minBalance']) ?></strong></div>
        <ul class="space-y-1">
          <?php foreach ($account['features'] as $feature): ?>
          <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><i data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i><?= esc($feature) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="bank-card p-6" style="background-color: hsl(var(--muted) / 0.35);">
      <h3 class="font-semibold text-foreground mb-3">Documents Required</h3>
      <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-3 text-sm" style="color: hsl(var(--muted-foreground));">
        <?php foreach (['PAN Card', 'Aadhaar Card', 'Passport-size Photos (2)', 'Address Proof', 'Income Proof (for premium)', 'Introduction by existing account holder', 'Entity documents (for current accounts)', 'Board Resolution (for trusts / societies)'] as $document): ?>
        <span class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span><?= esc($document) ?></span>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php elseif ($pageKey === 'dicgc'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <div class="bank-card p-8 mb-8 text-center">
      <i data-lucide="shield" class="w-16 h-16 text-primary mx-auto mb-4"></i>
      <h2 class="font-heading text-2xl text-foreground mb-3">Your Deposits Are Insured</h2>
      <p class="text-4xl font-heading font-bold text-primary mb-2">Up to ₹5,00,000</p>
      <p class="readable" style="color: hsl(var(--muted-foreground));">per depositor per bank under the DICGC scheme</p>
    </div>

    <div class="space-y-6 mb-10">
      <div class="bank-card p-6">
        <h3 class="font-semibold text-foreground mb-3">What is DICGC?</h3>
        <p class="readable" style="color: hsl(var(--muted-foreground));">The Deposit Insurance and Credit Guarantee Corporation, a wholly-owned subsidiary of the Reserve Bank of India, provides insurance on bank deposits and offers reassurance to depositors in the event of a bank failure.</p>
      </div>

      <div class="grid md:grid-cols-2 gap-6">
        <div class="bank-card p-6">
          <h3 class="font-semibold text-foreground mb-3 flex items-center gap-2"><i data-lucide="circle-check" class="w-5 h-5 text-primary"></i> What Is Covered</h3>
          <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
            <?php foreach (['Savings account deposits', 'Fixed deposit accounts', 'Current account deposits', 'Recurring deposits', 'Other eligible deposits'] as $item): ?>
            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><?= esc($item) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="bank-card p-6">
          <h3 class="font-semibold text-foreground mb-3 flex items-center gap-2"><i data-lucide="alert-circle" class="w-5 h-5" style="color: hsl(var(--destructive));"></i> What Is Not Covered</h3>
          <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
            <?php foreach (['Deposits of foreign governments', 'Deposits of Central or State Governments', 'Inter-bank deposits', 'Deposits received outside India', 'Deposits specifically exempted by DICGC'] as $item): ?>
            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full" style="background-color: hsl(var(--destructive));"></span><?= esc($item) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>

    <div class="bank-card p-6">
      <h3 class="font-heading text-lg text-foreground mb-4">Frequently Asked Questions</h3>
      <div class="space-y-4">
        <?php foreach ($dicgcFaqs as $faq): ?>
        <details>
          <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i><?= esc($faq['q']) ?></summary>
          <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));"><?= esc($faq['a']) ?></p>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php elseif ($pageKey === 'deaf'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <div class="bank-card p-6 mb-8" style="border-left: 4px solid hsl(var(--accent));">
      <div class="flex items-start gap-3">
        <i data-lucide="alert-circle" class="w-6 h-6 flex-shrink-0 mt-0.5" style="color: hsl(var(--accent));"></i>
        <div>
          <h2 class="font-semibold text-foreground mb-1">What is DEAF?</h2>
          <p class="readable" style="color: hsl(var(--muted-foreground));">The Depositor Education and Awareness Fund was established by RBI under Section 26A of the Banking Regulation Act. Unclaimed deposits that remain inoperative for 10 years or more are transferred to this fund, but depositors can still claim their money through the bank.</p>
        </div>
      </div>
    </div>

    <h2 class="font-heading text-xl text-foreground mb-6">How to Claim Your Deposit</h2>
    <div class="grid sm:grid-cols-2 gap-4 mb-10">
      <?php foreach ($deafSteps as $step): ?>
      <div class="bank-card p-5 flex items-start gap-4">
        <span class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold flex-shrink-0"><?= esc($step['step']) ?></span>
        <div>
          <h3 class="font-semibold text-foreground"><?= esc($step['title']) ?></h3>
          <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($step['desc']) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="bank-card p-6 mb-8">
      <h3 class="font-semibold text-foreground mb-3">Documents Required</h3>
      <ul class="grid sm:grid-cols-2 gap-2 text-sm" style="color: hsl(var(--muted-foreground));">
        <?php foreach (['DEAF claim form', 'Valid photo ID (Aadhaar / PAN / Voter ID)', 'Passbook or account statement', 'Address proof', 'Legal heir certificate (if applicable)', 'Death certificate (if account holder is deceased)'] as $document): ?>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><?= esc($document) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="flex flex-wrap gap-3">
      <a href="<?= site_url('downloads/forms') ?>" class="btn-primary flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Download Claim Form</a>
      <a href="<?= site_url('contact') ?>" class="btn-outline flex items-center gap-2"><i data-lucide="phone" class="w-4 h-4"></i> Contact Branch</a>
    </div>
  </div>
</section>
<?php endif; ?>

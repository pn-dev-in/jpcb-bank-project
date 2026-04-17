<?php
$digitalServices = [
    ['icon' => 'smartphone', 'title' => 'Mobile Banking', 'desc' => 'Full-featured banking app for Android and iOS.', 'href' => '/digital/mobile-banking'],
    ['icon' => 'qr-code', 'title' => 'UPI Service', 'desc' => 'Instant bank-to-bank payments using UPI ID or QR code.', 'href' => '/digital/upi'],
    ['icon' => 'arrow-left-right', 'title' => 'RTGS / NEFT', 'desc' => 'Electronic fund transfer services for retail and business users.', 'href' => '/digital/rtgs-neft'],
    ['icon' => 'credit-card', 'title' => 'ATM Services', 'desc' => 'ATM access and debit card banking support.', 'href' => '/digital/atm'],
    ['icon' => 'search', 'title' => 'IFSC / MICR Codes', 'desc' => 'Search branch codes for transactions and payments.', 'href' => '/digital/ifsc-micr'],
    ['icon' => 'shield', 'title' => 'DigiSaathi', 'desc' => 'Digital payments assistance and support resources.', 'href' => '/digital/digisaathi'],
];

$mobileFeatures = ['Account balance & mini statement', 'Fund transfer (NEFT / RTGS / UPI)', 'Bill payments', 'Fixed deposit booking', 'Cheque book request', 'Account statement download', 'ATM / debit card management', 'Complaint registration'];
$mobileSteps = [
    ['step' => '1', 'title' => 'Download the App', 'desc' => 'Get JPC Mobile Banking from the Google Play Store or Apple App Store.'],
    ['step' => '2', 'title' => 'Register', 'desc' => 'Enter your registered mobile number and account details.'],
    ['step' => '3', 'title' => 'Set MPIN', 'desc' => 'Create a secure MPIN for transaction authorization.'],
    ['step' => '4', 'title' => 'Start Banking', 'desc' => 'Login and begin using digital services securely.'],
];
$mobileFaqs = [
    ['q' => 'Is mobile banking safe?', 'a' => 'Yes. The app uses encryption, secure login, and session controls to protect transactions.'],
    ['q' => 'What if I forget my MPIN?', 'a' => 'You can reset it through the app or by contacting your nearest branch.'],
    ['q' => 'Can I use mobile banking on multiple devices?', 'a' => 'For security, registration is typically linked to one device at a time.'],
];

$atmLocations = [
    ['name' => 'Head Office ATM', 'city' => 'Jalgaon', 'area' => 'Station Road', 'pin' => '425001', 'hours' => '24x7', 'status' => 'Active'],
    ['name' => 'Market Yard ATM', 'city' => 'Jalgaon', 'area' => 'Market Yard', 'pin' => '425001', 'hours' => '24x7', 'status' => 'Active'],
    ['name' => 'Bhusawal ATM', 'city' => 'Bhusawal', 'area' => 'Station Road', 'pin' => '425201', 'hours' => '24x7', 'status' => 'Active'],
    ['name' => 'Pachora ATM', 'city' => 'Pachora', 'area' => 'Main Road', 'pin' => '424201', 'hours' => '24x7', 'status' => 'Active'],
    ['name' => 'Chopda ATM', 'city' => 'Chopda', 'area' => 'Nehru Road', 'pin' => '425107', 'hours' => '24x7', 'status' => 'Active'],
    ['name' => 'Amalner ATM', 'city' => 'Amalner', 'area' => 'Gandhi Chowk', 'pin' => '425401', 'hours' => '24x7', 'status' => 'Maintenance'],
];

$branchCodes = [
    ['branch' => 'Head Office', 'city' => 'Jalgaon', 'ifsc' => 'JPCB0000001', 'micr' => '425112001'],
    ['branch' => 'Market Yard Branch', 'city' => 'Jalgaon', 'ifsc' => 'JPCB0000002', 'micr' => '425112002'],
    ['branch' => 'Bhusawal Branch', 'city' => 'Bhusawal', 'ifsc' => 'JPCB0000003', 'micr' => '425112003'],
    ['branch' => 'Pachora Branch', 'city' => 'Pachora', 'ifsc' => 'JPCB0000004', 'micr' => '425112004'],
    ['branch' => 'Chopda Branch', 'city' => 'Chopda', 'ifsc' => 'JPCB0000005', 'micr' => '425112005'],
    ['branch' => 'Amalner Branch', 'city' => 'Amalner', 'ifsc' => 'JPCB0000006', 'micr' => '425112006'],
];

$upiBenefits = ['Instant transfer 24x7', 'No charges for most customer transactions', 'Works with UPI ID or QR code', 'Supports multiple bank accounts', 'Useful for bill and merchant payments', 'Request money from contacts'];
$upiSafetyTips = ['Never share your UPI PIN', 'Verify UPI ID before sending money', 'Do not scan unknown QR codes', 'Ignore calls asking for PIN or OTP', 'Report suspicious activity immediately', 'Use official banking or UPI apps only'];

$digisaathiCategories = [
    ['title' => 'ATM / Debit Card Issues', 'desc' => 'Card not working, PIN issues, or transaction failures.'],
    ['title' => 'UPI / Mobile Banking', 'desc' => 'Registration issues, failed transactions, and app support.'],
    ['title' => 'Account Related', 'desc' => 'Balance enquiry, statement help, and account service support.'],
    ['title' => 'Fund Transfers', 'desc' => 'NEFT / RTGS issues, beneficiary setup, and status help.'],
    ['title' => 'Fraud & Security', 'desc' => 'Suspicious transactions, phishing, and card theft support.'],
];

$digitalSearch = trim((string) ($query['q'] ?? ''));

$filteredAtmLocations = $atmLocations;
if ($digitalSearch !== '') {
    $needle = strtolower($digitalSearch);
    $filteredAtmLocations = array_values(array_filter($atmLocations, static function (array $location) use ($needle): bool {
        $haystack = strtolower($location['name'] . ' ' . $location['city'] . ' ' . $location['area'] . ' ' . $location['pin']);
        return str_contains($haystack, $needle);
    }));
}

$filteredBranchCodes = $branchCodes;
if ($digitalSearch !== '') {
    $needle = strtolower($digitalSearch);
    $filteredBranchCodes = array_values(array_filter($branchCodes, static function (array $code) use ($needle): bool {
        $haystack = strtolower($code['branch'] . ' ' . $code['city'] . ' ' . $code['ifsc'] . ' ' . $code['micr']);
        return str_contains($haystack, $needle);
    }));
}
?>

<?php if ($pageKey === 'overview'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">Experience secure and convenient digital banking with modern payment services, transfer rails, self-service account access, and customer assistance resources.</p>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
      <?php foreach ($digitalServices as $service): ?>
      <a href="<?= site_url(ltrim($service['href'], '/')) ?>" class="bank-card p-6 group transition-colors">
        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background-color: hsl(var(--primary) / 0.1);">
          <i data-lucide="<?= esc($service['icon']) ?>" class="w-6 h-6 text-primary"></i>
        </div>
        <h3 class="font-semibold text-foreground mb-2 group-hover:text-primary"><?= esc($service['title']) ?></h3>
        <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($service['desc']) ?></p>
        <span class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-3">Learn more <i data-lucide="arrow-right" class="w-4 h-4"></i></span>
      </a>
      <?php endforeach; ?>
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
          <?php foreach ($mobileFeatures as $feature): ?>
          <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i><?= esc($feature) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <h2 class="font-heading text-xl text-foreground mb-6">How to Register</h2>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
      <?php foreach ($mobileSteps as $step): ?>
      <div class="bank-card p-5 text-center">
        <span class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-3"><?= esc($step['step']) ?></span>
        <h3 class="font-semibold text-foreground text-sm"><?= esc($step['title']) ?></h3>
        <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($step['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="bank-card p-6">
      <h3 class="font-heading text-lg text-foreground mb-4">FAQs</h3>
      <div class="space-y-3">
        <?php foreach ($mobileFaqs as $faq): ?>
        <details>
          <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i><?= esc($faq['q']) ?></summary>
          <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));"><?= esc($faq['a']) ?></p>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php elseif ($pageKey === 'atm'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <div class="max-w-xl mb-8">
      <form method="get" action="<?= current_url() ?>">
        <label for="atm-search-page" class="text-sm font-medium text-foreground mb-2 block">Search by city, area, or PIN code</label>
        <div class="relative">
          <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" style="color: hsl(var(--muted-foreground));"></i>
          <input id="atm-search-page" type="search" name="q" value="<?= esc($digitalSearch) ?>" placeholder="e.g. Jalgaon, 425001" class="w-full pl-10 pr-4 py-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));">
        </div>
      </form>
    </div>

    <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));"><?= count($filteredAtmLocations) ?> ATM(s) found</p>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <?php foreach ($filteredAtmLocations as $location): ?>
      <div class="bank-card p-5">
        <div class="flex items-start justify-between mb-2">
          <h3 class="font-semibold text-foreground"><?= esc($location['name']) ?></h3>
          <span class="text-xs px-2 py-0.5 rounded-full font-medium" style="background-color: <?= $location['status'] === 'Active' ? 'hsl(var(--primary) / 0.1)' : 'hsl(var(--accent) / 0.15)' ?>; color: <?= $location['status'] === 'Active' ? 'hsl(var(--primary))' : 'hsl(var(--accent-foreground))' ?>;"><?= esc($location['status']) ?></span>
        </div>
        <p class="text-sm flex items-center gap-1" style="color: hsl(var(--muted-foreground));"><i data-lucide="map-pin" class="w-4 h-4"></i><?= esc($location['area']) ?>, <?= esc($location['city']) ?> - <?= esc($location['pin']) ?></p>
        <p class="text-sm flex items-center gap-1 mt-1" style="color: hsl(var(--muted-foreground));"><i data-lucide="clock" class="w-4 h-4"></i><?= esc($location['hours']) ?></p>
      </div>
      <?php endforeach; ?>
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
      <?php foreach ([['icon' => 'phone', 'title' => 'Call Our Helpline', 'desc' => 'Call 0257-2220055 and follow the IVR instructions. Keep your account number ready.'], ['icon' => 'smartphone', 'title' => 'Use Mobile Banking App', 'desc' => 'Open JPC Mobile Banking, go to Cards, choose Block Card, and confirm.'], ['icon' => 'shield', 'title' => 'Visit Your Branch', 'desc' => 'Visit the nearest branch with ID proof to block the card and request a replacement.']] as $method): ?>
      <div class="bank-card p-5 flex items-start gap-4">
        <span class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: hsl(var(--destructive) / 0.1);">
          <i data-lucide="<?= esc($method['icon']) ?>" class="w-5 h-5" style="color: hsl(var(--destructive));"></i>
        </span>
        <div>
          <h3 class="font-semibold text-foreground"><?= esc($method['title']) ?></h3>
          <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($method['desc']) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="bank-card p-6">
      <h3 class="font-semibold text-foreground mb-3">After Blocking Your Card</h3>
      <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
        <?php foreach (['File a written complaint at your branch within 3 working days', 'Request a new card replacement', 'Check your account for unauthorized transactions', 'Report any suspicious entries immediately', 'You may also file a cyber crime complaint at cybercrime.gov.in'] as $item): ?>
        <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full flex-shrink-0 mt-2" style="background-color: hsl(var(--destructive));"></span><?= esc($item) ?></li>
        <?php endforeach; ?>
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
          <input id="code-search-page" type="search" name="q" value="<?= esc($digitalSearch) ?>" placeholder="e.g. Bhusawal, JPCB0000003" class="w-full pl-10 pr-4 py-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));">
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
            <?php foreach ($filteredBranchCodes as $index => $code): ?>
            <tr class="border-b" style="border-color: hsl(var(--border)); background-color: <?= $index % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
              <td class="p-4 text-sm font-medium text-foreground"><?= esc($code['branch']) ?></td>
              <td class="p-4 text-sm text-foreground"><?= esc($code['city']) ?></td>
              <td class="p-4 text-sm">
                <span class="flex items-center gap-2">
                  <code class="font-mono text-foreground"><?= esc($code['ifsc']) ?></code>
                  <button type="button" class="tap-target p-1 rounded" style="background-color: hsl(var(--muted));" onclick="navigator.clipboard.writeText('<?= esc($code['ifsc'], 'js') ?>'); this.textContent='Copied'; setTimeout(() => this.textContent='Copy', 1500);">Copy</button>
                </span>
              </td>
              <td class="p-4 text-sm">
                <span class="flex items-center gap-2">
                  <code class="font-mono text-foreground"><?= esc($code['micr']) ?></code>
                  <button type="button" class="tap-target p-1 rounded" style="background-color: hsl(var(--muted));" onclick="navigator.clipboard.writeText('<?= esc($code['micr'], 'js') ?>'); this.textContent='Copied'; setTimeout(() => this.textContent='Copy', 1500);">Copy</button>
                </span>
              </td>
            </tr>
            <?php endforeach; ?>
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
        <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">Real Time Gross Settlement for high-value, real-time transfers.</p>
        <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
          <li class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-primary"></i> Settlement: real-time</li>
          <li class="flex items-center gap-2"><i data-lucide="arrow-left-right" class="w-4 h-4 text-primary"></i> Minimum: ₹2,00,000</li>
          <li class="flex items-center gap-2"><i data-lucide="shield" class="w-4 h-4 text-primary"></i> Availability: 24x7x365</li>
        </ul>
      </div>
      <div class="bank-card p-6">
        <h2 class="font-heading text-xl text-foreground mb-3">NEFT</h2>
        <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">National Electronic Funds Transfer for batch-processed transfers.</p>
        <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
          <li class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-primary"></i> Settlement: half-hourly batches</li>
          <li class="flex items-center gap-2"><i data-lucide="arrow-left-right" class="w-4 h-4 text-primary"></i> Minimum: no minimum</li>
          <li class="flex items-center gap-2"><i data-lucide="shield" class="w-4 h-4 text-primary"></i> Availability: 24x7x365</li>
        </ul>
      </div>
    </div>

    <div class="bank-card p-6 mb-8">
      <h2 class="font-heading text-lg text-foreground mb-4">How to Initiate a Transfer</h2>
      <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4">
        <?php foreach ([['step' => '1', 'title' => 'Collect Details', 'desc' => 'Get beneficiary name, account number, IFSC code, and bank name.'], ['step' => '2', 'title' => 'Visit Branch / Use App', 'desc' => 'Use branch-assisted transfer or mobile banking.'], ['step' => '3', 'title' => 'Submit & Verify', 'desc' => 'Confirm amount, details, and transaction type.'], ['step' => '4', 'title' => 'Confirmation', 'desc' => 'Receive the UTR number as confirmation.']] as $step): ?>
        <div class="text-center">
          <span class="w-8 h-8 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-2 text-sm"><?= esc($step['step']) ?></span>
          <h3 class="font-semibold text-foreground text-sm"><?= esc($step['title']) ?></h3>
          <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($step['desc']) ?></p>
        </div>
        <?php endforeach; ?>
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
          <?php foreach ($upiBenefits as $benefit): ?>
          <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><?= esc($benefit) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="bank-card p-6">
        <h3 class="font-semibold text-foreground mb-4 flex items-center gap-2"><i data-lucide="shield" class="w-5 h-5" style="color: hsl(var(--destructive));"></i> Safety Tips</h3>
        <ul class="space-y-2">
          <?php foreach ($upiSafetyTips as $tip): ?>
          <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><i data-lucide="alert-triangle" class="w-4 h-4 flex-shrink-0" style="color: hsl(var(--accent));"></i><?= esc($tip) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="bank-card p-6">
      <h3 class="font-heading text-lg text-foreground mb-4">How to Link Your Account</h3>
      <div class="grid sm:grid-cols-3 gap-4">
        <?php foreach ([['step' => '1', 'title' => 'Open UPI App', 'desc' => 'Use BHIM, Google Pay, PhonePe, or JPC Mobile Banking.'], ['step' => '2', 'title' => 'Add Bank Account', 'desc' => 'Select JPC Bank and link your account with your registered mobile number.'], ['step' => '3', 'title' => 'Create UPI PIN', 'desc' => 'Set your UPI PIN using your debit card details.']] as $step): ?>
        <div class="text-center">
          <span class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-3"><?= esc($step['step']) ?></span>
          <h4 class="font-semibold text-foreground text-sm"><?= esc($step['title']) ?></h4>
          <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($step['desc']) ?></p>
        </div>
        <?php endforeach; ?>
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
      <?php foreach ($digisaathiCategories as $category): ?>
      <div class="bank-card p-5">
        <h3 class="font-semibold text-foreground"><?= esc($category['title']) ?></h3>
        <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($category['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="bank-card p-6">
      <h3 class="font-semibold text-foreground mb-4">Contact DigiSaathi</h3>
      <div class="grid sm:grid-cols-3 gap-4">
        <a href="tel:14431" class="flex items-center gap-3 p-4 rounded-lg transition-colors tap-target" style="background-color: hsl(var(--muted));">
          <i data-lucide="phone" class="w-6 h-6 text-primary"></i>
          <div><p class="font-medium text-foreground">Call 14431</p><p class="text-xs" style="color: hsl(var(--muted-foreground));">Toll-free helpline</p></div>
        </a>
        <a href="https://digisaathi.info" target="_blank" rel="noopener" class="flex items-center gap-3 p-4 rounded-lg transition-colors tap-target" style="background-color: hsl(var(--muted));">
          <i data-lucide="external-link" class="w-6 h-6 text-primary"></i>
          <div><p class="font-medium text-foreground">Visit Website</p><p class="text-xs" style="color: hsl(var(--muted-foreground));">digisaathi.info</p></div>
        </a>
        <a href="<?= site_url('complaints') ?>" class="flex items-center gap-3 p-4 rounded-lg transition-colors tap-target" style="background-color: hsl(var(--muted));">
          <i data-lucide="message-square" class="w-6 h-6 text-primary"></i>
          <div><p class="font-medium text-foreground">Lodge Complaint</p><p class="text-xs" style="color: hsl(var(--muted-foreground));">With JPC Bank</p></div>
        </a>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

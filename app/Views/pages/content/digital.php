<?php
$atmLocations = $atmLocations ?? [];
$branchCodes = $branchCodes ?? [];

// For IFSC/MICR search
$codeSearch = trim($query['q'] ?? '');
$filteredBranchCodes = $branchCodes;
if ($codeSearch !== '') {
  $needle = strtolower($codeSearch);
  $filteredBranchCodes = array_values(array_filter($branchCodes, function ($code) use ($needle) {
    $haystack = strtolower($code['branch_name'] . ' ' . ($code['city'] ?? '') . ' ' . ($code['ifsc'] ?? '') . ' ' . ($code['micr'] ?? ''));
    return str_contains($haystack, $needle);
  }));
}

// For ATM search
$atmSearch = trim($query['q'] ?? '');
$filteredAtmLocations = $atmLocations;
if ($atmSearch !== '') {
  $needle = strtolower($atmSearch);
  $filteredAtmLocations = array_values(array_filter($atmLocations, function ($loc) use ($needle) {
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
      <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">
        <?= esc($digitalSettings['digital_overview_intro'] ?? 'Experience secure and convenient digital banking with modern payment services, transfer rails, self-service account access, and customer assistance resources.') ?>
      </p>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <?php if (!empty($digitalServices)): ?>
          <?php foreach ($digitalServices as $service): ?>
            <a href="<?= site_url(ltrim($service['href'], '/')) ?>" class="bank-card p-6 group transition-colors">
              <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4"
                style="background-color: hsl(var(--primary) / 0.1);">
                <i data-lucide="<?= esc($service['icon']) ?>" class="w-6 h-6 text-primary"></i>
              </div>
              <h3 class="font-semibold text-foreground mb-2 group-hover:text-primary"><?= esc($service['title']) ?></h3>
              <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($service['description']) ?></p>
              <span class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-3">Learn more <i
                  data-lucide="arrow-right" class="w-4 h-4"></i></span>
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No digital services found.</p>
        <?php endif; ?>
      </div>
      <div class="bank-card p-6" style="border-left: 4px solid hsl(var(--destructive));">
        <div class="flex items-start gap-3">
          <i data-lucide="alert-triangle" class="w-6 h-6 flex-shrink-0 mt-0.5"
            style="color: hsl(var(--destructive));"></i>
          <div>
            <h3 class="font-semibold text-foreground mb-1">Emergency: Block ATM Card</h3>
            <p class="text-sm mb-2" style="color: hsl(var(--muted-foreground));">If your ATM or debit card is lost,
              stolen, or compromised, block it immediately.</p>
            <a href="<?= site_url('digital/block-card') ?>" class="btn-primary text-sm"
              style="background-color: hsl(var(--destructive)); color: hsl(var(--destructive-foreground));">Block Card
              Now</a>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'mobile-banking'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank max-w-5xl">

      <!-- Tab Navigation Buttons -->
      <div class="flex flex-wrap gap-2 mb-8" role="tablist" aria-label="Mobile Banking Sections">
        <button type="button" role="tab" aria-selected="true" aria-controls="mb-tab-features"
          class="mb-tab-btn btn-primary text-sm flex items-center gap-2" data-tab="mb-tab-features">
          <i data-lucide="star" class="w-4 h-4"></i> Features
        </button>
        <button type="button" role="tab" aria-selected="false" aria-controls="mb-tab-services"
          class="mb-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="mb-tab-services">
          <i data-lucide="users" class="w-4 h-4"></i> Services &amp; Eligibility
        </button>
        <button type="button" role="tab" aria-selected="false" aria-controls="mb-tab-howto"
          class="mb-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="mb-tab-howto">
          <i data-lucide="list-ordered" class="w-4 h-4"></i> How to Avail
        </button>
        <button type="button" role="tab" aria-selected="false" aria-controls="mb-tab-limits"
          class="mb-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="mb-tab-limits">
          <i data-lucide="arrow-up-down" class="w-4 h-4"></i> Transfer Limits
        </button>
        <button type="button" role="tab" aria-selected="false" aria-controls="mb-tab-facility"
          class="mb-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="mb-tab-facility">
          <i data-lucide="arrow-down-left" class="w-4 h-4"></i> Facility
        </button>
      </div>

      <!-- TAB: Features -->
      <div id="mb-tab-features" role="tabpanel" class="mb-tab-panel">
        <div class="grid md:grid-cols-2 gap-10 items-start mb-10">
          <div>
            <h2 class="font-heading text-2xl text-foreground mb-4">Bank on Your Phone</h2>
            <p class="readable mb-6" style="color: hsl(var(--muted-foreground));">
              <?= esc($digitalSettings['mobile_banking_intro'] ?? 'Access your accounts, transfer funds, pay bills, request services, and manage your finances directly from your mobile phone. Enjoy instant 24x7 IMPS transfers, card controls, recharges, and more — anytime, anywhere.') ?>
            </p>
            <div class="flex gap-3">
              <a href="<?= esc($digitalSettings['google_play_url'] ?? 'https://play.google.com/store/apps/details?id=com.jalgaonbank.banking&pcampaignid=web_share') ?>"
                target="_blank" rel="noopener" class="btn-primary text-sm flex items-center gap-2"><i
                  data-lucide="download" class="w-4 h-4"></i> Google Play</a>
              <a href="<?= esc($digitalSettings['app_store_url'] ?? 'https://apps.apple.com/in/app/jalgaon-peoples-bank/id1202840224') ?>"
                target="_blank" rel="noopener" class="btn-outline text-sm flex items-center gap-2"><i
                  data-lucide="download" class="w-4 h-4"></i> App Store</a>
            </div>
          </div>
          <div class="bank-card p-6">
            <h3 class="font-semibold text-foreground mb-4">App Features</h3>
            <ul class="space-y-2">
              <?php if (!empty($mobileFeatures)): ?>
                <?php foreach ($mobileFeatures as $feature): ?>
                  <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i
                      data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i><?= esc($feature) ?></li>
                <?php endforeach; ?>
              <?php else: ?>
                <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i
                    data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i>Instant 24x7 IMPS fund
                  transfer (up to ₹5 lakh/txn, ₹10 lakh/day)</li>
                <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i
                    data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i>NEFT transfers (up to ₹2
                  lakh/txn, ₹30 lakh/day)</li>
                <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i
                    data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i>Own account, intra-bank &amp;
                  inter-bank fund transfers</li>
                <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i
                    data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i>Check balances — Savings,
                  Current &amp; Overdraft accounts</li>
                <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i
                    data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i>Mini statement &amp; last 5
                  IMPS transactions</li>
                <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i
                    data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i>Manage beneficiaries (Payee
                  Name, Account No., Bank IFSC)</li>
                <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i
                    data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i>Mobile, DTH &amp; Data Card
                  recharge &amp; bill payment</li>
                <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i
                    data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i>Card Safe: block/unblock debit
                  card, set ATM/POS/E-Com limits, reset PIN without visiting branch</li>
                <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));"><i
                    data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i>Branch/ATM locator, cheque
                  book request, account statement on email</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>

        <div class="bank-card p-6">
          <h3 class="font-heading text-lg text-foreground mb-4">FAQs</h3>
          <div class="space-y-3">
            <?php if (!empty($mobileFaqs)): ?>
              <?php foreach ($mobileFaqs as $faq): ?>
                <details>
                  <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i
                      data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i><?= esc($faq['question']) ?>
                  </summary>
                  <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));">
                    <?= nl2br(esc((string) $faq['answer'])) ?>
                  </p>
                </details>
              <?php endforeach; ?>
            <?php else: ?>
              <details>
                <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i
                    data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i>How do I register for Mobile
                  Banking?</summary>
                <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));">Fill up the Mobile Banking
                  Registration Form at your branch. IMPS will be activated the next working day and your Security Code will
                  be sent to your registered mobile number. Download the JPCB Mobile App, enter your mobile number and
                  Security Code, verify via OTP, set your 4-digit MPIN, and you're ready to go.</p>
              </details>
              <details>
                <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i
                    data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i>What is the maximum transfer
                  limit via IMPS?</summary>
                <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));">You can transfer up to ₹5,00,000
                  per transaction and a maximum of ₹10,00,000 per day using IMPS. For NEFT, the per-transaction limit is
                  ₹2,00,000 with a daily maximum of ₹30,00,000.</p>
              </details>
              <details>
                <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i
                    data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i>Can joint account holders use
                  Mobile Banking?</summary>
                <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));">Joint savings accounts with a
                  "Jointly" mode of operation are not eligible. Single-operated savings and individual current/loan accounts
                  are eligible. Firm accounts are also not eligible.</p>
              </details>
              <details>
                <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i
                    data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i>How do I block my debit card
                  via the app?</summary>
                <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));">Use the Card Safe Services feature
                  in the app to instantly block or unblock your debit card, set daily transaction limits for
                  ATM/POS/E-Commerce, or reset your ATM PIN — all without visiting the branch.</p>
              </details>
              <details>
                <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i
                    data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i>What should I do if I forget my
                  MPIN?</summary>
                <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));">Contact our Toll Free helpline at
                  1800-233-1385 or visit your nearest branch for assistance in resetting your MPIN. Never share your PIN
                  with anyone.</p>
              </details>
            <?php endif; ?>
          </div>
        </div>
      </div><!-- /mb-tab-features -->

      <!-- TAB: Services & Eligibility -->
      <div id="mb-tab-services" role="tabpanel" class="mb-tab-panel hidden">
        <div class="bank-card p-6 mb-6">
          <h2 class="font-heading text-lg text-foreground mb-2">Who Can Avail Mobile Banking?</h2>
          <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">Customers having Savings, Current, or Loan
            accounts are eligible, subject to the following conditions:</p>
          <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse" role="table">
              <thead>
                <tr class="bg-primary text-primary-foreground">
                  <th class="text-left p-3 font-semibold">Account Type</th>
                  <th class="text-left p-3 font-semibold">Constitution</th>
                  <th class="text-left p-3 font-semibold">Mode of Operation</th>
                  <th class="text-left p-3 font-semibold">Eligible</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($eligibilityRules)): ?>
                  <?php $i = 0; ?>
                  <?php foreach ($eligibilityRules as $rule): ?>
                    <tr class="border-b"
                      style="border-color: hsl(var(--border)); <?= $i % 2 === 1 ? 'background-color: hsl(var(--muted) / 0.3);' : '' ?>">
                      <td class="p-3 text-foreground font-medium"><?= esc($rule['account_type']) ?></td>
                      <td class="p-3" style="color: hsl(var(--muted-foreground));"><?= esc($rule['constitution']) ?></td>
                      <td class="p-3" style="color: hsl(var(--muted-foreground));"><?= esc($rule['mode_of_operation']) ?></td>
                      <td class="p-3">
                        <?php if ($rule['eligible']): ?>
                          <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                            style="background-color: hsl(var(--primary) / 0.1); color: hsl(var(--primary));">The Account
                            Holder</span>
                        <?php else: ?>
                          <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                            style="background-color: hsl(var(--accent) / 0.15); color: hsl(var(--accent-foreground));">Not
                            Eligible</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php $i++; ?>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4" class="p-4 text-center text-muted-foreground">No eligibility data available.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- TAB: How to Avail -->
      <div id="mb-tab-howto" role="tabpanel" class="mb-tab-panel hidden">
        <h2 class="font-heading text-xl text-foreground mb-6">How to Register</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
          <?php if (!empty($mobileSteps)): ?>
            <?php foreach ($mobileSteps as $step): ?>
              <div class="bank-card p-5 text-center">
                <span
                  class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-3"><?= esc($step['step_number']) ?></span>
                <h3 class="font-semibold text-foreground text-sm"><?= esc($step['title']) ?></h3>
                <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($step['description']) ?></p>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="bank-card p-5 text-center">
              <span
                class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-3">1</span>
              <h3 class="font-semibold text-foreground text-sm">Fill Registration Form</h3>
              <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));">Collect the Mobile Banking Registration
                Form from your nearest branch and submit it.</p>
            </div>
            <div class="bank-card p-5 text-center">
              <span
                class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-3">2</span>
              <h3 class="font-semibold text-foreground text-sm">Receive Security Code</h3>
              <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));">IMPS will be activated the next working
                day. Your Security Code will be sent to your registered mobile number.</p>
            </div>
            <div class="bank-card p-5 text-center">
              <span
                class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-3">3</span>
              <h3 class="font-semibold text-foreground text-sm">Download JPCB App</h3>
              <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));">Download from <a
                  href="<?= esc($digitalSettings['jpcb_website_url'] ?? 'https://www.jpcbank.com') ?>" target="_blank"
                  rel="noopener" class="text-primary underline">jpcbank.com</a> or Google Play Store. Enter your registered
                mobile number and Security Code, then tap Register.</p>
            </div>
            <div class="bank-card p-5 text-center">
              <span
                class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-3">4</span>
              <h3 class="font-semibold text-foreground text-sm">Set MPIN &amp; Login</h3>
              <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));">Enter the OTP sent to your mobile, create
                your 4-digit MPIN, and log in to start banking.</p>
            </div>
          <?php endif; ?>
        </div>

        <div class="bank-card p-6" style="border-left: 4px solid hsl(var(--primary));">
          <div class="flex items-start gap-3">
            <i data-lucide="phone" class="w-6 h-6 flex-shrink-0 mt-0.5 text-primary"></i>
            <div>
              <h3 class="font-semibold text-foreground mb-1">Need Help?</h3>
              <p class="text-sm mb-2" style="color: hsl(var(--muted-foreground));">Call our Toll Free number or visit your
                nearest branch for assistance with Mobile Banking. Do not share your PIN with anyone.</p>
              <a href="tel:<?= str_replace(['-', ' '], '', $digitalSettings['toll_free'] ?? '18002331385') ?>"
                class="btn-primary text-sm inline-flex items-center gap-2"><i data-lucide="phone" class="w-4 h-4"></i>
                Toll Free: <?= esc($digitalSettings['toll_free'] ?? '1800-233-1385') ?></a>
            </div>
          </div>
        </div>
      </div><!-- /mb-tab-howto -->

      <!-- TAB: Transfer Limits -->
      <div id="mb-tab-limits" role="tabpanel" class="mb-tab-panel hidden">
        <div class="grid sm:grid-cols-2 gap-6 mb-6">
          <div class="bank-card p-6">
            <h2 class="font-heading text-xl text-foreground mb-3 flex items-center gap-2"><i data-lucide="zap"
                class="w-5 h-5 text-primary"></i> IMPS</h2>
            <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">Immediate Payment Service — real-time,
              24x7 fund transfer.</p>
            <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
              <li class="flex items-center gap-2"><i data-lucide="arrow-right" class="w-4 h-4 text-primary"></i>Per
                Transaction: up to <strong
                  class="text-foreground">₹<?= esc($digitalSettings['imps_limit_per_txn'] ?? '5,00,000') ?></strong></li>
              <li class="flex items-center gap-2"><i data-lucide="arrow-right" class="w-4 h-4 text-primary"></i>Per Day:
                maximum <strong
                  class="text-foreground">₹<?= esc($digitalSettings['imps_limit_per_day'] ?? '10,00,000') ?></strong></li>
            </ul>
          </div>
          <div class="bank-card p-6">
            <h2 class="font-heading text-xl text-foreground mb-3 flex items-center gap-2"><i data-lucide="repeat"
                class="w-5 h-5 text-primary"></i> NEFT</h2>
            <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">National Electronic Funds Transfer —
              available 24x7.</p>
            <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
              <li class="flex items-center gap-2"><i data-lucide="arrow-right" class="w-4 h-4 text-primary"></i>Per
                Transaction: up to <strong
                  class="text-foreground">₹<?= esc($digitalSettings['neft_limit_per_txn'] ?? '2,00,000') ?></strong></li>
              <li class="flex items-center gap-2"><i data-lucide="arrow-right" class="w-4 h-4 text-primary"></i>Per Day:
                maximum <strong
                  class="text-foreground">₹<?= esc($digitalSettings['neft_limit_per_day'] ?? '30,00,000') ?></strong></li>
            </ul>
          </div>
        </div>
        <div class="flex gap-3 flex-wrap">
          <a href="<?= site_url('digital/ifsc-micr') ?>" class="btn-outline text-sm flex items-center gap-2"><i
              data-lucide="search" class="w-4 h-4"></i> Search IFSC Codes</a>
          <a href="<?= site_url('services/charges') ?>" class="btn-outline text-sm flex items-center gap-2"><i
              data-lucide="indian-rupee" class="w-4 h-4"></i> View Charges</a>
        </div>
      </div><!-- /mb-tab-limits -->

      <!-- TAB: Facility -->
      <div id="mb-tab-facility" role="tabpanel" class="mb-tab-panel hidden">
        <div class="bank-card p-6 mb-6">
          <h2 class="font-heading text-lg text-foreground mb-3 flex items-center gap-2">
            <i data-lucide="arrow-down-left" class="w-5 h-5 text-primary"></i>
            <?= esc($digitalSettings['mobile_facility_heading'] ?? 'Receive Money via IMPS') ?>
          </h2>
          <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">
            <?= esc($digitalSettings['mobile_facility_text'] ?? 'Share either of the following details with the sender (who must also be an IMPS user):') ?>
          </p>
          <div class="grid sm:grid-cols-2 gap-4">
            <!-- Option 1 -->
            <div class="rounded-lg p-4 flex items-start gap-3" style="background-color: hsl(var(--muted) / 0.4);">
              <i data-lucide="<?= esc($digitalSettings['mobile_facility_option1_icon'] ?? 'smartphone') ?>"
                class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"></i>
              <div>
                <p class="font-semibold text-foreground text-sm">
                  <?= esc($digitalSettings['mobile_facility_option1_title'] ?? 'Option 1') ?>
                </p>
                <p class="text-sm" style="color: hsl(var(--muted-foreground));">
                  <?= $digitalSettings['mobile_facility_option1_text'] ?? 'Your <strong>Mobile Number</strong> &amp; <strong>MMID</strong>' ?>
                </p>
              </div>
            </div>
            <!-- Option 2 -->
            <div class="rounded-lg p-4 flex items-start gap-3" style="background-color: hsl(var(--muted) / 0.4);">
              <i data-lucide="<?= esc($digitalSettings['mobile_facility_option2_icon'] ?? 'landmark') ?>"
                class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"></i>
              <div>
                <p class="font-semibold text-foreground text-sm">
                  <?= esc($digitalSettings['mobile_facility_option2_title'] ?? 'Option 2') ?>
                </p>
                <p class="text-sm" style="color: hsl(var(--muted-foreground));">
                  <?= $digitalSettings['mobile_facility_option2_text'] ?? 'Your <strong>Account Number</strong> &amp; <strong>IFSC Code</strong>' ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /mb-tab-facility -->

    </div>
  </section>

  <script>
    (function () {
      var tabs = document.querySelectorAll('.mb-tab-btn');
      var panels = document.querySelectorAll('.mb-tab-panel');

      tabs.forEach(function (btn) {
        btn.addEventListener('click', function () {
          var target = btn.getAttribute('data-tab');

          // Toggle button styles
          tabs.forEach(function (b) {
            var active = b.getAttribute('data-tab') === target;
            b.setAttribute('aria-selected', active ? 'true' : 'false');
            if (active) {
              b.classList.remove('btn-outline');
              b.classList.add('btn-primary');
            } else {
              b.classList.remove('btn-primary');
              b.classList.add('btn-outline');
            }
          });

          // Toggle panels
          panels.forEach(function (panel) {
            if (panel.id === target) {
              panel.classList.remove('hidden');
            } else {
              panel.classList.add('hidden');
            }
          });

          // Re-init lucide icons inside newly shown panel
          if (window.lucide && window.lucide.createIcons) {
            window.lucide.createIcons();
          }
        });
      });
    }());
  </script>

<?php elseif ($pageKey === 'atm'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank">

      <!-- Tab Navigation -->
      <div class="flex flex-wrap gap-2 mb-8" role="tablist" aria-label="ATM Sections">
        <button type="button" role="tab" aria-selected="true" aria-controls="atm-tab-overview"
          class="atm-tab-btn btn-primary text-sm flex items-center gap-2" data-tab="atm-tab-overview">
          <i data-lucide="landmark" class="w-4 h-4"></i> ATM
        </button>
        <button type="button" role="tab" aria-selected="false" aria-controls="atm-tab-debitcard"
          class="atm-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="atm-tab-debitcard">
          <i data-lucide="credit-card" class="w-4 h-4"></i> Debit Card
        </button>
        <button type="button" role="tab" aria-selected="false" aria-controls="atm-tab-services"
          class="atm-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="atm-tab-services">
          <i data-lucide="list-checks" class="w-4 h-4"></i> Avail Services
        </button>
        <button type="button" role="tab" aria-selected="false" aria-controls="atm-tab-obtain"
          class="atm-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="atm-tab-obtain">
          <i data-lucide="badge-check" class="w-4 h-4"></i> How to Obtain
        </button>
        <button type="button" role="tab" aria-selected="false" aria-controls="atm-tab-dosdontss"
          class="atm-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="atm-tab-dosdontss">
          <i data-lucide="shield-check" class="w-4 h-4"></i> Do's &amp; Don'ts
        </button>
        <button type="button" role="tab" aria-selected="false" aria-controls="atm-tab-limits"
          class="atm-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="atm-tab-limits">
          <i data-lucide="arrow-up-down" class="w-4 h-4"></i> Transaction Limits
        </button>
        <button type="button" role="tab" aria-selected="false" aria-controls="atm-tab-locations"
          class="atm-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="atm-tab-locations">
          <i data-lucide="map-pin" class="w-4 h-4"></i> ATM Locations
        </button>
      </div>

      <!-- TAB: ATM Overview -->
      <div id="atm-tab-overview" role="tabpanel" class="atm-tab-panel">
        <div class="grid md:grid-cols-2 gap-6 mb-8">
          <div class="bank-card p-6">
            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4"
              style="background-color: hsl(var(--primary) / 0.1);">
              <i data-lucide="landmark" class="w-6 h-6 text-primary"></i>
            </div>
            <h2 class="font-heading text-xl text-foreground mb-3"><?= count($atmLocations) ?> ATM Centers</h2>
            <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">
              <?= $digitalSettings['atm_overview_intro'] ?? 'To avoid waiting in queues at the branch, our ATM service is available at ' . count($atmLocations) . ' ATM centers. Use your Debit Card at any of our ATMs or at over <strong>2,25,000 RuPay enabled ATMs</strong> across India. JPCB is now part of the <strong>NPCI network</strong> — any bank\'s card can be used for balance enquiry and cash withdrawal at our ATMs.' ?>
            </p>
          </div>
          <div class="bank-card p-6">
            <h3 class="font-semibold text-foreground mb-4">Quick Block — Lost Card?</h3>
            <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">
              <?= $digitalSettings['atm_quick_block_text'] ?? 'If your Debit Card is lost or stolen, block it immediately via SMS — available 24x7.' ?>
            </p>
            <div class="rounded-lg p-4 mb-4 flex items-center gap-3"
              style="background-color: hsl(var(--destructive) / 0.08); border: 1px solid hsl(var(--destructive) / 0.2);">
              <i data-lucide="message-square" class="w-5 h-5 flex-shrink-0" style="color: hsl(var(--destructive));"></i>
              <div>
                <p class="text-sm font-semibold text-foreground">SMS:
                  <?= $digitalSettings['atm_quick_block_sms'] ?? 'BLOCK → Send to 8750587505' ?>
                </p>
                <p class="text-xs mt-0.5" style="color: hsl(var(--muted-foreground));">
                  <?= $digitalSettings['atm_quick_block_note'] ?? 'From your registered mobile number only' ?>
                </p>
              </div>
            </div>
            <a href="<?= site_url('digital/block-card') ?>" class="btn-primary text-sm flex items-center gap-2 w-fit"
              style="background-color: hsl(var(--destructive)); color: hsl(var(--destructive-foreground));"><i
                data-lucide="shield-off" class="w-4 h-4"></i> Block Card Now</a>
          </div>
        </div>

        <!-- Important Guidelines -->
        <div class="bank-card p-6" style="border-left: 4px solid hsl(var(--accent));">
          <h3 class="font-semibold text-foreground mb-4 flex items-center gap-2"><i data-lucide="alert-triangle"
              class="w-5 h-5" style="color: hsl(var(--accent));"></i>
            <?= $digitalSettings['atm_overview_guidelines_heading'] ?? 'Important Guidelines' ?></h3>
          <?php if (!empty($atmGuidelines)): ?>
            <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
              <?php foreach ($atmGuidelines as $guideline): ?>
                <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full flex-shrink-0 mt-2"
                    style="background-color: hsl(var(--accent));"></span><?= esc($guideline['guideline']) ?></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p class="text-sm" style="color: hsl(var(--muted-foreground));">No guidelines available.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- TAB: Debit Card -->
      <div id="atm-tab-debitcard" role="tabpanel" class="atm-tab-panel hidden">
        <div class="grid md:grid-cols-2 gap-6 mb-8">
          <div class="bank-card p-6">
            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4"
              style="background-color: hsl(var(--primary) / 0.1);">
              <i data-lucide="credit-card" class="w-6 h-6 text-primary"></i>
            </div>
            <h2 class="font-heading text-xl text-foreground mb-3">
              <?= esc($digitalSettings['debit_card_heading'] ?? 'RuPay Debit Card') ?>
            </h2>
            <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">
              <?= esc($digitalSettings['debit_card_description'] ?? 'JPCB issues RuPay Debit Cards accepted at all ATMs and POS devices under the NPCI Network across India. Also usable for online purchases and utility bill or insurance premium payments.') ?>
            </p>
            <h3 class="font-semibold text-foreground mb-2">JPCB Debit Card</h3>
            <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
              <?php
              $bullets = explode('|', $digitalSettings['debit_card_bullets'] ?? 'Use at any ATM under NPCI / NFS Network across India|Accepted at all POS (card swipe) devices nationwide|Online shopping and bill payments via internet');
              foreach ($bullets as $bullet): ?>
                <li class="flex items-center gap-2"><i data-lucide="circle-check"
                    class="w-4 h-4 text-primary flex-shrink-0"></i><?= esc($bullet) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="bank-card p-6">
            <h3 class="font-semibold text-foreground mb-4">Usage of Debit Card</h3>
            <ul class="space-y-3 text-sm" style="color: hsl(var(--muted-foreground));">
              <?php
              $usage = explode('|', $digitalSettings['debit_card_usage'] ?? 'ATM Cash Withdrawal — Immediate cash withdrawals at any ATM.|POS (Card Swipe) — Departmental stores, malls, restaurants, hotels, hospitals, cinema halls, petrol pumps, and more.|Online Transactions — Shopping or bill payments over the internet.');
              foreach ($usage as $item): ?>
                <li class="flex items-start gap-3">
                  <i data-lucide="banknote" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"></i>
                  <div><?= esc($item) ?></div>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <div class="bank-card p-6">
          <h3 class="font-semibold text-foreground mb-4">Benefits</h3>
          <div class="grid sm:grid-cols-2 gap-4">
            <?php
            $benefits = explode('|', $digitalSettings['debit_card_benefits'] ?? 'No need to carry cash — no fear of loss or theft.|No need to issue a cheque — pay by swiping the card or via online transaction.');
            foreach ($benefits as $benefit): ?>
              <div class="rounded-lg p-4 flex items-start gap-3" style="background-color: hsl(var(--muted) / 0.4);">
                <i data-lucide="wallet" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"></i>
                <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($benefit) ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div><!-- /atm-tab-debitcard -->

      <!-- TAB: Avail Services -->
      <div id="atm-tab-services" role="tabpanel" class="atm-tab-panel hidden">
        <div class="bank-card p-6 mb-6">
          <h2 class="font-heading text-lg text-foreground mb-4">Services Available at ATM Centres</h2>
          <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($atmServices as $service): ?>
              <div class="rounded-lg p-4 flex items-center gap-3" style="background-color: hsl(var(--muted) / 0.4);">
                <i data-lucide="<?= esc($service['icon']) ?>" class="w-6 h-6 text-primary flex-shrink-0"></i>
                <span class="font-medium text-foreground text-sm"><?= esc($service['service_name']) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="bank-card p-6" style="border-left: 4px solid hsl(var(--primary));">
          <div class="flex items-start gap-3">
            <i data-lucide="info" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"></i>
            <p class="text-sm" style="color: hsl(var(--muted-foreground));">
              <?= $digitalSettings['atm_green_pin_note'] ?? 'If you forgot your PIN, use the <strong>Green PIN facility</strong> available at JPCB ATMs to create a new PIN for your JPCB-issued Debit Card instantly — no branch visit required.' ?>
            </p>
          </div>
        </div>
      </div><!-- /atm-tab-services -->

      <!-- TAB: How to Obtain -->
      <div id="atm-tab-obtain" role="tabpanel" class="atm-tab-panel hidden">
        <div class="grid sm:grid-cols-2 gap-6 mb-6">
          <?php foreach ($atmObtainSteps as $step): ?>
            <div class="bank-card p-5 text-center">
              <span
                class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-3"><?= esc($step['step_number']) ?></span>
              <h3 class="font-semibold text-foreground text-sm"><?= esc($step['title']) ?></h3>
              <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($step['description']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div><!-- /atm-tab-obtain -->

      <!-- TAB: Do's & Don'ts -->
      <div id="atm-tab-dosdontss" role="tabpanel" class="atm-tab-panel hidden">
        <div class="grid md:grid-cols-2 gap-6">
          <div class="bank-card p-6">
            <h3 class="font-semibold text-foreground mb-4 flex items-center gap-2"><i data-lucide="circle-check"
                class="w-5 h-5 text-primary"></i> Do's</h3>
            <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
              <?php foreach ($atmDos as $do): ?>
                <li class="flex items-start gap-2"><span
                    class="w-1.5 h-1.5 rounded-full flex-shrink-0 mt-2 bg-primary"></span><?= esc($do['item']) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="bank-card p-6" style="border-left: 4px solid hsl(var(--destructive));">
            <h3 class="font-semibold text-foreground mb-4 flex items-center gap-2"><i data-lucide="x-circle"
                class="w-5 h-5" style="color: hsl(var(--destructive));"></i> Don'ts</h3>
            <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
              <?php foreach ($atmDonts as $dont): ?>
                <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full flex-shrink-0 mt-2"
                    style="background-color: hsl(var(--destructive));"></span><?= esc($dont['item']) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div><!-- /atm-tab-dosdontss -->

      <!-- NEW TAB: ATM Transaction Limits -->
      <div id="atm-tab-limits" role="tabpanel" class="atm-tab-panel hidden">
        <div class="bank-card p-6">
          <h3 class="font-heading text-lg font-bold mb-4 text-foreground flex items-center gap-2">
            <i data-lucide="credit-card" class="w-5 h-5" style="color: hsl(var(--primary));"></i>
            ATM / Debit Card Transaction Limits
          </h3>
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead>
                <tr class="bg-primary text-primary-foreground">
                  <th class="p-3 text-left font-semibold">Channel</th>
                  <th class="p-3 text-left font-semibold">Description</th>
                  <th class="p-3 text-center font-semibold">Min/Txn</th>
                  <th class="p-3 text-center font-semibold">Max/Txn</th>
                  <th class="p-3 text-center font-semibold">Max/Day</th>
                  <th class="p-3 text-center font-semibold">Max/Month</th>
                  <th class="p-3 text-center font-semibold">Day Count</th>
                  <th class="p-3 text-center font-semibold">Month Count</th>
                  <th class="p-3 text-center font-semibold">Availability</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($digitalLimits)): ?>
                  <?php
                  $atmLimits = array_filter($digitalLimits, function ($limit) {
                    return in_array($limit['channel'], ['ATM', 'ECOM/POS']);
                  });
                  ?>
                  <?php foreach ($atmLimits as $limit): ?>
                    <tr class="border-b" style="border-color: hsl(var(--border));">
                      <td class="p-3 font-medium"><?= esc($limit['channel']) ?></td>
                      <td class="p-3" style="color: hsl(var(--muted-foreground));"><?= esc($limit['description']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['min_per_txn']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['max_per_txn']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['max_per_day']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['max_per_month']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['per_day_count']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['per_month_count']) ?></td>
                      <td class="p-3 text-center">
                        <span class="text-xs px-2 py-1 rounded-full"
                          style="background-color: hsl(var(--primary)/0.1); color: hsl(var(--primary));">
                          <?= esc($limit['availability']) ?>
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="9" class="p-4 text-center">No transaction limit data available.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- TAB: ATM Locations -->
      <div id="atm-tab-locations" role="tabpanel" class="atm-tab-panel hidden">
        <div class="max-w-xl mb-8">
          <form method="get" action="<?= current_url() ?>">
            <label for="atm-search-page" class="text-sm font-medium text-foreground mb-2 block">Search by city, area, PIN,
              or ATM name</label>
            <div class="relative">
              <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5"
                style="color: hsl(var(--muted-foreground));"></i>
              <input id="atm-search-page" type="search" name="q" value="<?= esc($atmSearch) ?>"
                placeholder="e.g. Jalgaon, 425001, Head Office"
                class="w-full pl-10 pr-4 py-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none"
                style="border-color: hsl(var(--border));">
            </div>
          </form>
        </div>
        <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));"><?= count($filteredAtmLocations) ?> ATM(s)
          found</p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php if (!empty($filteredAtmLocations)): ?>
            <?php foreach ($filteredAtmLocations as $location): ?>
              <div class="bank-card p-5">
                <div class="flex items-start justify-between mb-2">
                  <h3 class="font-semibold text-foreground"><?= esc($location['name']) ?></h3>
                  <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                    style="background-color: <?= $location['atm_status'] === 'Active' ? 'hsl(var(--primary) / 0.1)' : 'hsl(var(--accent) / 0.15)' ?>; color: <?= $location['atm_status'] === 'Active' ? 'hsl(var(--primary))' : 'hsl(var(--accent-foreground))' ?>;">
                    <?= esc($location['atm_status']) ?>
                  </span>
                </div>
                <p class="text-sm flex items-center gap-1" style="color: hsl(var(--muted-foreground));">
                  <i data-lucide="map-pin" class="w-4 h-4"></i>
                  <?= esc($location['address'] ?: ($location['area'] . ', ' . $location['city'])) ?>
                  <?php if ($location['pin']): ?> - <?= esc($location['pin']) ?><?php endif; ?>
                </p>
                <?php if ($location['location_type']): ?>
                  <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($location['location_type']) ?>
                  </p>
                <?php endif; ?>
                <p class="text-sm flex items-center gap-1 mt-1" style="color: hsl(var(--muted-foreground));">
                  <i data-lucide="clock" class="w-4 h-4"></i><?= esc($location['hours']) ?>
                </p>
                <?php if (!empty($location['latitude']) && !empty($location['longitude'])): ?>
                  <a href="https://www.google.com/maps?q=<?= $location['latitude'] ?>,<?= $location['longitude'] ?>"
                    target="_blank" class="text-xs mt-2 inline-block text-primary">
                    <i data-lucide="map"></i> View on map
                  </a>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="col-span-3">No ATMs found.</p>
          <?php endif; ?>
        </div>
      </div><!-- /atm-tab-locations -->

    </div>
  </section>

  <script>
    (function () {
      var tabs = document.querySelectorAll('.atm-tab-btn');
      var panels = document.querySelectorAll('.atm-tab-panel');

      tabs.forEach(function (btn) {
        btn.addEventListener('click', function () {
          var target = btn.getAttribute('data-tab');
          tabs.forEach(function (b) {
            var active = b.getAttribute('data-tab') === target;
            b.setAttribute('aria-selected', active ? 'true' : 'false');
            if (active) {
              b.classList.remove('btn-outline');
              b.classList.add('btn-primary');
            } else {
              b.classList.remove('btn-primary');
              b.classList.add('btn-outline');
            }
          });
          panels.forEach(function (panel) {
            if (panel.id === target) {
              panel.classList.remove('hidden');
            } else {
              panel.classList.add('hidden');
            }
          });
          if (window.lucide && window.lucide.createIcons) {
            window.lucide.createIcons();
          }
        });
      });
    }());
  </script>

<?php elseif ($pageKey === 'block-card'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank max-w-3xl">
      <div class="bank-card p-8 mb-8 text-center" style="border: 2px solid hsl(var(--destructive));">
        <i data-lucide="alert-triangle" class="w-16 h-16 mx-auto mb-4" style="color: hsl(var(--destructive));"></i>
        <h2 class="font-heading text-2xl text-foreground mb-3">Emergency Card Block</h2>
        <p class="readable mb-6" style="color: hsl(var(--muted-foreground));">If your ATM or debit card is lost, stolen,
          or compromised, block it immediately using one of the options below.</p>
        <a href="tel:<?= str_replace(['-', ' '], '', $digitalSettings['phone'] ?? '02572220055') ?>"
          class="btn-primary text-lg inline-flex items-center gap-2 px-8 py-4"
          style="background-color: hsl(var(--destructive)); color: hsl(var(--destructive-foreground));"><i
            data-lucide="phone" class="w-5 h-5"></i> Call: <?= esc($digitalSettings['phone'] ?? '8750587505') ?></a>
        <p class="text-sm mt-3" style="color: hsl(var(--muted-foreground));">Available 24x7 for card blocking support</p>
      </div>

      <h2 class="font-heading text-xl text-foreground mb-4">How to Block Your Card</h2>
      <div class="space-y-4 mb-8">
        <?php if (!empty($blockCardMethods)): ?>
          <?php foreach ($blockCardMethods as $method): ?>
            <div class="bank-card p-5 flex items-start gap-4">
              <span class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                style="background-color: hsl(var(--destructive) / 0.1);">
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
              <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full flex-shrink-0 mt-2"
                  style="background-color: hsl(var(--destructive));"></span><?= esc($step) ?></li>
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
          <label for="code-search-page" class="text-sm font-medium text-foreground mb-2 block">Search by branch name,
            city, or code</label>
          <div class="relative">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5"
              style="color: hsl(var(--muted-foreground));"></i>
            <input id="code-search-page" type="search" name="q" value="<?= esc($codeSearch) ?>"
              placeholder="e.g. Bhusawal, JPCB0000003"
              class="w-full pl-10 pr-4 py-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none"
              style="border-color: hsl(var(--border));">
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
                  <tr class="border-b"
                    style="border-color: hsl(var(--border)); background-color: <?= $index % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
                    <td class="p-4 text-sm font-medium text-foreground"><?= esc($code['branch_name']) ?></td>
                    <td class="p-4 text-sm text-foreground"><?= esc($code['city']) ?></td>
                    <td class="p-4 text-sm">
                      <?php if (!empty($code['ifsc'])): ?>
                        <span class="flex items-center gap-2">
                          <code class="font-mono text-foreground"><?= esc($code['ifsc']) ?></code>
                          <button type="button" class="tap-target p-1 rounded text-xs"
                            style="background-color: hsl(var(--muted));"
                            onclick="navigator.clipboard.writeText('<?= esc($code['ifsc'], 'js') ?>'); this.textContent='Copied'; setTimeout(() => this.textContent='Copy', 1500);">Copy</button>
                        </span>
                      <?php else: ?>
                        —
                      <?php endif; ?>
                    </td>
                    <td class="p-4 text-sm">
                      <?php if (!empty($code['micr'])): ?>
                        <span class="flex items-center gap-2">
                          <code class="font-mono text-foreground"><?= esc($code['micr']) ?></code>
                          <button type="button" class="tap-target p-1 rounded text-xs"
                            style="background-color: hsl(var(--muted));"
                            onclick="navigator.clipboard.writeText('<?= esc($code['micr'], 'js') ?>'); this.textContent='Copied'; setTimeout(() => this.textContent='Copy', 1500);">Copy</button>
                        </span>
                      <?php else: ?>
                        —
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="p-4 text-center">No branches with IFSC/MICR codes
                    found.<?php if ($codeSearch !== ''): ?> Try a different search.<?php endif; ?></td>
                </tr>
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
          <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">
            <?= esc($rtgsDescription ?? 'Real Time Gross Settlement for high-value, real-time transfers.') ?>
          </p>
          <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
            <?php if (!empty($rtgsFeatures)): ?>
              <?php foreach ($rtgsFeatures as $feature): ?>
                <li class="flex items-center gap-2"><i data-lucide="clock"
                    class="w-4 h-4 text-primary"></i><?= esc($feature) ?></li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-primary"></i>Settlement:
                real-time</li>
              <li class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-primary"></i>Minimum: ₹2,00,000
              </li>
              <li class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-primary"></i>Availability:
                24x7x365</li>
            <?php endif; ?>
          </ul>
        </div>
        <div class="bank-card p-6">
          <h2 class="font-heading text-xl text-foreground mb-3">NEFT</h2>
          <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">
            <?= esc($neftDescription ?? 'National Electronic Funds Transfer for batch-processed transfers.') ?>
          </p>
          <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
            <?php if (!empty($neftFeatures)): ?>
              <?php foreach ($neftFeatures as $feature): ?>
                <li class="flex items-center gap-2"><i data-lucide="clock"
                    class="w-4 h-4 text-primary"></i><?= esc($feature) ?></li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-primary"></i>Settlement:
                half-hourly batches</li>
              <li class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-primary"></i>Minimum: no
                minimum</li>
              <li class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-primary"></i>Availability:
                24x7x365</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>

      <!-- RTGS/NEFT Transaction Limits -->
      <div class="bank-card p-6 mb-8">
        <h3 class="font-heading text-lg font-bold mb-4 text-foreground flex items-center gap-2">
          <i data-lucide="arrow-left-right" class="w-5 h-5" style="color: hsl(var(--primary));"></i>
          RTGS / NEFT Transaction Limits
        </h3>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-primary text-primary-foreground">
                <th class="p-3 text-left font-semibold">Channel</th>
                <th class="p-3 text-left font-semibold">Description</th>
                <th class="p-3 text-center font-semibold">Min/Txn</th>
                <th class="p-3 text-center font-semibold">Max/Txn</th>
                <th class="p-3 text-center font-semibold">Max/Day</th>
                <th class="p-3 text-center font-semibold">Max/Month</th>
                <th class="p-3 text-center font-semibold">Availability</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($digitalLimits)): ?>
                <?php
                $rtgsNeftLimits = array_filter($digitalLimits, function ($limit) {
                  return in_array($limit['channel'], ['RTGS', 'NEFT']);
                });
                ?>
                <?php foreach ($rtgsNeftLimits as $limit): ?>
                  <tr class="border-b" style="border-color: hsl(var(--border));">
                    <td class="p-3 font-medium"><?= esc($limit['channel']) ?></td>
                    <td class="p-3" style="color: hsl(var(--muted-foreground));"><?= esc($limit['description']) ?></td>
                    <td class="p-3 text-center"><?= esc($limit['min_per_txn']) ?></td>
                    <td class="p-3 text-center"><?= esc($limit['max_per_txn']) ?></td>
                    <td class="p-3 text-center"><?= esc($limit['max_per_day']) ?></td>
                    <td class="p-3 text-center"><?= esc($limit['max_per_month']) ?></td>
                    <td class="p-3 text-center">
                      <span class="text-xs px-2 py-1 rounded-full"
                        style="background-color: hsl(var(--primary)/0.1); color: hsl(var(--primary));">
                        <?= esc($limit['availability']) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="p-4 text-center">No transaction limit data available.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="bank-card p-6 mb-8">
        <h2 class="font-heading text-lg text-foreground mb-4">How to Initiate a Transfer</h2>
        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4">
          <?php if (!empty($transferSteps)): ?>
            <?php foreach ($transferSteps as $step): ?>
              <div class="text-center">
                <span
                  class="w-8 h-8 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-2 text-sm"><?= esc($step['step']) ?></span>
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
        <?php if (!empty($rtgsNeftFormPdf)): ?>
          <a href="<?= base_url($rtgsNeftFormPdf) ?>" class="btn-primary text-sm flex items-center gap-2" target="_blank">
            <i data-lucide="download" class="w-4 h-4"></i> Download RTGS/NEFT Form
          </a>
        <?php else: ?>
          <a href="<?= site_url('downloads/forms') ?>" class="btn-primary text-sm flex items-center gap-2">
            <i data-lucide="download" class="w-4 h-4"></i> All Forms
          </a>
        <?php endif; ?>
        <a href="<?= site_url('digital/ifsc-micr') ?>" class="btn-outline text-sm">Search IFSC Codes</a>
        <a href="<?= site_url('services/charges') ?>" class="btn-outline text-sm">View Charges</a>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'upi'): ?>

  <section class="section-padding bg-background">
    <div class="container-bank">

      <!-- Hero Section -->
      <div class="text-center mb-12">
        <div class="flex justify-center mb-4">
          <span class="inline-flex items-center gap-2 text-sm font-medium px-3 py-1 rounded-full"
            style="background-color: hsl(var(--primary)/0.1); color: hsl(var(--primary));">
            <i data-lucide="zap" class="w-3.5 h-3.5"></i>
            <?= esc($digitalSettings['upi_header_eyebrow'] ?? 'National Payments Corporation of India') ?>
          </span>
        </div>
        <h1 class="font-heading text-4xl md:text-5xl font-bold mb-4" style="color: hsl(var(--primary));">
          <?= esc($digitalSettings['upi_header_title'] ?? 'Unified Payments Interface') ?>
        </h1>
        <p class="text-lg max-w-3xl mx-auto" style="color: hsl(var(--muted-foreground));">
          <?= esc($digitalSettings['upi_header_description'] ?? 'An instant, secure payment system built on IMPS infrastructure — enabling real-time transfers between any two bank accounts, 24×7, 365 days a year.') ?>
        </p>
      </div>

      <!-- Key Stats Row -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-14">
        <?php foreach ($statPills as $pill): ?>
          <div class="bank-card p-4 text-center">
            <div class="flex justify-center mb-2">
              <i data-lucide="<?= esc($pill['icon'] ?? 'clock') ?>" class="w-6 h-6" style="color: hsl(var(--primary));"></i>
            </div>
            <div class="text-xl font-bold text-foreground"><?= esc($pill['title']) ?></div>
            <div class="text-xs" style="color: hsl(var(--muted-foreground));"><?= esc($pill['description']) ?></div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Tab Navigation -->
      <div class="flex flex-wrap gap-3 mb-10" role="tablist" aria-label="UPI Sections">

        <button type="button" role="tab" aria-selected="true" aria-controls="tab-features"
          class="upi-tab-btn btn-primary text-sm flex items-center gap-2" data-tab="tab-features">

          <i data-lucide="star" class="w-4 h-4"></i>
          Features
        </button>

        <button type="button" role="tab" aria-selected="false" aria-controls="tab-eligibility"
          class="upi-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="tab-eligibility">

          <i data-lucide="users" class="w-4 h-4"></i>
          Eligibility
        </button>

        <button type="button" role="tab" aria-selected="false" aria-controls="tab-transactions"
          class="upi-tab-btn btn-outline text-sm flex items-center gap-2" data-tab="tab-transactions">

          <i data-lucide="arrow-left-right" class="w-4 h-4"></i>
          Transactions
        </button>

      </div>

      <!-- ========== TAB 1: FEATURES ========== -->
      <div id="tab-features" class="upi-tab-panel">
        <!-- Feature Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-10">
          <?php if (!empty($upiFeatures['feature_cards']['card'])): ?>
            <?php foreach ($upiFeatures['feature_cards']['card'] as $card): ?>
              <div class="bank-card p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4"
                  style="background-color: hsl(var(--primary)/0.1);">
                  <i data-lucide="<?= esc($card['icon'] ?? 'circle') ?>" class="w-6 h-6"
                    style="color: hsl(var(--primary));"></i>
                </div>
                <h3 class="font-heading text-lg font-semibold mb-2 text-foreground"><?= esc($card['title']) ?></h3>
                <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($card['description']) ?></p>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Feature Overview -->
        <?php if (!empty($upiFeatures['checklist']['checklist'])): ?>
          <div class="bank-card p-6">
            <h3 class="font-heading text-xl font-bold mb-4 text-foreground">Complete Feature Overview</h3>
            <div class="grid md:grid-cols-2 gap-3">
              <?php foreach ($upiFeatures['checklist']['checklist'] as $item): ?>
                <div class="flex items-center gap-2">
                  <i data-lucide="check-circle" class="w-4 h-4" style="color: hsl(var(--primary));"></i>
                  <span class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($item['title']) ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- ========== TAB 2: ELIGIBILITY ========== -->
      <div id="tab-eligibility" class="upi-tab-panel hidden">
        <div class="grid md:grid-cols-2 gap-8">
          <!-- Who Can Avail -->
          <div class="bank-card p-6">
            <div class="flex items-center gap-2 mb-4">
              <i data-lucide="user-check" class="w-5 h-5" style="color: hsl(var(--primary));"></i>
              <h3 class="font-heading text-lg font-bold text-foreground">Who Can Avail UPI Service?</h3>
            </div>
            <p class="text-sm mb-4" style="color: hsl(var(--muted-foreground));">Individual having —</p>
            <ul class="space-y-2">
              <?php foreach ($eligibilityChecklist as $item): ?>
                <li class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));">
                  <i data-lucide="check" class="w-4 h-4" style="color: hsl(var(--primary));"></i>
                  <?= esc($item['title']) ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- Registration Steps -->
          <div class="space-y-6">
            <div class="bank-card p-6">
              <div class="flex items-center gap-2 mb-4">
                <i data-lucide="smartphone" class="w-5 h-5" style="color: hsl(var(--primary));"></i>
                <h3 class="font-heading text-lg font-bold text-foreground">Registration in UPI App</h3>
              </div>
              <div class="space-y-4">
                <?php foreach ($registrationSteps as $step): ?>
                  <div class="flex gap-3">
                    <div
                      class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold text-white"
                      style="background-color: hsl(var(--primary));"><?= esc($step['step_number']) ?></div>
                    <div>
                      <p class="font-medium text-sm text-foreground"><?= esc($step['title']) ?></p>
                      <?php if (!empty($step['description'])): ?>
                        <p class="text-xs" style="color: hsl(var(--muted-foreground));"><?= esc($step['description']) ?></p>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- PIN Generation Steps -->
            <div class="bank-card p-6">
              <div class="flex items-center gap-2 mb-4">
                <i data-lucide="key" class="w-5 h-5" style="color: hsl(var(--primary));"></i>
                <h3 class="font-heading text-lg font-bold text-foreground">Generating UPI PIN</h3>
              </div>
              <div class="space-y-4">
                <?php foreach ($pinSteps as $step): ?>
                  <div class="flex gap-3">
                    <div
                      class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold text-white"
                      style="background-color: hsl(var(--primary));"><?= esc($step['step_number']) ?></div>
                    <div>
                      <p class="font-medium text-sm text-foreground"><?= esc($step['title']) ?></p>
                      <?php if (!empty($step['description'])): ?>
                        <p class="text-xs" style="color: hsl(var(--muted-foreground));"><?= esc($step['description']) ?></p>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ========== TAB 3: TRANSACTIONS ========== -->
      <div id="tab-transactions" class="upi-tab-panel hidden">
        <!-- Financial & Non-Financial -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
          <?php if (!empty($financialItems)): ?>
            <div class="bank-card p-6">
              <h3 class="font-heading text-lg font-bold mb-3 text-foreground">Financial Transactions</h3>
              <ul class="space-y-2">
                <?php foreach ($financialItems as $item): ?>
                  <li class="flex items-start gap-2 text-sm" style="color: hsl(var(--muted-foreground));">
                    <i data-lucide="arrow-right" class="w-4 h-4 mt-0.5 flex-shrink-0" style="color: hsl(var(--primary));"></i>
                    <span><?= $item['title'] ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <?php if (!empty($nonFinancialItems)): ?>
            <div class="bank-card p-6">
              <h3 class="font-heading text-lg font-bold mb-3 text-foreground">Non-Financial Transactions</h3>
              <ul class="space-y-2">
                <?php foreach ($nonFinancialItems as $item): ?>
                  <li class="flex items-start gap-2 text-sm" style="color: hsl(var(--muted-foreground));">
                    <i data-lucide="arrow-right" class="w-4 h-4 mt-0.5 flex-shrink-0" style="color: hsl(var(--primary));"></i>
                    <span><?= esc($item['title']) ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
        </div>

        <!-- PUSH & PULL Steps -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
          <?php if (!empty($pushSteps)): ?>
            <div class="bank-card p-6">
              <div class="flex items-center gap-2 mb-4">
                <i data-lucide="send" class="w-5 h-5" style="color: hsl(var(--primary));"></i>
                <h3 class="font-heading text-lg font-bold text-foreground">Sending Money (PUSH)</h3>
              </div>
              <div class="space-y-3">
                <?php foreach ($pushSteps as $step): ?>
                  <div class="flex gap-2 text-sm">
                    <span class="font-bold" style="color: hsl(var(--primary));"><?= esc($step['step_number']) ?>.</span>
                    <span style="color: hsl(var(--muted-foreground));"><?= esc($step['title']) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <?php if (!empty($pullSteps)): ?>
            <div class="bank-card p-6">
              <div class="flex items-center gap-2 mb-4">
                <i data-lucide="download" class="w-5 h-5" style="color: hsl(var(--primary));"></i>
                <h3 class="font-heading text-lg font-bold text-foreground">Requesting Money (PULL)</h3>
              </div>
              <div class="space-y-3">
                <?php foreach ($pullSteps as $step): ?>
                  <div class="flex gap-2 text-sm">
                    <span class="font-bold" style="color: hsl(var(--primary));"><?= esc($step['step_number']) ?>.</span>
                    <span style="color: hsl(var(--muted-foreground));"><?= esc($step['title']) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <!-- UPI Transaction Limits Table -->
        <?php if (!empty($upiLimits)): ?>
          <div class="bank-card p-6 mb-8">
            <h3 class="font-heading text-lg font-bold mb-4 text-foreground">UPI Transaction Limits</h3>
            <div class="overflow-x-auto">
              <table class="w-full text-sm">
                <thead>
                    <tr class="bg-primary text-primary-foreground">
                    <th class="p-3 text-left font-semibold">Transaction Type</th>
                    <th class="p-3 text-center font-semibold">Per Transaction</th>
                    <th class="p-3 text-center font-semibold">Per Day Limit</th>
                    <th class="p-3 text-center font-semibold">Per Day Count</th>
                    <th class="p-3 text-center font-semibold">Per Month Limit</th>
                    <th class="p-3 text-center font-semibold">Per Month Count</th>
                    <th class="p-3 text-center font-semibold">Per Month UPI</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($upiLimits as $limit): ?>
                    <tr class="border-b" style="border-color: hsl(var(--border));">
                      <td class="p-3 text-center"><?= esc($limit['transaction_type']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['per_transaction']) ?></td>

                      <td class="p-3 text-center">
                        <?= esc($limit['per_day_limit']) ?>
                      </td>

                      <td class="p-3 text-center">
                        <?= esc($limit['per_day_count']) ?>
                      </td>

                      <td class="p-3 text-center">
                        <?= esc($limit['per_month_limit']) ?>
                      </td>

                      <td class="p-3 text-center">
                        <?= esc($limit['per_month_count']) ?>
                      </td>

                      <td class="p-3 text-center">
                        <?= esc($limit['per_month_upi']) ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>

        <!-- UPI / IMPS Transaction Limits Table -->
        <div class="bank-card p-6 mb-8">
          <h3 class="font-heading text-lg font-bold mb-4 text-foreground flex items-center gap-2">
            <i data-lucide="smartphone" class="w-5 h-5" style="color: hsl(var(--primary));"></i>
            UPI / IMPS Transaction Limits
          </h3>
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead>
                <tr class="bg-primary text-primary-foreground">
                  <th class="p-3 text-left font-semibold">Channel</th>
                  <th class="p-3 text-left font-semibold">Description</th>
                  <th class="p-3 text-center font-semibold">Min/Txn</th>
                  <th class="p-3 text-center font-semibold">Max/Txn</th>
                  <th class="p-3 text-center font-semibold">Max/Day</th>
                  <th class="p-3 text-center font-semibold">Max/Month</th>
                  <th class="p-3 text-center font-semibold">Day Count</th>
                  <th class="p-3 text-center font-semibold">Month Count</th>
                  <th class="p-3 text-center font-semibold">Availability</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($digitalLimits)): ?>
                  <?php
                  $upiImpsLimits = array_filter($digitalLimits, function ($limit) {
                    return in_array($limit['channel'], ['UPI', 'IMPS']);
                  });
                  ?>
                  <?php foreach ($upiImpsLimits as $limit): ?>
                    <tr class="border-b" style="border-color: hsl(var(--border));">
                      <td class="p-3 font-medium"><?= esc($limit['channel']) ?></td>
                      <td class="p-3" style="color: hsl(var(--muted-foreground));"><?= esc($limit['description']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['min_per_txn']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['max_per_txn']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['max_per_day']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['max_per_month']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['per_day_count']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['per_month_count']) ?></td>
                      <td class="p-3 text-center">
                        <span class="text-xs px-2 py-1 rounded-full"
                          style="background-color: hsl(var(--primary)/0.1); color: hsl(var(--primary));">
                          <?= esc($limit['availability']) ?>
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="9" class="p-4 text-center">No transaction limit data available.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Digital Channel Transaction Limits (for reference) -->
        <?php if (!empty($digitalLimits)): ?>
          <div class="bank-card p-6">
            <h3 class="font-heading text-lg font-bold mb-4 text-foreground flex items-center gap-2">
              <i data-lucide="credit-card" class="w-5 h-5" style="color: hsl(var(--primary));"></i>
              Digital Channel Transaction Limits
            </h3>
            <div class="overflow-x-auto">
              <table class="w-full text-sm">
                <thead>
                  <tr class="bg-primary text-primary-foreground">
                    <th class="p-3 text-left font-semibold">Channel</th>
                    <th class="p-3 text-left font-semibold">Description</th>
                    <th class="p-3 text-center font-semibold">Min/Txn</th>
                    <th class="p-3 text-center font-semibold">Max/Txn</th>
                    <th class="p-3 text-center font-semibold">Max/Day</th>
                    <th class="p-3 text-center font-semibold">Max/Month</th>
                    <th class="p-3 text-center font-semibold">Day Count</th>
                    <th class="p-3 text-center font-semibold">Month Count</th>
                    <th class="p-3 text-center font-semibold">Availability</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($digitalLimits as $limit): ?>
                    <tr class="border-b" style="border-color: hsl(var(--border));">
                      <td class="p-3 font-medium"><?= esc($limit['channel']) ?></td>
                      <td class="p-3" style="color: hsl(var(--muted-foreground));"><?= esc($limit['description']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['min_per_txn']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['max_per_txn']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['max_per_day']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['max_per_month']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['per_day_count']) ?></td>
                      <td class="p-3 text-center"><?= esc($limit['per_month_count']) ?></td>
                      <td class="p-3 text-center">
                        <span class="text-xs px-2 py-1 rounded-full" style="background-color: hsl(var(--primary)/0.1); color: hsl(var(--primary));">
                          <?= esc($limit['availability']) ?>
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      </div>

      </div>
  </section>

  <script>
    (function () {

      var tabs = document.querySelectorAll('.upi-tab-btn');
      var panels = document.querySelectorAll('.upi-tab-panel');

      tabs.forEach(function (btn) {

        btn.addEventListener('click', function () {

          var target = btn.getAttribute('data-tab');

          // Toggle buttons
          tabs.forEach(function (b) {

            var active = b.getAttribute('data-tab') === target;

            b.setAttribute('aria-selected', active ? 'true' : 'false');

            if (active) {
              b.classList.remove('btn-outline');
              b.classList.add('btn-primary');
            } else {
              b.classList.remove('btn-primary');
              b.classList.add('btn-outline');
            }

          });

          // Toggle panels
          panels.forEach(function (panel) {

            if (panel.id === target) {
              panel.classList.remove('hidden');
            } else {
              panel.classList.add('hidden');
            }

          });

          // Re-render Lucide icons
          if (window.lucide && window.lucide.createIcons) {
            window.lucide.createIcons();
          }

        });

      });

    }());
  </script>


<?php elseif ($pageKey === 'digisaathi'): ?>

  <section class="section-padding bg-background">
    <div class="container-bank">

      <!-- Hero Section -->
      <div class="text-center mb-12">
        <h1 class="font-heading text-5xl font-bold mb-4" style="color: hsl(var(--primary));">
          <?= esc($digisaathiSettings['hero_title'] ?? 'Your Trusted Saathi for Digital Payments') ?>
        </h1>
        <p class="text-xl font-semibold mb-2">
          <?= esc($digisaathiSettings['hero_subtitle'] ?? 'Get information on digital payment products and services') ?>
        </p>
        <p style="color: hsl(var(--muted-foreground));">
          <?= esc($digisaathiSettings['hero_footer_text'] ?? '24x7 Helpline for information on digital payment products and services') ?>
        </p>
      </div>

      <!-- Main Introduction Card -->
      <div class="bank-card p-8 mb-10 border-l-4" style="border-left-color: hsl(var(--primary));">
        <div class="grid md:grid-cols-2 gap-8 items-center">
          <div>
            <h2 class="text-3xl font-bold mb-4">
              <?= esc($digisaathiSettings['about_title'] ?? 'About DigiSaathi') ?>
            </h2>
            <p class="leading-8 mb-4 text-base">
              <?= esc($digisaathiSettings['about_description'] ?? 'DigiSaathi is a 24x7 helpline for information on digital payment products and services set up by NPCI on behalf of payment system operators and participants including banks and non-banks.') ?>
            </p>
            <p class="leading-8 text-base" style="color: hsl(var(--muted-foreground));">
              <?= esc($digisaathiSettings['about_note'] ?? 'Your trusted companion for information on all digital payment products and services. Ask questions related to digital payments via WhatsApp, phone calls and chatbot available in 10 Indian languages.') ?>
            </p>
          </div>
          <div class="flex justify-center">
            <?php
            $aboutImage = $digisaathiImages['about']['image_path'] ?? $digisaathiSettings['about_image'] ?? 'assets/img/digisaathi-1.jpg';
            $aboutAlt = $digisaathiImages['about']['alt_text'] ?? 'DigiSaathi Introduction';
            ?>
            <img src="<?= base_url($aboutImage) ?>" class="rounded-lg shadow-lg object-cover"
              style="width: 100%; max-width: 450px; height: auto; aspect-ratio: 4/3;" alt="<?= esc($aboutAlt) ?>">
          </div>
        </div>
      </div>

      <!-- Contact & Access Section -->
      <div class="bank-card p-8 mb-10"
        style="background: linear-gradient(135deg, hsl(var(--primary)) 0%, hsl(var(--primary)/.8) 100%); color: white;">
        <h2 class="text-3xl font-bold mb-8 text-center">
          <?= esc($digisaathiSettings['contact_title'] ?? 'For Instant Access') ?>
        </h2>

        <div class="grid md:grid-cols-2 gap-8 items-center">
          <div class="text-center">
            <h3 class="text-2xl font-bold mb-4">Chat with us on</h3>
            <p class="text-lg mb-4"><?= esc($digisaathiSettings['contact_website'] ?? 'digisaathi.info') ?></p>

            <div class="space-y-3 text-lg">
              <?php if (!empty($digisaathiContacts)): ?>
                <?php foreach ($digisaathiContacts as $contact): ?>
                  <?php if ($contact['status'] == 1 && ($contact['type'] === 'call' || $contact['type'] === 'phone' || $contact['type'] === 'whatsapp' || $contact['type'] === 'website')): ?>
                    <div class="flex items-center justify-center gap-2">
                      <i data-lucide="<?= esc($contact['icon']) ?>" class="w-5 h-5"></i>
                      <span><strong><?= esc($contact['title']) ?></strong></span>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

          <div class="text-center">
            <?php
            $qrImage = $digisaathiImages['qr']['image_path'] ?? $digisaathiSettings['contact_qr_image'] ?? 'assets/img/digisaathi-qr.jpg';
            $qrAlt = $digisaathiImages['qr']['alt_text'] ?? 'DigiSaathi QR Code';
            ?>
            <img src="<?= base_url($qrImage) ?>" class="rounded-lg shadow-lg mx-auto"
              style="width: 160px; height: 160px; object-fit: cover;" alt="<?= esc($qrAlt) ?>">
            <p class="mt-4">Scan to chat</p>
          </div>
        </div>
      </div>

      <!-- Language Support -->
      <div class="bank-card p-8 mb-10">
        <div class="grid md:grid-cols-2 gap-8 items-center">
          <div class="flex justify-center">
            <?php
            $languageImage = $digisaathiImages['language']['image_path'] ?? $digisaathiSettings['language_image'] ?? 'assets/img/digisaathi-2.jpg';
            $languageAlt = $digisaathiImages['language']['alt_text'] ?? 'Language Support';
            ?>
            <img src="<?= base_url($languageImage) ?>" class="rounded-lg shadow-lg object-cover"
              style="width: 100%; max-width: 450px; height: auto; aspect-ratio: 4/3;" alt="<?= esc($languageAlt) ?>">
          </div>
          <div>
            <h2 class="text-3xl font-bold mb-4">
              <?= esc($digisaathiSettings['language_title'] ?? 'Available in 10 Languages') ?>
            </h2>
            <p class="mb-6" style="color: hsl(var(--muted-foreground));">
              <?= esc($digisaathiSettings['language_description'] ?? 'DigiSaathi is available in multiple Indian languages to serve you better:') ?>
            </p>
            <div class="grid grid-cols-2 gap-3">
              <?php if (!empty($digisaathiLanguages)): ?>
                <?php
                $half = ceil(count($digisaathiLanguages) / 2);
                $firstColumn = array_slice($digisaathiLanguages, 0, $half);
                $secondColumn = array_slice($digisaathiLanguages, $half);
                ?>
                <div class="space-y-2">
                  <?php foreach ($firstColumn as $language): ?>
                    <div class="flex items-center gap-2">
                      <i data-lucide="check-circle" class="w-5 h-5 text-primary flex-shrink-0"></i>
                      <span><?= esc($language['name']) ?></span>
                    </div>
                  <?php endforeach; ?>
                </div>
                <div class="space-y-2">
                  <?php foreach ($secondColumn as $language): ?>
                    <div class="flex items-center gap-2">
                      <i data-lucide="check-circle" class="w-5 h-5 text-primary flex-shrink-0"></i>
                      <span><?= esc($language['name']) ?></span>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Chatbot & Support -->
      <div class="bank-card p-8 mb-10">
        <div class="grid md:grid-cols-2 gap-8 items-center">
          <div>
            <h2 class="text-3xl font-bold mb-4">
              <?= esc($digisaathiSettings['support_title'] ?? 'Chatbot & Helpline Support') ?>
            </h2>
            <p class="mb-4" style="color: hsl(var(--muted-foreground));">
              <?= esc($digisaathiSettings['support_description'] ?? 'DigiSaathi assists users through multiple channels for all your digital payment queries:') ?>
            </p>
            <ul class="space-y-3">
              <?php if (!empty($digisaathiSupportFeatures)): ?>
                <?php foreach ($digisaathiSupportFeatures as $feature): ?>
                  <li class="flex items-start gap-3">
                    <i data-lucide="<?= esc($feature['icon']) ?>" class="w-5 h-5 text-primary mt-1 flex-shrink-0"></i>
                    <span>
                      <strong><?= esc($feature['title']) ?>:</strong>
                      <?= esc($feature['description']) ?>
                      <?php if (!empty($feature['link_text']) && !empty($feature['link'])): ?>
                        <a href="<?= esc($feature['link']) ?>" target="_blank" class="underline ml-1"
                          style="color: hsl(var(--primary));">
                          <?= esc($feature['link_text']) ?>
                        </a>
                      <?php endif; ?>
                    </span>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
            </ul>
          </div>
          <div class="flex justify-center">
            <?php
            $supportImage = $digisaathiImages['support']['image_path'] ?? $digisaathiSettings['support_image'] ?? 'assets/img/digisaathi-3.jpg';
            $supportAlt = $digisaathiImages['support']['alt_text'] ?? 'Chatbot Support';
            ?>
            <img src="<?= base_url($supportImage) ?>" class="rounded-lg shadow-lg object-cover"
              style="width: 100%; max-width: 450px; height: auto; aspect-ratio: 4/3;" alt="<?= esc($supportAlt) ?>">
          </div>
        </div>
      </div>

      <!-- Services & Features -->
      <div class="bank-card p-8 mb-10">
        <h2 class="text-3xl font-bold mb-8 text-center">
          <?= esc($digisaathiSettings['services_title'] ?? 'Digital Payment Services Covered') ?>
        </h2>

        <div class="grid md:grid-cols-2 gap-8 items-center">
          <div class="flex justify-center">
            <?php
            $servicesImage = $digisaathiImages['services']['image_path'] ?? $digisaathiSettings['services_image'] ?? 'assets/img/digisaathi-4.jpg';
            $servicesAlt = $digisaathiImages['services']['alt_text'] ?? 'Services';
            ?>
            <img src="<?= base_url($servicesImage) ?>" class="rounded-lg shadow-lg object-cover"
              style="width: 100%; max-width: 450px; height: auto; aspect-ratio: 4/3;" alt="<?= esc($servicesAlt) ?>">
          </div>
          <div>
            <ul class="space-y-3 text-base">
              <?php if (!empty($digisaathiServices)): ?>
                <?php
                $half = ceil(count($digisaathiServices) / 2);
                $firstServiceCol = array_slice($digisaathiServices, 0, $half);
                $secondServiceCol = array_slice($digisaathiServices, $half);
                ?>
                <div class="grid grid-cols-2 gap-3">
                  <div class="space-y-3">
                    <?php foreach ($firstServiceCol as $service): ?>
                      <li class="flex items-center gap-3">
                        <i data-lucide="<?= esc($service['icon']) ?>" class="w-5 h-5 text-primary flex-shrink-0"></i>
                        <span><?= esc($service['service_name']) ?></span>
                      </li>
                    <?php endforeach; ?>
                  </div>
                  <div class="space-y-3">
                    <?php foreach ($secondServiceCol as $service): ?>
                      <li class="flex items-center gap-3">
                        <i data-lucide="<?= esc($service['icon']) ?>" class="w-5 h-5 text-primary flex-shrink-0"></i>
                        <span><?= esc($service['service_name']) ?></span>
                      </li>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>

      <!-- CTA Section -->
      <div class="text-center mb-10">
        <h2 class="text-2xl font-bold mb-6">
          <?= esc($digisaathiSettings['cta_title'] ?? 'Ready to Get Help?') ?>
        </h2>
        <div class="flex flex-wrap gap-4 justify-center">
          <?php if (!empty($digisaathiContacts)): ?>
            <?php foreach ($digisaathiContacts as $contact): ?>
              <?php if ($contact['status'] == 1 && !empty($contact['link'])): ?>
                <a href="<?= esc($contact['link']) ?>" target="<?= $contact['is_external'] ? '_blank' : '_self' ?>"
                  class="btn-primary flex items-center gap-2" <?php if ($contact['type'] === 'whatsapp'): ?>
                    style="background-color: #25D366; border-color: #25D366;" <?php elseif (!empty($contact['button_color'])): ?>
                    style="background-color: <?= esc($contact['button_color']) ?>; border-color: <?= esc($contact['button_color']) ?>;"
                  <?php endif; ?>>
                  <i data-lucide="<?= esc($contact['icon']) ?>" class="w-4 h-4"></i>
                  <?= esc($contact['button_text'] ?? $contact['title']) ?>
                </a>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <!-- Footer Note -->
      <div class="text-center text-sm" style="color: hsl(var(--muted-foreground));">
        <p>
          <?= esc($digisaathiSettings['footer_note'] ?? 'Managed by NPCI, on behalf of the Indian payments ecosystem.') ?>
        </p>
      </div>

    </div>
  </section>

<?php endif; ?>
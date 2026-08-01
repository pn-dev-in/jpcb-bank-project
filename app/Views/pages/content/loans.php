<?php if ($pageKey === 'overview'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank">
      <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">We offer credit facilities for
        personal, business, and agricultural needs with competitive rates, practical documentation requirements, and
        flexible repayment structures.</p>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <?php if (!empty($loanCards)): ?>
          <?php foreach ($loanCards as $card): ?>
            <a href="<?= site_url(ltrim($card['href'], '/')) ?>" class="bank-card p-6 group transition-colors">
              <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4"
                style="background-color: hsl(var(--primary) / 0.1);">
                <i data-lucide="<?= esc($card['icon']) ?>" class="w-6 h-6 text-primary"></i>
              </div>
              <h3 class="font-semibold text-foreground mb-1 group-hover:text-primary"><?= esc($card['title']) ?></h3>
              <p class="text-sm text-primary font-medium mb-2"><?= esc($card['rate']) ?></p>
              <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($card['description']) ?></p>
              <span class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-3">Learn more <i
                  data-lucide="arrow-right" class="w-4 h-4"></i></span>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>
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
        <?php if (!empty($loanSchemes)): ?>
          <?php foreach ($loanSchemes as $scheme): ?>
            <div class="bank-card p-6">
              <h3 class="font-heading text-xl text-foreground mb-4"><?= esc($scheme['name']) ?></h3>
              <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <div>
                  <span class="text-xs block" style="color: hsl(var(--muted-foreground));">Max Loan Amount</span>
                  <span class="text-sm font-semibold text-primary"><?= esc($scheme['max_loan_amount'] ?? '—') ?></span>
                </div>
                <div>
                  <span class="text-xs block" style="color: hsl(var(--muted-foreground));">
                    <?= !empty($scheme['repayment']) ? 'Repayment' : 'Max Tenure' ?>
                  </span>
                  <span class="text-sm font-medium text-foreground">
                    <?= esc($scheme['repayment'] ?? $scheme['max_tenure'] ?? '—') ?>
                  </span>
                </div>
                <div>
                  <span class="text-xs block" style="color: hsl(var(--muted-foreground));">Margin</span>
                  <span class="text-sm font-medium text-foreground"><?= esc($scheme['margin'] ?? '—') ?></span>
                </div>
                <div>
                  <span class="text-xs block" style="color: hsl(var(--muted-foreground));">Collateral Security</span>
                  <span class="text-sm font-medium text-foreground"><?= esc($scheme['collateral_security'] ?? '—') ?></span>
                </div>
              </div>
              <div class="grid md:grid-cols-3 gap-6">
                <div>
                  <h4 class="text-sm font-semibold text-foreground mb-2">Purpose</h4>
                  <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc($scheme['purpose'])) ?></p>
                </div>
                <div>
                  <h4 class="text-sm font-semibold text-foreground mb-2">Eligibility</h4>
                  <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc($scheme['eligibility'])) ?>
                  </p>
                </div>
                <div>
                  <h4 class="text-sm font-semibold text-foreground mb-2">Prime Security</h4>
                  <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc($scheme['prime_security'])) ?>
                  </p>
                </div>
              </div>
              <div class="flex gap-3 mt-4 pt-4 border-t" style="border-color: hsl(var(--border));">
                <a href="<?= site_url('loans/emi-calculator') ?>" class="btn-primary text-sm">Calculate EMI</a>

                <?php if (!empty($scheme['form_pdf'])): ?>
                  <a href="<?= base_url($scheme['form_pdf']) ?>" target="_blank"
                    class="btn-outline text-sm flex items-center gap-1">
                    <i data-lucide="download" class="w-4 h-4"></i> Application Form
                  </a>
                <?php else: ?>
                  <a href="<?= site_url('downloads/forms') ?>" class="btn-outline text-sm flex items-center gap-1">
                    <i data-lucide="download" class="w-4 h-4"></i> All Forms
                  </a>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center">No loan schemes available at the moment.</p>
        <?php endif; ?>
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
          <button class="btn-outline text-sm flex items-center gap-1" type="button" onclick="window.print()"><i
              data-lucide="printer" class="w-4 h-4"></i> Print</button>
          <?php if (!empty($loanRatesPdf)): ?>
            <a href="<?= base_url($loanRatesPdf) ?>" class="btn-primary text-sm flex items-center gap-1" download>
              <i data-lucide="download" class="w-4 h-4"></i> Download PDF
            </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Interest Rates Table (commented out as per new design) 
      <div class="bank-card overflow-hidden mb-12">
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
              <?php if (!empty($loanRates)): ?>
                <?php foreach ($loanRates as $index => $rate): ?>
                  <tr class="border-b"
                    style="border-color: hsl(var(--border)); background-color: <?= $index % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
                    <td class="p-4 text-sm font-medium text-foreground"><?= esc($rate['product_name']) ?></td>
                    <td class="p-4 text-sm text-center font-semibold text-primary"><?= esc($rate['rate']) ?></td>
                    <td class="p-4 text-sm text-center text-foreground"><?= esc($rate['processing_fee']) ?></td>
                    <td class="p-4 text-sm text-center text-foreground"><?= esc($rate['prepayment_charge']) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="p-4 text-center">No interest rates available.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div> -->

      <!-- Tab Navigation for Loan Schemes -->
      <div class="mb-8">
        <h2 class="font-heading text-2xl text-foreground mb-6">Loan Schemes</h2>
        <div class="flex gap-2 mb-6 border-b" style="border-color: hsl(var(--border));">
          <button class="scheme-tab-btn active px-4 py-3 text-sm font-medium text-foreground border-b-2"
            style="border-color: hsl(var(--primary));" data-tab="retail">Retail Loans Scheme</button>
          <button class="scheme-tab-btn px-4 py-3 text-sm font-medium" style="color: hsl(var(--muted-foreground));"
            data-tab="wholesale">Wholesale Loans Scheme</button>
        </div>
        <!-- Retail Table -->
        <div id="retail-tab" class="scheme-tab-content active">
          <div class="bank-card overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full" role="table">
                <thead>
                  <tr class="bg-primary text-primary-foreground">
                    <th class="text-left p-4 font-semibold text-sm">No.</th>
                    <th class="text-left p-4 font-semibold text-sm">Name of Scheme</th>
                    <th class="text-center p-4 font-semibold text-sm">Min. ROI</th>
                    <th class="text-center p-4 font-semibold text-sm">Max. ROI</th>
                    <th class="text-center p-4 font-semibold text-sm">Women Entrepreneurs Benefit in ROI</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($retailSchemes as $scheme): ?>
                    <tr class="border-b"
                      style="border-color: hsl(var(--border)); background-color: <?= $scheme['serial_no'] % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
                      <td class="p-4 text-sm font-medium text-foreground"><?= $scheme['serial_no'] ?></td>
                      <td class="p-4 text-sm font-medium text-foreground"><?= esc($scheme['scheme_name']) ?></td>
                      <td class="p-4 text-sm text-center text-foreground"><?= $scheme['min_roi'] ?></td>
                      <td class="p-4 text-sm text-center text-primary font-semibold"><?= $scheme['max_roi'] ?></td>
                      <td class="p-4 text-sm text-center text-foreground"><?= esc($scheme['women_benefit']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Wholesale Table -->
        <div id="wholesale-tab" class="scheme-tab-content" style="display: none;">
          <div class="bank-card overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full" role="table">
                <thead>
                  <tr class="bg-primary text-primary-foreground">
                    <th class="text-left p-4 font-semibold text-sm">No.</th>
                    <th class="text-left p-4 font-semibold text-sm">Name of Scheme</th>
                    <th class="text-center p-4 font-semibold text-sm">Min. ROI</th>
                    <th class="text-center p-4 font-semibold text-sm">Max. ROI</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($wholesaleSchemes as $scheme): ?>
                    <tr class="border-b"
                      style="border-color: hsl(var(--border)); background-color: <?= $scheme['serial_no'] % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
                      <td class="p-4 text-sm font-medium text-foreground"><?= $scheme['serial_no'] ?></td>
                      <td class="p-4 text-sm font-medium text-foreground"><?= esc($scheme['scheme_name']) ?></td>
                      <td class="p-4 text-sm text-center text-foreground"><?= $scheme['min_roi'] ?></td>
                      <td class="p-4 text-sm text-center text-primary font-semibold"><?= $scheme['max_roi'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="mt-6 bank-card p-4">
          <h3 class="font-semibold text-foreground text-sm mb-2">Notes</h3>
          <ul class="text-sm space-y-1" style="color: hsl(var(--muted-foreground));">
            <?php if (!empty($loanInterestNotes)): ?>
              <?php foreach ($loanInterestNotes as $note): ?>
                <li><?= esc($note['note']) ?></li>
              <?php endforeach; ?>
            <?php else: ?>
              <li>No notes available.</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>


      <script>

        document.querySelectorAll('.scheme-tab-btn').forEach(btn => {

          btn.addEventListener('click', function () {

            const tabName = this.dataset.tab;

            // Remove active class from all buttons
            document.querySelectorAll('.scheme-tab-btn').forEach(b => {
              b.classList.remove('active');
            });

            // Hide all tab contents
            document.querySelectorAll('.scheme-tab-content').forEach(content => {
              content.style.display = 'none';
            });

            // Activate current button
            this.classList.add('active');

            // Show selected tab
            document.getElementById(tabName + '-tab').style.display = 'block';

          });

        });

      </script>
  </section>

<?php elseif ($pageKey === 'emi-calculator'): ?>

<section class="section-padding bg-background">

    <div class="container-bank">

        <div class="grid lg:grid-cols-5 gap-8">

            <!-- LEFT -->
            <div class="lg:col-span-2">

                <div class="bank-card p-6 sticky top-24">

                    <h2 class="font-heading text-lg text-foreground mb-6">

                        Calculate Your EMI

                    </h2>

                    <div class="space-y-6"
                         id="emi-calculator-root">

                        <!-- LOAN AMOUNT -->
                        <div>

                            <div class="flex items-center justify-between mb-2">

                                <label for="emi-principal"
                                       class="text-sm font-medium text-foreground">

                                    Loan Amount

                                </label>

                                <input type="number"
                                       id="emi-principal-input"
                                       value="500000"
                                       min="10000"
                                       max="10000000"
                                       step="10000"
                                       class="emi-manual-input">

                            </div>

                            <div class="mb-2">

                                <strong class="text-primary"
                                        id="emi-principal-display">

                                    ₹5,00,000

                                </strong>

                            </div>

                            <input id="emi-principal"
                                   type="range"
                                   min="10000"
                                   max="10000000"
                                   step="1"
                                   value="500000"
                                   class="w-full accent-primary">

                            <div class="flex justify-between text-xs mt-1"
                                 style="color: hsl(var(--muted-foreground));">

                                <span>₹10K</span>

                                <span>₹1Cr</span>

                            </div>

                        </div>

                        <!-- INTEREST RATE -->
                        <div>

                            <div class="flex items-center justify-between mb-2">

                                <label for="emi-rate"
                                       class="text-sm font-medium text-foreground">

                                    Interest Rate

                                </label>

                                <input type="number"
                                       id="emi-rate-input"
                                       value="10"
                                       min="1"
                                       max="24"
                                       step="0.25"
                                       class="emi-manual-input">

                            </div>

                            <div class="mb-2">

                                <strong class="text-primary"
                                        id="emi-rate-display">

                                    10%

                                </strong>

                                <span style="color: hsl(var(--muted-foreground));">

                                    p.a.

                                </span>

                            </div>

                            <input id="emi-rate"
                                   type="range"
                                   min="1"
                                   max="24"
                                   step="0.25"
                                   value="10"
                                   class="w-full accent-primary">

                            <div class="flex justify-between text-xs mt-1"
                                 style="color: hsl(var(--muted-foreground));">

                                <span>1%</span>

                                <span>24%</span>

                            </div>

                        </div>

                        <!-- TENURE -->
                        <div>

                            <div class="flex items-center justify-between mb-2">

                                <label for="emi-tenure"
                                       class="text-sm font-medium text-foreground">

                                    Loan Tenure

                                </label>

                                <input type="number"
                                       id="emi-tenure-input"
                                       value="36"
                                       min="1"
                                       max="120"
                                       step="1"
                                       class="emi-manual-input">

                            </div>

                            <div class="mb-2">

                                <strong class="text-primary"
                                        id="emi-tenure-display">

                                    36 months

                                </strong>

                                <span style="color: hsl(var(--muted-foreground));">

                                    (<span id="emi-years-display">3.0</span> years)

                                </span>

                            </div>

                            <input id="emi-tenure"
                                   type="range"
                                   min="1"
                                   max="120"
                                   step="1"
                                   value="36"
                                   class="w-full accent-primary">

                            <div class="flex justify-between text-xs mt-1"
                                 style="color: hsl(var(--muted-foreground));">

                                <span>1 mo</span>

                                <span>10 yrs</span>

                            </div>

                        </div>

                        <!-- RESET -->
                        <button type="button"
                                id="emi-reset"
                                class="btn-outline text-sm w-full flex items-center justify-center gap-2">

                            <i data-lucide="rotate-ccw"
                               class="w-4 h-4"></i>

                            Reset

                        </button>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="lg:col-span-3">

                <!-- STATS -->
                <div class="grid sm:grid-cols-3 gap-4 mb-8">

                    <div class="bank-card p-5 text-center">

                        <p class="text-xs mb-1"
                           style="color: hsl(var(--muted-foreground));">

                            Monthly EMI

                        </p>

                        <p class="text-2xl font-heading font-bold text-primary"
                           id="emi-monthly-value">

                            ₹16,134

                        </p>

                    </div>

                    <div class="bank-card p-5 text-center">

                        <p class="text-xs mb-1"
                           style="color: hsl(var(--muted-foreground));">

                            Total Interest

                        </p>

                        <p class="text-2xl font-heading font-bold text-foreground"
                           id="emi-interest-value">

                            ₹80,823

                        </p>

                    </div>

                    <div class="bank-card p-5 text-center">

                        <p class="text-xs mb-1"
                           style="color: hsl(var(--muted-foreground));">

                            Total Payable

                        </p>

                        <p class="text-2xl font-heading font-bold text-foreground"
                           id="emi-total-value">

                            ₹5,80,823

                        </p>

                    </div>

                </div>

                <!-- BREAKDOWN -->
                <div class="bank-card p-5 mb-8">

                    <h3 class="text-sm font-semibold text-foreground mb-3">

                        Payment Breakdown

                    </h3>

                    <div class="flex rounded-full overflow-hidden h-6"
                         aria-hidden="true">

                        <div id="emi-principal-bar"
                             class="bg-primary"
                             style="width: 86%;"></div>

                        <div id="emi-interest-bar"
                             style="width: 14%; background-color: hsl(var(--accent));"></div>

                    </div>

                    <div class="flex gap-6 mt-2 text-xs">

                        <span class="flex items-center gap-1.5">

                            <span class="w-3 h-3 rounded bg-primary"></span>

                            Principal:

                            <strong id="emi-principal-summary">

                                ₹5,00,000

                            </strong>

                        </span>

                        <span class="flex items-center gap-1.5">

                            <span class="w-3 h-3 rounded"
                                  style="background-color: hsl(var(--accent));"></span>

                            Interest:

                            <strong id="emi-interest-summary">

                                ₹80,823

                            </strong>

                        </span>

                    </div>

                </div>

                <!-- TABLE -->
                <div class="bank-card overflow-hidden">

                    <div class="p-4 border-b flex items-center justify-between"
                         style="border-color: hsl(var(--border));">

                        <h3 class="font-semibold text-foreground text-sm">

                            Amortization Schedule

                        </h3>

                        <button type="button"
                                onclick="window.print()"
                                class="text-sm text-primary flex items-center gap-1">

                            <i data-lucide="printer"
                               class="w-4 h-4"></i>

                            Print

                        </button>

                    </div>

                    <div class="overflow-x-auto max-h-[400px] overflow-y-auto">

                        <table class="w-full text-sm"
                               role="table">

                            <thead class="sticky top-0">

                                <tr class="bg-muted">

                                    <th class="p-3 text-left font-medium"
                                        style="color: hsl(var(--muted-foreground));">

                                        Month

                                    </th>

                                    <th class="p-3 text-right font-medium"
                                        style="color: hsl(var(--muted-foreground));">

                                        EMI

                                    </th>

                                    <th class="p-3 text-right font-medium"
                                        style="color: hsl(var(--muted-foreground));">

                                        Principal

                                    </th>

                                    <th class="p-3 text-right font-medium"
                                        style="color: hsl(var(--muted-foreground));">

                                        Interest

                                    </th>

                                    <th class="p-3 text-right font-medium"
                                        style="color: hsl(var(--muted-foreground));">

                                        Balance

                                    </th>

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

<style>

.emi-manual-input {

    width: 120px;

    border: 1px solid hsl(var(--border));

    background: hsl(var(--background));

    color: hsl(var(--foreground));

    border-radius: 10px;

    padding: 8px 12px;

    font-size: 14px;

    font-weight: 600;

    outline: none;

    transition: all 0.25s ease;

}

.emi-manual-input:focus {

    border-color: hsl(var(--primary));

    box-shadow:
        0 0 0 3px hsl(var(--primary) / 0.12);

}

</style>

<script>

(function () {

    const principalSlider =
        document.getElementById('emi-principal');

    const rateSlider =
        document.getElementById('emi-rate');

    const tenureSlider =
        document.getElementById('emi-tenure');

    const principalInput =
        document.getElementById('emi-principal-input');

    const rateInput =
        document.getElementById('emi-rate-input');

    const tenureInput =
        document.getElementById('emi-tenure-input');

    const principalDisplay =
        document.getElementById('emi-principal-display');

    const rateDisplay =
        document.getElementById('emi-rate-display');

    const tenureDisplay =
        document.getElementById('emi-tenure-display');

    const yearsDisplay =
        document.getElementById('emi-years-display');

    const monthlySpan =
        document.getElementById('emi-monthly-value');

    const totalInterestSpan =
        document.getElementById('emi-interest-value');

    const totalPayableSpan =
        document.getElementById('emi-total-value');

    const principalBar =
        document.getElementById('emi-principal-bar');

    const interestBar =
        document.getElementById('emi-interest-bar');

    const principalSummary =
        document.getElementById('emi-principal-summary');

    const interestSummary =
        document.getElementById('emi-interest-summary');

    const scheduleBody =
        document.getElementById('emi-schedule-body');

    const resetBtn =
        document.getElementById('emi-reset');

    function formatCurrency(value) {

        return '₹' + Math.round(value).toLocaleString('en-IN');

    }

    function calculateEMI() {

        let P = parseFloat(principalSlider.value);

        let r = parseFloat(rateSlider.value) / 100 / 12;

        let n = parseFloat(tenureSlider.value);

        let emi = 0;

        let totalPayment = 0;

        let totalInterest = 0;

        if (r === 0) {

            emi = P / n;

            totalPayment = P;

            totalInterest = 0;

        } else {

            emi =
                P * r * Math.pow(1 + r, n) /
                (Math.pow(1 + r, n) - 1);

            totalPayment = emi * n;

            totalInterest = totalPayment - P;

        }

        monthlySpan.innerText =
            formatCurrency(emi);

        totalInterestSpan.innerText =
            formatCurrency(totalInterest);

        totalPayableSpan.innerText =
            formatCurrency(totalPayment);

        principalSummary.innerText =
            formatCurrency(P);

        interestSummary.innerText =
            formatCurrency(totalInterest);

        let principalPercent =
            (P / totalPayment) * 100;

        let interestPercent =
            100 - principalPercent;

        principalBar.style.width =
            principalPercent + '%';

        interestBar.style.width =
            interestPercent + '%';

        // TABLE

        let balance = P;

        let rows = '';

        for (let month = 1; month <= n && month <= 120; month++) {

            let interestPayment = balance * r;

            let principalPayment =
                emi - interestPayment;

            if (principalPayment > balance) {

                principalPayment = balance;

            }

            balance -= principalPayment;

            if (balance < 0) {

                balance = 0;

            }

            rows += `
            <tr>
                <td class="p-3 text-left">${month}</td>
                <td class="p-3 text-right">${formatCurrency(emi)}</td>
                <td class="p-3 text-right">${formatCurrency(principalPayment)}</td>
                <td class="p-3 text-right">${formatCurrency(interestPayment)}</td>
                <td class="p-3 text-right">${formatCurrency(balance)}</td>
            </tr>`;

        }

        scheduleBody.innerHTML = rows;

    }

    function updateDisplay() {

        let p = parseInt(principalSlider.value);

        let r = parseFloat(rateSlider.value);

        let t = parseInt(tenureSlider.value);

        principalDisplay.innerText =
            formatCurrency(p);

        rateDisplay.innerText =
            r + '%';

        tenureDisplay.innerText =
            t + ' months';

        yearsDisplay.innerText =
            (t / 12).toFixed(1);

        calculateEMI();

    }

    // SLIDER EVENTS

    principalSlider.addEventListener('input', () => {

        principalInput.value =
            principalSlider.value;

        updateDisplay();

    });

    rateSlider.addEventListener('input', () => {

        rateInput.value =
            rateSlider.value;

        updateDisplay();

    });

    tenureSlider.addEventListener('input', () => {

        tenureInput.value =
            tenureSlider.value;

        updateDisplay();

    });

    // MANUAL INPUT EVENTS

    principalInput.addEventListener('input', () => {

        principalSlider.value =
            principalInput.value;

        updateDisplay();

    });

    rateInput.addEventListener('input', () => {

        rateSlider.value =
            rateInput.value;

        updateDisplay();

    });

    tenureInput.addEventListener('input', () => {

        tenureSlider.value =
            tenureInput.value;

        updateDisplay();

    });

    // RESET

    resetBtn.addEventListener('click', function () {

        principalSlider.value = 500000;
        rateSlider.value = 10;
        tenureSlider.value = 36;

        principalInput.value = 500000;
        rateInput.value = 10;
        tenureInput.value = 36;

        updateDisplay();

    });

    updateDisplay();

})();

</script>
<?php endif; ?>
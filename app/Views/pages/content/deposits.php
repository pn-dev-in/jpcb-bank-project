<?php if ($pageKey === 'overview'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank">
      <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">Grow your savings with deposit products designed for individuals, families, and businesses. Eligible deposits up to ₹5 lakh are insured under DICGC.</p>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <?php if (!empty($depositCards)): ?>
          <?php foreach ($depositCards as $card): ?>
            <a href="<?= site_url(ltrim($card['href'], '/')) ?>" class="bank-card p-6 group transition-colors">
              <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background-color: hsl(var(--primary) / 0.1);">
                <i data-lucide="<?= esc($card['icon']) ?>" class="w-6 h-6 text-primary"></i>
              </div>
              <h3 class="font-semibold text-foreground mb-2 group-hover:text-primary"><?= esc($card['title']) ?></h3>
              <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($card['description']) ?></p>
              <span class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-3">Learn more <i data-lucide="arrow-right" class="w-4 h-4"></i></span>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <div class="bank-card p-6">
        <h2 class="font-heading text-xl text-foreground mb-4">Quick Links</h2>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
          <?php if (!empty($depositQuickLinks)): ?>
            <?php foreach ($depositQuickLinks as $link): ?>
              <a href="<?= site_url(ltrim($link['href'], '/')) ?>" class="flex items-center gap-2 p-3 rounded-lg hover-bg-muted transition-colors tap-target">
                <i data-lucide="<?= esc($link['icon']) ?>" class="w-5 h-5 text-primary flex-shrink-0"></i>
                <span class="text-sm font-medium text-foreground"><?= esc($link['label']) ?></span>
              </a>
            <?php endforeach; ?>
          <?php endif; ?>
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
        <?php if (!empty($depositProducts)): ?>
          <?php foreach ($depositProducts as $product): ?>
            <div class="bank-card p-6">
              <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                <div class="flex-1">
                  <h3 class="font-heading text-lg text-foreground mb-3"><?= esc($product['name']) ?></h3>
                  <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Tenure</span><span class="text-sm font-medium text-foreground"><?= esc($product['tenure']) ?></span></div>
                    <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Min. Amount</span><span class="text-sm font-medium text-foreground"><?= esc($product['min_amount']) ?></span></div>
                    <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Interest Rate</span><span class="text-sm font-medium text-primary"><?= esc($product['interest_rate']) ?></span></div>
                    <div><span class="text-xs block" style="color: hsl(var(--muted-foreground));">Payout</span><span class="text-sm font-medium text-foreground"><?= esc($product['payout']) ?></span></div>
                  </div>
                  <?php if (!empty($product['features'])): ?>
                    <ul class="grid sm:grid-cols-2 gap-1">
                      <?php foreach ($product['features'] as $feature): ?>
                        <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><span class="w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span><?= esc($feature) ?></li>
                      <?php endforeach; ?>
                    </ul>
                  <?php endif; ?>
                </div>
                <div class="flex flex-col gap-2 lg:min-w-[160px]">
                  <a href="<?= site_url('deposits/interest-rates') ?>" class="btn-primary text-sm text-center">View Rates</a>
                  <a href="<?= site_url('downloads/forms') ?>" class="btn-outline text-sm text-center flex items-center justify-center gap-1"><i data-lucide="download" class="w-4 h-4"></i> Application Form</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center" style="color: hsl(var(--muted-foreground));">No deposit products found.</p>
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
              <?php if (!empty($depositRates)): ?>
                <?php foreach ($depositRates as $index => $rate): ?>
                  <tr class="border-b" style="border-color: hsl(var(--border)); background-color: <?= $index % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
                    <td class="p-4 text-sm text-foreground"><?= esc($rate['tenure']) ?></td>
                    <td class="p-4 text-sm text-center font-semibold text-foreground"><?= esc($rate['general_rate']) ?></td>
                    <td class="p-4 text-sm text-center font-semibold text-primary"><?= esc($rate['senior_rate']) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="3" class="p-4 text-center">No interest rates available.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <?php if (!empty($rateNotes)): ?>
        <div class="mt-6 bank-card p-4">
          <h3 class="font-semibold text-foreground text-sm mb-2">Notes</h3>
          <div class="text-sm space-y-1" style="color: hsl(var(--muted-foreground));">
            <?= nl2br(esc($rateNotes)) ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>

<?php elseif ($pageKey === 'savings-current'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank">
      <h2 class="font-heading text-2xl text-foreground mb-6">Savings Accounts</h2>
      <div class="grid md:grid-cols-2 gap-6 mb-12">
        <?php if (!empty($savingsAccounts)): ?>
          <?php foreach ($savingsAccounts as $account): ?>
            <div class="bank-card p-6">
              <h3 class="font-semibold text-foreground text-lg mb-2"><?= esc($account['name']) ?></h3>
              <div class="flex gap-6 mb-3 text-sm">
                <div><span style="color: hsl(var(--muted-foreground));">Min Balance: </span><strong class="text-foreground"><?= esc($account['min_balance']) ?></strong></div>
                <div><span style="color: hsl(var(--muted-foreground));">Interest: </span><strong class="text-primary"><?= esc($account['interest_rate']) ?></strong></div>
              </div>
              <?php if (!empty($account['features'])): ?>
                <ul class="space-y-1">
                  <?php foreach ($account['features'] as $feature): ?>
                    <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><i data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i><?= esc($feature) ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
              <a href="<?= site_url('downloads/forms') ?>" class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-4"><i data-lucide="download" class="w-4 h-4"></i> Download Form</a>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="col-span-2 text-center" style="color: hsl(var(--muted-foreground));">No savings accounts found.</p>
        <?php endif; ?>
      </div>

      <h2 class="font-heading text-2xl text-foreground mb-6">Current Accounts</h2>
      <div class="grid md:grid-cols-3 gap-6 mb-8">
        <?php if (!empty($currentAccounts)): ?>
          <?php foreach ($currentAccounts as $account): ?>
            <div class="bank-card p-6">
              <h3 class="font-semibold text-foreground mb-2"><?= esc($account['name']) ?></h3>
              <div class="text-sm mb-3"><span style="color: hsl(var(--muted-foreground));">Min Balance: </span><strong class="text-foreground"><?= esc($account['min_balance']) ?></strong></div>
              <?php if (!empty($account['features'])): ?>
                <ul class="space-y-1">
                  <?php foreach ($account['features'] as $feature): ?>
                    <li class="text-sm flex items-center gap-2" style="color: hsl(var(--muted-foreground));"><i data-lucide="circle-check" class="w-4 h-4 text-primary flex-shrink-0"></i><?= esc($feature) ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="col-span-3 text-center" style="color: hsl(var(--muted-foreground));">No current accounts found.</p>
        <?php endif; ?>
      </div>

      <?php if (!empty($savingsDocuments)): ?>
        <div class="bank-card p-6" style="background-color: hsl(var(--muted) / 0.35);">
          <h3 class="font-semibold text-foreground mb-3">Documents Required</h3>
          <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-3 text-sm" style="color: hsl(var(--muted-foreground));">
            <?php foreach ($savingsDocuments as $document): ?>
              <span class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span><?= esc($document) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
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

      <?php if (!empty($dicgcIntro)): ?>
        <div class="space-y-6 mb-10">
          <div class="bank-card p-6">
            <h3 class="font-semibold text-foreground mb-3">What is DICGC?</h3>
            <p class="readable" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc($dicgcIntro)) ?></p>
          </div>
        </div>
      <?php endif; ?>

      <div class="grid md:grid-cols-2 gap-6 mb-10">
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

      <div class="bank-card p-6">
        <h3 class="font-heading text-lg text-foreground mb-4">Frequently Asked Questions</h3>
        <div class="space-y-4">
          <?php if (!empty($dicgcFaqs) && is_array($dicgcFaqs)): ?>
            <?php foreach ($dicgcFaqs as $faq): ?>
              <details>
                <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target">
                  <i data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i>
                  <?= esc(is_array($faq) ? ($faq['question'] ?? '') : '') ?>
                </summary>
                <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));">
                  <?php
                  $answer = '';
                  if (is_array($faq) && isset($faq['answer'])) {
                    $answer = is_array($faq['answer']) ? implode(' ', $faq['answer']) : (string)$faq['answer'];
                  }
                  echo nl2br(esc($answer));
                  ?>
                </p>
              </details>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No FAQs available.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'deaf'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank max-w-4xl">
      <?php if (!empty($deafIntro)): ?>
        <div class="bank-card p-6 mb-8" style="border-left: 4px solid hsl(var(--accent));">
          <div class="flex items-start gap-3">
            <i data-lucide="alert-circle" class="w-6 h-6 flex-shrink-0 mt-0.5" style="color: hsl(var(--accent));"></i>
            <div>
              <h2 class="font-semibold text-foreground mb-1">What is DEAF?</h2>
              <p class="readable" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc($deafIntro)) ?></p>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <h2 class="font-heading text-xl text-foreground mb-6">How to Claim Your Deposit</h2>
      <div class="grid sm:grid-cols-2 gap-4 mb-10">
        <?php if (!empty($deafSteps)): ?>
          <?php foreach ($deafSteps as $step): ?>
            <div class="bank-card p-5 flex items-start gap-4">
              <span class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold flex-shrink-0"><?= esc($step['step_number']) ?></span>
              <div>
                <h3 class="font-semibold text-foreground"><?= esc($step['title']) ?></h3>
                <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($step['description']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="col-span-2 text-center">No claim steps available.</p>
        <?php endif; ?>
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
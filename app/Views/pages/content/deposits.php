<?php if ($pageKey === 'overview'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank">
      <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">Grow your savings with deposit
        products designed for individuals, families, and businesses. Eligible deposits up to ₹5 lakh are insured under
        DICGC.</p>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <?php if (!empty($depositCards)): ?>
          <?php foreach ($depositCards as $card): ?>
            <a href="<?= site_url(ltrim($card['href'], '/')) ?>" class="bank-card p-6 group transition-colors">
              <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4"
                style="background-color: hsl(var(--primary) / 0.1);">
                <i data-lucide="<?= esc($card['icon']) ?>" class="w-6 h-6 text-primary"></i>
              </div>
              <h3 class="font-semibold text-foreground mb-2 group-hover:text-primary"><?= esc($card['title']) ?></h3>
              <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($card['description']) ?></p>
              <span class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-3">Learn more <i
                  data-lucide="arrow-right" class="w-4 h-4"></i></span>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <div class="bank-card p-6">
        <h2 class="font-heading text-xl text-foreground mb-4">Quick Links</h2>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
          <?php if (!empty($depositQuickLinks)): ?>
            <?php foreach ($depositQuickLinks as $link): ?>
              <a href="<?= site_url(ltrim($link['href'], '/')) ?>"
                class="flex items-center gap-2 p-3 rounded-lg hover-bg-muted transition-colors tap-target">
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
      <p class="readable max-w-2xl mx-auto" style="color: hsl(var(--muted-foreground));">All eligible deposits up to
        ₹5,00,000 per depositor are insured under the Deposit Insurance and Credit Guarantee Corporation scheme.</p>
      <a href="<?= site_url('deposits/dicgc') ?>" class="btn-primary inline-block mt-6">Learn About DICGC Insurance</a>
    </div>
  </section>

<?php elseif ($pageKey === 'products'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank">
      <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">
        Choose from a range of deposit products tailored for short-term liquidity, steady monthly savings, or long-term
        wealth building.
      </p>
      <div class="space-y-6">
        <?php if (!empty($depositProducts)): ?>
          <?php foreach ($depositProducts as $index => $product): ?>
            <?php 
              $isTaxSaver = strpos($product['name'], 'Tax Saver') !== false;
              $isShortTerm = $product['name'] === 'Short Term Deposit Scheme';
              $cardClass = '';
              $headerClass = '';
              
              if ($isTaxSaver) {
                $cardClass = 'border-l-4 border-l-green-500';
                $headerClass = 'bg-gradient-to-r from-green-50 to-transparent dark:from-green-950/20';
              } elseif ($isShortTerm) {
                $cardClass = 'border-l-4 border-l-blue-500';
                $headerClass = 'bg-gradient-to-r from-blue-50 to-transparent dark:from-blue-950/20';
              }
            ?>
            <div class="bank-card p-6 <?= $cardClass ?>">
              <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                <div class="flex-1 <?= $headerClass ?>">
                  <div class="flex items-center gap-3 flex-wrap mb-3">
                    <h3 class="font-heading text-lg font-bold text-foreground"><?= esc($product['name']) ?></h3>
                    
                    <?php if ($isTaxSaver): ?>
                      <span class="inline-flex items-center gap-1 text-xs bg-green-100 text-green-800 px-2 py-1 rounded" 
                            style="background-color: #dcfce7; color: #166534;">
                        <i data-lucide="shield-check" class="w-3 h-3"></i> 80C Tax Benefit
                      </span>
                      <span class="inline-flex items-center gap-1 text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded" 
                            style="background-color: #ffedd5; color: #9a3412;">
                        <i data-lucide="lock" class="w-3 h-3"></i> 5 Years Lock-in
                      </span>
                    <?php endif; ?>
                    
                    <?php if ($isShortTerm): ?>
                      <span class="inline-flex items-center gap-1 text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded" 
                            style="background-color: #dbeafe; color: #1e40af;">
                        <i data-lucide="zap" class="w-3 h-3"></i> Short Term
                      </span>
                    <?php endif; ?>
                  </div>
                  
                  <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    <div>
                      <span class="text-xs block" style="color: hsl(var(--muted-foreground));">Tenure</span>
                      <span class="text-sm font-medium text-foreground"><?= esc($product['tenure']) ?></span>
                    </div>
                    <div>
                      <span class="text-xs block" style="color: hsl(var(--muted-foreground));">Min. Amount</span>
                      <span class="text-sm font-medium text-foreground"><?= esc($product['min_amount']) ?></span>
                    </div>
                    <?php if ($isTaxSaver): ?>
                      <div>
                        <span class="text-xs block" style="color: hsl(var(--muted-foreground));">Max. Amount</span>
                        <span class="text-sm font-medium text-foreground">₹1,50,000</span>
                      </div>
                    <?php endif; ?>
                    <div>
                      <span class="text-xs block" style="color: hsl(var(--muted-foreground));">Interest Rate</span>
                      <span class="text-sm font-medium text-primary"><?= esc($product['interest_rate']) ?></span>
                    </div>
                    <div>
                      <span class="text-xs block" style="color: hsl(var(--muted-foreground));">Payout</span>
                      <span class="text-sm font-medium text-foreground"><?= esc($product['payout']) ?></span>
                    </div>
                  </div>
                  
                  <?php if (!empty($product['features'])): ?>
                    <ul class="grid sm:grid-cols-2 gap-1 mt-3">
                      <?php foreach ($product['features'] as $feature): ?>
                        <li class="text-sm flex items-start gap-2" style="color: hsl(var(--muted-foreground));">
                          <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 flex-shrink-0"></span>
                          <span><?= esc($feature) ?></span>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  <?php endif; ?>
                </div>
                <div class="flex flex-col gap-2 lg:min-w-[160px]">
                  <a href="<?= site_url('deposits/interest-rates') ?>" class="btn-primary text-sm text-center">View Rates</a>

                  <?php if (!empty($product['form_pdf'])): ?>
                    <a href="<?= base_url($product['form_pdf']) ?>" target="_blank"
                      class="btn-outline text-sm text-center flex items-center justify-center gap-1">
                      <i data-lucide="download" class="w-4 h-4"></i> Application Form
                    </a>
                  <?php else: ?>
                    <a href="<?= site_url('downloads/forms') ?>"
                      class="btn-outline text-sm text-center flex items-center justify-center gap-1">
                      <i data-lucide="download" class="w-4 h-4"></i> All Forms
                    </a>
                  <?php endif; ?>
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
          <button class="btn-primary text-sm flex items-center gap-1" type="button" onclick="window.print()">
            <i data-lucide="printer" class="w-4 h-4"></i> Print
          </button>

          <?php if (!empty($depositRatesPdf)): ?>
            <a href="<?= base_url($depositRatesPdf) ?>" class="btn-primary text-sm flex items-center gap-1" download>
              <i data-lucide="download" class="w-4 h-4"></i> Download PDF
            </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Normal Deposit Rates - Below Rs.100.00 lakh -->
      <div class="mb-8">
        <h3 class="text-xl font-bold mb-4" style="color: hsl(var(--primary));">Deposit Interest Rates (Below ₹100 Lakh)</h3>
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
                <?php if (!empty($depositRatesBelow1Cr)): ?>
                  <?php foreach ($depositRatesBelow1Cr as $index => $rate): ?>
                    <tr class="border-b"
                      style="border-color: hsl(var(--border)); background-color: <?= $index % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
                      <td class="p-4 text-sm text-foreground"><?= esc($rate['tenure']) ?></td>
                      <td class="p-4 text-sm text-center font-semibold text-foreground"><?= esc($rate['general_rate']) ?>%</td>
                      <td class="p-4 text-sm text-center font-semibold text-primary"><?= esc($rate['senior_rate']) ?>%</td>
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
      </div>

      <!-- Normal Deposit Rates - Rs. 100.00 lakh & Above -->
      <div class="mb-8">
        <h3 class="text-xl font-bold mb-4" style="color: hsl(var(--primary));">Deposit Interest Rates (₹100 Lakh & Above)</h3>
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
                <?php if (!empty($depositRatesAbove1Cr)): ?>
                  <?php foreach ($depositRatesAbove1Cr as $index => $rate): ?>
                    <tr class="border-b"
                      style="border-color: hsl(var(--border)); background-color: <?= $index % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
                      <td class="p-4 text-sm text-foreground"><?= esc($rate['tenure']) ?></td>
                      <td class="p-4 text-sm text-center font-semibold text-foreground"><?= esc($rate['general_rate']) ?>%</td>
                      <td class="p-4 text-sm text-center font-semibold text-primary"><?= esc($rate['senior_rate']) ?>%</td>
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
      </div>

      <!-- Special Term Deposit Schemes - Combined Table Format -->
      <?php if (!empty($depositSpecialSchemes)): ?>
        <div class="mb-8">
          <h3 class="text-xl font-bold mb-4" style="color: hsl(var(--primary));">Special Term Deposit Schemes</h3>
          <div class="bank-card overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full" role="table">
                <thead>
                  <tr class="bg-primary text-primary-foreground">
                    <th class="text-left p-4 font-semibold text-sm">Scheme Name</th>
                    <th class="text-left p-4 font-semibold text-sm">Tenure</th>
                    <th class="text-center p-4 font-semibold text-sm">Amount Slab</th>
                    <th class="text-center p-4 font-semibold text-sm">General Rate (% p.a.)</th>
                    <th class="text-center p-4 font-semibold text-sm">Senior Citizen Rate (% p.a.)</th>
                   </tr>
                </thead>
                <tbody>
                  <?php 
                  // Group special schemes by scheme_name to show in rows
                  $groupedSchemes = [];
                  foreach ($depositSpecialSchemes as $scheme) {
                      $schemeName = $scheme['scheme_name'] ?? ($scheme['scheme_type'] === 'tax_saver' ? 'Tax Saver Scheme' : 'Special Scheme');
                      $groupedSchemes[$schemeName][] = $scheme;
                  }
                  
                  $rowIndex = 0;
                  foreach ($groupedSchemes as $schemeName => $schemes):
                      foreach ($schemes as $scheme):
                  ?>
                    <tr class="border-b"
                      style="border-color: hsl(var(--border)); background-color: <?= $rowIndex % 2 === 0 ? 'hsl(var(--background))' : 'hsl(var(--muted) / 0.3)' ?>;">
                      <td class="p-4 text-sm font-semibold text-foreground">
                        <?= esc($schemeName) ?>
                        <?php if ($scheme['scheme_type'] === 'tax_saver'): ?>
                          <span class="inline-flex items-center gap-1 ml-2 text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded" style="background-color: #dcfce7; color: #166534;">
                            <i data-lucide="shield-check" class="w-3 h-3"></i> 80C
                          </span>
                        <?php endif; ?>
                      </td>
                      <td class="p-4 text-sm text-foreground"><?= esc($scheme['tenure']) ?></td>
                      <td class="p-4 text-sm text-center">
                        <?= esc($scheme['amount_slab'] === 'below_1cr' ? 'Below ₹100 Lakh' : '₹100 Lakh & Above') ?>
                      </td>
                      <td class="p-4 text-sm text-center font-semibold text-foreground"><?= esc($scheme['general_rate']) ?>%</td>
                      <td class="p-4 text-sm text-center font-semibold text-primary"><?= esc($scheme['senior_rate']) ?>%</td>
                     </tr>
                  <?php 
                      $rowIndex++;
                      endforeach;
                  endforeach; 
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <?php endif; ?>

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

        <!-- PAGE HEADING -->
        <div class="text-center mb-14">
            <h2 class="font-heading text-3xl md:text-5xl mb-4 text-foreground">
                Savings & Current Accounts
            </h2>
        </div>

        <!-- TABS -->
        <div class="account-tabs-wrapper">
            <button class="account-tab-btn active" data-tab="savingsTab">
                Savings Account
            </button>
            <button class="account-tab-btn" data-tab="currentTab">
                Current Account
            </button>
            <button class="account-tab-btn" data-tab="eliteTab">
                Elite Account
            </button>
        </div>

        <!-- =========================
             SAVINGS ACCOUNT (CMS DRIVEN)
        ========================== -->
        <div id="savingsTab" class="account-tab-content active">
            <?php if (!empty($savingsAccount)): ?>
            <div class="bank-card p-8 md:p-10">
                <div class="flex flex-col lg:flex-row gap-10">
                    <div class="flex-1">
                        <!-- Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-5"
                             style="background:hsl(var(--primary)/0.1); color:hsl(var(--primary));">
                            <i data-lucide="<?= esc($savingsAccount['badge_icon'] ?? 'wallet') ?>" class="w-4 h-4"></i>
                            <?= esc($savingsAccount['badge_text'] ?? 'Regular Savings Account') ?>
                        </div>

                        <!-- Heading -->
                        <h3 class="font-heading text-3xl mb-4 text-foreground">
                            <?= esc($savingsAccount['heading'] ?? 'JPCB Bank Savings Account') ?>
                        </h3>

                        <!-- Description -->
                        <p class="leading-8 mb-6" style="color:hsl(var(--muted-foreground));">
                            <?= nl2br(esc($savingsAccount['description'] ?? '')) ?>
                        </p>

                        <!-- Features -->
                        <div class="grid md:grid-cols-2 gap-4 mb-8">
                            <?php if (!empty($savingsAccount['features'])): ?>
                                <?php foreach ($savingsAccount['features'] as $feature): ?>
                                <div class="feature-box">
                                    <i data-lucide="circle-check" class="w-5 h-5 text-primary"></i>
                                    <?= esc($feature) ?>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="feature-box">
                                    <i data-lucide="circle-check" class="w-5 h-5 text-primary"></i>
                                    Available for individuals & organisations
                                </div>
                                <div class="feature-box">
                                    <i data-lucide="circle-check" class="w-5 h-5 text-primary"></i>
                                    Digital & mobile banking enabled
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- RIGHT CARD - Minimum Balance Information -->
                    <div class="lg:w-[380px]">
                        <div class="account-side-card">
                            <h4 class="font-semibold text-lg mb-5">Minimum Balance</h4>
                            <div class="space-y-4 text-sm">
                                <?php if (!empty($savingsAccount['min_balance_individual'])): ?>
                                <div class="balance-row">
                                    <span>Individuals</span>
                                    <strong><?= esc($savingsAccount['min_balance_individual']) ?></strong>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($savingsAccount['min_balance_trust'])): ?>
                                <div class="balance-row">
                                    <span>Trust / Society / HUF</span>
                                    <strong><?= esc($savingsAccount['min_balance_trust']) ?></strong>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($savingsAccount['min_balance_salary'])): ?>
                                <div class="balance-row">
                                    <span>Salary / SHG</span>
                                    <strong><?= esc($savingsAccount['min_balance_salary']) ?></strong>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($savingsAccount['interest_rate_note'])): ?>
                            <div class="divider-line"></div>
                            <div class="flex items-center justify-between">
                                <span></span>
                                <strong class="text-primary"><?= esc($savingsAccount['interest_rate_note']) ?></strong>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="bank-card p-8 text-center text-muted-foreground">
                Savings account information is currently being updated. Please check back later.
            </div>
            <?php endif; ?>
        </div>

        <!-- =========================
             CURRENT ACCOUNT (CMS DRIVEN)
        ========================== -->
        <div id="currentTab" class="account-tab-content">
            <?php if (!empty($currentAccount)): ?>
            <div class="bank-card p-8 md:p-10">
                <div class="flex flex-col lg:flex-row gap-10 items-center">
                    <div class="flex-1">
                        <!-- Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-5"
                             style="background:hsl(var(--primary)/0.1); color:hsl(var(--primary));">
                            <i data-lucide="<?= esc($currentAccount['badge_icon'] ?? 'building-2') ?>" class="w-4 h-4"></i>
                            <?= esc($currentAccount['badge_text'] ?? 'Current Account') ?>
                        </div>

                        <!-- Heading -->
                        <h3 class="font-heading text-3xl mb-4 text-foreground">
                            <?= esc($currentAccount['heading'] ?? 'Business Current Account') ?>
                        </h3>

                        <!-- Description -->
                        <p class="leading-8 mb-8" style="color:hsl(var(--muted-foreground));">
                            <?= nl2br(esc($currentAccount['description'] ?? '')) ?>
                        </p>

                        <!-- Features -->
                        <div class="grid md:grid-cols-2 gap-4 mb-8">
                            <?php if (!empty($currentAccount['features'])): ?>
                                <?php foreach ($currentAccount['features'] as $feature): ?>
                                <div class="feature-box">
                                    <i data-lucide="circle-check" class="w-5 h-5 text-primary"></i>
                                    <?= esc($feature) ?>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="feature-box">
                                    <i data-lucide="circle-check" class="w-5 h-5 text-primary"></i>
                                    Free cheque book facility
                                </div>
                                <div class="feature-box">
                                    <i data-lucide="circle-check" class="w-5 h-5 text-primary"></i>
                                    RTGS / NEFT support
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Download PDF Button -->
                        <?php if (!empty($currentAccount['form_pdf'])): ?>
                        <a href="<?= base_url($currentAccount['form_pdf']) ?>" target="_blank" class="btn-primary inline-flex items-center gap-2">
                            <i data-lucide="download" class="w-4 h-4"></i> Download Application Form
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="bank-card p-8 text-center text-muted-foreground">
                Current account information is currently being updated. Please check back later.
            </div>
            <?php endif; ?>
        </div>

        <!-- =========================
             ELITE ACCOUNT (CMS DRIVEN)
        ========================== -->
        <div id="eliteTab" class="account-tab-content">
            <?php if (!empty($eliteAccount)): ?>
            <div class="bank-card p-8 md:p-10">
                <div class="flex flex-col lg:flex-row gap-10 items-center">
                    <div class="flex-1">
                        <!-- Badge (Special Gradient for Elite) -->
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-5"
                             style="background:linear-gradient(135deg,#b38728,#e0c878); color:white;">
                            <i data-lucide="<?= esc($eliteAccount['badge_icon'] ?? 'crown') ?>" class="w-4 h-4"></i>
                            <?= esc($eliteAccount['badge_text'] ?? 'Premium Banking') ?>
                        </div>

                        <!-- Heading -->
                        <h3 class="font-heading text-3xl mb-4 text-foreground">
                            <?= esc($eliteAccount['heading'] ?? 'Elite Account') ?>
                        </h3>

                        <!-- Description -->
                        <p class="leading-8 mb-8" style="color:hsl(var(--muted-foreground));">
                            <?= nl2br(esc($eliteAccount['description'] ?? '')) ?>
                        </p>

                        <!-- Features -->
                        <div class="grid md:grid-cols-2 gap-4 mb-8">
                            <?php if (!empty($eliteAccount['features'])): ?>
                                <?php foreach ($eliteAccount['features'] as $feature): ?>
                                <div class="feature-box">
                                    <i data-lucide="badge-check" class="w-5 h-5 text-primary"></i>
                                    <?= esc($feature) ?>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="feature-box">
                                    <i data-lucide="badge-check" class="w-5 h-5 text-primary"></i>
                                    Free Mobile Banking
                                </div>
                                <div class="feature-box">
                                    <i data-lucide="badge-check" class="w-5 h-5 text-primary"></i>
                                    Premium Banking Services
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Download PDF Button -->
                        <?php if (!empty($eliteAccount['form_pdf'])): ?>
                        <a href="<?= base_url($eliteAccount['form_pdf']) ?>" target="_blank" class="btn-primary inline-flex items-center gap-2">
                            <i data-lucide="download" class="w-4 h-4"></i> Download Application Form
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="bank-card p-8 text-center text-muted-foreground">
                Elite account information is currently being updated. Please check back later.
            </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<style>
/* ========================= TABS ========================= */
.account-tabs-wrapper {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}
.account-tab-btn {
    border: none;
    padding: 14px 26px;
    border-radius: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    background: hsl(var(--muted));
    color: hsl(var(--foreground));
}
.account-tab-btn.active {
    background: hsl(var(--primary));
    color: white;
}
.account-tab-btn:hover {
    transform: translateY(-2px);
}
/* ========================= CONTENT ========================= */
.account-tab-content {
    display: none;
}
.account-tab-content.active {
    display: block;
    animation: fadeTab .3s ease;
}
@keyframes fadeTab {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
/* ========================= FEATURES ========================= */
.feature-box {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    border-radius: 14px;
    background: hsl(var(--muted)/0.4);
    font-size: 14px;
    color: hsl(var(--foreground));
}
/* ========================= SIDE CARD ========================= */
.account-side-card {
    background: hsl(var(--muted)/0.35);
    border-radius: 24px;
    padding: 28px;
}
.balance-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.divider-line {
    height: 1px;
    background: hsl(var(--border));
    margin: 20px 0;
}
/* ========================= MOBILE ========================= */
@media (max-width: 768px) {
    .account-tab-btn {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.account-tab-btn');
    const tabContents = document.querySelectorAll('.account-tab-content');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const target = this.dataset.tab;
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            this.classList.add('active');
            document.getElementById(target).classList.add('active');
        });
    });
});
</script>

<?php elseif ($pageKey === 'dicgc'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank max-w-4xl">
      <?php if (!empty($dicgcBanner)): ?>

        <div class="bank-card p-6 mb-8 text-center">

          <img src="<?= base_url($dicgcBanner) ?>" alt="DICGC Banner" class="img-fluid mx-auto mb-4"
            style="max-width:420px;">

          <?php if (!empty($dicgcBannerText)): ?>

            <p class="text-sm" style="color:hsl(var(--muted-foreground));">

              <?= $dicgcBannerText ?>

            </p>

          <?php endif; ?>

          <a href="https://www.dicgc.org.in" target="_blank" rel="noopener" class="text-primary text-sm font-medium">

            Visit DICGC Website

          </a>

        </div>

      <?php endif; ?>
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
          <h3 class="font-semibold text-foreground mb-3 flex items-center gap-2"><i data-lucide="circle-check"
              class="w-5 h-5 text-primary"></i> What Is Covered</h3>
          <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
            <?php foreach (['Savings account deposits', 'Fixed deposit accounts', 'Current account deposits', 'Recurring deposits', 'Other eligible deposits'] as $item): ?>
              <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><?= esc($item) ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="bank-card p-6">
          <h3 class="font-semibold text-foreground mb-3 flex items-center gap-2"><i data-lucide="alert-circle"
              class="w-5 h-5" style="color: hsl(var(--destructive));"></i> What Is Not Covered</h3>
          <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
            <?php foreach (['Deposits of foreign governments', 'Deposits of Central or State Governments', 'Inter-bank deposits', 'Deposits received outside India', 'Deposits specifically exempted by DICGC'] as $item): ?>
              <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full"
                  style="background-color: hsl(var(--destructive));"></span><?= esc($item) ?></li>
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
                    $answer = is_array($faq['answer']) ? implode(' ', $faq['answer']) : (string) $faq['answer'];
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

      <!-- Display flash messages -->
      <?php if (session()->getFlashdata('error')): ?>
        <div class="bank-card p-4 mb-6"
          style="background-color: hsl(var(--destructive) / 0.1); border-left: 4px solid hsl(var(--destructive));">
          <p class="text-sm" style="color: hsl(var(--destructive));"><?= esc(session()->getFlashdata('error')) ?></p>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('info')): ?>
        <div class="bank-card p-4 mb-6"
          style="background-color: hsl(var(--primary) / 0.06); border-left: 4px solid hsl(var(--primary));">
          <p class="text-sm" style="color: hsl(var(--foreground));"><?= esc(session()->getFlashdata('info')) ?></p>
        </div>
      <?php endif; ?>

      <!-- SEARCH FORM -->
      <div class="bank-card p-6 mb-8" style="background-color: hsl(var(--primary) / 0.06);">
        <div class="text-center mb-6">
          <h2 class="font-heading text-2xl text-foreground mb-2">Search Unclaimed Deposit Accounts</h2>
          <p class="text-sm" style="color: hsl(var(--muted-foreground));">
            Search for unclaimed or inoperative deposit accounts transferred to DEAF.
          </p>
        </div>

        <form action="<?= site_url('deposits/deaf/search') ?>" method="get">
          <div class="grid md:grid-cols-12 gap-4 items-end">
            <div class="md:col-span-4">
              <label class="block text-sm font-medium mb-2 text-foreground">Name (minimum 4 characters)</label>
              <input type="text" name="name" minlength="4" required placeholder="Enter Name"
                value="<?= esc(session()->getFlashdata('search_name') ?? '') ?>"
                class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2"
                style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); color: hsl(var(--foreground));">
            </div>
            <div class="md:col-span-6">
              <label class="block text-sm font-medium mb-2 text-foreground">Address</label>
              <input type="text" name="address" placeholder="Enter Address"
                value="<?= esc(session()->getFlashdata('search_address') ?? '') ?>"
                class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2"
                style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); color: hsl(var(--foreground));">
            </div>
            <div class="md:col-span-2">
              <button type="submit" class="btn-primary w-full justify-center">Search</button>
            </div>
          </div>
        </form>

        <div class="text-center mt-6">
          <?php if (!empty($deafClaimFormPdf)): ?>
            <a href="<?= base_url($deafClaimFormPdf) ?>" target="_blank" class="btn-accent inline-flex items-center gap-2">
              <i data-lucide="download" class="w-4 h-4"></i> Claim Application Form
            </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- SEARCH RESULTS (if any) -->
<?php if (session()->getFlashdata('search_performed')): ?>
  <div class="bank-card p-6 mb-8">
    <div class="flex justify-between items-center mb-4">
      <h3 class="font-semibold text-foreground text-lg">Search Results</h3>
      <span class="text-sm px-2 py-1 rounded-full" style="background-color: hsl(var(--primary) / 0.1); color: hsl(var(--primary));">
        Found: <?= session()->getFlashdata('search_count') ?? 0 ?> record(s)
      </span>
    </div>
    
    <?php $results = session()->getFlashdata('search_results'); ?>
    <?php if (!empty($results)): ?>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b" style="border-color: hsl(var(--border)); background-color: hsl(var(--muted) / 0.3);">
              <th class="text-left py-3 px-3">Sr. No.</th>
              <th class="text-left py-3 px-3">UDRN</th>
              <th class="text-left py-3 px-3">Name</th>
              <th class="text-left py-3 px-3">Address</th>
             </td>
          </thead>
          <tbody>
            <?php foreach ($results as $result): ?>
            <tr class="border-b hover:bg-muted/20 transition-colors" style="border-color: hsl(var(--border));">
              <td class="py-2 px-3"><?= esc($result['sr_no']) ?></td>
              <td class="py-2 px-3 font-mono text-xs"><?= esc($result['udrn']) ?></td>
              <td class="py-2 px-3 font-medium"><?= esc($result['name']) ?></td>
              <td class="py-2 px-3 text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($result['address']) ?></td>
             </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      
      <div class="mt-4 p-3 text-xs rounded" style="background-color: hsl(var(--primary) / 0.05);">
        <i data-lucide="info" class="w-3.5 h-3.5 inline mr-1"></i>
        To claim a deposit, please visit your nearest branch with valid ID proof and the UDRN number mentioned above.
      </div>
      
    <?php else: ?>
      <div class="text-center py-6">
        <i data-lucide="search-x" class="w-12 h-12 mx-auto mb-3" style="color: hsl(var(--muted-foreground));"></i>
        <p style="color: hsl(var(--muted-foreground));">No records found matching your search criteria.</p>
        <p class="text-sm mt-2">Try using different keywords or <a href="<?= site_url('contact') ?>" class="text-primary hover:underline">contact your branch</a> for assistance.</p>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>

      <!-- DEAF Deposits List -->
      <div class="bank-card p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-foreground text-lg">Unclaimed Deposits List</h3>
          <span class="text-xs px-2 py-1 rounded-full"
            style="background-color: hsl(var(--primary) / 0.1); color: hsl(var(--primary));">
            Total: <?= count($deafDeposits ?? []) ?>
          </span>
        </div>

        <?php if (!empty($deafDeposits)): ?>
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b" style="border-color: hsl(var(--border)); background-color: hsl(var(--muted) / 0.3);">
                  <th class="text-left py-3 px-3">Sr. No.</th>
                  <th class="text-left py-3 px-3">UDRN</th>
                  <th class="text-left py-3 px-3">Name</th>
                  <th class="text-left py-3 px-3">Address</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($deafDeposits as $deposit): ?>
                  <tr class="border-b hover:bg-muted/20 transition-colors" style="border-color: hsl(var(--border));">
                    <td class="py-2 px-3"><?= esc($deposit['sr_no']) ?></td>
                    <td class="py-2 px-3 font-mono text-xs"><?= esc($deposit['udrn']) ?></td>
                    <td class="py-2 px-3 font-medium"><?= esc($deposit['name']) ?></td>
                    <td class="py-2 px-3 text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($deposit['address']) ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <div class="mt-4 p-3 text-xs rounded" style="background-color: hsl(var(--primary) / 0.05);">
            <i data-lucide="info" class="w-3.5 h-3.5 inline mr-1"></i>
            If your name appears in the above list, please visit your nearest branch with valid ID proof to claim your
            deposit.
          </div>

        <?php else: ?>
          <div class="text-center py-6">
            <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3" style="color: hsl(var(--muted-foreground));"></i>
            <p style="color: hsl(var(--muted-foreground));">No unclaimed deposits to display at this time.</p>
          </div>
        <?php endif; ?>

        <!-- Simple Pagination -->
        <!-- Simple Pagination -->
        <?php
        $currentPage = $pager->getCurrentPage();
        $totalPages = $pager->getPageCount();
        $startPage = max(1, $currentPage - 2);
        $endPage = min($totalPages, $currentPage + 2);
        ?>

        <div class="flex justify-center mt-6">
          <nav class="flex items-center gap-1 flex-wrap" aria-label="Pagination">
            <!-- Previous Button -->
            <?php if ($currentPage > 1): ?>
              <a href="<?= $pager->getPreviousPageURI() ?>"
                class="px-3 py-2 rounded-md border transition-colors hover:bg-primary hover:text-primary-foreground"
                style="border-color: hsl(var(--border)); color: hsl(var(--foreground));">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                <span class="sr-only">Previous</span>
              </a>
            <?php else: ?>
              <span class="px-3 py-2 rounded-md border opacity-50 cursor-not-allowed"
                style="border-color: hsl(var(--border)); color: hsl(var(--muted-foreground));">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
              </span>
            <?php endif; ?>

            <!-- First Page -->
            <?php if ($startPage > 1): ?>
              <a href="<?= $pager->getPageURI(1) ?>"
                class="px-3 py-2 rounded-md border transition-colors hover:bg-primary hover:text-primary-foreground"
                style="border-color: hsl(var(--border));">1</a>
              <?php if ($startPage > 2): ?>
                <span class="px-3 py-2">...</span>
              <?php endif; ?>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
              <?php if ($i == $currentPage): ?>
                <span class="px-3 py-2 rounded-md bg-primary text-primary-foreground font-medium"
                  style="background-color: hsl(var(--primary)); color: hsl(var(--primary-foreground));">
                  <?= $i ?>
                </span>
              <?php else: ?>
                <a href="<?= $pager->getPageURI($i) ?>"
                  class="px-3 py-2 rounded-md border transition-colors hover:bg-primary hover:text-primary-foreground"
                  style="border-color: hsl(var(--border)); color: hsl(var(--foreground));">
                  <?= $i ?>
                </a>
              <?php endif; ?>
            <?php endfor; ?>

            <!-- Last Page -->
            <?php if ($endPage < $totalPages): ?>
              <?php if ($endPage < $totalPages - 1): ?>
                <span class="px-3 py-2">...</span>
              <?php endif; ?>
              <a href="<?= $pager->getPageURI($totalPages) ?>"
                class="px-3 py-2 rounded-md border transition-colors hover:bg-primary hover:text-primary-foreground"
                style="border-color: hsl(var(--border));"><?= $totalPages ?></a>
            <?php endif; ?>

            <!-- Next Button -->
            <?php if ($currentPage < $totalPages): ?>
              <a href="<?= $pager->getNextPageURI() ?>"
                class="px-3 py-2 rounded-md border transition-colors hover:bg-primary hover:text-primary-foreground"
                style="border-color: hsl(var(--border));">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="sr-only">Next</span>
              </a>
            <?php else: ?>
              <span class="px-3 py-2 rounded-md border opacity-50 cursor-not-allowed"
                style="border-color: hsl(var(--border)); color: hsl(var(--muted-foreground));">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
              </span>
            <?php endif; ?>
          </nav>
        </div>

        <!-- Showing info -->
        <div class="text-center mt-4 text-xs" style="color: hsl(var(--muted-foreground));">
          Showing <?= $pager->getCurrentPage() == 1 ? 1 : (($pager->getCurrentPage() - 1) * 15 + 1) ?>
          to <?= min($pager->getCurrentPage() * 15, $pager->getTotal()) ?>
          of <?= $pager->getTotal() ?> entries
        </div>
      </div>

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
              <span
                class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold flex-shrink-0"><?= esc($step['step_number']) ?></span>
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
            <li class="flex items-center gap-2"><span
                class="w-1.5 h-1.5 rounded-full bg-primary"></span><?= esc($document) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="flex flex-wrap gap-3">
        <?php if (!empty($deafClaimFormPdf)): ?>
          <a href="<?= base_url($deafClaimFormPdf) ?>" class="btn-primary flex items-center gap-2" target="_blank">
            <i data-lucide="download" class="w-4 h-4"></i> Download Claim Form
          </a>
        <?php else: ?>
          <a href="<?= site_url('downloads/forms') ?>" class="btn-primary flex items-center gap-2">
            <i data-lucide="download" class="w-4 h-4"></i> Download Claim Form
          </a>
        <?php endif; ?>
        <a href="<?= site_url('contact') ?>" class="btn-outline flex items-center gap-2">
          <i data-lucide="phone" class="w-4 h-4"></i> Contact Branch
        </a>
      </div>
    </div>
  </section>
<?php endif; ?>
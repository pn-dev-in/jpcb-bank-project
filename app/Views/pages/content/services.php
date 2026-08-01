<?php if ($pageKey === 'overview'): ?>
  <section class="section-padding bg-background">

    <div class="container-bank">
      <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">Explore our range of banking
        services designed for safety, convenience, and compliance.</p>
      <?php if (!empty($serviceCards)): ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($serviceCards as $card): ?>
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
        </div>
      <?php endif; ?>
    </div>
  </section>

<?php elseif ($pageKey === 'charges'): ?>
  <style>
    .sc-tab-btn {
      padding: .6rem 1.1rem;
      font-size: .8rem;
      font-weight: 600;
      border-radius: .5rem;
      border: 1.5px solid hsl(var(--border));
      background: hsl(var(--background));
      color: hsl(var(--muted-foreground));
      cursor: pointer;
      white-space: nowrap;
      transition: all .18s;
    }

    .sc-tab-btn.active {
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
      border-color: hsl(var(--primary));
    }

    .sc-tab-btn:not(.active):hover {
      border-color: hsl(var(--primary));
      color: hsl(var(--primary));
    }

    .sc-panel {
      display: none;
    }

    .sc-panel.active {
      display: block;
    }

    .sc-table {
      width: 100%;
      border-collapse: collapse;
    }

    .sc-table thead tr {
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
    }

    .sc-table thead th {
      padding: .75rem 1rem;
      text-align: left;
      font-size: .8rem;
      font-weight: 600;
    }

    .sc-table tbody tr:nth-child(even) {
      background: hsl(var(--muted) / 0.3);
    }

    .sc-table tbody tr:nth-child(odd) {
      background: hsl(var(--background));
    }

    .sc-table tbody td {
      padding: .7rem 1rem;
      font-size: .82rem;
      color: hsl(var(--foreground));
      border-bottom: 1px solid hsl(var(--border));
      vertical-align: top;
    }

    .sc-table tbody td:last-child {
      font-weight: 600;
      color: hsl(var(--primary));
    }

    /* section title with visible green left border */
    .sc-section-title {
      font-size: 1rem;
      font-weight: 700;
      color: hsl(var(--foreground));
      padding: .75rem 1rem;
      background: hsl(var(--muted) / 0.5);
      border-left: 4px solid #198754;
      /* green always visible */
      margin: 0;
    }

    .sc-note {
      font-size: .78rem;
      color: hsl(var(--muted-foreground));
      padding: .6rem 1rem;
      background: hsl(var(--muted) / 0.25);
      border-top: 1px solid hsl(var(--border));
    }
  </style>

  <section class="section-padding bg-background">
    <div class="container-bank">

      <!-- Header -->
      <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-2 text-sm" style="color: hsl(var(--muted-foreground));">
          <i data-lucide="calendar" class="w-4 h-4"></i>
          <span>Effective from: <strong class="text-foreground"><?= esc($chargesEffectiveDate) ?></strong></span>
        </div>
        <div class="flex gap-2">
          <?php if (!empty($serviceChargesPdf)): ?>
            <a href="<?= base_url($serviceChargesPdf) ?>" class="btn-primary text-sm flex items-center gap-1" download>
              <i data-lucide="download" class="w-4 h-4"></i> Download PDF
            </a>
          <?php else: ?>
            <button class="btn-primary text-sm flex items-center gap-1" disabled>
              <i data-lucide="download" class="w-4 h-4"></i> PDF not available
            </button>
          <?php endif; ?>
        </div>
      </div>

      <!-- Tab Bar -->
      <?php
      $tabNames = [
        'advances' => 'Advances',
        'dd' => 'DD / Pay Order',
        'cheque' => 'Cheque & Passbook',
        'cash' => 'Cash & ATM',
        'rtgs' => 'RTGS / NEFT / OBC',
        'account' => 'Account Services',
        'misc' => 'Miscellaneous',
        'scheme' => 'Scheme-wise Fees',
      ];
      $firstTab = true;
      ?>
      <div style="overflow-x:auto;padding-bottom:.5rem;margin-bottom:1.5rem;">
        <div style="display:flex;gap:.5rem;min-width:max-content;">
          <?php foreach ($tabNames as $tabSlug => $tabLabel): ?>
            <button class="sc-tab-btn <?= $firstTab ? 'active' : '' ?>" data-tab="<?= esc($tabSlug) ?>">
              <?= esc($tabLabel) ?>
            </button>
            <?php $firstTab = false; endforeach; ?>
        </div>
      </div>
      <!-- Panels -->
      <?php $firstPanel = true;
      foreach ($tabNames as $tabSlug => $tabLabel): ?>
        <div id="tab-<?= esc($tabSlug) ?>" class="sc-panel <?= $firstPanel ? 'active' : '' ?>">
          <?php if ($tabSlug === 'cash' && !empty($cashNote)): ?>
            <div class="bank-card p-4 mb-6" style="border-left:4px solid hsl(var(--primary));">
              <?= $cashNote ?>
            </div>
          <?php endif; ?>

          <?php
          $tabSections = $chargeTabs[$tabSlug] ?? [];
          // Re-order sections: three-col sections first
          $sections3col = [];
          $sections2col = [];
          foreach ($tabSections as $title => $rows) {
            $is3col = false;
            foreach ($rows as $row) {
              if ($row['type'] === 'three_col') {
                $is3col = true;
                break;
              }
            }
            if ($is3col) {
              $sections3col[$title] = $rows;
            } else {
              $sections2col[$title] = $rows;
            }
          }
          $tabSections = array_merge($sections3col, $sections2col);
          foreach ($tabSections as $sectionTitle => $rows):
            // Sort rows: three_col first, then row, then sub_header, then note
            // Determine if this section has data rows that need a table
            $hasDataRow = false;
            $firstDataRow = null;
            foreach ($rows as $row) {
              if (in_array($row['type'], ['row', 'three_col', 'scheme_row', 'sub_header'])) {
                $hasDataRow = true;
                if ($firstDataRow === null && in_array($row['type'], ['row', 'three_col', 'scheme_row'])) {
                  $firstDataRow = $row;
                }
              }
            }
            ?>

            <div class="bank-card overflow-hidden mb-6">
              <p class="sc-section-title"><?= esc($sectionTitle) ?></p>

              <?php if ($hasDataRow && !empty($rows)): ?>
                <div class="overflow-x-auto">
                  <table class="sc-table">
                    <thead>
                      <?php
                      // Determine table headers
                      $customHeaders = null;
                      // Look for column_headers JSON on the first row
                      if (!empty($rows)) {
                        foreach ($rows as $row) {
                          if (!empty($row['column_headers'])) {
                            $decoded = json_decode($row['column_headers'], true);
                            if (is_array($decoded)) {
                              $customHeaders = $decoded;
                            }
                            break;
                          }
                        }
                      }
                      // Fallback logic
                      if (is_array($customHeaders)): ?>
                        <tr>
                          <?php foreach ($customHeaders as $header): ?>
                            <th><?= esc($header) ?></th>
                          <?php endforeach; ?>
                        </tr>
                      <?php elseif ($firstDataRow && $firstDataRow['type'] === 'three_col'): ?>
                        <tr>
                          <th>Particulars</th>
                          <th>Old Charges</th>
                          <th>Revised Charges</th>
                        </tr>
                      <?php elseif ($firstDataRow && $firstDataRow['type'] === 'scheme_row'): ?>
                        <tr>
                          <th style="width:3rem;">No.</th>
                          <th>Name of Scheme</th>
                          <th>Processing Fees</th>
                        </tr>
                      <?php else: ?>
                        <tr>
                          <th>Nature of Service</th>
                          <th>Charges</th>
                        </tr>
                      <?php endif; ?>
                    </thead>
                    <tbody>
                      <?php foreach ($rows as $row): ?>
                        <?php if ($row['type'] === 'sub_header'): ?>
                          <tr>
                            <?php
                            $colspan = is_array($customHeaders)
                              ? count($customHeaders)
                              : (($firstDataRow && $firstDataRow['type'] === 'three_col') ? 3 : 2);
                            ?>

                            <td colspan="<?= $colspan ?>"
                              style="font-weight:600;color:hsl(var(--foreground));background:hsl(var(--muted)/0.4);">
                              <?= esc($row['label']) ?>
                            </td>
                          </tr>
                        <?php elseif ($row['type'] === 'three_col'): ?>
                          <tr>
                            <td><?= esc($row['label']) ?></td>
                            <td><?= esc($row['charge']) ?></td>
                            <td><?= esc($row['description']) ?></td>
                          </tr>
                        <?php elseif ($row['type'] === 'scheme_row'): ?>
                          <tr>
                            <td><?= $row['sort_order'] ?></td>
                            <td><?= esc($row['label']) ?></td>
                            <td><?= nl2br(esc($row['charge'])) ?></td>
                          </tr>
                        <?php elseif ($row['type'] === 'note'): ?>
                          <tr>
                            <?php
                            $colspan = is_array($customHeaders)
                              ? count($customHeaders)
                              : (($firstDataRow && $firstDataRow['type'] === 'three_col') ? 3 : 2);
                            ?>

                            <td colspan="<?= $colspan ?>">
                              <p class="sc-note"><?= esc($row['label']) ?></p>
                            </td>
                          </tr>
                        <?php else: // default row ?>
                          <tr>
                            <td><?= esc($row['label']) ?></td>
                            <td><?= esc($row['charge']) ?></td>
                          </tr>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
          <!-- For the Advances tab, append Penal Charges paragraph at the END -->
          <?php if ($tabSlug === 'advances' && !empty($penalChargesNote)): ?>
            <div class="bank-card overflow-hidden mb-6">
              <p class="sc-section-title">Penal Charges — Annexure I</p>
              <div class="p-4 text-sm" style="color: hsl(var(--muted-foreground)); line-height:1.75;">
                <?= $penalChargesNote ?>
              </div>
            </div>
          <?php endif; ?>
        </div><!-- /panel -->
        <?php $firstPanel = false; endforeach; ?>
    </div>
  </section>

  <script>
    (function () {
      var tabs = document.querySelectorAll('.sc-tab-btn');
      var panels = document.querySelectorAll('.sc-panel');

      tabs.forEach(function (btn) {
        btn.addEventListener('click', function () {
          var target = 'tab-' + btn.dataset.tab;

          tabs.forEach(function (b) { b.classList.remove('active'); });
          panels.forEach(function (p) { p.classList.remove('active'); });

          btn.classList.add('active');
          var panel = document.getElementById(target);
          if (panel) panel.classList.add('active');
        });
      });

      function downloadChargesPDF() {
        var btn = document.querySelector('[onclick="downloadChargesPDF()"]');
        if (btn) { btn.disabled = true; btn.textContent = 'Generating…'; }
        window.print();
        setTimeout(function () {
          if (btn) { btn.disabled = false; btn.innerHTML = '<i data-lucide="download" class="w-4 h-4"></i> Download PDF'; }
        }, 2000);
      }
      window.downloadChargesPDF = downloadChargesPDF;
    })();
  </script>

<?php elseif ($pageKey === 'lockers'): ?>
  <section class="section-padding bg-background">
    <div class="container-bank max-w-4xl">
      <div class="bank-card p-8 text-center mb-10">
        <i data-lucide="lock" class="w-16 h-16 text-primary mx-auto mb-4"></i>
        <h2 class="font-heading text-2xl text-foreground mb-3">Secure Your Valuables</h2>
        <p class="readable" style="color: hsl(var(--muted-foreground));">Our safe deposit locker facility offers maximum
          security for your important documents, jewellery, and valuables.</p>
      </div>
      <h2 class="font-heading text-xl text-foreground mb-4">Locker Sizes & Charges</h2>
      <div class="grid sm:grid-cols-3 gap-4 mb-10">
        <?php if (!empty($lockerSizes)): ?>
          <?php foreach ($lockerSizes as $size): ?>
            <div class="bank-card p-5 text-center">
              <h3 class="font-semibold text-foreground text-lg mb-2"><?= esc($size['size']) ?></h3>
              <p class="text-xs mb-2" style="color: hsl(var(--muted-foreground));"><?= esc($size['dimensions']) ?></p>
              <p class="text-xl font-bold text-primary"><?= esc($size['rent']) ?></p>
              <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));">Key Deposit: <?= esc($size['deposit']) ?>
              </p>
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
              <li class="flex items-center gap-2"><i data-lucide="circle-check" class="w-4 h-4 flex-shrink-0"
                  style="color: hsl(var(--success, var(--primary)));"></i><?= esc($item) ?></li>
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
                <summary class="flex items-center gap-2 cursor-pointer font-medium text-foreground py-2 tap-target"><i
                    data-lucide="circle-help" class="w-5 h-5 text-primary flex-shrink-0"></i><?= esc($faq['question']) ?>
                </summary>
                <p class="text-sm pl-7 pb-2" style="color: hsl(var(--muted-foreground));"><?= esc($faq['answer']) ?></p>
              </details>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No FAQs available.</p>
          <?php endif; ?>
        </div>
      </div>
      <div class="flex gap-3">
        <a href="<?= site_url('downloads/locker') ?>" class="btn-primary text-sm flex items-center gap-2"><i
            data-lucide="download" class="w-4 h-4"></i> View Locker Forms</a>
        <a href="<?= site_url('contact') ?>" class="btn-outline text-sm">Enquire at Branch</a>
      </div>
    </div>
  </section>

<?php elseif ($pageKey === 'insurance'): ?>
  <style>
    .ins-tab-btn {
      padding: .6rem 1.1rem;
      font-size: .8rem;
      font-weight: 600;
      border-radius: .5rem;
      border: 1.5px solid hsl(var(--border));
      background: hsl(var(--background));
      color: hsl(var(--muted-foreground));
      cursor: pointer;
      white-space: nowrap;
      transition: all .18s;
    }

    .ins-tab-btn.active {
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
      border-color: hsl(var(--primary));
    }

    .ins-tab-btn:not(.active):hover {
      border-color: hsl(var(--primary));
      color: hsl(var(--primary));
    }

    .ins-panel {
      display: none;
    }

    .ins-panel.active {
      display: block;
    }

    .ins-table {
      width: 100%;
      border-collapse: collapse;
    }

    .ins-table thead tr {
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
    }

    .ins-table thead th {
      padding: .75rem 1rem;
      text-align: left;
      font-size: .8rem;
      font-weight: 600;
    }

    .ins-table tbody tr:nth-child(even) {
      background: hsl(var(--muted) / 0.3);
    }

    .ins-table tbody tr:nth-child(odd) {
      background: hsl(var(--background));
    }

    .ins-table tbody td {
      padding: .7rem 1rem;
      font-size: .82rem;
      color: hsl(var(--foreground));
      border-bottom: 1px solid hsl(var(--border));
      vertical-align: top;
    }

    .ins-section-title {
      font-size: 1rem;
      font-weight: 700;
      color: hsl(var(--foreground));
      padding: .75rem 1rem;
      background: hsl(var(--muted) / 0.5);
      border-left: 4px solid hsl(var(--primary));
      margin: 0;
    }

    .ins-note {
      font-size: .78rem;
      color: hsl(var(--muted-foreground));
      padding: .6rem 1rem;
      background: hsl(var(--muted) / 0.25);
      border-top: 1px solid hsl(var(--border));
    }

    .ins-plan-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: .75rem;
      padding: 1rem;
    }

    .ins-plan-item {
      display: flex;
      align-items: center;
      gap: .5rem;
      padding: .55rem .85rem;
      border-radius: .5rem;
      background: hsl(var(--background));
      border: 1px solid hsl(var(--border));
      font-size: .82rem;
      color: hsl(var(--foreground));
      transition: border-color .15s, color .15s;
    }

    .ins-plan-item:hover {
      border-color: hsl(var(--primary));
      color: hsl(var(--primary));
    }

    .ins-plan-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: hsl(var(--primary));
      flex-shrink: 0;
    }

    .ins-partner-strip {
      display: flex;
      flex-wrap: wrap;
      gap: .75rem;
      padding: 1rem;
    }

    .ins-partner-badge {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      padding: .5rem 1rem;
      border-radius: .5rem;
      border: 1.5px solid hsl(var(--primary) / 0.4);
      background: hsl(var(--primary) / 0.05);
      font-size: .82rem;
      font-weight: 600;
      color: hsl(var(--primary));
    }

    .ins-highlight {
      font-weight: 700;
      color: hsl(var(--primary));
    }

    .ins-callout {
      padding: 1rem 1.25rem;
      background: hsl(var(--primary) / 0.06);
      border-left: 4px solid hsl(var(--primary));
      border-radius: 0 .5rem .5rem 0;
      font-size: .85rem;
      color: hsl(var(--foreground));
      line-height: 1.7;
    }
  </style>

  <section class="section-padding bg-background">
    <div class="container-bank">

      <?php if (!empty($insuranceIntro)): ?>

        <p class="readable" style="color:hsl(var(--muted-foreground)); margin-bottom:2rem;">

          <?= nl2br(esc($insuranceIntro)) ?>

        </p>

      <?php endif; ?>

      <!-- Tab Bar -->
      <div style="overflow-x:auto;padding-bottom:.5rem;margin-bottom:1.5rem;">
        <div style="display:flex;gap:.5rem;min-width:max-content;">
          <button class="ins-tab-btn active" data-ins-tab="life">Life Insurance</button>
          <button class="ins-tab-btn" data-ins-tab="general">General Insurance</button>
          <button class="ins-tab-btn" data-ins-tab="health">Health Insurance</button>
          <button class="ins-tab-btn" data-ins-tab="govt">PMJJBY &amp; PMSBY</button>
          <button class="ins-tab-btn" data-ins-tab="tieup">Tie-Up Partners</button>
        </div>
      </div>

      <div id="ins-tab-life" class="ins-panel active">

        <?php
        // The controller should pass $lifePlansLIC and $lifePlansSBI, or we fetch them here
        $planModel = new \App\Models\InsurancePlanModel();

        // --- LIC Card ---
        $licPlans = $planModel->where('tab', 'life')->where('provider', 'LIC')
          ->where('status', 1)->orderBy('category, sort_order')->findAll();
        $groupedLIC = [];
        foreach ($licPlans as $plan) {
          $groupedLIC[$plan['category']][] = $plan;
        }
        ?>

        <!-- LIC of India -->
        <div class="bank-card overflow-hidden mb-6">
          <p class="ins-section-title">
            <i data-lucide="shield" class="w-4 h-4 inline-block mr-1 align-middle"></i>
            LIC of India — Plans Available
          </p>
          <?php $first = true;
          foreach ($groupedLIC as $cat => $plans): ?>
            <?php if (!$first): ?>
              <hr style="border-color:hsl(var(--border));margin:0 1rem;"><?php endif;
            $first = false; ?>
            <div class="px-4 pt-4 pb-2">
              <p class="text-sm font-semibold text-foreground mb-2"><?= esc($cat) ?></p>
              <div class="ins-plan-grid" style="padding:0;margin-bottom:.5rem;">
                <?php foreach ($plans as $p): ?>
                  <?php if (empty($p['description'])): ?>
                    <div class="ins-plan-item"><span class="ins-plan-dot"></span><?= esc($p['plan_name']) ?></div>
                  <?php else: ?>
                    <div class="ins-callout"><?= esc($p['description']) ?></div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- SBI Life Card -->
        <?php
        $sbiPlans = $planModel->where('tab', 'life')->where('provider', 'SBI Life')
          ->where('status', 1)->orderBy('category, sort_order')->findAll();
        $groupedSBI = [];

        foreach ($sbiPlans as $plan) {

          $groupedSBI[$plan['category']][] = $plan;
        }

        $categoryOrder = [
          'Retirement Plans',
          'Protection Plans',
        ];

        uksort($groupedSBI, function ($a, $b) use ($categoryOrder) {

          $posA = array_search($a, $categoryOrder);
          $posB = array_search($b, $categoryOrder);

          $posA = ($posA === false) ? 999 : $posA;
          $posB = ($posB === false) ? 999 : $posB;

          return $posA <=> $posB;
        });
        ?>
        <div class="bank-card overflow-hidden mb-6">
          <p class="ins-section-title">
            <i data-lucide="shield-check" class="w-4 h-4 inline-block mr-1 align-middle"></i>
            SBI Life Insurance Co. Ltd. — Plans Available
          </p>
          <div class="px-4 pt-4 pb-4">
            <?php foreach ($groupedSBI as $cat => $plans): ?>
              <p class="text-sm font-semibold text-foreground mb-2"><?= esc($cat) ?></p>
              <div class="ins-plan-grid" style="padding:0;">
                <?php foreach ($plans as $p): ?>
                  <?php if (empty($p['description'])): ?>
                    <div class="ins-plan-item"><span class="ins-plan-dot"></span><?= esc($p['plan_name']) ?></div>
                  <?php else: ?>
                    <div class="ins-callout"> <?= esc($p['description']) ?></div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div><!-- /life -->
        <!-- ── PANEL: General Insurance ──────────────────────────────────── -->
      </div>
      <?php

      $generalPartners = $planModel
        ->where('tab', 'general')
        ->where('category', 'General Insurance Partners')
        ->where('status', 1)
        ->orderBy('sort_order', 'ASC')
        ->findAll();

      $generalProducts = $planModel
        ->where('tab', 'general')
        ->where('category', 'General Insurance Products')
        ->where('status', 1)
        ->orderBy('sort_order', 'ASC')
        ->findAll();

      ?>
      <div id="ins-tab-general" class="ins-panel">

        <div class="bank-card overflow-hidden mb-6">
          <p class="ins-section-title">
            <i data-lucide="building-2" class="w-4 h-4 inline-block mr-1 align-middle"></i>
            General Insurance Partners
          </p>
          <div class="ins-partner-strip">
            <?php if (!empty($generalPartners)): ?>
              <?php foreach ($generalPartners as $partner): ?>
                <span class="ins-partner-badge">
                  <i data-lucide="check-circle" class="w-4 h-4"></i>
                  <?= esc($partner['plan_name']) ?>
                </span>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

        <div class="bank-card overflow-hidden mb-6">
          <p class="ins-section-title">General Insurance Products Offered</p>
          <div class="overflow-x-auto">
            <table class="ins-table">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Description</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($generalProducts)): ?>
                  <?php foreach ($generalProducts as $product): ?>
                    <tr>
                      <td>
                        <strong><?= esc($product['plan_name']) ?></strong>
                      </td>
                      <td>
                        <?= esc($product['description']) ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <?php if (!empty($generalInsuranceNote)): ?>
            <p class="ins-note">
              <?= esc($generalInsuranceNote) ?>
            </p>
          <?php endif; ?>
        </div>
      </div><!-- /general -->

      <!-- ── PANEL: Health Insurance ───────────────────────────────────── -->
      <div id="ins-tab-health" class="ins-panel">

        <div class="bank-card overflow-hidden mb-6">
          <p class="ins-section-title">
            <i data-lucide="heart-pulse" class="w-4 h-4 inline-block mr-1 align-middle"></i>
            <?= esc($healthInsurancePartner['plan_name'] ?? '') ?>
            — Our Health Insurance Partner
          </p>
          <div class="p-5">
            <div class="ins-callout mb-5">
              <?= $healthInsuranceIntro ?>
            </div>
            <div class="grid sm:grid-cols-3 gap-4">
              <?php if (!empty($healthInsuranceFeatures)): ?>
                <?php foreach ($healthInsuranceFeatures as $feature): ?>
                  <div class="bank-card p-4 text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-3"
                      style="background:hsl(var(--primary)/0.1);">
                      <i data-lucide="shield-plus" class="w-5 h-5 text-primary"></i>
                    </div>
                    <p class="font-semibold text-foreground text-sm mb-1">
                      <?= esc($feature['plan_name']) ?>
                    </p>
                    <p class="text-xs" style="color:hsl(var(--muted-foreground));">
                      <?= esc($feature['description']) ?>
                    </p>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div><!-- /health -->

      <!-- ── PANEL: PMJJBY & PMSBY ─────────────────────────────────────── -->
      <div id="ins-tab-govt" class="ins-panel">

        <div class="bank-card overflow-hidden mb-6">
          <p class="ins-section-title">
            <i data-lucide="landmark" class="w-4 h-4 inline-block mr-1 align-middle"></i>
            1. Pradhan Mantri Jeevan Jyoti Bima Yojana (PMJJBY)
          </p>
          <div class="overflow-x-auto">
            <table class="ins-table">
              <thead>
                <tr>
                  <th>Feature</th>
                  <th>Details</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($pmjjbyPlans)): ?>
                  <?php foreach ($pmjjbyPlans as $index => $row): ?>
                    <?php if ($index === 3): ?>
                      <tr>
                        <td colspan="2" style="font-weight:600;color:hsl(var(--foreground));background:hsl(var(--muted)/0.4);">
                          Pro-rata Premium for Delayed Enrolment
                        </td>
                      </tr>
                    <?php endif; ?>
                    <tr>
                      <td><?= esc($row['plan_name']) ?></td>
                      <td><?= $row['description'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <?php if (!empty($pmjjbyNote)): ?>
            <p class="ins-note">
              <?= $pmjjbyNote ?>
            </p>
          <?php endif; ?>
        </div>

        <div class="bank-card overflow-hidden mb-6">
          <p class="ins-section-title">
            <i data-lucide="ambulance" class="w-4 h-4 inline-block mr-1 align-middle"></i>
            2. Pradhan Mantri Suraksha Bima Yojana (PMSBY)
          </p>
          <div class="overflow-x-auto">
            <table class="ins-table">
              <thead>
                <tr>
                  <th>Feature</th>
                  <th>Details</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($pmsbyPlans)): ?>
                  <?php foreach ($pmsbyPlans as $row): ?>
                    <tr>
                      <td><?= esc($row['plan_name']) ?></td>
                      <td><?= $row['description'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <?php if (!empty($pmsbyNote)): ?>
            <p class="ins-note">
              <?= $pmsbyNote ?>
            </p>
          <?php endif; ?>
        </div>
      </div><!-- /govt -->

      <!-- ── PANEL: Tie-Up Partners ─────────────────────────────────────── -->
      <div id="ins-tab-tieup" class="ins-panel">

        <div class="bank-card overflow-hidden mb-6">
          <p class="ins-section-title">
            <i data-lucide="handshake" class="w-4 h-4 inline-block mr-1 align-middle"></i>
            Bancassurance Tie-Up Partners
          </p>
          <div class="overflow-x-auto">
            <table class="ins-table">
              <thead>
                <tr>
                  <th>Partner</th>
                  <th>Category</th>
                  <th>Products</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($tieupPartners)): ?>
                  <?php foreach ($tieupPartners as $partner): ?>
                    <tr>
                      <td>
                        <strong><?= esc($partner['plan_name']) ?></strong>
                      </td>
                      <td>
                        <?= esc($partner['category']) ?>
                      </td>
                      <td>
                        <?= esc($partner['description']) ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <?php if (!empty($tieupPartnersNote)): ?>
            <p class="ins-note">
              <?= $tieupPartnersNote ?>
            </p>
          <?php endif; ?>
        </div>
      </div><!-- /tieup -->
    </div><!-- /container-bank -->
  </section>

  <script>
    (function () {
      var tabs = document.querySelectorAll('.ins-tab-btn');
      var panels = document.querySelectorAll('.ins-panel');

      tabs.forEach(function (btn) {
        btn.addEventListener('click', function () {
          var target = 'ins-tab-' + btn.dataset.insTab;

          tabs.forEach(function (b) { b.classList.remove('active'); });
          panels.forEach(function (p) { p.classList.remove('active'); });

          btn.classList.add('active');
          var panel = document.getElementById(target);
          if (panel) panel.classList.add('active');
        });
      });
    })();
  </script>

<?php elseif ($pageKey === 'positive-pay'): ?>
  <style>
    .pps-step {
      display: flex;
      gap: 1rem;
      align-items: flex-start;
      padding: 1rem 1.25rem;
      border-radius: .5rem;
      border: 1px solid hsl(var(--border));
      background: hsl(var(--background));
      transition: border-color .15s;
    }

    .pps-step:hover {
      border-color: hsl(var(--primary));
    }

    .pps-step-num {
      width: 2rem;
      height: 2rem;
      border-radius: 50%;
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
      font-size: .8rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: .1rem;
    }

    .pps-badge {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      padding: .35rem .75rem;
      border-radius: 9999px;
      background: hsl(var(--primary) / 0.1);
      color: hsl(var(--primary));
      font-size: .75rem;
      font-weight: 600;
    }

    .pps-section-title {
      font-size: 1rem;
      font-weight: 700;
      color: hsl(var(--foreground));
      padding: .75rem 1rem;
      background: hsl(var(--muted) / 0.5);
      border-left: 4px solid hsl(var(--primary));
      margin: 0;
    }

    .pps-note {
      font-size: .78rem;
      color: hsl(var(--muted-foreground));
      padding: .6rem 1rem;
      background: hsl(var(--muted) / 0.25);
      border-top: 1px solid hsl(var(--border));
    }

    .pps-field-chip {
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      padding: .3rem .7rem;
      border-radius: .4rem;
      background: hsl(var(--muted) / 0.5);
      border: 1px solid hsl(var(--border));
      font-size: .78rem;
      font-weight: 600;
      color: hsl(var(--foreground));
    }

    .pps-mode-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: .6rem;
      padding: 1.5rem 1rem;
      border-radius: .75rem;
      border: 1.5px solid hsl(var(--border));
      background: hsl(var(--background));
      transition: border-color .18s, box-shadow .18s;
      text-decoration: none;
    }

    .pps-mode-card:hover {
      border-color: hsl(var(--primary));
      box-shadow: 0 4px 16px hsl(var(--primary) / 0.12);
    }

    .pps-mode-icon {
      width: 3rem;
      height: 3rem;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: hsl(var(--primary) / 0.1);
    }
  </style>

  <section class="section-padding bg-background">
    <div class="container-bank">

      <!-- RBI Notice Banner -->
      <?php if (!empty($ppsBanner)): ?>
        <div class="bank-card p-4 mb-8 flex gap-3" style="border-left:4px solid hsl(var(--primary));">
          <i data-lucide="shield-check" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"></i>
          <div class="text-sm" style="color:hsl(var(--muted-foreground));line-height:1.7;">
            <?= $ppsBanner ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- How it works -->
      <div class="bank-card overflow-hidden mb-6">
        <p class="pps-section-title">
          <i data-lucide="info" class="w-4 h-4 inline-block mr-1 align-middle"></i>
          How Positive Pay System Works
        </p>
        <div class="p-5 text-sm" style="color:hsl(var(--muted-foreground));line-height:1.8;">
          <?= esc($ppsHowItWorks) ?>
        </div>
        <?php if (!empty($ppsFields)): ?>
          <div class="px-5 pb-5 flex flex-wrap gap-2">
            <?php foreach ($ppsFields as $field): ?>
              <span class="pps-field-chip"><i data-lucide="hash" class="w-3.5 h-3.5"></i> <?= esc($field) ?></span>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Sample Cheque -->
      <div class="bank-card overflow-hidden mb-6">
        <p class="pps-section-title">
          <i data-lucide="scan-search" class="w-4 h-4 inline-block mr-1 align-middle"></i>
          Sample Cheque — Field Reference
        </p>
        <div class="p-4">

          <img src="<?= base_url(ltrim($ppsSampleImage, '/')) ?>"
            alt="JPCB Sample Cheque for Positive Pay System showing labelled fields" class="w-full rounded-lg border"
            style="border-color:hsl(var(--border));max-width:800px;display:block;margin:0 auto;">
        </div>
        <?php if (!empty($ppsSampleNote)): ?>
          <p class="pps-note"><?= esc($ppsSampleNote) ?></p>
        <?php endif; ?>
      </div>

      <!-- Submission Modes -->
      <div class="bank-card overflow-hidden mb-6">
        <p class="pps-section-title">
          <i data-lucide="send" class="w-4 h-4 inline-block mr-1 align-middle"></i>
          Modes to Submit Cheque Details
        </p>
        <div class="p-5 grid sm:grid-cols-3 gap-4">
          <?php if (!empty($ppsModes)): ?>
            <?php foreach ($ppsModes as $mode):
              $hasLink = !empty($mode['link']);
              $external = !empty($mode['external']);
              ?>
              <?= $hasLink ? '<a href="' . esc($mode['link']) . '" ' . ($external ? 'target="_blank" rel="noopener noreferrer"' : '') . ' class="pps-mode-card">' : '<div class="pps-mode-card" style="cursor:default;">' ?>
              <div class="pps-mode-icon">
                <i data-lucide="<?= esc($mode['icon'] ?? 'circle') ?>" class="w-6 h-6 text-primary"></i>
              </div>
              <p class="font-semibold text-foreground text-sm"><?= esc($mode['title'] ?? '') ?></p>
              <p class="text-xs" style="color:hsl(var(--muted-foreground));"><?= $mode['description'] ?? '' ?></p>
              <?php if (!empty($mode['badge'])): ?>
                <span class="pps-badge"><?= esc($mode['badge']) ?></span>
              <?php endif; ?>
              <?= $hasLink ? '</a>' : '</div>' ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <?php if (!empty($ppsFooterNote)): ?>
          <p class="pps-note"><?= $ppsFooterNote ?></p>
        <?php endif; ?>
      </div>

    </div>
  </section>

<?php endif; ?>
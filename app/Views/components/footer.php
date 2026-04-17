<footer id="contact" role="contentinfo" style="background-color: hsl(var(--foreground)); color: hsl(var(--background));">
  <div class="container-bank">
    <div class="flex justify-end py-3 border-b" style="border-color: rgba(255,255,255,0.1);">
      <a href="#top" class="flex items-center gap-1.5 text-sm tap-target transition-colors" style="color: rgba(255,255,255,0.6);" onmouseover="this.style.color='rgba(255,255,255,1)'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
        <i data-lucide="arrow-up" class="w-4 h-4" aria-hidden="true"></i> Back to top
      </a>
    </div>
  </div>

  <div class="container-bank py-10 md:py-14">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">
      <div class="col-span-2 md:col-span-3 lg:col-span-1">
        <img src="<?= base_url('assets/images/bank-logo.png') ?>" alt="JPC Bank" class="h-10 w-auto mb-4" style="filter: brightness(0) invert(1);">

        <div class="space-y-2.5 text-sm" style="color: rgba(255,255,255,0.7);">
          <a href="tel:<?= str_replace(['-', ' '], '', $siteSettings['phone'] ?? '02572220055') ?>" class="flex items-center gap-2 tap-target transition-colors" onmouseover="this.style.color='rgba(255,255,255,1)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">
            <i data-lucide="phone" class="w-4 h-4 flex-shrink-0" aria-hidden="true"></i><?= esc($siteSettings['phone'] ?? '0257-2220055') ?>
          </a>
          <a href="mailto:<?= esc($siteSettings['email'] ?? 'info@jpcb.in') ?>" class="flex items-center gap-2 tap-target transition-colors" onmouseover="this.style.color='rgba(255,255,255,1)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">
            <i data-lucide="mail" class="w-4 h-4 flex-shrink-0" aria-hidden="true"></i><?= esc($siteSettings['email'] ?? 'info@jpcb.in') ?>
          </a>
          <p class="flex items-start gap-2">
            <i data-lucide="map-pin" class="w-4 h-4 flex-shrink-0 mt-0.5" aria-hidden="true"></i>
            <?php
            $address = $siteSettings['footer_address'] ?? '';
            if (empty($address)) {
                $address = $siteSettings['address'] ?? '';
            }
            if (empty($address)) {
                $address = 'Near Railway Station,<br>Jalgaon - 425001, Maharashtra';
            }
            ?>
            <span><?= $address ?></span>
          </p>
        </div>

        <div class="flex items-center gap-2 mt-4">
          <?php foreach($socialLinks as $social): ?>
            <a href="<?= esc($social['url']) ?>" target="_blank"
               class="w-9 h-9 rounded-full flex items-center justify-center tap-target transition-colors"
               style="background-color: rgba(255,255,255,0.1);"
               onmouseover="this.style.backgroundColor='rgba(255,255,255,0.2)'"
               onmouseout="this.style.backgroundColor='rgba(255,255,255,0.1)'"
               aria-label="<?= esc($social['name'] ?? $social['icon']) ?>">
              <i data-lucide="<?= esc($social['icon']) ?>" class="w-4 h-4"></i>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Static footer columns (can be made dynamic later) -->
      <div>
        <h3 class="font-semibold mb-3 capitalize text-sm" style="color: rgba(255,255,255,1);">About</h3>
        <ul class="space-y-1.5">
          <li><a href="<?= site_url('about') ?>" class="footer-link">About Us</a></li>
          <li><a href="<?= site_url('about/board') ?>" class="footer-link">Board of Directors</a></li>
          <li><a href="<?= site_url('about/management') ?>" class="footer-link">Management Team</a></li>
          <li><a href="<?= site_url('about/awards') ?>" class="footer-link">Awards</a></li>
          <li><a href="<?= site_url('about/gallery') ?>" class="footer-link">Gallery</a></li>
        </ul>
      </div>

      <div>
        <h3 class="font-semibold mb-3 capitalize text-sm" style="color: rgba(255,255,255,1);">Products</h3>
        <ul class="space-y-1.5">
          <li><a href="<?= site_url('deposits/savings-current') ?>" class="footer-link">Savings Account</a></li>
          <li><a href="<?= site_url('deposits/products') ?>" class="footer-link">Fixed Deposit</a></li>
          <li><a href="<?= site_url('loans') ?>" class="footer-link">Loans</a></li>
          <li><a href="<?= site_url('deposits/interest-rates') ?>" class="footer-link">Interest Rates</a></li>
          <li><a href="<?= site_url('loans/emi-calculator') ?>" class="footer-link">EMI Calculator</a></li>
        </ul>
      </div>

      <div>
        <h3 class="font-semibold mb-3 capitalize text-sm" style="color: rgba(255,255,255,1);">Services</h3>
        <ul class="space-y-1.5">
          <li><a href="<?= site_url('digital/mobile-banking') ?>" class="footer-link">Mobile Banking</a></li>
          <li><a href="<?= site_url('digital/rtgs-neft') ?>" class="footer-link">UPI / RTGS / NEFT</a></li>
          <li><a href="<?= site_url('digital/atm') ?>" class="footer-link">ATM Locator</a></li>
          <li><a href="<?= site_url('services/lockers') ?>" class="footer-link">Lockers</a></li>
          <li><a href="<?= site_url('services/charges') ?>" class="footer-link">Service Charges</a></li>
          <li><a href="<?= site_url('downloads') ?>" class="footer-link">Downloads</a></li>
        </ul>
      </div>

      <div>
        <h3 class="font-semibold mb-3 capitalize text-sm" style="color: rgba(255,255,255,1);">Help</h3>
        <ul class="space-y-1.5">
          <li><a href="<?= site_url('contact') ?>" class="footer-link">Contact Us</a></li>
          <li><a href="<?= site_url('faq') ?>" class="footer-link">FAQs</a></li>
          <li><a href="<?= site_url('complaints') ?>" class="footer-link">Lodge Complaint</a></li>
          <li><a href="<?= site_url('complaints/escalation') ?>" class="footer-link">Escalation Matrix</a></li>
          <li><a href="<?= site_url('rbi') ?>" class="footer-link">RBI Awareness</a></li>
        </ul>
      </div>

      <div>
        <h3 class="font-semibold mb-3 capitalize text-sm" style="color: rgba(255,255,255,1);">Policies</h3>
        <ul class="space-y-1.5">
          <li><a href="<?= site_url('privacy') ?>" class="footer-link">Privacy Policy</a></li>
          <li><a href="<?= site_url('accessibility') ?>" class="footer-link">Accessibility</a></li>
          <li><a href="<?= site_url('rbi/fair-practice') ?>" class="footer-link">Fair Practice Code</a></li>
          <li><a href="<?= site_url('sitemap') ?>" class="footer-link">Sitemap</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="border-t" style="border-color: rgba(255,255,255,0.1);">
    <div class="container-bank py-4">
      <div class="flex flex-col md:flex-row items-center justify-between gap-3 text-xs" style="color: rgba(255,255,255,0.5);">
        <p>© <?= date('Y') ?> <?= esc($siteSettings['copyright_text'] ?? 'The Jalgaon Peoples Co-Op. Bank Ltd. All rights reserved.') ?></p>
        <div class="flex items-center gap-3">
          <a href="<?= esc($siteSettings['rbi_guidelines_link'] ?? 'https://rbi.org.in') ?>" target="_blank" rel="noopener" class="transition-colors flex items-center gap-1" onmouseover="this.style.color='rgba(255,255,255,1)'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
            <?= esc($siteSettings['rbi_guidelines_text'] ?? 'RBI Guidelines') ?> <i data-lucide="external-link" class="w-3 h-3" aria-hidden="true"></i>
          </a>
          <span>|</span>
          <span><?= esc($siteSettings['bank_type_text'] ?? 'Multi-State Scheduled Co-operative Bank') ?></span>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- Mobile Top Bar (Digital Banking CTA) -->
<div class="mobile-top-bar border-b"
  style="background-color: hsl(var(--accent, var(--primary))); border-color: hsl(var(--border));">
  <a href="<?= site_url($siteSettings['digital_banking_link']) ?>"
    class="flex items-center justify-center gap-1.5 py-2 text-sm font-medium no-highlight"
    style="color: hsl(var(--accent-foreground, var(--primary-foreground)));">
    <i data-lucide="smartphone" class="w-4 h-4" aria-hidden="true"></i>
    <?= esc($siteSettings['digital_banking_button_text']) ?>
  </a>
</div>

<!-- Utility Bar -->
<div class="border-b py-1.5 text-sm hidden md:block"
  style="background-color: hsl(var(--muted)); border-color: hsl(var(--border));">
  <div class="container-bank">
    <div class="flex items-center justify-between py-1">
      <div class="flex items-center gap-5" style="color: hsl(var(--muted-foreground));">
        <a href="tel:<?= str_replace(['-', ' '], '', $siteSettings['phone']) ?>"
          class="flex items-center gap-1.5 hover-primary transition-colors">
          <i data-lucide="phone" class="w-3.5 h-3.5" aria-hidden="true"></i><?= esc($siteSettings['phone']) ?>
        </a>
        <a href="mailto:<?= esc($siteSettings['email']) ?>"
          class="flex items-center gap-1.5 hover-primary transition-colors">
          <i data-lucide="mail" class="w-3.5 h-3.5" aria-hidden="true"></i><?= esc($siteSettings['email']) ?>
        </a>
        <span class="flex items-center gap-1.5">
          <i data-lucide="clock" class="w-3.5 h-3.5" aria-hidden="true"></i><?= esc($siteSettings['business_hours']) ?>
        </span>
      </div>
      <div class="flex items-center gap-3">
        <a href="<?= site_url($siteSettings['locate_branch_link']) ?>"
          class="flex items-center gap-1.5 hover-primary transition-colors font-medium"
          style="color: hsl(var(--muted-foreground));">
          <i data-lucide="map-pin" class="w-3.5 h-3.5" aria-hidden="true"></i>Locate Branch
        </a>
        <a href="<?= site_url($siteSettings['block_card_link']) ?>"
          class="flex items-center gap-1.5 transition-opacity font-medium" style="color: hsl(var(--destructive));">
          <i data-lucide="credit-card" class="w-3.5 h-3.5" aria-hidden="true"></i>Block ATM Card
        </a>
        <a href="<?= site_url($siteSettings['lodge_complaint_link']) ?>"
          class="flex items-center gap-1.5 transition-opacity font-medium" style="color: hsl(var(--destructive));">
          <i data-lucide="alert-triangle" class="w-3.5 h-3.5" aria-hidden="true"></i>Lodge Complaint
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Main Header -->
<header class="shadow-sm border-b" role="banner"
  style="background-color: hsl(var(--card)); border-color: hsl(var(--border));">
  <div class="container-bank">

    <!-- ===================================================== -->
    <!-- BRAND HEADER - INCREASED LOGO SIZE FOR MOBILE -->
    <!-- ===================================================== -->
    <div class="py-3 lg:py-4">
      <div class="flex items-center justify-between gap-4 overflow-hidden">
        <a href="<?= site_url('/') ?>" class="flex items-center min-w-0 flex-1 no-highlight overflow-hidden"
          aria-label="JPC Bank - Home">
          <img
    src="<?= base_url('assets/images/bank-logo.png') ?>"
    alt="The Jalgaon Peoples Co-Op. Bank Ltd."
    class="bank-logo">
        </a>

        <div class="hidden lg:flex items-center gap-3">
          <button id="search-btn"
            class="tap-target w-10 h-10 rounded-full flex items-center justify-center transition-colors hover-bg-muted"
            aria-label="Search">
            <i data-lucide="search" class="w-5 h-5"></i>
          </button>
          <a href="<?= site_url('digital') ?>"
            class="header-digital-cta btn-accent rounded-xl text-sm py-2.5 px-5 items-center gap-1 no-highlight flex">
            <i data-lucide="smartphone" class="w-4 h-4" aria-hidden="true"></i>
            <?= esc($siteSettings['digital_banking_button_text']) ?>
          </a>
          <!-- Desktop Login Button -->
          <a href="#" onclick="openComingSoonModal(event)"
            class="btn-outline rounded-xl text-sm py-2.5 px-5 items-center gap-2 flex">
            <i data-lucide="lock" class="w-4 h-4"></i> Login
          </a>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="lg:hidden tap-target p-2 rounded-lg transition-colors hover-bg-muted"
          aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
          <i id="mobile-menu-icon" data-lucide="menu" class="w-7 h-7"></i>
        </button>
      </div>
    </div>

    <!-- ===================================================== -->
    <!-- NAVIGATION BAR - 9 MENUS AS PER LOCKED STRUCTURE -->
    <!-- ===================================================== -->
    <div class="border-t" style="border-color: hsl(var(--border));">
      <nav id="main-nav" class="hidden lg:flex items-center nav-scrollable" role="navigation"
        aria-label="Main navigation">

        <!-- HOME (First Item) -->
        <a href="<?= site_url('/') ?>"
          class="flex items-center gap-1 px-2 lg:px-3 py-3 font-medium transition-colors tap-target nav-link">
          Home
        </a>

        <!-- 1. ABOUT US DROPDOWN -->
        <div class="relative" data-mega-menu="about">
          <a href="<?= site_url('about') ?>"
            class="flex items-center gap-1 px-2 lg:px-3 py-3 font-medium transition-colors tap-target nav-link">
            About Us <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50"></i>
          </a>
          <div data-dropdown="about"
            class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50"
            style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 280px;">
            <div class="p-4">
              <div class="grid grid-cols-1 gap-1">
                <a href="<?= site_url('about') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">About Bank</span></a>
                <a href="<?= site_url('about/board') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Board of Directors</span></a>
                <a href="<?= site_url('about/management') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Management</span></a>
                <a href="<?= site_url('about/branches') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">HO &amp; Branches</span></a>
                <a href="<?= site_url('about/awards') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Awards</span></a>
                <a href="<?= site_url('about/gallery') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Gallery</span></a>
              </div>
            </div>
          </div>
        </div>

        <!-- 2. DEPOSIT DROPDOWN -->
        <div class="relative" data-mega-menu="deposit">
          <a href="<?= site_url('deposits') ?>"
            class="flex items-center gap-1 px-2 lg:px-3 py-3 font-medium transition-colors tap-target nav-link">
            Deposit <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50"></i>
          </a>
          <div data-dropdown="deposit"
            class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50"
            style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 260px;">
            <div class="p-4">
              <div class="grid grid-cols-1 gap-1">
                <a href="<?= site_url('deposits/deaf') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">DEAF</span></a>
                <a href="<?= site_url('deposits/interest-rates') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Interest Rates</span></a>
                <a href="<?= site_url('deposits/products') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Dep.Products</span></a>
                <a href="<?= site_url('deposits/savings-current') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Saving / Current A/c</span></a>
                <a href="<?= site_url('deposits/dicgc') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">DICGC Insurance</span></a>
              </div>
            </div>
          </div>
        </div>

        <!-- 3. LOANS DROPDOWN -->
        <div class="relative" data-mega-menu="loans">
          <a href="<?= site_url('loans') ?>"
            class="flex items-center gap-1 px-2 lg:px-3 py-3 font-medium transition-colors tap-target nav-link">
            Loans <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50"></i>
          </a>
          <div data-dropdown="loans"
            class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50"
            style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 240px;">
            <div class="p-4">
              <div class="grid grid-cols-1 gap-1">
                <a href="<?= site_url('loans/interest-rates') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Interest Rates</span></a>
                <a href="<?= site_url('loans/products') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Loan Products</span></a>
                <a href="<?= site_url('loans/emi-calculator') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">EMI Calculator</span></a>
              </div>
            </div>
          </div>
        </div>

        <!-- 4. DIGITAL PAYMENT DROPDOWN -->
        <div class="relative" data-mega-menu="digital">
          <a href="<?= site_url('digital') ?>"
            class="flex items-center gap-1 px-2 lg:px-3 py-3 font-medium transition-colors tap-target nav-link">
            Digital Payment <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50"></i>
          </a>
          <div data-dropdown="digital"
            class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50"
            style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 260px;">
            <div class="p-4">
              <div class="grid grid-cols-1 gap-1">
                <a href="<?= site_url('digital/mobile-banking') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Mobile banking</span></a>
                <a href="<?= site_url('digital/atm') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">ATM</span></a>
                <a href="<?= site_url('digital/ifsc-micr') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">IFSC &amp; MICR code</span></a>
                <a href="<?= site_url('digital/rtgs-neft') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">RTGS NEFT</span></a>
                <a href="<?= site_url('digital/upi') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">UPI Service</span></a>
                <a href="<?= site_url('digital/digisaathi') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">DigiSaathi</span></a>
              </div>
            </div>
          </div>
        </div>

        <!-- 5. SERVICES DROPDOWN -->
        <div class="relative" data-mega-menu="services">
          <a href="<?= site_url('services') ?>"
            class="flex items-center gap-1 px-2 lg:px-3 py-3 font-medium transition-colors tap-target nav-link">
            Services <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50"></i>
          </a>
          <div data-dropdown="services"
            class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50"
            style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 240px;">
            <div class="p-4">
              <div class="grid grid-cols-1 gap-1">
                <a href="<?= site_url('services/charges') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Service charges</span></a>
                <a href="<?= site_url('services/lockers') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Lockers</span></a>
                <a href="<?= site_url('services/insurance') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Insurance</span></a>
                <a href="<?= site_url('services/positive-pay') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Positive pay</span></a>
              </div>
            </div>
          </div>
        </div>

        <!-- 6. RBI SAYS DROPDOWN -->
        <div class="relative" data-mega-menu="rbi">
          <a href="<?= site_url('rbi') ?>"
            class="flex items-center gap-1 px-2 lg:px-3 py-3 font-medium transition-colors tap-target nav-link">
            RBI Says <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50"></i>
          </a>
          <div data-dropdown="rbi"
            class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50"
            style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 260px;">
            <div class="p-4">
              <div class="grid grid-cols-1 gap-1">
                <a href="<?= site_url('rbi/fair-practice') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Fair practice Code</span></a>
                <a href="<?= site_url('rbi/ombudsman') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Banking Ombudsman</span></a>
                <a href="<?= site_url('rbi/booklet') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">BE(A)WARE RBI BOOKLET</span></a>
              </div>
            </div>
          </div>
        </div>

        <!-- 7. DOWNLOADS DROPDOWN -->
        <div class="relative" data-mega-menu="downloads">
          <a href="<?= site_url('downloads') ?>"
            class="flex items-center gap-1 px-2 lg:px-3 py-3 font-medium transition-colors tap-target nav-link">
            Downloads <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50"></i>
          </a>
          <div data-dropdown="downloads"
            class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50"
            style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 240px;">
            <div class="p-4">
              <div class="grid grid-cols-1 gap-1">
                <a href="<?= site_url('downloads') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Download</span></a>
                <a href="<?= site_url('downloads/forms') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Forms</span></a>
                <a href="<?= site_url('downloads/reports') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Annual Report</span></a>
                <a href="<?= site_url('downloads/policies') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Policies</span></a>
                <a href="<?= site_url('downloads/secured-assets') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Secured Assets</span></a>
              </div>
            </div>
          </div>
        </div>

        <!-- 8. LODGE A COMPLAINT DROPDOWN -->
        <div class="relative" data-mega-menu="complaints">
          <a href="<?= site_url('complaints') ?>"
            class="flex items-center gap-1 px-2 lg:px-3 py-3 font-medium transition-colors tap-target nav-link">
            Lodge Complaint <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50"></i>
          </a>
          <div data-dropdown="complaints"
            class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50"
            style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 280px;">
            <div class="p-4">
              <div class="grid grid-cols-1 gap-1">
                <a href="<?= site_url('contact') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Contact Us</span></a>
                <a href="<?= site_url('complaints') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Complaint Logging</span></a>
                <a href="<?= base_url('uploads/downloads/1778060759_afac0d0efc5ddb0e7835.pdf') ?>" target="_blank"
                  rel="noopener noreferrer" class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item">
                  <span class="font-medium text-sm">Payment Settlement Contact Details</span>
                  <span class="text-xs ml-2 text-gray-400">(PDF)</span>
                </a>
                <a href="<?= site_url('rbi/integrated-ombudsman') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">RBI Integrated Ombudsman Scheme</span></a>
                <a href="<?= site_url('complaints/escalation') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">Escalation Matrix</span></a>
              </div>
            </div>
          </div>
        </div>

        <!-- 9. CUSTOMER AWARENESS DROPDOWN -->
        <div class="relative" data-mega-menu="awareness">
          <a href="<?= site_url('rbi/dos-and-donts') ?>"
            class="flex items-center gap-1 px-2 lg:px-3 py-3 font-medium transition-colors tap-target nav-link">
            Customer Awareness <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50"></i>
          </a>
          <div data-dropdown="awareness"
            class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50"
            style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 300px;">
            <div class="p-4">
              <div class="grid grid-cols-1 gap-1">
                <a href="<?= site_url('faq') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">FAQs</span></a>
                <a href="<?= site_url('rbi/dos-and-donts') ?>"
                  class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span
                    class="font-medium text-sm">RBI Do's &amp; Don't's for Digital Payments</span></a>
                <a href="<?= base_url('uploads/rbi/1778317726_c757c401d3e61d09ac06.pdf') ?>" target="_blank"
                rel="noopener noreferrer" class="px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item">
                    <span class="font-medium text-sm">Be(A)ware - RBI Customer Awareness Tips</span>
                  <span class="text-xs ml-2 text-gray-400">(PDF)</span>
                  </a>
              </div>
            </div>
          </div>
        </div>

      </nav>
    </div>

    <!-- Search Bar (Hidden by default) -->
    <div id="search-bar" class="hidden pb-4 animate-fade-in">
      <form action="<?= site_url('search') ?>" method="get" role="search" class="relative">
        <label for="global-search" class="sr-only">Search the website</label>
        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 pointer-events-none"
          style="color: hsl(var(--muted-foreground));" aria-hidden="true"></i>
        <input id="global-search" type="search" name="q" placeholder="Search products, forms, rates, branches, FAQs..."
          maxlength="200" class="w-full pl-12 pr-4 py-3 rounded-lg border text-base focus:outline-none focus:ring-2"
          style="background-color: hsl(var(--background)); border-color: hsl(var(--border)); color: hsl(var(--foreground));"
          autocomplete="off">
      </form>
    </div>
  </div>

  <!-- Mobile Navigation Menu (Fully Synced) -->
  <nav id="mobile-menu" class="hidden lg:hidden border-t animate-fade-in max-h-[70vh] overflow-y-auto"
    style="background-color: hsl(var(--card)); border-color: hsl(var(--border));" aria-label="Mobile navigation">
    <div class="container-bank py-3">

      <!-- Mobile Login Button - Separate full-width button (ONLY ONCE) -->
      <a href="#" onclick="openComingSoonModal(event)"
        class="btn-outline text-center mb-4 block w-full py-3 rounded-lg border border-primary/30 flex items-center justify-center gap-2 font-medium">
        <i data-lucide="lock" class="w-4 h-4"></i> Login to Internet Banking
      </a>

      <div class="flex flex-wrap gap-1 mb-3 pb-3 border-b" style="border-color: hsl(var(--border));">
        <a href="<?= site_url($siteSettings['locate_branch_link']) ?>"
          class="flex items-center gap-1.5 text-sm font-medium px-3 py-2 rounded-md"
          style="color: hsl(var(--muted-foreground)); background-color: hsl(var(--muted));">
          <i data-lucide="map-pin" class="w-4 h-4"></i>Locate Branch
        </a>
        <a href="<?= site_url($siteSettings['block_card_link']) ?>"
          class="flex items-center gap-1.5 text-sm font-medium px-3 py-2 rounded-md"
          style="color: hsl(var(--destructive)); background-color: hsl(var(--destructive) / 0.1);">
          <i data-lucide="credit-card" class="w-4 h-4"></i>Block Card
        </a>
        <a href="<?= site_url($siteSettings['lodge_complaint_link']) ?>"
          class="flex items-center gap-1.5 text-sm font-medium px-3 py-2 rounded-md"
          style="color: hsl(var(--destructive)); background-color: hsl(var(--destructive) / 0.1);">
          <i data-lucide="alert-triangle" class="w-4 h-4"></i>Complaint
        </a>
      </div>

      <div class="border-b border-gray-100">
        <a href="<?= site_url('/') ?>" class="block py-3 font-medium">Home</a>
      </div>

      <!-- About Us Mobile -->
      <div class="border-b border-gray-100">
        <button data-mobile-submenu-btn="about" class="w-full flex items-center justify-between py-3 font-medium">About
          Us <i data-lucide="chevron-down" class="w-4 transition-transform"></i></button>
        <div id="mobile-sub-about" class="hidden pb-2 pl-4 space-y-1">
          <a href="<?= site_url('about') ?>" class="block py-2 text-sm">About Bank</a>
          <a href="<?= site_url('about/board') ?>" class="block py-2 text-sm">Board of Directors</a>
          <a href="<?= site_url('about/management') ?>" class="block py-2 text-sm">Management</a>
          <a href="<?= site_url('about/branches') ?>" class="block py-2 text-sm">HO &amp; Branches</a>
          <a href="<?= site_url('about/awards') ?>" class="block py-2 text-sm">Awards</a>
          <a href="<?= site_url('about/gallery') ?>" class="block py-2 text-sm">Gallery</a>
        </div>
      </div>

      <!-- Deposit Mobile -->
      <div class="border-b border-gray-100">
        <button data-mobile-submenu-btn="deposit"
          class="w-full flex items-center justify-between py-3 font-medium">Deposit <i data-lucide="chevron-down"
            class="w-4"></i></button>
        <div id="mobile-sub-deposit" class="hidden pb-2 pl-4 space-y-1">
          <a href="<?= site_url('deposits/deaf') ?>" class="block py-2 text-sm">DEAF</a>
          <a href="<?= site_url('deposits/interest-rates') ?>" class="block py-2 text-sm">Interest Rates</a>
          <a href="<?= site_url('deposits/products') ?>" class="block py-2 text-sm">Dep.Products</a>
          <a href="<?= site_url('deposits/savings-current') ?>" class="block py-2 text-sm">Saving / Current A/c</a>
          <a href="<?= site_url('deposits/dicgc') ?>" class="block py-2 text-sm">DICGC Insurance</a>
        </div>
      </div>

      <!-- Loans Mobile -->
      <div class="border-b border-gray-100">
        <button data-mobile-submenu-btn="loans" class="w-full flex items-center justify-between py-3 font-medium">Loans
          <i data-lucide="chevron-down" class="w-4"></i></button>
        <div id="mobile-sub-loans" class="hidden pb-2 pl-4 space-y-1">
          <a href="<?= site_url('loans/interest-rates') ?>" class="block py-2 text-sm">Interest Rates</a>
          <a href="<?= site_url('loans/products') ?>" class="block py-2 text-sm">Loan Products</a>
          <a href="<?= site_url('loans/emi-calculator') ?>" class="block py-2 text-sm">EMI Calculator</a>
        </div>
      </div>

      <!-- Digital Payment Mobile -->
      <div class="border-b border-gray-100">
        <button data-mobile-submenu-btn="digital"
          class="w-full flex items-center justify-between py-3 font-medium">Digital Payment <i
            data-lucide="chevron-down" class="w-4"></i></button>
        <div id="mobile-sub-digital" class="hidden pb-2 pl-4 space-y-1">
          <a href="<?= site_url('digital/mobile-banking') ?>" class="block py-2 text-sm">Mobile banking</a>
          <a href="<?= site_url('digital/atm') ?>" class="block py-2 text-sm">ATM</a>
          <a href="<?= site_url('digital/ifsc-micr') ?>" class="block py-2 text-sm">IFSC &amp; MICR code</a>
          <a href="<?= site_url('digital/rtgs-neft') ?>" class="block py-2 text-sm">RTGS NEFT</a>
          <a href="<?= site_url('digital/upi') ?>" class="block py-2 text-sm">UPI Service</a>
          <a href="<?= site_url('digital/digisaathi') ?>" class="block py-2 text-sm">DigiSaathi</a>
        </div>
      </div>

      <!-- Services Mobile -->
      <div class="border-b border-gray-100">
        <button data-mobile-submenu-btn="services"
          class="w-full flex items-center justify-between py-3 font-medium">Services <i data-lucide="chevron-down"
            class="w-4"></i></button>
        <div id="mobile-sub-services" class="hidden pb-2 pl-4 space-y-1">
          <a href="<?= site_url('services/charges') ?>" class="block py-2 text-sm">Service charges</a>
          <a href="<?= site_url('services/lockers') ?>" class="block py-2 text-sm">Lockers</a>
          <a href="<?= site_url('services/insurance') ?>" class="block py-2 text-sm">Insurance</a>
          <a href="<?= site_url('services/positive-pay') ?>" class="block py-2 text-sm">Positive pay</a>
        </div>
      </div>

      <!-- RBI Says Mobile -->
      <div class="border-b border-gray-100">
        <button data-mobile-submenu-btn="rbi" class="w-full flex items-center justify-between py-3 font-medium">RBI Says
          <i data-lucide="chevron-down" class="w-4"></i></button>
        <div id="mobile-sub-rbi" class="hidden pb-2 pl-4 space-y-1">
          <a href="<?= site_url('rbi/fair-practice') ?>" class="block py-2 text-sm">Fair practice Code</a>
          <a href="<?= site_url('rbi/ombudsman') ?>" class="block py-2 text-sm">Banking Ombudsman</a>
          <a href="<?= site_url('rbi/booklet') ?>" class="block py-2 text-sm">BE(A)WARE RBI BOOKLET</a>
        </div>
      </div>

      <!-- Downloads Mobile -->
      <div class="border-b border-gray-100">
        <button data-mobile-submenu-btn="downloads"
          class="w-full flex items-center justify-between py-3 font-medium">Downloads <i data-lucide="chevron-down"
            class="w-4"></i></button>
        <div id="mobile-sub-downloads" class="hidden pb-2 pl-4 space-y-1">
          <a href="<?= site_url('downloads') ?>" class="block py-2 text-sm">Download</a>
          <a href="<?= site_url('downloads/forms') ?>" class="block py-2 text-sm">Forms</a>
          <a href="<?= site_url('downloads/reports') ?>" class="block py-2 text-sm">Annual Report</a>
          <a href="<?= site_url('downloads/policies') ?>" class="block py-2 text-sm">Policies</a>
          <a href="<?= site_url('downloads/secured-assets') ?>" class="block py-2 text-sm">Secured Assets</a>
        </div>
      </div>

      <!-- Lodge a Complaint Mobile -->
      <div class="border-b border-gray-100">
        <button data-mobile-submenu-btn="complaints"
          class="w-full flex items-center justify-between py-3 font-medium">Lodge Complaint <i
            data-lucide="chevron-down" class="w-4"></i></button>
        <div id="mobile-sub-complaints" class="hidden pb-2 pl-4 space-y-1">
          <a href="<?= site_url('contact') ?>" class="block py-2 text-sm">Contact Us</a>
          <a href="<?= site_url('complaints') ?>" class="block py-2 text-sm">Complaint Logging</a>
          <a href="#" class="block py-2 text-sm">Payment Settlement Contact Details <span
              class="text-xs text-gray-400">(Soon)</span></a>
          <a href="<?= site_url('rbi/integrated-ombudsman') ?>" class="block py-2 text-sm">RBI Integrated Ombudsman
            Scheme</a>
          <a href="<?= site_url('complaints/escalation') ?>" class="block py-2 text-sm">Escalation Matrix</a>
        </div>
      </div>

      <!-- Customer Awareness Mobile -->
      <div class="border-b border-gray-100">
        <button data-mobile-submenu-btn="awareness"
          class="w-full flex items-center justify-between py-3 font-medium">Customer Awareness <i
            data-lucide="chevron-down" class="w-4"></i></button>
        <div id="mobile-sub-awareness" class="hidden pb-2 pl-4 space-y-1">
          <a href="<?= site_url('rbi/dos-and-donts') ?>" class="block py-2 text-sm">FAQs</a>
          <a href="<?= site_url('rbi/dos-and-donts') ?>" class="block py-2 text-sm">Do's &amp; Don't's for Digital
            Payments</a>
          <a href="<?= site_url('rbi/booklet') ?>" class="block py-2 text-sm">Be(A)ware - RBI Customer Awareness
            Tips</a>
        </div>
      </div>
    </div>
  </nav>
</header>
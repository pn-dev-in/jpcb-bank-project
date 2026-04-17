<!-- Utility Bar -->
<div class="border-b py-1.5 text-sm hidden md:block" style="background-color: hsl(var(--muted)); border-color: hsl(var(--border));">
  <div class="container-bank">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-5" style="color: hsl(var(--muted-foreground));">
        <a href="tel:<?= str_replace(['-', ' '], '', $siteSettings['phone']) ?>" class="flex items-center gap-1.5 hover-primary transition-colors">
          <i data-lucide="phone" class="w-3.5 h-3.5" aria-hidden="true"></i><?= esc($siteSettings['phone']) ?>
        </a>
        <a href="mailto:<?= esc($siteSettings['email']) ?>" class="flex items-center gap-1.5 hover-primary transition-colors">
          <i data-lucide="mail" class="w-3.5 h-3.5" aria-hidden="true"></i><?= esc($siteSettings['email']) ?>
        </a>
        <span class="flex items-center gap-1.5">
          <i data-lucide="clock" class="w-3.5 h-3.5" aria-hidden="true"></i><?= esc($siteSettings['business_hours']) ?>
        </span>
      </div>
      <div class="flex items-center gap-3">
        <a href="<?= site_url($siteSettings['locate_branch_link']) ?>" class="flex items-center gap-1.5 hover-primary transition-colors font-medium" style="color: hsl(var(--muted-foreground));">
          <i data-lucide="map-pin" class="w-3.5 h-3.5" aria-hidden="true"></i>Locate Branch
        </a>
        <a href="<?= site_url($siteSettings['block_card_link']) ?>" class="flex items-center gap-1.5 transition-opacity font-medium" style="color: hsl(var(--destructive));">
          <i data-lucide="credit-card" class="w-3.5 h-3.5" aria-hidden="true"></i>Block ATM Card
        </a>
        <a href="<?= site_url($siteSettings['lodge_complaint_link']) ?>" class="flex items-center gap-1.5 transition-opacity font-medium" style="color: hsl(var(--destructive));">
          <i data-lucide="alert-triangle" class="w-3.5 h-3.5" aria-hidden="true"></i>Lodge Complaint
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Main Header -->
<header class="shadow-sm sticky top-0 z-50 border-b" role="banner" style="background-color: hsl(var(--card)); border-color: hsl(var(--border));">
  <div class="container-bank">
    <div class="flex items-center justify-between py-3 lg:py-0">
      <a href="<?= site_url('/') ?>" class="no-highlight flex-shrink-0" aria-label="JPC Bank - Home">
        <img src="<?= base_url('assets/images/bank-logo.png') ?>" alt="The Jalgaon Peoples Co-Op. Bank Ltd." class="h-10 sm:h-12 lg:h-14 w-auto">
      </a>

      <nav id="main-nav" class="hidden lg:flex items-center" role="navigation" aria-label="Main navigation">
        <a href="<?= site_url('/') ?>" class="flex items-center gap-1 px-4 py-5 font-medium transition-colors tap-target nav-link">Home</a>

        <div class="relative" data-mega-menu="about">
          <a href="<?= site_url('about') ?>" class="flex items-center gap-1 px-4 py-5 font-medium transition-colors tap-target nav-link" aria-haspopup="true" aria-expanded="false">
            About <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50" aria-hidden="true"></i>
          </a>
          <div data-dropdown="about" class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50" style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 320px;">
            <div class="p-5">
              <div class="grid grid-cols-1 gap-1">
                <a href="<?= site_url('about') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">About the Bank</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Our story, mission &amp; values</span></a>
                <a href="<?= site_url('about/board') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Board of Directors</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Leadership &amp; governance</span></a>
                <a href="<?= site_url('about/management') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Management</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Executive team</span></a>
                <a href="<?= site_url('about/awards') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Awards &amp; Recognition</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Achievements &amp; milestones</span></a>
                <a href="<?= site_url('about/gallery') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Gallery</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Events &amp; activities</span></a>
                <a href="<?= site_url('about/branches') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Branches</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">HO &amp; branch network</span></a>
              </div>
            </div>
          </div>
        </div>

        <div class="relative" data-mega-menu="banking">
          <a href="<?= site_url('deposits') ?>" class="flex items-center gap-1 px-4 py-5 font-medium transition-colors tap-target nav-link" aria-haspopup="true" aria-expanded="false">
            Banking <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50" aria-hidden="true"></i>
          </a>
          <div data-dropdown="banking" class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50" style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 500px;">
            <div class="p-5">
              <div class="mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider mb-2 px-2" style="color: hsl(var(--muted-foreground));">Deposits</h3>
                <div class="grid grid-cols-2 gap-1">
                  <a href="<?= site_url('deposits/savings-current') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Savings Account</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Zero balance &amp; regular</span></a>
                  <a href="<?= site_url('deposits/savings-current') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Current Account</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">For businesses</span></a>
                  <a href="<?= site_url('deposits/products') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Fixed / Recurring Deposit</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Attractive rates</span></a>
                  <a href="<?= site_url('deposits/interest-rates') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Deposit Rates</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Current interest rates</span></a>
                </div>
              </div>
              <div>
                <h3 class="text-xs font-bold uppercase tracking-wider mb-2 px-2" style="color: hsl(var(--muted-foreground));">Loans</h3>
                <div class="grid grid-cols-2 gap-1">
                  <a href="<?= site_url('loans/products') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Vehicle Loan</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Personal &amp; commercial</span></a>
                  <a href="<?= site_url('loans/products') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Gold Loan</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Quick &amp; secure</span></a>
                  <a href="<?= site_url('loans/products') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Business Loan</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">MSME &amp; working capital</span></a>
                  <a href="<?= site_url('loans/products') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Agri Finance</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">KCC &amp; crop loans</span></a>
                  <a href="<?= site_url('loans/interest-rates') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Loan Rates</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Current interest rates</span></a>
                  <a href="<?= site_url('loans/emi-calculator') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">EMI Calculator</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Plan your repayments</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="relative" data-mega-menu="services">
          <a href="<?= site_url('services') ?>" class="flex items-center gap-1 px-4 py-5 font-medium transition-colors tap-target nav-link" aria-haspopup="true" aria-expanded="false">
            Services <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50" aria-hidden="true"></i>
          </a>
          <div data-dropdown="services" class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50" style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 480px;">
            <div class="p-5">
              <div class="mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider mb-2 px-2" style="color: hsl(var(--muted-foreground));">Digital</h3>
                <div class="grid grid-cols-2 gap-1">
                  <a href="<?= site_url('digital/mobile-banking') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Mobile Banking</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Bank on your phone</span></a>
                  <a href="<?= site_url('digital/upi') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">UPI Service</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Instant payments</span></a>
                  <a href="<?= site_url('digital/rtgs-neft') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">RTGS / NEFT</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Fund transfers</span></a>
                  <a href="<?= site_url('digital/atm') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">ATM Locator</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Find nearby ATMs</span></a>
                  <a href="<?= site_url('digital/ifsc-micr') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">IFSC / MICR Codes</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Branch codes</span></a>
                </div>
              </div>
              <div>
                <h3 class="text-xs font-bold uppercase tracking-wider mb-2 px-2" style="color: hsl(var(--muted-foreground));">Branch</h3>
                <div class="grid grid-cols-2 gap-1">
                  <a href="<?= site_url('services/lockers') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Lockers</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Safe deposit facility</span></a>
                  <a href="<?= site_url('services/insurance') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Insurance</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">PMSBY / PMJJBY</span></a>
                  <a href="<?= site_url('services/charges') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Service Charges</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Fee schedule</span></a>
                  <a href="<?= site_url('services/positive-pay') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Positive Pay</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Cheque security</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="relative" data-mega-menu="contact">
          <a href="<?= site_url('contact') ?>" class="flex items-center gap-1 px-4 py-5 font-medium transition-colors tap-target nav-link" aria-haspopup="true" aria-expanded="false">
            Contact <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-50" aria-hidden="true"></i>
          </a>
          <div data-dropdown="contact" class="hidden absolute top-full left-1/2 -translate-x-1/2 rounded-lg shadow-xl border animate-fade-in z-50" style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); min-width: 320px;">
            <div class="p-5">
              <div class="grid grid-cols-1 gap-1">
                <a href="<?= site_url('contact') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Contact Us</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Reach our team</span></a>
                <a href="<?= site_url('about/branches') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Branch / ATM Locator</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Find locations</span></a>
                <a href="<?= site_url('complaints') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Lodge Complaint</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Submit a grievance</span></a>
                <a href="<?= site_url('complaints/escalation') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Escalation Matrix</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Complaint escalation</span></a>
                <a href="<?= site_url('faq') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">FAQs</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Common questions</span></a>
                <a href="<?= site_url('downloads') ?>" class="flex flex-col px-3 py-2.5 rounded-md transition-colors tap-target dropdown-item"><span class="font-medium text-sm">Downloads</span><span class="text-xs" style="color: hsl(var(--muted-foreground));">Forms &amp; policies</span></a>
              </div>
            </div>
          </div>
        </div>
      </nav>

       <div class="flex items-center gap-2">
        <button id="search-btn" class="tap-target p-2 rounded-md transition-colors hover-bg-muted" aria-label="Search">
          <i data-lucide="search" class="w-5 h-5"></i>
        </button>

        <a href="<?= site_url($siteSettings['digital_banking_link']) ?>" class="hidden sm:flex btn-accent rounded-md text-sm py-2 px-4 items-center gap-1.5 no-highlight">
          <i data-lucide="smartphone" class="w-4 h-4" aria-hidden="true"></i>
          <?= esc($siteSettings['digital_banking_button_text']) ?>
        </a>

        <button id="mobile-menu-btn" class="lg:hidden tap-target p-2 rounded-md transition-colors hover-bg-muted" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
          <i id="mobile-menu-icon" data-lucide="menu" class="w-6 h-6"></i>
        </button>
      </div>
    </div>

    <div id="search-bar" class="hidden pb-4 animate-fade-in">
      <form action="<?= site_url('search') ?>" method="get" role="search" class="relative">
        <label for="global-search" class="sr-only">Search the website</label>
        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 pointer-events-none" style="color: hsl(var(--muted-foreground));" aria-hidden="true"></i>
        <input id="global-search" type="search" name="q" placeholder="Search products, forms, rates, branches, FAQs..." maxlength="200" class="w-full pl-12 pr-4 py-3 rounded-lg border text-base focus:outline-none focus:ring-2" style="background-color: hsl(var(--background)); border-color: hsl(var(--border)); color: hsl(var(--foreground));" autocomplete="off">
      </form>
    </div>
  </div>

  <nav id="mobile-menu" class="hidden lg:hidden border-t animate-fade-in max-h-[70vh] overflow-y-auto" style="background-color: hsl(var(--card)); border-color: hsl(var(--border));" aria-label="Mobile navigation">
    <div class="container-bank py-3">
      <div class="flex flex-wrap gap-2 mb-3 pb-3 border-b" style="border-color: hsl(var(--border));">
        <a href="<?= site_url($siteSettings['locate_branch_link']) ?>" class="flex items-center gap-1.5 text-sm font-medium px-3 py-2 rounded-md" style="color: hsl(var(--muted-foreground)); background-color: hsl(var(--muted));">
          <i data-lucide="map-pin" class="w-4 h-4" aria-hidden="true"></i>Locate Branch
        </a>
        <a href="<?= site_url($siteSettings['block_card_link']) ?>" class="flex items-center gap-1.5 text-sm font-medium px-3 py-2 rounded-md" style="color: hsl(var(--destructive)); background-color: hsl(var(--destructive) / 0.1);">
          <i data-lucide="credit-card" class="w-4 h-4" aria-hidden="true"></i>Block Card
        </a>
        <a href="<?= site_url($siteSettings['lodge_complaint_link']) ?>" class="flex items-center gap-1.5 text-sm font-medium px-3 py-2 rounded-md" style="color: hsl(var(--destructive)); background-color: hsl(var(--destructive) / 0.1);">
          <i data-lucide="alert-triangle" class="w-4 h-4" aria-hidden="true"></i>Complaint
        </a>
      </div>

      <div class="border-b" style="border-color: hsl(var(--border));">
        <a href="<?= site_url('/') ?>" class="block py-3 px-2 font-medium tap-target" style="color: hsl(var(--foreground));">Home</a>
      </div>

      <div class="border-b" style="border-color: hsl(var(--border));">
        <button data-mobile-submenu-btn="about" class="w-full flex items-center justify-between py-3 px-2 font-medium tap-target" style="color: hsl(var(--foreground));" aria-expanded="false">
          About <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
        </button>
        <div id="mobile-sub-about" class="hidden pb-3 pl-4 animate-fade-in" data-mobile-sub>
          <a href="<?= site_url('about') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">About the Bank</a>
          <a href="<?= site_url('about/board') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Board of Directors</a>
          <a href="<?= site_url('about/management') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Management</a>
          <a href="<?= site_url('about/awards') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Awards &amp; Recognition</a>
          <a href="<?= site_url('about/gallery') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Gallery</a>
          <a href="<?= site_url('about/branches') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Branches</a>
        </div>
      </div>

      <div class="border-b" style="border-color: hsl(var(--border));">
        <button data-mobile-submenu-btn="banking" class="w-full flex items-center justify-between py-3 px-2 font-medium tap-target" style="color: hsl(var(--foreground));" aria-expanded="false">
          Banking <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
        </button>
        <div id="mobile-sub-banking" class="hidden pb-3 pl-4 animate-fade-in" data-mobile-sub>
          <a href="<?= site_url('deposits/savings-current') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Savings Account</a>
          <a href="<?= site_url('deposits/products') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Fixed Deposit</a>
          <a href="<?= site_url('loans/products') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Vehicle Loan</a>
          <a href="<?= site_url('loans/products') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Gold Loan</a>
          <a href="<?= site_url('loans/products') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Agri Finance</a>
          <a href="<?= site_url('loans/emi-calculator') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">EMI Calculator</a>
        </div>
      </div>

      <div class="border-b" style="border-color: hsl(var(--border));">
        <button data-mobile-submenu-btn="services" class="w-full flex items-center justify-between py-3 px-2 font-medium tap-target" style="color: hsl(var(--foreground));" aria-expanded="false">
          Services <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
        </button>
        <div id="mobile-sub-services" class="hidden pb-3 pl-4 animate-fade-in" data-mobile-sub>
          <a href="<?= site_url('digital/mobile-banking') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Mobile Banking</a>
          <a href="<?= site_url('digital/upi') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">UPI Service</a>
          <a href="<?= site_url('digital/rtgs-neft') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">RTGS / NEFT</a>
          <a href="<?= site_url('services/lockers') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Lockers</a>
          <a href="<?= site_url('services/charges') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Service Charges</a>
        </div>
      </div>

      <div class="border-b" style="border-color: hsl(var(--border));">
        <button data-mobile-submenu-btn="contact" class="w-full flex items-center justify-between py-3 px-2 font-medium tap-target" style="color: hsl(var(--foreground));" aria-expanded="false">
          Contact <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
        </button>
        <div id="mobile-sub-contact" class="hidden pb-3 pl-4 animate-fade-in" data-mobile-sub>
          <a href="<?= site_url('contact') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Contact Us</a>
          <a href="<?= site_url('about/branches') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Branch / ATM Locator</a>
          <a href="<?= site_url('complaints') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Lodge Complaint</a>
          <a href="<?= site_url('faq') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">FAQs</a>
          <a href="<?= site_url('downloads') ?>" class="block py-2 px-2 text-sm transition-colors mobile-sub-link">Downloads</a>
        </div>
      </div>

      <a href="<?= site_url($siteSettings['digital_banking_link']) ?>" class="btn-accent text-center mt-4 block w-full">
        <i data-lucide="smartphone" class="w-4 h-4 inline mr-2" aria-hidden="true"></i><?= esc($siteSettings['digital_banking_button_text']) ?>
      </a>
    </div>
  </nav>
</header>

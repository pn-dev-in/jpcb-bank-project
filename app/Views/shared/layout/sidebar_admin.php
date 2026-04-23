<?php
$uriPath = trim((string) service('uri')->getPath(), '/');
if (str_starts_with($uriPath, 'index.php/')) {
    $uriPath = substr($uriPath, 10);
}
$isActive = static function (string $path) use ($uriPath): bool {
    $path = trim($path, '/');
    return $uriPath === $path || str_starts_with($uriPath, $path . '/');
};

$userName = session()->get('admin_name') ?? session()->get('name') ?? 'Admin';
$profileImage = session()->get('profile_image');
$gender = strtolower((string) session()->get('gender'));
$gender = ($gender === 'female') ? 'female' : 'male';

$adminImageToShow = null;
if (!empty($profileImage)) {
    $profileFile = FCPATH . 'uploads/profile/' . basename((string) $profileImage);
    if (is_file($profileFile)) {
        $adminImageToShow = base_url('uploads/profile/' . basename((string) $profileImage));
    }
}
if ($adminImageToShow === null) {
    $adminImageToShow = $gender === 'male'
        ? base_url('admin-assets/images/users/avatar-2.jpg')
        : base_url('admin-assets/images/users/avatar-3.jpg');
}
?>

<div class="sidenav-menu">
    <div class="logo-box px-3 py-3">

    <a href="<?= base_url('admin/dashboard') ?>" class="d-block text-center">

        <img src="<?= base_url('assets/images/logo-tree.png') ?>" 
             alt="JPCB Logo"
             style="width: 100%; max-height: 70px; object-fit: contain;">

    </a>

</div>

    <div data-simplebar>
        <div class="sidenav-user">
            <div class="text-center px-3 py-2">
                <img src="<?= esc($adminImageToShow) ?>" width="46" height="46" class="rounded-circle object-fit-cover" alt="user-image">
                <div class="mt-2">
                    <span class="mb-0 fw-semibold lh-base fs-15 d-block"><?= esc($userName) ?></span>
                    <p class="my-0 fs-13 text-muted">Administrator</p>
                </div>
            </div>
        </div>

        <ul class="side-nav">
            <!-- Dashboard -->
            <li class="side-nav-item">
                <a href="<?= base_url('admin/dashboard') ?>" class="side-nav-link <?= $isActive('admin/dashboard') ? 'active' : '' ?>">
                    <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <!-- Website Content -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarWebsite" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-world"></i></span>
                    <span class="menu-text">Home Page Content</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarWebsite">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/homepage') ?>" class="side-nav-link <?= $isActive('admin/homepage') ? 'active' : '' ?>">
                                Hero Content
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/notices') ?>" class="side-nav-link <?= $isActive('admin/notices') ? 'active' : '' ?>">
                                Notices
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/products') ?>" class="side-nav-link <?= $isActive('admin/products') ? 'active' : '' ?>">
                                Products & Services
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/ticker') ?>" class="side-nav-link <?= $isActive('admin/ticker') ? 'active' : '' ?>">
                                Ticker Messages
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/quick-actions') ?>" class="side-nav-link <?= $isActive('admin/quick-actions') ? 'active' : '' ?>">
                                Quick Actions
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/safety-section/edit') ?>" class="side-nav-link <?= $isActive('admin/safety-section/edit') ? 'active' : '' ?>">
                                Safety Section
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/grievance-steps') ?>" class="side-nav-link <?= $isActive('admin/grievance-steps') ? 'active' : '' ?>">
                                Grievance Steps
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/trust-stats') ?>" class="side-nav-link <?= $isActive('admin/trust-stats') ? 'active' : '' ?>">
                                Trust Stat
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- About Section -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarAbout" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-info-circle"></i></span>
                    <span class="menu-text">About Section</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarAbout">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/about-stats') ?>" class="side-nav-link <?= $isActive('admin/about-stats') ? 'active' : '' ?>">
                                About Stats
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/about-values') ?>" class="side-nav-link <?= $isActive('admin/about-values') ? 'active' : '' ?>">
                                Core Values
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/about-milestones') ?>" class="side-nav-link <?= $isActive('admin/about-milestones') ? 'active' : '' ?>">
                                Milestones
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/board-members') ?>" class="side-nav-link <?= $isActive('admin/board-members') ? 'active' : '' ?>">
                                Board Members
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/management-team') ?>" class="side-nav-link <?= $isActive('admin/management-team') ? 'active' : '' ?>">
                                Management Team
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/awards') ?>" class="side-nav-link <?= $isActive('admin/awards') ? 'active' : '' ?>">
                                Awards
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/gallery-categories') ?>" class="side-nav-link <?= $isActive('admin/gallery-categories') ? 'active' : '' ?>">
                                Gallery Categories
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/gallery-items') ?>" class="side-nav-link <?= $isActive('admin/gallery-items') ? 'active' : '' ?>">
                                Gallery Items
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Deposits Section -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDeposits" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-building-bank"></i></span>
                    <span class="menu-text">Deposits Section</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarDeposits">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/deposit-settings/edit') ?>" class="side-nav-link <?= $isActive('admin/deposit-settings/edit') ? 'active' : '' ?>">
                                Deposit Settings
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/deposit-cards') ?>" class="side-nav-link <?= $isActive('admin/deposit-cards') ? 'active' : '' ?>">
                                Deposit Cards
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/deposit-quick-links') ?>" class="side-nav-link <?= $isActive('admin/deposit-quick-links') ? 'active' : '' ?>">
                                Quick Links
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/deposit-products') ?>" class="side-nav-link <?= $isActive('admin/deposit-products') ? 'active' : '' ?>">
                                Deposit Products
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/deposit-interest-rates') ?>" class="side-nav-link <?= $isActive('admin/deposit-interest-rates') ? 'active' : '' ?>">
                                Interest Rates
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/savings-accounts') ?>" class="side-nav-link <?= $isActive('admin/savings-accounts') ? 'active' : '' ?>">
                                Savings Accounts
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/current-accounts') ?>" class="side-nav-link <?= $isActive('admin/current-accounts') ? 'active' : '' ?>">
                                Current Accounts
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/dicgc-faqs') ?>" class="side-nav-link <?= $isActive('admin/dicgc-faqs') ? 'active' : '' ?>">
                                DICGC FAQs
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/deaf-steps') ?>" class="side-nav-link <?= $isActive('admin/deaf-steps') ? 'active' : '' ?>">
                                DEAF Steps
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Loans Section -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLoans" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-cash"></i></span>
                    <span class="menu-text">Loans Section</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarLoans">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/loan-cards') ?>" class="side-nav-link <?= $isActive('admin/loan-cards') ? 'active' : '' ?>">
                                Loan Cards
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/loan-products') ?>" class="side-nav-link <?= $isActive('admin/loan-products') ? 'active' : '' ?>">
                                Loan Products
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/loan-interest-rates') ?>" class="side-nav-link <?= $isActive('admin/loan-interest-rates') ? 'active' : '' ?>">
                                Loan Interest Rates
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Services Section -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarServices" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-tools"></i></span>
                    <span class="menu-text">Services Section</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarServices">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/service-settings/edit') ?>" class="side-nav-link <?= $isActive('admin/service-settings/edit') ? 'active' : '' ?>">
                                Service Settings
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/service-cards') ?>" class="side-nav-link <?= $isActive('admin/service-cards') ? 'active' : '' ?>">
                                Service Cards
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/service-charges') ?>" class="side-nav-link <?= $isActive('admin/service-charges') ? 'active' : '' ?>">
                                Service Charges
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/insurance-products') ?>" class="side-nav-link <?= $isActive('admin/insurance-products') ? 'active' : '' ?>">
                                Insurance Products
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/locker-sizes') ?>" class="side-nav-link <?= $isActive('admin/locker-sizes') ? 'active' : '' ?>">
                                Locker Sizes
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/locker-faqs') ?>" class="side-nav-link <?= $isActive('admin/locker-faqs') ? 'active' : '' ?>">
                                Locker FAQs
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Digital Banking Section -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDigital" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-device-mobile"></i></span>
                    <span class="menu-text">Digital Banking Section</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarDigital">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/digital-settings/edit') ?>" class="side-nav-link <?= $isActive('admin/digital-settings/edit') ? 'active' : '' ?>">
                                Digital Settings
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/digital-services') ?>" class="side-nav-link <?= $isActive('admin/digital-services') ? 'active' : '' ?>">
                                Digital Services
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/mobile-features') ?>" class="side-nav-link <?= $isActive('admin/mobile-features') ? 'active' : '' ?>">
                                Mobile App Features
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/mobile-registration-steps') ?>" class="side-nav-link <?= $isActive('admin/mobile-registration-steps') ? 'active' : '' ?>">
                                Mobile Registration Steps
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/mobile-faqs') ?>" class="side-nav-link <?= $isActive('admin/mobile-faqs') ? 'active' : '' ?>">
                                Mobile FAQs
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/atm-locations') ?>" class="side-nav-link <?= $isActive('admin/atm-locations') ? 'active' : '' ?>">
                                ATM Locations
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/block-card-methods') ?>" class="side-nav-link <?= $isActive('admin/block-card-methods') ? 'active' : '' ?>">
                                Block Card Methods
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/block-card-after-steps') ?>" class="side-nav-link <?= $isActive('admin/block-card-after-steps') ? 'active' : '' ?>">
                                After‑Block Steps
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/upi-benefits') ?>" class="side-nav-link <?= $isActive('admin/upi-benefits') ? 'active' : '' ?>">
                                UPI Benefits
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/upi-safety-tips') ?>" class="side-nav-link <?= $isActive('admin/upi-safety-tips') ? 'active' : '' ?>">
                                UPI Safety Tips
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/upi-linking-steps') ?>" class="side-nav-link <?= $isActive('admin/upi-linking-steps') ? 'active' : '' ?>">
                                UPI Linking Steps
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/digisaathi-categories') ?>" class="side-nav-link <?= $isActive('admin/digisaathi-categories') ? 'active' : '' ?>">
                                DigiSaathi Categories
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/digisaathi-contacts') ?>" class="side-nav-link <?= $isActive('admin/digisaathi-contacts') ? 'active' : '' ?>">
                                DigiSaathi Contacts
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Downloads Section -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDownloads" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-download"></i></span>
                    <span class="menu-text">Downloads Section</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarDownloads">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/downloads') ?>" class="side-nav-link <?= $isActive('admin/downloads') ? 'active' : '' ?>">
                                All Documents
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Complaints Section -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarComplaints" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-alert-circle"></i></span>
                    <span class="menu-text">Complaints Section</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarComplaints">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/complaint-escalation-levels') ?>" class="side-nav-link <?= $isActive('admin/complaint-escalation-levels') ? 'active' : '' ?>">
                                Escalation Levels
                            </a>
                        </li>
                        <li class="side-nav-item">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/complaint-categories') ?>" class="side-nav-link <?= $isActive('admin/complaint-categories') ? 'active' : '' ?>">
                                Complaint Categories
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- RBI Awareness -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarRbi" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-shield"></i></span>
                    <span class="menu-text">RBI Awareness</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarRbi">
                    <ul class="sub-menu">
                        <li class="side-nav-item">

                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/rbi-settings/edit') ?>" class="side-nav-link <?= $isActive('admin/rbi-settings/edit') ? 'active' : '' ?>">
                                RBI Settings
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/rbi-topics') ?>" class="side-nav-link <?= $isActive('admin/rbi-topics') ? 'active' : '' ?>">
                                RBI Topics
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/rbi-fair-practice-principles') ?>" class="side-nav-link <?= $isActive('admin/rbi-fair-practice-principles') ? 'active' : '' ?>">
                                Fair Practice Principles
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/rbi-dos') ?>" class="side-nav-link <?= $isActive('admin/rbi-dos') ? 'active' : '' ?>">
                                Do's
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/rbi-donts') ?>" class="side-nav-link <?= $isActive('admin/rbi-donts') ? 'active' : '' ?>">
                                Don'ts
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/rbi-ombudsman-reasons') ?>" class="side-nav-link <?= $isActive('admin/rbi-ombudsman-reasons') ? 'active' : '' ?>">
                                Ombudsman Reasons
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/rbi-booklet-topics') ?>" class="side-nav-link <?= $isActive('admin/rbi-booklet-topics') ? 'active' : '' ?>">
                                Booklet Topics
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/rbi-integrated-steps') ?>" class="side-nav-link <?= $isActive('admin/rbi-integrated-steps') ? 'active' : '' ?>">
                                Integrated Ombudsman Steps
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Utility Pages -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarUtility" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-file"></i></span>
                    <span class="menu-text">Utility Pages</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarUtility">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/faq-categories') ?>" class="side-nav-link <?= $isActive('admin/faq-categories') ? 'active' : '' ?>">
                                FAQ Categories
                            </a>
                        <li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/faqs') ?>" class="side-nav-link <?= $isActive('admin/faqs') ? 'active' : '' ?>">
                                FAQs
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/accessibility-features') ?>" class="side-nav-link <?= $isActive('admin/accessibility-features') ? 'active' : '' ?>">
                                Accessibility Features
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/privacy-policy-sections') ?>" class="side-nav-link <?= $isActive('admin/privacy-policy-sections') ? 'active' : '' ?>">
                                Privacy Policy Sections
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/sitemap-sections') ?>" class="side-nav-link <?= $isActive('admin/sitemap-sections') ? 'active' : '' ?>">
                                Sitemap Sections
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/sitemap-links') ?>" class="side-nav-link <?= $isActive('admin/sitemap-links') ? 'active' : '' ?>">
                                Sitemap Links
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Operations -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarOperations" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-briefcase"></i></span>
                    <span class="menu-text">Operations</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarOperations">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/branches') ?>" class="side-nav-link <?= $isActive('admin/branches') ? 'active' : '' ?>">
                                Branches
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/complaints') ?>" class="side-nav-link <?= $isActive('admin/complaints') ? 'active' : '' ?>">
                                Complaints
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/careers') ?>" class="side-nav-link <?= $isActive('admin/careers') ? 'active' : '' ?>">
                                Careers
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Users Management -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarUsers" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-users"></i></span>
                    <span class="menu-text">Users Management</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarUsers">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/users') ?>" class="side-nav-link <?= $isActive('admin/users') ? 'active' : '' ?>">
                                Users
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/roles') ?>" class="side-nav-link <?= $isActive('admin/roles') ? 'active' : '' ?>">
                                Roles & Permissions
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Settings -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSettings" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-settings"></i></span>
                    <span class="menu-text">Settings</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSettings">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/settings/edit') ?>" class="side-nav-link <?= $isActive('admin/settings/edit') ? 'active' : '' ?>">
                                General Settings
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/social-links') ?>" class="side-nav-link <?= $isActive('admin/social-links') ? 'active' : '' ?>">
                                Social Links
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="<?= base_url('admin/logs') ?>" class="side-nav-link <?= $isActive('admin/logs') ? 'active' : '' ?>">
                                Activity Logs
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="#" class="side-nav-link <?= $isActive('admin/security') ? 'active' : '' ?>">
                                Security
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Logout -->
            <li class="side-nav-item">
                <a href="<?= base_url('admin/logout') ?>" class="side-nav-link text-danger">
                    <span class="menu-icon"><i class="ti ti-logout"></i></span>
                    <span class="menu-text">Logout</span>
                </a>
            </li>
        </ul>

        <div class="help-box text-center">
            <h5 class="fw-semibold fs-16">JPCB Bank</h5>
            <p class="mb-3 text-muted">Admin panel for content and complaint management.</p>
        </div>

        <div class="clearfix"></div>
    </div>
</div>
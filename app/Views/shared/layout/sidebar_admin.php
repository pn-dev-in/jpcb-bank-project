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
    // Check if profile_image contains a full relative path (e.g., 'uploads/profile/xxx.jpg')
    $fullPath = FCPATH . $profileImage;
    if (is_file($fullPath)) {
        $adminImageToShow = base_url($profileImage);
    } else {
        // Backward compatibility: if stored as just a filename (old way)
        $legacyPath = FCPATH . 'uploads/profile/' . basename((string) $profileImage);
        if (is_file($legacyPath)) {
            $adminImageToShow = base_url('uploads/profile/' . basename((string) $profileImage));
        }
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
            <img src="<?= base_url('assets/images/logo-tree.png') ?>" alt="JPCB Logo"
                style="width: 100%; max-height: 70px; object-fit: contain;">
        </a>
    </div>

    <div data-simplebar>
        <div class="sidenav-user">
            <div class="text-center px-3 py-2">
                <img src="<?= esc($adminImageToShow) ?>" width="46" height="46" class="rounded-circle object-fit-cover"
                    alt="user-image">
                <div class="mt-2">
                    <span class="mb-0 fw-semibold lh-base fs-15 d-block"><?= esc($userName) ?></span>
                    <p class="my-0 fs-13 text-muted"><?= esc(session()->get('role_name') ?? 'User') ?></p>
                    <?php if (session()->get('employee_id')): ?>
                        <p class="my-0 fs-12 text-muted mt-1">
                            <i class="ti ti-id-badge me-1"></i> Emp ID: <?= esc(session()->get('employee_id')) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <ul class="side-nav">
            <!-- Dashboard -->
            <?php if (has_permission('dashboard.view')): ?>
                <li class="side-nav-item">
                    <a href="<?= base_url('admin/dashboard') ?>"
                        class="side-nav-link <?= $isActive('admin/dashboard') ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- ========== BRANCHES ========== -->
            <?php if (has_permission('branches.view')): ?>
                <li class="side-nav-item">
                    <a href="<?= base_url('admin/branches') ?>"
                        class="side-nav-link <?= $isActive('admin/branches') ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="ti ti-building"></i></span>
                        <span class="menu-text">Branches</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- ========== COMPLAINTS ========== -->
            <?php if (has_permission('complaints.view')): ?>
                <li class="side-nav-item">
                    <a href="<?= base_url('admin/complaints') ?>"
                        class="side-nav-link <?= $isActive('admin/complaints') ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="ti ti-alert-triangle"></i></span>
                        <span class="menu-text">Complaints</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- ========== CAREERS ========== -->
            <?php if (has_permission('careers.view')): ?>
                <li class="side-nav-item">
                    <a href="<?= base_url('admin/careers') ?>"
                        class="side-nav-link <?= $isActive('admin/careers') ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="ti ti-briefcase"></i></span>
                        <span class="menu-text">Careers</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Website Content (Home Page Content) -->
            <?php if (has_any_permission(['homepage.view', 'notices.view', 'products.view', 'ticker.view', 'quick_actions.view', 'safety_section.view', 'grievance_steps.view', 'trust_stats.view', 'alert_banners.view', 'home_sliders.view', 'whats_new.view', 'apply_panel.view'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarWebsite" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-world"></i></span>
                        <span class="menu-text">Home Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarWebsite">
                        <ul class="sub-menu">

                            <!-- Hero Content -->
                            <?php if (has_permission('homepage.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/homepage') ?>"
                                        class="side-nav-link <?= $isActive('admin/homepage') ? 'active' : '' ?>">
                                        <i class="ti ti-crown"></i> Hero Content
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Notices -->
                            <?php if (has_permission('notices.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/notices') ?>"
                                        class="side-nav-link <?= $isActive('admin/notices') ? 'active' : '' ?>">
                                        <i class="ti ti-bell"></i> Notices
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Products & Services -->
                            <?php if (has_permission('products.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/products') ?>"
                                        class="side-nav-link <?= $isActive('admin/products') ? 'active' : '' ?>">
                                        <i class="ti ti-package"></i> Products & Services
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- What's New Ticker -->
                            <?php if (has_permission('ticker.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/ticker') ?>"
                                        class="side-nav-link <?= $isActive('admin/ticker') ? 'active' : '' ?>">
                                        <i class="ti ti-news"></i> What's New Ticker
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Apply Now Panel -->
                            <?php if (has_permission('apply_panel.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/apply-panel') ?>"
                                        class="side-nav-link <?= $isActive('admin/apply-panel') ? 'active' : '' ?>">
                                        <i class="ti ti-rocket"></i> Apply Now Panel
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Quick Actions -->
                            <?php if (has_permission('quick_actions.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/quick-actions') ?>"
                                        class="side-nav-link <?= $isActive('admin/quick-actions') ? 'active' : '' ?>">
                                        <i class="ti ti-bolt"></i> Quick Actions
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Safety Section -->
                            <?php if (has_permission('safety_section.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/safety-section/edit') ?>"
                                        class="side-nav-link <?= $isActive('admin/safety-section/edit') ? 'active' : '' ?>">
                                        <i class="ti ti-shield"></i> Safety Section
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Grievance Steps -->
                            <?php if (has_permission('grievance_steps.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/grievance-steps') ?>"
                                        class="side-nav-link <?= $isActive('admin/grievance-steps') ? 'active' : '' ?>">
                                        <i class="ti ti-list-numbers"></i> Grievance Steps
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Trust Stat -->
                            <?php if (has_permission('trust_stats.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/trust-stats') ?>"
                                        class="side-nav-link <?= $isActive('admin/trust-stats') ? 'active' : '' ?>">
                                        <i class="ti ti-chart-pie"></i> Trust Stat
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Alert Banners -->
                            <?php if (has_permission('alert_banners.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/alert-banner') ?>"
                                        class="side-nav-link <?= $isActive('admin/alert-banner') ? 'active' : '' ?>">
                                        <i class="ti ti-alert-circle"></i> Alert Banners
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Home Sliders -->
                            <?php if (has_permission('home_sliders.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/home-sliders') ?>"
                                        class="side-nav-link <?= $isActive('admin/home-sliders') ? 'active' : '' ?>">
                                        <i class="ti ti-slideshow"></i> Home Sliders
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- What's New (Popups) - Commented as per original -->
                            <!--
                <?php if (has_permission('whats_new.view')): ?>
                    <li class="side-nav-item">
                        <a href="<?= base_url('admin/whats-new') ?>" class="side-nav-link <?= $isActive('admin/whats-new') ? 'active' : '' ?>">
                            <i class="ti ti-popup"></i> What's New (Popups)
                        </a>
                    </li>
                <?php endif; ?>
                -->

                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <!-- About Section -->
            <?php if (has_any_permission(['about_page_content.view', 'about_stats.view', 'about_values.view', 'about_milestones.view', 'board_members.view', 'management_team.view', 'awards.view', 'gallery_categories.view', 'gallery_items.view', 'about_heritage.view'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarAbout" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-info-circle"></i></span>
                        <span class="menu-text">About Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAbout">
                        <ul class="sub-menu">

                            <!-- About Settings -->
                            <?php if (has_permission('about_page_content.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/about-page-content/edit') ?>"
                                        class="side-nav-link <?= $isActive('admin/about-page-content') ? 'active' : '' ?>">
                                        <i class="ti ti-settings"></i> About Settings
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- About Stats -->
                            <?php if (has_permission('about_stats.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/about-stats') ?>"
                                        class="side-nav-link <?= $isActive('admin/about-stats') ? 'active' : '' ?>">
                                        <i class="ti ti-chart-bar"></i> About Stats
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Core Values -->
                            <?php if (has_permission('about_values.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/about-values') ?>"
                                        class="side-nav-link <?= $isActive('admin/about-values') ? 'active' : '' ?>">
                                        <i class="ti ti-heart"></i> Core Values
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- About Heritage (Bodhi Tree) -->
<?php if (has_permission('about_heritage.view')): ?>
    <li class="side-nav-item">
        <a href="<?= base_url('admin/about-heritage') ?>" class="side-nav-link <?= $isActive('admin/about-heritage') ? 'active' : '' ?>">
            <i class="ti ti-tree"></i>Heritage & Legacy
        </a>
    </li>
<?php endif; ?>

                            <!-- Milestones -->
                            <?php if (has_permission('about_milestones.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/about-milestones') ?>"
                                        class="side-nav-link <?= $isActive('admin/about-milestones') ? 'active' : '' ?>">
                                        <i class="ti ti-flag"></i> Milestones
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Board Members -->
                            <?php if (has_permission('board_members.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/board-members') ?>"
                                        class="side-nav-link <?= $isActive('admin/board-members') ? 'active' : '' ?>">
                                        <i class="ti ti-users"></i> Board Members
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Management Team -->
                            <?php if (has_permission('management_team.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/management-team') ?>"
                                        class="side-nav-link <?= $isActive('admin/management-team') ? 'active' : '' ?>">
                                        <i class="ti ti-briefcase"></i> Management Team
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Awards -->
                            <?php if (has_permission('awards.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/awards') ?>"
                                        class="side-nav-link <?= $isActive('admin/awards') ? 'active' : '' ?>">
                                        <i class="ti ti-trophy"></i> Awards
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Gallery Categories -->
                            <?php if (has_permission('gallery_categories.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/gallery-categories') ?>"
                                        class="side-nav-link <?= $isActive('admin/gallery-categories') ? 'active' : '' ?>">
                                        <i class="ti ti-folder"></i> Gallery Categories
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Gallery Items -->
                            <?php if (has_permission('gallery_items.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/gallery-items') ?>"
                                        class="side-nav-link <?= $isActive('admin/gallery-items') ? 'active' : '' ?>">
                                        <i class="ti ti-photo"></i> Gallery Items
                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <!-- Deposits Section -->
            <?php if (has_any_permission(['deposit_settings.view', 'deposit_cards.view', 'deposit_quick_links.view', 'deposit_products.view', 'deposit_interest_rates.view', 'savings_accounts.view', 'current_accounts.view', 'elite_accounts.view', 'dicgc_faqs.view', 'deaf_steps.view', 'deaf_deposits.view'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarDeposits" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-building-bank"></i></span>
                        <span class="menu-text">Deposits Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarDeposits">
                        <ul class="sub-menu">

                            <!-- Deposit Settings -->
                            <?php if (has_permission('deposit_settings.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/deposit-settings/edit') ?>"
                                        class="side-nav-link <?= $isActive('admin/deposit-settings/edit') ? 'active' : '' ?>">
                                        <i class="ti ti-settings"></i> Deposit Settings
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Deposit Cards -->
                            <?php if (has_permission('deposit_cards.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/deposit-cards') ?>"
                                        class="side-nav-link <?= $isActive('admin/deposit-cards') ? 'active' : '' ?>">
                                        <i class="ti ti-cards"></i> Deposit Cards
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Quick Links -->
                            <?php if (has_permission('deposit_quick_links.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/deposit-quick-links') ?>"
                                        class="side-nav-link <?= $isActive('admin/deposit-quick-links') ? 'active' : '' ?>">
                                        <i class="ti ti-link"></i> Quick Links
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Deposit Products -->
                            <?php if (has_permission('deposit_products.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/deposit-products') ?>"
                                        class="side-nav-link <?= $isActive('admin/deposit-products') ? 'active' : '' ?>">
                                        <i class="ti ti-package"></i> Deposit Products
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Interest Rates -->
                            <?php if (has_permission('deposit_interest_rates.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/deposit-interest-rates') ?>"
                                        class="side-nav-link <?= $isActive('admin/deposit-interest-rates') ? 'active' : '' ?>">
                                        <i class="ti ti-chart-line"></i> Interest Rates
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Savings Accounts -->
                            <?php if (has_permission('savings_accounts.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/savings-accounts') ?>"
                                        class="side-nav-link <?= $isActive('admin/savings-accounts') ? 'active' : '' ?>">
                                        <i class="ti ti-wallet"></i> Savings Accounts
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Current Accounts -->
                            <?php if (has_permission('current_accounts.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/current-accounts') ?>"
                                        class="side-nav-link <?= $isActive('admin/current-accounts') ? 'active' : '' ?>">
                                        <i class="ti ti-building"></i> Current Accounts
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Elite Accounts -->
                            <?php if (has_permission('elite_accounts.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/elite-accounts') ?>"
                                        class="side-nav-link <?= $isActive('admin/elite-accounts') ? 'active' : '' ?>">
                                        <i class="ti ti-crown"></i> Elite Accounts
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- DICGC FAQs -->
                            <?php if (has_permission('dicgc_faqs.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/dicgc-faqs') ?>"
                                        class="side-nav-link <?= $isActive('admin/dicgc-faqs') ? 'active' : '' ?>">
                                        <i class="ti ti-help"></i> DICGC FAQs
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- DEAF Deposits -->
                            <?php if (has_permission('deaf_deposits.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/deaf-deposits') ?>"
                                        class="side-nav-link <?= $isActive('admin/deaf-deposits') ? 'active' : '' ?>">
                                        <i class="ti ti-folder-search"></i> DEAF Deposits
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- DEAF Steps -->
                            <?php if (has_permission('deaf_steps.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/deaf-steps') ?>"
                                        class="side-nav-link <?= $isActive('admin/deaf-steps') ? 'active' : '' ?>">
                                        <i class="ti ti-list-details"></i> DEAF Steps
                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <!-- Loans Section -->
            <?php if (has_any_permission(['loan_cards.view', 'loan_products.view', 'loan_interest_rates.view', 'loan_schemes.view', 'loan_interest_schemes.view', 'loan_interest_notes.view'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarLoans" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-cash"></i></span>
                        <span class="menu-text">Loans Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarLoans">
                        <ul class="sub-menu">

                            <!-- Loan Cards -->
                            <?php if (has_permission('loan_cards.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/loan-cards') ?>"
                                        class="side-nav-link <?= $isActive('admin/loan-cards') ? 'active' : '' ?>">
                                        <i class="ti ti-cards"></i> Loan Cards
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Loan Schemes -->
                            <?php if (has_permission('loan_schemes.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/loan-schemes') ?>"
                                        class="side-nav-link <?= $isActive('admin/loan-schemes') ? 'active' : '' ?>">
                                        <i class="ti ti-file-description"></i> Loan Schemes
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Loan Products -->
                            <?php if (has_permission('loan_products.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/loan-products') ?>"
                                        class="side-nav-link <?= $isActive('admin/loan-products') ? 'active' : '' ?>">
                                        <i class="ti ti-package"></i> Loan Products
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Loan Interest Schemes -->
                            <?php if (has_permission('loan_interest_schemes.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/loan-interest-schemes') ?>"
                                        class="side-nav-link <?= $isActive('admin/loan-interest-schemes') ? 'active' : '' ?>">
                                        <i class="ti ti-charging-pile"></i> Loan Interest Schemes
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Loan Interest Notes -->
                            <?php if (has_permission('loan_interest_notes.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/loan-interest-notes') ?>"
                                        class="side-nav-link <?= $isActive('admin/loan-interest-notes') ? 'active' : '' ?>">
                                        <i class="ti ti-notes"></i> Loan Interest Notes
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Loan Interest Rates - Commented as per original -->
                            <!--
                <?php if (has_permission('loan_interest_rates.view')): ?>
                    <li class="side-nav-item">
                        <a href="<?= base_url('admin/loan-interest-rates') ?>" class="side-nav-link <?= $isActive('admin/loan-interest-rates') ? 'active' : '' ?>">
                            <i class="ti ti-chart-line"></i> Loan Interest Rates
                        </a>
                    </li>
                <?php endif; ?>
                -->

                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <!-- Digital Banking Section -->
            <?php if (
                has_any_permission([
                    'digital_settings.view',
                    'digital_services.view',
                    'mobile_features.view',
                    'mobile_registration_steps.view',
                    'mobile_faqs.view',
                    'atm_locations.view',
                    'block_card_methods.view',
                    'block_card_after_steps.view',
                    'upi_benefits.view',
                    'upi_safety_tips.view',
                    'upi_linking_steps.view',
                    'atm_services.view',
                    'atm_obtain_steps.view',
                    'atm_dos.view',
                    'atm_donts.view',
                    'mobile_banking_eligibility.view',
                    'atm_guidelines.view',
                    'upi_items.view',
                    'upi_transaction_limits.view',
                    'digital_transaction_limits.view'
                ])
            ): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarDigital" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-device-mobile"></i></span>
                        <span class="menu-text">Digital Payments Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarDigital">
                        <ul class="sub-menu">

                            <!-- ========== SECTION 1: GENERAL SETTINGS ========== -->
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#sidebarDigitalGeneral" aria-expanded="false"
                                    class="side-nav-link sub-trigger">
                                    <span class="menu-icon"><i class="ti ti-settings"></i></span>
                                    <span class="menu-text">General Settings</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarDigitalGeneral">
                                    <ul class="sub-menu sub-sub-menu">
                                        <?php if (has_permission('digital_settings.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/digital-settings/edit') ?>"
                                                    class="side-nav-link <?= $isActive('admin/digital-settings/edit') ? 'active' : '' ?>">
                                                    <i class="ti ti-settings"></i> Digital Settings
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('digital_services.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/digital-services') ?>"
                                                    class="side-nav-link <?= $isActive('admin/digital-services') ? 'active' : '' ?>">
                                                    <i class="ti ti-list"></i> Digital Services
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>

                            <!-- ========== SECTION 2: MOBILE BANKING ========== -->
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#sidebarDigitalMobile" aria-expanded="false"
                                    class="side-nav-link sub-trigger">
                                    <span class="menu-icon"><i class="ti ti-device-mobile"></i></span>
                                    <span class="menu-text">Mobile Banking</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarDigitalMobile">
                                    <ul class="sub-menu sub-sub-menu">
                                        <?php if (has_permission('mobile_features.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/mobile-features') ?>"
                                                    class="side-nav-link <?= $isActive('admin/mobile-features') ? 'active' : '' ?>">
                                                    <i class="ti ti-star"></i> Mobile App Features
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('mobile_registration_steps.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/mobile-registration-steps') ?>"
                                                    class="side-nav-link <?= $isActive('admin/mobile-registration-steps') ? 'active' : '' ?>">
                                                    <i class="ti ti-list-numbers"></i> Registration Steps
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('mobile_faqs.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/mobile-faqs') ?>"
                                                    class="side-nav-link <?= $isActive('admin/mobile-faqs') ? 'active' : '' ?>">
                                                    <i class="ti ti-help"></i> Mobile FAQs
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('mobile_banking_eligibility.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/mobile-banking-eligibility') ?>"
                                                    class="side-nav-link <?= $isActive('admin/mobile-banking-eligibility') ? 'active' : '' ?>">
                                                    <i class="ti ti-checklist"></i> Banking Eligibility
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>

                            <!-- ========== SECTION 3: ATM SERVICES ========== -->
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#sidebarDigitalATM" aria-expanded="false"
                                    class="side-nav-link sub-trigger">
                                    <span class="menu-icon"><i class="ti ti-credit-card"></i></span>
                                    <span class="menu-text">ATM Services</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarDigitalATM">
                                    <ul class="sub-menu sub-sub-menu">
                                        <?php if (has_permission('atm_locations.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/atm-locations') ?>"
                                                    class="side-nav-link <?= $isActive('admin/atm-locations') ? 'active' : '' ?>">
                                                    <i class="ti ti-map-pin"></i> ATM Locations
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('atm_services.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/atm-services') ?>"
                                                    class="side-nav-link <?= $isActive('admin/atm-services') ? 'active' : '' ?>">
                                                    <i class="ti ti-list"></i> ATM Services
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('atm_obtain_steps.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/atm-obtain-steps') ?>"
                                                    class="side-nav-link <?= $isActive('admin/atm-obtain-steps') ? 'active' : '' ?>">
                                                    <i class="ti ti-numbers"></i> How to Obtain
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('atm_guidelines.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/atm-guidelines') ?>"
                                                    class="side-nav-link <?= $isActive('admin/atm-guidelines') ? 'active' : '' ?>">
                                                    <i class="ti ti-file-description"></i> ATM Guidelines
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('atm_dos.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/atm-dos') ?>"
                                                    class="side-nav-link <?= $isActive('admin/atm-dos') ? 'active' : '' ?>">
                                                    <i class="ti ti-checkbox"></i> ATM Do's
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('atm_donts.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/atm-donts') ?>"
                                                    class="side-nav-link <?= $isActive('admin/atm-donts') ? 'active' : '' ?>">
                                                    <i class="ti ti-circle-x"></i> ATM Don'ts
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>

                            <!-- ========== SECTION 4: CARD MANAGEMENT ========== -->
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#sidebarDigitalCards" aria-expanded="false"
                                    class="side-nav-link sub-trigger">
                                    <span class="menu-icon"><i class="ti ti-shield-lock"></i></span>
                                    <span class="menu-text">Card Management</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarDigitalCards">
                                    <ul class="sub-menu sub-sub-menu">
                                        <?php if (has_permission('block_card_methods.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/block-card-methods') ?>"
                                                    class="side-nav-link <?= $isActive('admin/block-card-methods') ? 'active' : '' ?>">
                                                    <i class="ti ti-shield"></i> Block Card Methods
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('block_card_after_steps.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/block-card-after-steps') ?>"
                                                    class="side-nav-link <?= $isActive('admin/block-card-after-steps') ? 'active' : '' ?>">
                                                    <i class="ti ti-checklist"></i> After‑Block Steps
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>

                            <!-- ========== SECTION 5: UPI SERVICES ========== -->
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#sidebarDigitalUPI" aria-expanded="false"
                                    class="side-nav-link sub-trigger">
                                    <span class="menu-icon"><i class="ti ti-transfer"></i></span>
                                    <span class="menu-text">UPI Services</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarDigitalUPI">
                                    <ul class="sub-menu sub-sub-menu">
                                        <?php if (has_permission('upi_items.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/upi-items') ?>"
                                                    class="side-nav-link <?= $isActive('admin/upi-items') ? 'active' : '' ?>">
                                                    <i class="ti ti-components"></i> UPI Items
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('upi_benefits.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/upi-benefits') ?>"
                                                    class="side-nav-link <?= $isActive('admin/upi-benefits') ? 'active' : '' ?>">
                                                    <i class="ti ti-star"></i> UPI Benefits
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('upi_safety_tips.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/upi-safety-tips') ?>"
                                                    class="side-nav-link <?= $isActive('admin/upi-safety-tips') ? 'active' : '' ?>">
                                                    <i class="ti ti-shield"></i> UPI Safety Tips
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('upi_linking_steps.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/upi-linking-steps') ?>"
                                                    class="side-nav-link <?= $isActive('admin/upi-linking-steps') ? 'active' : '' ?>">
                                                    <i class="ti ti-link"></i> UPI Linking Steps
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (has_permission('upi_transaction_limits.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/upi-transaction-limits') ?>"
                                                    class="side-nav-link <?= $isActive('admin/upi-transaction-limits') ? 'active' : '' ?>">
                                                    <i class="ti ti-chart-bar"></i> UPI Transaction Limits
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>

                            <!-- ========== SECTION 6: TRANSACTION LIMITS ========== -->
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#sidebarDigitalLimits" aria-expanded="false"
                                    class="side-nav-link sub-trigger">
                                    <span class="menu-icon"><i class="ti ti-chart-line"></i></span>
                                    <span class="menu-text">Transaction Limits</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarDigitalLimits">
                                    <ul class="sub-menu sub-sub-menu">
                                        <?php if (has_permission('digital_transaction_limits.view')): ?>
                                            <li class="side-nav-item">
                                                <a href="<?= base_url('admin/digital-transaction-limits') ?>"
                                                    class="side-nav-link <?= url_is('admin/digital-transaction-limits*') ? 'active' : '' ?>">
                                                    <i class="ti ti-chart-line"></i> Digital Transaction Limits
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <!-- DigiSaathi Management Section -->
            <?php if (has_any_permission(['digisaathi_settings.view', 'digisaathi_categories.view', 'digisaathi_contacts.view', 'digisaathi_languages.view', 'digisaathi_services.view', 'digisaathi_support_features.view', 'digisaathi_images.view'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarDigisaathi" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-headset"></i></span>
                        <span class="menu-text">DigiSaathi Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarDigisaathi">
                        <ul class="sub-menu">

                            <!-- Settings -->
                            <?php if (has_permission('digisaathi_settings.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/digisaathi-settings') ?>"
                                        class="side-nav-link <?= $isActive('admin/digisaathi-settings') ? 'active' : '' ?>">
                                        <i class="ti ti-settings"></i> Settings
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Categories -->
                            <?php if (has_permission('digisaathi_categories.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/digisaathi-categories') ?>"
                                        class="side-nav-link <?= $isActive('admin/digisaathi-categories') ? 'active' : '' ?>">
                                        <i class="ti ti-category"></i> Categories
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Contact Methods -->
                            <?php if (has_permission('digisaathi_contacts.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/digisaathi-contacts') ?>"
                                        class="side-nav-link <?= $isActive('admin/digisaathi-contacts') ? 'active' : '' ?>">
                                        <i class="ti ti-phone-call"></i> Contact Methods
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Languages -->
                            <?php if (has_permission('digisaathi_languages.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/digisaathi-languages') ?>"
                                        class="side-nav-link <?= $isActive('admin/digisaathi-languages') ? 'active' : '' ?>">
                                        <i class="ti ti-language"></i> Languages
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Services -->
                            <?php if (has_permission('digisaathi_services.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/digisaathi-services') ?>"
                                        class="side-nav-link <?= $isActive('admin/digisaathi-services') ? 'active' : '' ?>">
                                        <i class="ti ti-server"></i> Services
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Support Features -->
                            <?php if (has_permission('digisaathi_support_features.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/digisaathi-support-features') ?>"
                                        class="side-nav-link <?= $isActive('admin/digisaathi-support-features') ? 'active' : '' ?>">
                                        <i class="ti ti-message-circle"></i> Support Features
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Image Manager -->
                            <?php if (has_permission('digisaathi_images.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/digisaathi-images') ?>"
                                        class="side-nav-link <?= $isActive('admin/digisaathi-images') ? 'active' : '' ?>">
                                        <i class="ti ti-photo"></i> Image Manager
                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <!-- Services Section -->
            <?php if (has_any_permission(['service_settings.view', 'service_cards.view', 'service_charges.view', 'insurance_products.view', 'locker_sizes.view', 'locker_faqs.view', 'insurance_plans.view', 'service_charge_items.view'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarServices" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-tools"></i></span>
                        <span class="menu-text">Services Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarServices">
                        <ul class="sub-menu">
                            <?php if (has_permission('service_settings.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/service-settings/edit') ?>"
                                        class="side-nav-link <?= $isActive('admin/service-settings/edit') ? 'active' : '' ?>">
                                        <i class="ti ti-settings"></i> Service Settings
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('service_cards.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/service-cards') ?>"
                                        class="side-nav-link <?= $isActive('admin/service-cards') ? 'active' : '' ?>">
                                        <i class="ti ti-cards"></i> Service Cards
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('service_charges.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/service-charges') ?>"
                                        class="side-nav-link <?= $isActive('admin/service-charges') ? 'active' : '' ?>">
                                        <i class="ti ti-receipt"></i> Service Charges
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('service_charge_items.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/service-charge-items') ?>"
                                        class="side-nav-link <?= $isActive('admin/service-charge-items') ? 'active' : '' ?>">
                                        <i class="ti ti-list-details"></i> Service Charge Items
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('insurance_plans.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/insurance-plans') ?>"
                                        class="side-nav-link <?= $isActive('admin/insurance-plans') ? 'active' : '' ?>">
                                        <i class="ti ti-license"></i> Insurance Plans
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('insurance_products.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/insurance-products') ?>"
                                        class="side-nav-link <?= $isActive('admin/insurance-products') ? 'active' : '' ?>">
                                        <i class="ti ti-package"></i> Insurance Products
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('locker_sizes.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/locker-sizes') ?>"
                                        class="side-nav-link <?= $isActive('admin/locker-sizes') ? 'active' : '' ?>">
                                        <i class="ti ti-dimensions"></i> Locker Sizes
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('locker_faqs.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/locker-faqs') ?>"
                                        class="side-nav-link <?= $isActive('admin/locker-faqs') ? 'active' : '' ?>">
                                        <i class="ti ti-help-circle"></i> Locker FAQs
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <!-- RBI Awareness -->
            <?php if (has_any_permission(['rbi_settings.view', 'rbi_topics.view', 'rbi_fair_practice_principles.view', 'rbi_dos.view', 'rbi_donts.view', 'rbi_ombudsman_reasons.view', 'rbi_booklet_topics.view', 'rbi_integrated_steps.view', 'rbi_ombudsman_officers.view', 'complaint_escalation_levels.view', 'complaint_categories.view'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarRbi" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-shield"></i></span>
                        <span class="menu-text">RBI Says Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarRbi">
                        <ul class="sub-menu">
                            <?php if (has_permission('rbi_settings.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/rbi-settings/edit') ?>"
                                        class="side-nav-link <?= $isActive('admin/rbi-settings/edit') ? 'active' : '' ?>">
                                        <i class="ti ti-settings"></i> RBI Settings
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('rbi_topics.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/rbi-topics') ?>"
                                        class="side-nav-link <?= $isActive('admin/rbi-topics') ? 'active' : '' ?>">
                                        <i class="ti ti-list"></i> RBI Topics
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('rbi_fair_practice_principles.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/rbi-fair-practice-principles') ?>"
                                        class="side-nav-link <?= $isActive('admin/rbi-fair-practice-principles') ? 'active' : '' ?>">
                                        <i class="ti ti-scale"></i> Fair Practice Principles
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('rbi_dos.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/rbi-dos') ?>"
                                        class="side-nav-link <?= $isActive('admin/rbi-dos') ? 'active' : '' ?>">
                                        <i class="ti ti-checkbox"></i> Do's
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('rbi_donts.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/rbi-donts') ?>"
                                        class="side-nav-link <?= $isActive('admin/rbi-donts') ? 'active' : '' ?>">
                                        <i class="ti ti-circle-x"></i> Don'ts
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('rbi_ombudsman_reasons.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/rbi-ombudsman-reasons') ?>"
                                        class="side-nav-link <?= $isActive('admin/rbi-ombudsman-reasons') ? 'active' : '' ?>">
                                        <i class="ti ti-paperclip"></i> Ombudsman Reasons
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('rbi_ombudsman_officers.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/rbi-ombudsman-officers') ?>"
                                        class="side-nav-link <?= $isActive('admin/rbi-ombudsman-officers*') ? 'active' : '' ?>">
                                        <i class="ti ti-users"></i> Ombudsman Officers
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('rbi_booklet_topics.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/rbi-booklet-topics') ?>"
                                        class="side-nav-link <?= $isActive('admin/rbi-booklet-topics') ? 'active' : '' ?>">
                                        <i class="ti ti-book"></i> Booklet Topics
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('rbi_integrated_steps.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/rbi-integrated-steps') ?>"
                                        class="side-nav-link <?= $isActive('admin/rbi-integrated-steps') ? 'active' : '' ?>">
                                        <i class="ti ti-stack-2"></i> Integrated Ombudsman Steps
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (has_permission('complaint_escalation_levels.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/complaint-escalation-levels') ?>"
                                        class="side-nav-link <?= $isActive('admin/complaint-escalation-levels') ? 'active' : '' ?>">
                                        <i class="ti ti-chart-arrows"></i> Escalation Levels
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <!-- Downloads Section -->
            <?php if (has_permission('downloads.view')): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarDownloads" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-download"></i></span>
                        <span class="menu-text">Downloads Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarDownloads">
                        <ul class="sub-menu">
                            <!-- All Documents -->
                            <li class="side-nav-item">
                                <a href="<?= base_url('admin/downloads') ?>"
                                    class="side-nav-link <?= $isActive('admin/downloads') ? 'active' : '' ?>">
                                    <i class="ti ti-files"></i> All Documents
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>


            <!-- Utility Pages -->
            <?php if (has_any_permission(['faq_categories.view', 'faqs.view', 'accessibility_features.view', 'privacy_policy_sections.view', 'sitemap_sections.view', 'sitemap_links.view'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarUtility" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-file"></i></span>
                        <span class="menu-text">Utility Pages</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarUtility">
                        <ul class="sub-menu">

                            <!-- FAQ Categories -->
                            <?php if (has_permission('faq_categories.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/faq-categories') ?>"
                                        class="side-nav-link <?= $isActive('admin/faq-categories') ? 'active' : '' ?>">
                                        <i class="ti ti-folder"></i> FAQ Categories
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- FAQs -->
                            <?php if (has_permission('faqs.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/faqs') ?>"
                                        class="side-nav-link <?= $isActive('admin/faqs') ? 'active' : '' ?>">
                                        <i class="ti ti-help"></i> FAQs
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Accessibility Features -->
                            <?php if (has_permission('accessibility_features.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/accessibility-features') ?>"
                                        class="side-nav-link <?= $isActive('admin/accessibility-features') ? 'active' : '' ?>">
                                        <i class="ti ti-wheelchair"></i> Accessibility Features
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Privacy Policy Sections -->
                            <?php if (has_permission('privacy_policy_sections.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/privacy-policy-sections') ?>"
                                        class="side-nav-link <?= $isActive('admin/privacy-policy-sections') ? 'active' : '' ?>">
                                        <i class="ti ti-lock"></i> Privacy Policy Sections
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Sitemap Sections -->
                            <?php if (has_permission('sitemap_sections.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/sitemap-sections') ?>"
                                        class="side-nav-link <?= $isActive('admin/sitemap-sections') ? 'active' : '' ?>">
                                        <i class="ti ti-sitemap"></i> Sitemap Sections
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Sitemap Links -->
                            <?php if (has_permission('sitemap_links.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/sitemap-links') ?>"
                                        class="side-nav-link <?= $isActive('admin/sitemap-links') ? 'active' : '' ?>">
                                        <i class="ti ti-link"></i> Sitemap Links
                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </div>
                </li>
            <?php endif; ?>


            <!-- Users Management -->
            <?php if (has_any_permission(['admin_users.view', 'roles_permissions.view'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarUsers" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-users"></i></span>
                        <span class="menu-text">Users Management</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarUsers">
                        <ul class="sub-menu">

                            <!-- Users -->
                            <?php if (has_permission('admin_users.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/users') ?>"
                                        class="side-nav-link <?= $isActive('admin/users') ? 'active' : '' ?>">
                                        <i class="ti ti-user"></i> Users
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Roles & Permissions -->
                            <?php if (has_permission('roles_permissions.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/roles') ?>"
                                        class="side-nav-link <?= $isActive('admin/roles') ? 'active' : '' ?>">
                                        <i class="ti ti-lock"></i> Roles & Permissions
                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <!-- Settings -->
            <?php if (has_any_permission(['general_settings.view', 'social_links.view', 'site_translations.view', 'activity_logs.view', 'support_tickets.view'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarSettings" aria-expanded="false" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-settings"></i></span>
                        <span class="menu-text">Settings</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarSettings">
                        <ul class="sub-menu">

                            <!-- General Settings -->
                            <?php if (has_permission('general_settings.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/settings/edit') ?>"
                                        class="side-nav-link <?= $isActive('admin/settings/edit') ? 'active' : '' ?>">
                                        <i class="ti ti-settings"></i> General Settings
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Social Links -->
                            <?php if (has_permission('social_links.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/social-links') ?>"
                                        class="side-nav-link <?= $isActive('admin/social-links') ? 'active' : '' ?>">
                                        <i class="ti ti-share"></i> Social Links
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Site Translations -->
                            <?php if (has_permission('site_translations.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/site-translations') ?>"
                                        class="side-nav-link <?= $isActive('admin/site-translations') ? 'active' : '' ?>">
                                        <i class="ti ti-language"></i> Site Translations
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Support Tickets -->
                            <?php if (has_permission('support_tickets.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/support-tickets') ?>"
                                        class="side-nav-link <?= $isActive('admin/support-tickets') ? 'active' : '' ?>">
                                        <i class="ti ti-ticket"></i> Support Tickets
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Activity Logs -->
                            <?php if (has_permission('activity_logs.view')): ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url('admin/logs') ?>"
                                        class="side-nav-link <?= $isActive('admin/logs') ? 'active' : '' ?>">
                                        <i class="ti ti-history"></i> Activity Logs
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Security (no permission defined, kept as is) -->
                            <li class="side-nav-item">
                                <a href="#" class="side-nav-link <?= $isActive('admin/security') ? 'active' : '' ?>">
                                    <i class="ti ti-shield"></i> Security
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <!-- Logout (always visible) -->
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
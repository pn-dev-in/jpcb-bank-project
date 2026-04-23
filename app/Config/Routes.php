<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
 * ---------------------------------------------------------------
 * ROUTE DEFINITIONS
 * ---------------------------------------------------------------
 * Explicit routing only (auto-routing disabled for security).
 */

// Home
$routes->get('/', 'Home::index');

// Search (GET - no sensitive data in query string for banking)
$routes->get('search', 'Home::search');

// About
$routes->get('about', 'Pages::section/about');
$routes->get('about/(:segment)', 'Pages::section/about/$1');

// Deposits
$routes->get('deposits', 'Pages::section/deposits');
$routes->get('deposits/(:segment)', 'Pages::section/deposits/$1');
$routes->get('deposits/interest-rates-pdf', 'DepositPdf::interestRates');

// Loans
$routes->get('loans', 'Pages::section/loans');
$routes->get('loans/(:segment)', 'Pages::section/loans/$1');

// Digital
$routes->get('digital', 'Pages::section/digital');
$routes->get('digital/(:segment)', 'Pages::section/digital/$1');

// Services
$routes->get('services', 'Pages::section/services');
$routes->get('services/(:segment)', 'Pages::section/services/$1');

// Complaints
$routes->get('complaints', 'Pages::section/complaints');
$routes->get('complaints/(:segment)', 'Pages::section/complaints/$1');

// Downloads
$routes->get('downloads', 'Pages::section/downloads');
$routes->get('downloads/(:segment)', 'Pages::section/downloads/$1');

// RBI awareness
$routes->get('rbi', 'Pages::section/rbi');
$routes->get('rbi/(:segment)', 'Pages::section/rbi/$1');

// Utility pages
$routes->get('contact', 'Pages::single/contact');
$routes->get('faq', 'Pages::single/faq');
$routes->get('accessibility', 'Pages::single/accessibility');
$routes->get('privacy', 'Pages::single/privacy');
$routes->get('sitemap', 'Pages::single/sitemap');

// 404 fallback
$routes->set404Override([\App\Controllers\Pages::class, 'notFound']);

// All admin routes (AuthFilter will handle protection, excluding login/logout)
$routes->group('admin', ['namespace' => 'App\Controllers'], function ($routes) {

    // Auth
    $routes->get('login', 'Admin\Auth::login');
    $routes->post('login', 'Admin\Auth::loginProcess');
    $routes->get('logout', 'Admin\Auth::logout');

    // Dashboard
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->get('dashboard', 'Admin\DashboardController::index');

    // $routes->get('banners', 'Admin\BannerController::index');
    // $routes->get('banners/create', 'Admin\BannerController::create');
    // $routes->post('banners/store', 'Admin\BannerController::store');
    // $routes->get('banners/delete/(:num)', 'Admin\BannerController::delete/$1');

    $routes->get('notices', 'Admin\NoticeController::index');
    $routes->get('notices/create', 'Admin\NoticeController::create');
    $routes->post('notices/store', 'Admin\NoticeController::store');
    $routes->get('notices/edit/(:num)', 'Admin\NoticeController::edit/$1');
    $routes->post('notices/update/(:num)', 'Admin\NoticeController::update/$1');
    $routes->get('notices/delete/(:num)', 'Admin\NoticeController::delete/$1');

    $routes->get('complaints', 'Admin\ComplaintController::index');
    $routes->get('complaints/view/(:num)', 'Admin\ComplaintController::view/$1');
    $routes->post('complaints/update/(:num)', 'Admin\ComplaintController::update/$1');

    $routes->get('branches', 'Admin\BranchController::index');
    $routes->get('branches/create', 'Admin\BranchController::create');
    $routes->post('branches/store', 'Admin\BranchController::store');
    $routes->get('branches/edit/(:num)', 'Admin\BranchController::edit/$1');
    $routes->post('branches/update/(:num)', 'Admin\BranchController::update/$1');
    $routes->post('branches/delete/(:num)', 'Admin\BranchController::delete/$1');

    $routes->get('roles', 'Admin\RoleController::index');
    $routes->get('roles/create', 'Admin\RoleController::create');
    $routes->post('roles/store', 'Admin\RoleController::store');
    $routes->get('roles/assign/(:num)', 'Admin\RoleController::assign/$1');
    $routes->post('roles/save/(:num)', 'Admin\RoleController::savePermissions/$1');

    $routes->get('users', 'Admin\AdminUserController::index');
    $routes->get('users/create', 'Admin\AdminUserController::create');
    $routes->post('users/store', 'Admin\AdminUserController::store');

    $routes->get('careers', 'Admin\CareerController::index');
    $routes->get('careers/delete/(:num)', 'Admin\CareerController::delete/$1');

    $routes->get('logs', 'Admin\ActivityLogController::index');

    $routes->get('homepage/edit-hero', 'Admin\Homepage::editHero');
    $routes->post('homepage/update-hero', 'Admin\Homepage::updateHero');

    $routes->get('homepage/trust-cards', 'Admin\Homepage::trustCards');
    $routes->get('homepage/create-card', 'Admin\Homepage::createCard');
    $routes->post('homepage/store-card', 'Admin\Homepage::storeCard');

    $routes->get('homepage/edit-card/(:num)', 'Admin\Homepage::editCard/$1');
    $routes->post('homepage/update-card/(:num)', 'Admin\Homepage::updateCard/$1');
    $routes->get('homepage/delete-card/(:num)', 'Admin\Homepage::deleteCard/$1');

    $routes->get('homepage', 'Admin\Homepage::index');

    // Products section settings
    $routes->get('products-section/edit', 'Admin\ProductsSection::edit');
    $routes->post('products-section/update', 'Admin\ProductsSection::update');

    // Products CRUD
    $routes->get('products', 'Admin\Products::index');
    $routes->get('products/create', 'Admin\Products::create');
    $routes->post('products/store', 'Admin\Products::store');
    $routes->get('products/edit/(:num)', 'Admin\Products::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\Products::update/$1');
    $routes->get('products/delete/(:num)', 'Admin\Products::delete/$1');

    // Ticker Management
    $routes->get('ticker', 'Admin\TickerController::index');
    $routes->get('ticker/create', 'Admin\TickerController::create');
    $routes->post('ticker/store', 'Admin\TickerController::store');
    $routes->get('ticker/edit/(:num)', 'Admin\TickerController::edit/$1');
    $routes->post('ticker/update/(:num)', 'Admin\TickerController::update/$1');
    $routes->post('ticker/delete/(:num)', 'Admin\TickerController::delete/$1');

    $routes->get('quick-actions', 'Admin\QuickActions::index');
    $routes->get('quick-actions/create', 'Admin\QuickActions::create');
    $routes->post('quick-actions/store', 'Admin\QuickActions::store');
    $routes->get('quick-actions/edit/(:num)', 'Admin\QuickActions::edit/$1');
    $routes->post('quick-actions/update/(:num)', 'Admin\QuickActions::update/$1');
    $routes->get('quick-actions/delete/(:num)', 'Admin\QuickActions::delete/$1');

    $routes->get('quick-actions-section/edit', 'Admin\QuickActionsSection::edit');
    $routes->post('quick-actions-section/update', 'Admin\QuickActionsSection::update');

    $routes->get('safety-section', 'Admin\SafetySection::index');
    $routes->get('safety-section/edit', 'Admin\SafetySection::edit');
    $routes->post('safety-section/update', 'Admin\SafetySection::update');

    $routes->get('grievance-section/edit', 'Admin\GrievanceSection::edit');
    $routes->post('grievance-section/update', 'Admin\GrievanceSection::update');

    $routes->get('grievance-steps', 'Admin\GrievanceSteps::index');
    $routes->get('grievance-steps/create', 'Admin\GrievanceSteps::create');
    $routes->post('grievance-steps/store', 'Admin\GrievanceSteps::store');
    $routes->get('grievance-steps/edit/(:num)', 'Admin\GrievanceSteps::edit/$1');
    $routes->post('grievance-steps/update/(:num)', 'Admin\GrievanceSteps::update/$1');
    $routes->get('grievance-steps/delete/(:num)', 'Admin\GrievanceSteps::delete/$1');

    // Trust Section Settings
    $routes->get('trust-section/edit', 'Admin\TrustSection::edit');
    $routes->post('trust-section/update', 'Admin\TrustSection::update');

    // Trust Stats
    $routes->get('trust-stats', 'Admin\TrustStats::index');
    $routes->get('trust-stats/create', 'Admin\TrustStats::create');
    $routes->post('trust-stats/store', 'Admin\TrustStats::store');
    $routes->get('trust-stats/edit/(:num)', 'Admin\TrustStats::edit/$1');
    $routes->post('trust-stats/update/(:num)', 'Admin\TrustStats::update/$1');
    $routes->get('trust-stats/delete/(:num)', 'Admin\TrustStats::delete/$1');

    // Trust Accessibility (single)
    $routes->get('trust-accessibility/edit', 'Admin\TrustAccessibility::edit');
    $routes->post('trust-accessibility/update', 'Admin\TrustAccessibility::update');

    // Trust Regulatory (single)
    $routes->get('trust-regulatory/edit', 'Admin\TrustRegulatory::edit');
    $routes->post('trust-regulatory/update', 'Admin\TrustRegulatory::update');

    // Trust Badges
    $routes->get('trust-badges', 'Admin\TrustBadges::index');
    $routes->get('trust-badges/create', 'Admin\TrustBadges::create');
    $routes->post('trust-badges/store', 'Admin\TrustBadges::store');
    $routes->get('trust-badges/edit/(:num)', 'Admin\TrustBadges::edit/$1');
    $routes->post('trust-badges/update/(:num)', 'Admin\TrustBadges::update/$1');
    $routes->get('trust-badges/delete/(:num)', 'Admin\TrustBadges::delete/$1');

    $routes->get('settings/edit', 'Admin\Settings::edit');
    $routes->post('settings/update', 'Admin\Settings::update');

    $routes->get('social-links', 'Admin\SocialLinks::index');
    $routes->get('social-links/create', 'Admin\SocialLinks::create');
    $routes->post('social-links/store', 'Admin\SocialLinks::store');
    $routes->get('social-links/edit/(:num)', 'Admin\SocialLinks::edit/$1');
    $routes->post('social-links/update/(:num)', 'Admin\SocialLinks::update/$1');
    $routes->get('social-links/delete/(:num)', 'Admin\SocialLinks::delete/$1');

    // About Stats
    $routes->get('about-stats', 'Admin\AboutStats::index');
    $routes->get('about-stats/create', 'Admin\AboutStats::create');
    $routes->post('about-stats/store', 'Admin\AboutStats::store');
    $routes->get('about-stats/edit/(:num)', 'Admin\AboutStats::edit/$1');
    $routes->post('about-stats/update/(:num)', 'Admin\AboutStats::update/$1');
    $routes->post('about-stats/delete/(:num)', 'Admin\AboutStats::delete/$1');

    // About Values
    $routes->get('about-values', 'Admin\AboutValues::index');
    $routes->get('about-values/create', 'Admin\AboutValues::create');
    $routes->post('about-values/store', 'Admin\AboutValues::store');
    $routes->get('about-values/edit/(:num)', 'Admin\AboutValues::edit/$1');
    $routes->post('about-values/update/(:num)', 'Admin\AboutValues::update/$1');
    $routes->post('about-values/delete/(:num)', 'Admin\AboutValues::delete/$1');

    // About Milestones
    $routes->get('about-milestones', 'Admin\AboutMilestones::index');
    $routes->get('about-milestones/create', 'Admin\AboutMilestones::create');
    $routes->post('about-milestones/store', 'Admin\AboutMilestones::store');
    $routes->get('about-milestones/edit/(:num)', 'Admin\AboutMilestones::edit/$1');
    $routes->post('about-milestones/update/(:num)', 'Admin\AboutMilestones::update/$1');
    $routes->post('about-milestones/delete/(:num)', 'Admin\AboutMilestones::delete/$1');

    // Board Members
    $routes->get('board-members', 'Admin\BoardMembers::index');
    $routes->get('board-members/create', 'Admin\BoardMembers::create');
    $routes->post('board-members/store', 'Admin\BoardMembers::store');
    $routes->get('board-members/edit/(:num)', 'Admin\BoardMembers::edit/$1');
    $routes->post('board-members/update/(:num)', 'Admin\BoardMembers::update/$1');
    $routes->post('board-members/delete/(:num)', 'Admin\BoardMembers::delete/$1');

    // Management Team
    $routes->get('management-team', 'Admin\ManagementTeam::index');
    $routes->get('management-team/create', 'Admin\ManagementTeam::create');
    $routes->post('management-team/store', 'Admin\ManagementTeam::store');
    $routes->get('management-team/edit/(:num)', 'Admin\ManagementTeam::edit/$1');
    $routes->post('management-team/update/(:num)', 'Admin\ManagementTeam::update/$1');
    $routes->post('management-team/delete/(:num)', 'Admin\ManagementTeam::delete/$1');

    // Awards
    $routes->get('awards', 'Admin\Awards::index');
    $routes->get('awards/create', 'Admin\Awards::create');
    $routes->post('awards/store', 'Admin\Awards::store');
    $routes->get('awards/edit/(:num)', 'Admin\Awards::edit/$1');
    $routes->post('awards/update/(:num)', 'Admin\Awards::update/$1');
    $routes->post('awards/delete/(:num)', 'Admin\Awards::delete/$1');

    // Gallery Categories
    $routes->get('gallery-categories', 'Admin\GalleryCategories::index');
    $routes->get('gallery-categories/create', 'Admin\GalleryCategories::create');
    $routes->post('gallery-categories/store', 'Admin\GalleryCategories::store');
    $routes->get('gallery-categories/edit/(:num)', 'Admin\GalleryCategories::edit/$1');
    $routes->post('gallery-categories/update/(:num)', 'Admin\GalleryCategories::update/$1');
    $routes->post('gallery-categories/delete/(:num)', 'Admin\GalleryCategories::delete/$1');

    // Gallery Items
    $routes->get('gallery-items', 'Admin\GalleryItems::index');
    $routes->get('gallery-items/create', 'Admin\GalleryItems::create');
    $routes->post('gallery-items/store', 'Admin\GalleryItems::store');
    $routes->get('gallery-items/edit/(:num)', 'Admin\GalleryItems::edit/$1');
    $routes->post('gallery-items/update/(:num)', 'Admin\GalleryItems::update/$1');
    $routes->post('gallery-items/delete/(:num)', 'Admin\GalleryItems::delete/$1');

    // Deposit Cards
    $routes->get('deposit-cards', 'Admin\DepositCards::index');
    $routes->get('deposit-cards/create', 'Admin\DepositCards::create');
    $routes->post('deposit-cards/store', 'Admin\DepositCards::store');
    $routes->get('deposit-cards/edit/(:num)', 'Admin\DepositCards::edit/$1');
    $routes->post('deposit-cards/update/(:num)', 'Admin\DepositCards::update/$1');
    $routes->post('deposit-cards/delete/(:num)', 'Admin\DepositCards::delete/$1');

    // Deposit Quick Links
    $routes->get('deposit-quick-links', 'Admin\DepositQuickLinks::index');
    $routes->get('deposit-quick-links/create', 'Admin\DepositQuickLinks::create');
    $routes->post('deposit-quick-links/store', 'Admin\DepositQuickLinks::store');
    $routes->get('deposit-quick-links/edit/(:num)', 'Admin\DepositQuickLinks::edit/$1');
    $routes->post('deposit-quick-links/update/(:num)', 'Admin\DepositQuickLinks::update/$1');
    $routes->post('deposit-quick-links/delete/(:num)', 'Admin\DepositQuickLinks::delete/$1');

    // Deposit Products
    $routes->get('deposit-products', 'Admin\DepositProducts::index');
    $routes->get('deposit-products/create', 'Admin\DepositProducts::create');
    $routes->post('deposit-products/store', 'Admin\DepositProducts::store');
    $routes->get('deposit-products/edit/(:num)', 'Admin\DepositProducts::edit/$1');
    $routes->post('deposit-products/update/(:num)', 'Admin\DepositProducts::update/$1');
    $routes->post('deposit-products/delete/(:num)', 'Admin\DepositProducts::delete/$1');

    // Deposit Interest Rates
    $routes->get('deposit-interest-rates', 'Admin\DepositInterestRates::index');
    $routes->get('deposit-interest-rates/create', 'Admin\DepositInterestRates::create');
    $routes->post('deposit-interest-rates/store', 'Admin\DepositInterestRates::store');
    $routes->get('deposit-interest-rates/edit/(:num)', 'Admin\DepositInterestRates::edit/$1');
    $routes->post('deposit-interest-rates/update/(:num)', 'Admin\DepositInterestRates::update/$1');
    $routes->post('deposit-interest-rates/delete/(:num)', 'Admin\DepositInterestRates::delete/$1');

    // Savings Accounts
    $routes->get('savings-accounts', 'Admin\SavingsAccounts::index');
    $routes->get('savings-accounts/create', 'Admin\SavingsAccounts::create');
    $routes->post('savings-accounts/store', 'Admin\SavingsAccounts::store');
    $routes->get('savings-accounts/edit/(:num)', 'Admin\SavingsAccounts::edit/$1');
    $routes->post('savings-accounts/update/(:num)', 'Admin\SavingsAccounts::update/$1');
    $routes->post('savings-accounts/delete/(:num)', 'Admin\SavingsAccounts::delete/$1');

    // Current Accounts
    $routes->get('current-accounts', 'Admin\CurrentAccounts::index');
    $routes->get('current-accounts/create', 'Admin\CurrentAccounts::create');
    $routes->post('current-accounts/store', 'Admin\CurrentAccounts::store');
    $routes->get('current-accounts/edit/(:num)', 'Admin\CurrentAccounts::edit/$1');
    $routes->post('current-accounts/update/(:num)', 'Admin\CurrentAccounts::update/$1');
    $routes->post('current-accounts/delete/(:num)', 'Admin\CurrentAccounts::delete/$1');

    // DICGC FAQs
    $routes->get('dicgc-faqs', 'Admin\DicgcFaqs::index');
    $routes->get('dicgc-faqs/create', 'Admin\DicgcFaqs::create');
    $routes->post('dicgc-faqs/store', 'Admin\DicgcFaqs::store');
    $routes->get('dicgc-faqs/edit/(:num)', 'Admin\DicgcFaqs::edit/$1');
    $routes->post('dicgc-faqs/update/(:num)', 'Admin\DicgcFaqs::update/$1');
    $routes->post('dicgc-faqs/delete/(:num)', 'Admin\DicgcFaqs::delete/$1');

    // DEAF Steps
    $routes->get('deaf-steps', 'Admin\DeafSteps::index');
    $routes->get('deaf-steps/create', 'Admin\DeafSteps::create');
    $routes->post('deaf-steps/store', 'Admin\DeafSteps::store');
    $routes->get('deaf-steps/edit/(:num)', 'Admin\DeafSteps::edit/$1');
    $routes->post('deaf-steps/update/(:num)', 'Admin\DeafSteps::update/$1');
    $routes->post('deaf-steps/delete/(:num)', 'Admin\DeafSteps::delete/$1');

    // Deposit Settings (single edit)
    $routes->get('deposit-settings/edit', 'Admin\DepositSettings::edit');
    $routes->post('deposit-settings/update', 'Admin\DepositSettings::update');

    // Loan Cards
    $routes->get('loan-cards', 'Admin\LoanCards::index');
    $routes->get('loan-cards/create', 'Admin\LoanCards::create');
    $routes->post('loan-cards/store', 'Admin\LoanCards::store');
    $routes->get('loan-cards/edit/(:num)', 'Admin\LoanCards::edit/$1');
    $routes->post('loan-cards/update/(:num)', 'Admin\LoanCards::update/$1');
    $routes->post('loan-cards/delete/(:num)', 'Admin\LoanCards::delete/$1');

    // Loan Products
    $routes->get('loan-products', 'Admin\LoanProducts::index');
    $routes->get('loan-products/create', 'Admin\LoanProducts::create');
    $routes->post('loan-products/store', 'Admin\LoanProducts::store');
    $routes->get('loan-products/edit/(:num)', 'Admin\LoanProducts::edit/$1');
    $routes->post('loan-products/update/(:num)', 'Admin\LoanProducts::update/$1');
    $routes->post('loan-products/delete/(:num)', 'Admin\LoanProducts::delete/$1');

    // Loan Interest Rates
    $routes->get('loan-interest-rates', 'Admin\LoanInterestRates::index');
    $routes->get('loan-interest-rates/create', 'Admin\LoanInterestRates::create');
    $routes->post('loan-interest-rates/store', 'Admin\LoanInterestRates::store');
    $routes->get('loan-interest-rates/edit/(:num)', 'Admin\LoanInterestRates::edit/$1');
    $routes->post('loan-interest-rates/update/(:num)', 'Admin\LoanInterestRates::update/$1');
    $routes->post('loan-interest-rates/delete/(:num)', 'Admin\LoanInterestRates::delete/$1');

    // Service Cards
    $routes->get('service-cards', 'Admin\ServiceCards::index');
    $routes->get('service-cards/create', 'Admin\ServiceCards::create');
    $routes->post('service-cards/store', 'Admin\ServiceCards::store');
    $routes->get('service-cards/edit/(:num)', 'Admin\ServiceCards::edit/$1');
    $routes->post('service-cards/update/(:num)', 'Admin\ServiceCards::update/$1');
    $routes->post('service-cards/delete/(:num)', 'Admin\ServiceCards::delete/$1');

    // Service Charges
    $routes->get('service-charges', 'Admin\ServiceCharges::index');
    $routes->get('service-charges/create', 'Admin\ServiceCharges::create');
    $routes->post('service-charges/store', 'Admin\ServiceCharges::store');
    $routes->get('service-charges/edit/(:num)', 'Admin\ServiceCharges::edit/$1');
    $routes->post('service-charges/update/(:num)', 'Admin\ServiceCharges::update/$1');
    $routes->post('service-charges/delete/(:num)', 'Admin\ServiceCharges::delete/$1');

    // Insurance Products
    $routes->get('insurance-products', 'Admin\InsuranceProducts::index');
    $routes->get('insurance-products/create', 'Admin\InsuranceProducts::create');
    $routes->post('insurance-products/store', 'Admin\InsuranceProducts::store');
    $routes->get('insurance-products/edit/(:num)', 'Admin\InsuranceProducts::edit/$1');
    $routes->post('insurance-products/update/(:num)', 'Admin\InsuranceProducts::update/$1');
    $routes->post('insurance-products/delete/(:num)', 'Admin\InsuranceProducts::delete/$1');

    // Locker Sizes
    $routes->get('locker-sizes', 'Admin\LockerSizes::index');
    $routes->get('locker-sizes/create', 'Admin\LockerSizes::create');
    $routes->post('locker-sizes/store', 'Admin\LockerSizes::store');
    $routes->get('locker-sizes/edit/(:num)', 'Admin\LockerSizes::edit/$1');
    $routes->post('locker-sizes/update/(:num)', 'Admin\LockerSizes::update/$1');
    $routes->post('locker-sizes/delete/(:num)', 'Admin\LockerSizes::delete/$1');

    // Locker FAQs
    $routes->get('locker-faqs', 'Admin\LockerFaqs::index');
    $routes->get('locker-faqs/create', 'Admin\LockerFaqs::create');
    $routes->post('locker-faqs/store', 'Admin\LockerFaqs::store');
    $routes->get('locker-faqs/edit/(:num)', 'Admin\LockerFaqs::edit/$1');
    $routes->post('locker-faqs/update/(:num)', 'Admin\LockerFaqs::update/$1');
    $routes->post('locker-faqs/delete/(:num)', 'Admin\LockerFaqs::delete/$1');

    // Service Settings
    $routes->get('service-settings/edit', 'Admin\ServiceSettings::edit');
    $routes->post('service-settings/update', 'Admin\ServiceSettings::update');

    // Digital Services
    $routes->get('digital-services', 'Admin\DigitalServices::index');
    $routes->get('digital-services/create', 'Admin\DigitalServices::create');
    $routes->post('digital-services/store', 'Admin\DigitalServices::store');
    $routes->get('digital-services/edit/(:num)', 'Admin\DigitalServices::edit/$1');
    $routes->post('digital-services/update/(:num)', 'Admin\DigitalServices::update/$1');
    $routes->post('digital-services/delete/(:num)', 'Admin\DigitalServices::delete/$1');

    // Mobile Features
    $routes->get('mobile-features', 'Admin\MobileFeatures::index');
    $routes->get('mobile-features/create', 'Admin\MobileFeatures::create');
    $routes->post('mobile-features/store', 'Admin\MobileFeatures::store');
    $routes->get('mobile-features/edit/(:num)', 'Admin\MobileFeatures::edit/$1');
    $routes->post('mobile-features/update/(:num)', 'Admin\MobileFeatures::update/$1');
    $routes->post('mobile-features/delete/(:num)', 'Admin\MobileFeatures::delete/$1');

    // Mobile Registration Steps
    $routes->get('mobile-registration-steps', 'Admin\MobileRegistrationSteps::index');
    $routes->get('mobile-registration-steps/create', 'Admin\MobileRegistrationSteps::create');
    $routes->post('mobile-registration-steps/store', 'Admin\MobileRegistrationSteps::store');
    $routes->get('mobile-registration-steps/edit/(:num)', 'Admin\MobileRegistrationSteps::edit/$1');
    $routes->post('mobile-registration-steps/update/(:num)', 'Admin\MobileRegistrationSteps::update/$1');
    $routes->post('mobile-registration-steps/delete/(:num)', 'Admin\MobileRegistrationSteps::delete/$1');

    // Mobile FAQs
    $routes->get('mobile-faqs', 'Admin\MobileFaqs::index');
    $routes->get('mobile-faqs/create', 'Admin\MobileFaqs::create');
    $routes->post('mobile-faqs/store', 'Admin\MobileFaqs::store');
    $routes->get('mobile-faqs/edit/(:num)', 'Admin\MobileFaqs::edit/$1');
    $routes->post('mobile-faqs/update/(:num)', 'Admin\MobileFaqs::update/$1');
    $routes->post('mobile-faqs/delete/(:num)', 'Admin\MobileFaqs::delete/$1');

    // ATM Locations
    $routes->get('atm-locations', 'Admin\AtmLocations::index');
    $routes->get('atm-locations/create', 'Admin\AtmLocations::create');
    $routes->post('atm-locations/store', 'Admin\AtmLocations::store');
    $routes->get('atm-locations/edit/(:num)', 'Admin\AtmLocations::edit/$1');
    $routes->post('atm-locations/update/(:num)', 'Admin\AtmLocations::update/$1');
    $routes->post('atm-locations/delete/(:num)', 'Admin\AtmLocations::delete/$1');

    // Block Card Methods
    $routes->get('block-card-methods', 'Admin\BlockCardMethods::index');
    $routes->get('block-card-methods/create', 'Admin\BlockCardMethods::create');
    $routes->post('block-card-methods/store', 'Admin\BlockCardMethods::store');
    $routes->get('block-card-methods/edit/(:num)', 'Admin\BlockCardMethods::edit/$1');
    $routes->post('block-card-methods/update/(:num)', 'Admin\BlockCardMethods::update/$1');
    $routes->post('block-card-methods/delete/(:num)', 'Admin\BlockCardMethods::delete/$1');

    // Block Card After Steps
    $routes->get('block-card-after-steps', 'Admin\BlockCardAfterSteps::index');
    $routes->get('block-card-after-steps/create', 'Admin\BlockCardAfterSteps::create');
    $routes->post('block-card-after-steps/store', 'Admin\BlockCardAfterSteps::store');
    $routes->get('block-card-after-steps/edit/(:num)', 'Admin\BlockCardAfterSteps::edit/$1');
    $routes->post('block-card-after-steps/update/(:num)', 'Admin\BlockCardAfterSteps::update/$1');
    $routes->post('block-card-after-steps/delete/(:num)', 'Admin\BlockCardAfterSteps::delete/$1');

    // UPI Benefits
    $routes->get('upi-benefits', 'Admin\UpiBenefits::index');
    $routes->get('upi-benefits/create', 'Admin\UpiBenefits::create');
    $routes->post('upi-benefits/store', 'Admin\UpiBenefits::store');
    $routes->get('upi-benefits/edit/(:num)', 'Admin\UpiBenefits::edit/$1');
    $routes->post('upi-benefits/update/(:num)', 'Admin\UpiBenefits::update/$1');
    $routes->post('upi-benefits/delete/(:num)', 'Admin\UpiBenefits::delete/$1');

    // UPI Safety Tips
    $routes->get('upi-safety-tips', 'Admin\UpiSafetyTips::index');
    $routes->get('upi-safety-tips/create', 'Admin\UpiSafetyTips::create');
    $routes->post('upi-safety-tips/store', 'Admin\UpiSafetyTips::store');
    $routes->get('upi-safety-tips/edit/(:num)', 'Admin\UpiSafetyTips::edit/$1');
    $routes->post('upi-safety-tips/update/(:num)', 'Admin\UpiSafetyTips::update/$1');
    $routes->post('upi-safety-tips/delete/(:num)', 'Admin\UpiSafetyTips::delete/$1');

    // UPI Linking Steps
    $routes->get('upi-linking-steps', 'Admin\UpiLinkingSteps::index');
    $routes->get('upi-linking-steps/create', 'Admin\UpiLinkingSteps::create');
    $routes->post('upi-linking-steps/store', 'Admin\UpiLinkingSteps::store');
    $routes->get('upi-linking-steps/edit/(:num)', 'Admin\UpiLinkingSteps::edit/$1');
    $routes->post('upi-linking-steps/update/(:num)', 'Admin\UpiLinkingSteps::update/$1');
    $routes->post('upi-linking-steps/delete/(:num)', 'Admin\UpiLinkingSteps::delete/$1');

    // DigiSaathi Categories
    $routes->get('digisaathi-categories', 'Admin\DigisaathiCategories::index');
    $routes->get('digisaathi-categories/create', 'Admin\DigisaathiCategories::create');
    $routes->post('digisaathi-categories/store', 'Admin\DigisaathiCategories::store');
    $routes->get('digisaathi-categories/edit/(:num)', 'Admin\DigisaathiCategories::edit/$1');
    $routes->post('digisaathi-categories/update/(:num)', 'Admin\DigisaathiCategories::update/$1');
    $routes->post('digisaathi-categories/delete/(:num)', 'Admin\DigisaathiCategories::delete/$1');

    // DigiSaathi Contacts
    $routes->get('digisaathi-contacts', 'Admin\DigisaathiContacts::index');
    $routes->get('digisaathi-contacts/create', 'Admin\DigisaathiContacts::create');
    $routes->post('digisaathi-contacts/store', 'Admin\DigisaathiContacts::store');
    $routes->get('digisaathi-contacts/edit/(:num)', 'Admin\DigisaathiContacts::edit/$1');
    $routes->post('digisaathi-contacts/update/(:num)', 'Admin\DigisaathiContacts::update/$1');
    $routes->post('digisaathi-contacts/delete/(:num)', 'Admin\DigisaathiContacts::delete/$1');

    // Digital Settings
    $routes->get('digital-settings/edit', 'Admin\DigitalSettings::edit');
    $routes->post('digital-settings/update', 'Admin\DigitalSettings::update');

    // Downloads Management
    $routes->get('downloads', 'Admin\Downloads::index');
    $routes->get('downloads/create', 'Admin\Downloads::create');
    $routes->post('downloads/store', 'Admin\Downloads::store');
    $routes->get('downloads/edit/(:num)', 'Admin\Downloads::edit/$1');
    $routes->post('downloads/update/(:num)', 'Admin\Downloads::update/$1');
    $routes->post('downloads/delete/(:num)', 'Admin\Downloads::delete/$1');

    // Complaint Escalation Levels
    $routes->get('complaint-escalation-levels', 'Admin\ComplaintEscalationLevels::index');
    $routes->get('complaint-escalation-levels/create', 'Admin\ComplaintEscalationLevels::create');
    $routes->post('complaint-escalation-levels/store', 'Admin\ComplaintEscalationLevels::store');
    $routes->get('complaint-escalation-levels/edit/(:num)', 'Admin\ComplaintEscalationLevels::edit/$1');
    $routes->post('complaint-escalation-levels/update/(:num)', 'Admin\ComplaintEscalationLevels::update/$1');
    $routes->post('complaint-escalation-levels/delete/(:num)', 'Admin\ComplaintEscalationLevels::delete/$1');

    // Complaint Categories
    $routes->get('complaint-categories', 'Admin\ComplaintCategories::index');
    $routes->get('complaint-categories/create', 'Admin\ComplaintCategories::create');
    $routes->post('complaint-categories/store', 'Admin\ComplaintCategories::store');
    $routes->get('complaint-categories/edit/(:num)', 'Admin\ComplaintCategories::edit/$1');
    $routes->post('complaint-categories/update/(:num)', 'Admin\ComplaintCategories::update/$1');
    $routes->post('complaint-categories/delete/(:num)', 'Admin\ComplaintCategories::delete/$1');

    // RBI Topics
    $routes->get('rbi-topics', 'Admin\RbiTopics::index');
    $routes->get('rbi-topics/create', 'Admin\RbiTopics::create');
    $routes->post('rbi-topics/store', 'Admin\RbiTopics::store');
    $routes->get('rbi-topics/edit/(:num)', 'Admin\RbiTopics::edit/$1');
    $routes->post('rbi-topics/update/(:num)', 'Admin\RbiTopics::update/$1');
    $routes->post('rbi-topics/delete/(:num)', 'Admin\RbiTopics::delete/$1');

    // Fair Practice Principles
    $routes->get('rbi-fair-practice-principles', 'Admin\RbiFairPracticePrinciples::index');
    $routes->get('rbi-fair-practice-principles/create', 'Admin\RbiFairPracticePrinciples::create');
    $routes->post('rbi-fair-practice-principles/store', 'Admin\RbiFairPracticePrinciples::store');
    $routes->get('rbi-fair-practice-principles/edit/(:num)', 'Admin\RbiFairPracticePrinciples::edit/$1');
    $routes->post('rbi-fair-practice-principles/update/(:num)', 'Admin\RbiFairPracticePrinciples::update/$1');
    $routes->post('rbi-fair-practice-principles/delete/(:num)', 'Admin\RbiFairPracticePrinciples::delete/$1');

    // RBI Do's
    $routes->get('rbi-dos', 'Admin\RbiDos::index');
    $routes->get('rbi-dos/create', 'Admin\RbiDos::create');
    $routes->post('rbi-dos/store', 'Admin\RbiDos::store');
    $routes->get('rbi-dos/edit/(:num)', 'Admin\RbiDos::edit/$1');
    $routes->post('rbi-dos/update/(:num)', 'Admin\RbiDos::update/$1');
    $routes->post('rbi-dos/delete/(:num)', 'Admin\RbiDos::delete/$1');

    // RBI Don'ts
    $routes->get('rbi-donts', 'Admin\RbiDonts::index');
    $routes->get('rbi-donts/create', 'Admin\RbiDonts::create');
    $routes->post('rbi-donts/store', 'Admin\RbiDonts::store');
    $routes->get('rbi-donts/edit/(:num)', 'Admin\RbiDonts::edit/$1');
    $routes->post('rbi-donts/update/(:num)', 'Admin\RbiDonts::update/$1');
    $routes->post('rbi-donts/delete/(:num)', 'Admin\RbiDonts::delete/$1');

    // Ombudsman Reasons
    $routes->get('rbi-ombudsman-reasons', 'Admin\RbiOmbudsmanReasons::index');
    $routes->get('rbi-ombudsman-reasons/create', 'Admin\RbiOmbudsmanReasons::create');
    $routes->post('rbi-ombudsman-reasons/store', 'Admin\RbiOmbudsmanReasons::store');
    $routes->get('rbi-ombudsman-reasons/edit/(:num)', 'Admin\RbiOmbudsmanReasons::edit/$1');
    $routes->post('rbi-ombudsman-reasons/update/(:num)', 'Admin\RbiOmbudsmanReasons::update/$1');
    $routes->post('rbi-ombudsman-reasons/delete/(:num)', 'Admin\RbiOmbudsmanReasons::delete/$1');

    // Booklet Topics
    $routes->get('rbi-booklet-topics', 'Admin\RbiBookletTopics::index');
    $routes->get('rbi-booklet-topics/create', 'Admin\RbiBookletTopics::create');
    $routes->post('rbi-booklet-topics/store', 'Admin\RbiBookletTopics::store');
    $routes->get('rbi-booklet-topics/edit/(:num)', 'Admin\RbiBookletTopics::edit/$1');
    $routes->post('rbi-booklet-topics/update/(:num)', 'Admin\RbiBookletTopics::update/$1');
    $routes->post('rbi-booklet-topics/delete/(:num)', 'Admin\RbiBookletTopics::delete/$1');

    // Integrated Ombudsman Steps
    $routes->get('rbi-integrated-steps', 'Admin\RbiIntegratedSteps::index');
    $routes->get('rbi-integrated-steps/create', 'Admin\RbiIntegratedSteps::create');
    $routes->post('rbi-integrated-steps/store', 'Admin\RbiIntegratedSteps::store');
    $routes->get('rbi-integrated-steps/edit/(:num)', 'Admin\RbiIntegratedSteps::edit/$1');
    $routes->post('rbi-integrated-steps/update/(:num)', 'Admin\RbiIntegratedSteps::update/$1');
    $routes->post('rbi-integrated-steps/delete/(:num)', 'Admin\RbiIntegratedSteps::delete/$1');

    // RBI Settings
    $routes->get('rbi-settings/edit', 'Admin\RbiSettings::edit');
    $routes->post('rbi-settings/update', 'Admin\RbiSettings::update');

    // FAQ Categories
    $routes->get('faq-categories', 'Admin\FaqCategories::index');
    $routes->get('faq-categories/create', 'Admin\FaqCategories::create');
    $routes->post('faq-categories/store', 'Admin\FaqCategories::store');
    $routes->get('faq-categories/edit/(:num)', 'Admin\FaqCategories::edit/$1');
    $routes->post('faq-categories/update/(:num)', 'Admin\FaqCategories::update/$1');
    $routes->post('faq-categories/delete/(:num)', 'Admin\FaqCategories::delete/$1');

    // FAQs
    $routes->get('faqs', 'Admin\Faqs::index');
    $routes->get('faqs/create', 'Admin\Faqs::create');
    $routes->post('faqs/store', 'Admin\Faqs::store');
    $routes->get('faqs/edit/(:num)', 'Admin\Faqs::edit/$1');
    $routes->post('faqs/update/(:num)', 'Admin\Faqs::update/$1');
    $routes->post('faqs/delete/(:num)', 'Admin\Faqs::delete/$1');

    // Accessibility Features
    $routes->get('accessibility-features', 'Admin\AccessibilityFeatures::index');
    $routes->get('accessibility-features/create', 'Admin\AccessibilityFeatures::create');
    $routes->post('accessibility-features/store', 'Admin\AccessibilityFeatures::store');
    $routes->get('accessibility-features/edit/(:num)', 'Admin\AccessibilityFeatures::edit/$1');
    $routes->post('accessibility-features/update/(:num)', 'Admin\AccessibilityFeatures::update/$1');
    $routes->post('accessibility-features/delete/(:num)', 'Admin\AccessibilityFeatures::delete/$1');

    // Privacy Policy Sections
    $routes->get('privacy-policy-sections', 'Admin\PrivacyPolicySections::index');
    $routes->get('privacy-policy-sections/create', 'Admin\PrivacyPolicySections::create');
    $routes->post('privacy-policy-sections/store', 'Admin\PrivacyPolicySections::store');
    $routes->get('privacy-policy-sections/edit/(:num)', 'Admin\PrivacyPolicySections::edit/$1');
    $routes->post('privacy-policy-sections/update/(:num)', 'Admin\PrivacyPolicySections::update/$1');
    $routes->post('privacy-policy-sections/delete/(:num)', 'Admin\PrivacyPolicySections::delete/$1');

    // Sitemap Sections
    $routes->get('sitemap-sections', 'Admin\SitemapSections::index');
    $routes->get('sitemap-sections/create', 'Admin\SitemapSections::create');
    $routes->post('sitemap-sections/store', 'Admin\SitemapSections::store');
    $routes->get('sitemap-sections/edit/(:num)', 'Admin\SitemapSections::edit/$1');
    $routes->post('sitemap-sections/update/(:num)', 'Admin\SitemapSections::update/$1');
    $routes->post('sitemap-sections/delete/(:num)', 'Admin\SitemapSections::delete/$1');

    // Sitemap Links
    $routes->get('sitemap-links', 'Admin\SitemapLinks::index');
    $routes->get('sitemap-links/create', 'Admin\SitemapLinks::create');
    $routes->post('sitemap-links/store', 'Admin\SitemapLinks::store');
    $routes->get('sitemap-links/edit/(:num)', 'Admin\SitemapLinks::edit/$1');
    $routes->post('sitemap-links/update/(:num)', 'Admin\SitemapLinks::update/$1');
    $routes->post('sitemap-links/delete/(:num)', 'Admin\SitemapLinks::delete/$1');

    $routes->get('profile', 'Admin\ProfileController::index');
    $routes->post('profile/update', 'Admin\ProfileController::update');
});

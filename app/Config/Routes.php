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

// Admin
$routes->group('admin', function ($routes) {

    $routes->get('admin', 'Admin\Auth::login');
    $routes->get('login', 'Admin\Auth::login');
    $routes->post('login', 'Admin\Auth::loginProcess');
    $routes->get('logout', 'Admin\Auth::logout');
    $routes->get('dashboard', 'Admin\DashboardController::index');

    $routes->get('banners', 'Admin\BannerController::index');
    $routes->get('banners/create', 'Admin\BannerController::create');
    $routes->post('banners/store', 'Admin\BannerController::store');
    $routes->get('banners/delete/(:num)', 'Admin\BannerController::delete/$1');

    $routes->get('notices', 'Admin\NoticeController::index');
    $routes->get('notices/create', 'Admin\NoticeController::create');
    $routes->post('notices/store', 'Admin\NoticeController::store');
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

    $routes->get('documents', 'Admin\DocumentController::index');
    $routes->get('documents/forms', 'Admin\DocumentController::forms');
    $routes->get('documents/create', 'Admin\DocumentController::create');
    $routes->post('documents/store', 'Admin\DocumentController::store');
    $routes->get('documents/delete/(:num)', 'Admin\DocumentController::delete/$1');

     $routes->get('interest-rates', 'Admin\InterestRateController::index');
    $routes->get('interest-rates/create', 'Admin\InterestRateController::create');
    $routes->post('interest-rates/store', 'Admin\InterestRateController::store');
    $routes->get('interest-rates/edit/(:num)', 'Admin\InterestRateController::edit/$1');
    $routes->post('interest-rates/update/(:num)', 'Admin\InterestRateController::update/$1');
    $routes->get('interest-rates/delete/(:num)', 'Admin\InterestRateController::delete/$1');

    $routes->get('popups', 'Admin\PopupController::index');
    $routes->get('popups/create', 'Admin\PopupController::create');
    $routes->post('popups/store', 'Admin\PopupController::store');
    $routes->get('popups/delete/(:num)', 'Admin\PopupController::delete/$1');

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

// Admin routes (protect with authentication if needed)
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
});

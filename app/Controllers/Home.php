<?php

declare(strict_types=1);

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\BannerModel;
use App\Models\NoticeModel;
use App\Models\DocumentModel;
use App\Models\BranchModel;
use App\Models\GalleryModel;
use App\Models\HomeHeroModel;
use App\Models\TrustCardModel;
use App\Models\ProductFeatureModel;
use App\Models\ProductModel;

use App\Controllers\BaseController;

/**
 * Home Controller
 * Serves the main JPCB website pages.
 */
class Home extends BaseController
{
    /**
     * An array of helpers to be loaded automatically upon class instantiation.
     */
    protected $helpers = ['url', 'html', 'text'];

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);
    }

    /**
     * Home page.
     */
    public function index(): string
    {

        $model = new BannerModel();
        $banners = $model->where('status', 1)->findAll();

        $db = \Config\Database::connect();
        /**
         * notices
         */
        $notices = $db->table('notices')
            ->where('status', 1) 
            ->orderBy('date', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        foreach ($notices as &$notice) {
            $notice['date'] = date('d M Y', strtotime($notice['date']));
            $notice['href'] = '#notice-' . $notice['id'];
        }
        unset($notice);

        // Hero section content (single row)
        $heroModel = new \App\Models\HomeHeroModel();
        $hero = $heroModel->find(1); // id=1 always

        // Trust cards (active, ordered)
        $trustCardModel = new \App\Models\TrustCardModel();
        $trustCards = $trustCardModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();


        // Branches (Dynamic)
        $branchModel = new BranchModel();
        // Show only the latest 5 branches (or you can change to 3 or 6)
        $branches = $branchModel->where('status', 1)->orderBy('created_at', 'DESC')->limit(5)->findAll();

        // Products section settings
        $sectionSettingsModel = new \App\Models\ProductsSectionSettingsModel();
        $productsSection = $sectionSettingsModel->find(1);
        if (!$productsSection) {
            // fallback insert
            $sectionSettingsModel->insert(['heading' => 'Our Products & Services', 'subheading' => 'Comprehensive banking solutions...']);
            $productsSection = $sectionSettingsModel->find(1);
        }

        // Products with features
        $productModel = new \App\Models\ProductModel();
        $products = $productModel->getProductsWithFeatures();


        //quick actions

        $quickActions = $db->table('quick_actions')
            ->where('status', 1)  
            ->get()
            ->getResultArray();

        foreach ($quickActions as &$action) {
            if (is_object($action)) {
                $action = (array) $action;
            }

            $action = array_merge([
                'title' => 'Action',
                'description' => '',
                'link' => '#',
                'icon' => 'circle',
                'is_alert' => 0
            ], $action);
        }

        // Quick Actions section settings
        $quickActionsSectionModel = new \App\Models\QuickActionsSectionSettingsModel();
        $quickActionsSection = $quickActionsSectionModel->find(1);
        if (!$quickActionsSection) {
            $quickActionsSectionModel->insert(['heading' => 'Quick Actions', 'subheading' => 'Frequently used banking services at your fingertips']);
            $quickActionsSection = $quickActionsSectionModel->find(1);
        }
        unset($action);

        // Safety section settings
        $safetyModel = new \App\Models\SafetySectionSettingsModel();
        $safetySection = $safetyModel->find(1);
        if (!$safetySection) {
            $safetyModel->insert([
                'heading' => 'Stay Safe from Fraud',
                'warning_text' => '⚠️ We NEVER ask for OTP, PIN, or Password over call, SMS, or email.',
                'description' => 'Beware of phishing websites, fake calls, and fraudulent messages. Do not share your card details, CVV, or banking credentials with anyone. Report suspicious activity immediately.',
                'button1_text' => 'Safety Tips',
                'button1_link' => 'rbi/dos-and-donts',
                'button2_text' => 'Report Fraud: 0257-2220055',
                'button2_link' => 'tel:02572220055',
                'button3_text' => 'Report Online',
                'button3_link' => 'https://cybercrime.gov.in'
            ]);
            $safetySection = $safetyModel->find(1);
        }

        // Grievance steps

        $grievanceSteps = $db->table('grievance_steps')
            ->orderBy('step', 'ASC')
            ->get()
            ->getResultArray();

        // Grievance section settings
        $grievanceSectionModel = new \App\Models\GrievanceSectionSettingsModel();
        $grievanceSection = $grievanceSectionModel->find(1);
        if (!$grievanceSection) {
            $grievanceSectionModel->insert([
                'heading' => 'Grievance Redressal',
                'subheading' => 'We are committed to resolving your complaints fairly and promptly. Follow the RBI-aligned escalation process below.'
            ]);
            $grievanceSection = $grievanceSectionModel->find(1);
        }

        // Trust section data
        $trustSectionModel = new \App\Models\TrustSectionSettingsModel();
        $trustSection = $trustSectionModel->find(1);
        if (!$trustSection) {
            $trustSectionModel->insert(['heading' => 'Why Choose Us', 'subheading' => 'Trusted by generations...']);
            $trustSection = $trustSectionModel->find(1);
        }

        $trustStatModel = new \App\Models\TrustStatModel();
        $trustStats = $trustStatModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();

        $trustAccessibilityModel = new \App\Models\TrustAccessibilityModel();
        $trustAccessibility = $trustAccessibilityModel->find(1);
        if (!$trustAccessibility) {
            $trustAccessibilityModel->insert([
                'heading' => 'Banking for Everyone',
                'description' => 'Our website supports text resizing...',
                'button_text' => 'Accessibility Statement',
                'button_link' => 'accessibility'
            ]);
            $trustAccessibility = $trustAccessibilityModel->find(1);
        }

        $trustRegulatoryModel = new \App\Models\TrustRegulatoryModel();
        $trustRegulatory = $trustRegulatoryModel->find(1);
        if (!$trustRegulatory) {
            $trustRegulatoryModel->insert([
                'description' => 'The Jalgaon Peoples Co-Op. Bank Ltd. is a regulated entity...',
                'disclaimer' => '*Badges shown are for illustration...'
            ]);
            $trustRegulatory = $trustRegulatoryModel->find(1);
        }

        $trustBadgeModel = new \App\Models\TrustBadgeModel();
        $trustBadges = $trustBadgeModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();


        // ticker

        $tickerRaw = $db->table('ticker')
            ->where('status', 1)
            ->get()
            ->getResultArray();

        $ticker = array_column($tickerRaw, 'message');

        // Alert banners (active, inline or popup)
$alertBannerModel = new \App\Models\HomeAlertBannerModel();
$alertBanners = $alertBannerModel->where('status', 1)->findAll();


        $data = [
            'title'       => 'The Jalgaon Peoples Co-Op. Bank Ltd. | Trusted Banking Since 1933',
            'description' => 'Your trusted banking partner for Savings, Fixed Deposits, Loans, Agri Finance, MSME Banking & Digital Payments in Maharashtra.',
            'banners' => $banners,
            'notices' => $notices,
            'branches' => $branches,
            'products' => $products,
            'productsSection' => $productsSection,
            'quickActions' => $quickActions,
            'quickActionsSection' => $quickActionsSection,
            'safetySection' => $safetySection,
            'grievanceSteps' => $grievanceSteps,
            'grievanceSection' => $grievanceSection,
            'trustSection' => $trustSection,
            'trustStats' => $trustStats,
            'trustAccessibility' => $trustAccessibility,
            'trustRegulatory' => $trustRegulatory,
            'trustBadges' => $trustBadges,
            'ticker' => $ticker,
            'hero'        => $hero,
            'trustCards'  => $trustCards,
            'alertBanners' => $alertBanners,
        ];

        return view('home/index', $data);
    }

    /**
     * Search handler (GET only – no sensitive data).
     */
    public function search()
    {
        $query = $this->request->getGet('q');

        // Sanitize: strip tags and limit length
        $query = strip_tags((string) $query);
        $query = substr($query, 0, 200);

        // In production this would query a database or search index.
        // For now, redirect back to home with query param preserved.
        return redirect()->to('/');
    }
}

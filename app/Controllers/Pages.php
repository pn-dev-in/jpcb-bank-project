<?php

declare(strict_types=1);

namespace App\Controllers;

class Pages extends BaseController
{
    private const SECTION_PAGES = [
        'about' => [
            'sectionTitle' => 'About',
            'default' => 'about',
            'contentView' => 'pages/content/about',
            'pages' => [
                'about' => ['title' => 'About the Bank'],
                'board' => ['title' => 'Board of Directors'],
                'management' => ['title' => 'Management'],
                'awards' => ['title' => 'Awards & Recognition'],
                'gallery' => ['title' => 'Gallery'],
                'branches' => ['title' => 'Branches'],
            ],
        ],
        'deposits' => [
            'sectionTitle' => 'Deposits',
            'default' => 'overview',
            'contentView' => 'pages/content/deposits',
            'pages' => [
                'overview' => ['title' => 'Deposits'],
                'products' => ['title' => 'Deposit Products'],
                'interest-rates' => ['title' => 'Deposit Interest Rates'],
                'savings-current' => ['title' => 'Savings & Current Accounts'],
                'dicgc' => ['title' => 'DICGC Insurance'],
                'deaf' => ['title' => 'DEAF'],
            ],
        ],
        'loans' => [
            'sectionTitle' => 'Loans',
            'default' => 'overview',
            'contentView' => 'pages/content/loans',
            'pages' => [
                'overview' => ['title' => 'Loans'],
                'products' => ['title' => 'Loan Products'],
                'interest-rates' => ['title' => 'Loan Interest Rates'],
                'emi-calculator' => ['title' => 'EMI Calculator', 'script' => 'pages/scripts/emi_calculator'],
            ],
        ],
        'digital' => [
            'sectionTitle' => 'Digital Banking',
            'default' => 'overview',
            'contentView' => 'pages/content/digital',
            'pages' => [
                'overview' => ['title' => 'Digital Banking'],
                'mobile-banking' => ['title' => 'Mobile Banking'],
                'atm' => ['title' => 'ATM Services'],
                'block-card' => ['title' => 'Block Card'],
                'ifsc-micr' => ['title' => 'IFSC / MICR Codes'],
                'rtgs-neft' => ['title' => 'RTGS / NEFT'],
                'upi' => ['title' => 'UPI Service'],
                'digisaathi' => ['title' => 'DigiSaathi'],
            ],
        ],
        'services' => [
            'sectionTitle' => 'Services',
            'default' => 'overview',
            'contentView' => 'pages/content/services',
            'pages' => [
                'overview' => ['title' => 'Services'],
                'charges' => ['title' => 'Service Charges'],
                'lockers' => ['title' => 'Lockers'],
                'insurance' => ['title' => 'Insurance'],
                'positive-pay' => ['title' => 'Positive Pay'],
            ],
        ],
        'complaints' => [
            'sectionTitle' => 'Complaints',
            'default' => 'complaints',
            'contentView' => 'pages/content/complaints',
            'pages' => [
                'complaints' => ['title' => 'Lodge Complaint', 'script' => 'pages/scripts/complaints'],
                'escalation' => ['title' => 'Escalation Matrix'],
            ],
        ],
        'downloads' => [
            'sectionTitle' => 'Downloads',
            'default' => 'overview',
            'contentView' => 'pages/content/downloads',
            'pages' => [
                'overview' => ['title' => 'All Downloads'],
                'forms' => ['title' => 'Forms'],
                'policies' => ['title' => 'Policies'],
                'reports' => ['title' => 'Annual Reports'],
                'notices' => ['title' => 'Notices'],
                'secured-assets' => ['title' => 'Secured Assets'],
                'locker' => ['title' => 'Lockers Documents'],
            ],
        ],
        'rbi' => [
            'sectionTitle' => 'RBI Awareness',
            'default' => 'overview',
            'contentView' => 'pages/content/rbi',
            'pages' => [
                'overview' => ['title' => 'RBI Awareness'],
                'fair-practice' => ['title' => 'Fair Practice Code'],
                'ombudsman' => ['title' => 'Banking Ombudsman'],
                'booklet' => ['title' => 'RBI Booklet'],
                'integrated-ombudsman' => ['title' => 'Integrated Ombudsman'],
                'dos-and-donts' => ['title' => 'RBI Dos and Donts'],
            ],
        ],
    ];

    private const SINGLE_PAGES = [
        'contact' => ['title' => 'Contact Us'],
        'faq' => ['title' => 'Frequently Asked Questions'],
        'accessibility' => ['title' => 'Accessibility'],
        'privacy' => ['title' => 'Privacy Policy'],
        'sitemap' => ['title' => 'Sitemap'],
    ];

    public function section(string $section, ?string $page = null): string
    {
        $sectionConfig = self::SECTION_PAGES[$section] ?? null;

        if ($sectionConfig === null) {
            return $this->notFound();
        }

        $pageKey = $page ?? $sectionConfig['default'];
        $pageConfig = $sectionConfig['pages'][$pageKey] ?? null;

        // 🔥 NEW: For 'downloads' section, if pageKey is not in the hardcoded pages list,
        // try to load it as a dynamic category from the database.
        if ($pageConfig === null && $section === 'downloads') {
            $categoryModel = new \App\Models\DownloadCategoryModel();
            $category = $categoryModel->where('slug', $pageKey)->where('status', 1)->first();
            if ($category) {
                $pageConfig = [
                    'title' => $category['name'],   // Use category name as page title
                    // no script
                ];
                // Flag that this is a dynamic category (optional)
                $contentData['isDynamicCategory'] = true;
            }
        }

        if ($pageConfig === null) {
            return $this->notFound();
        }

        $contentData = [
            'pageKey' => $pageKey,
            'query' => $this->request->getGet(),
        ];

        if (isset($pageConfig['defaultCategory'])) {
            $contentData['defaultCategory'] = $pageConfig['defaultCategory'];
        }

        // Load About section data dynamically
        if ($section === 'about') {
            switch ($pageKey) {
                case 'about':
                    $contentData['aboutContent'] = (new \App\Models\AboutPageContentModel())->where('status', 1)->orderBy('sort_order', 'asc')->first();
                    $contentData['stats'] = (new \App\Models\AboutStatModel())->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $contentData['values'] = (new \App\Models\AboutValueModel())->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $contentData['milestones'] = (new \App\Models\AboutMilestoneModel())->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $contentData['leadershipPreview'] = (new \App\Models\BoardMemberModel())->where('status', 1)->orderBy('sort_order', 'asc')->limit(4)->findAll();
                    $heritageSettingModel = new \App\Models\AboutHeritageSettingModel();
$heritageBadgeModel = new \App\Models\AboutHeritageBadgeModel();

                    $contentData['heritageSettings'] = $heritageSettingModel->getSettings();
$contentData['heritageBadges'] = $heritageBadgeModel->getActiveBadges();

                    $galleryPreview = (new \App\Models\GalleryItemModel())
                        ->select('gallery_items.*, gallery_categories.name as category_name, gallery_categories.slug as category_slug')
                        ->join('gallery_categories', 'gallery_categories.id = gallery_items.category_id')
                        ->where('gallery_items.status', 1)
                        ->orderBy('gallery_items.sort_order', 'asc')
                        ->limit(3)
                        ->findAll();
                    $contentData['galleryPreview'] = $galleryPreview;
                    break;
                case 'board':
                    $boardMembers = (new \App\Models\BoardMemberModel())->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    // Group by category
                    $directorsByCategory = [];
                    foreach ($boardMembers as $member) {
                        $directorsByCategory[$member['category']][] = $member;
                    }
                    $contentData['directorsByCategory'] = $directorsByCategory;
                    break;
                case 'management':
                    $contentData['managementTeam'] = (new \App\Models\ManagementTeamModel())->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    break;
                case 'awards':
                    $contentData['awards'] = (new \App\Models\AwardModel())->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    break;
                case 'gallery':
                    $categoryModel = new \App\Models\GalleryCategoryModel();
                    $itemModel = new \App\Models\GalleryItemModel();
                    $imageModel = new \App\Models\GalleryImageModel();   // <-- add this

                    $categories = $categoryModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $contentData['galleryCategories'] = array_merge([['name' => 'All', 'slug' => 'all']], $categories);

                    $items = $itemModel->select('gallery_items.*, gallery_categories.name as category_name, gallery_categories.slug as category_slug')
                        ->join('gallery_categories', 'gallery_categories.id = gallery_items.category_id')
                        ->where('gallery_items.status', 1)
                        ->where('gallery_categories.status', 1)
                        ->orderBy('gallery_items.sort_order', 'asc')
                        ->findAll();

                    // Attach sub‑photos to each item
                    foreach ($items as &$item) {
                        $item['sub_images'] = $imageModel->where('gallery_item_id', $item['id'])
                            ->where('status', 1)
                            ->orderBy('sort_order', 'asc')
                            ->findAll() ?? [];
                    }

                    $contentData['galleryItems'] = $items;
                    break;

                    break;
            }
        }

        // Load deposits section data dynamically
        if ($section === 'deposits') {
            switch ($pageKey) {
                case 'overview':
                    $contentData['depositCards'] = (new \App\Models\DepositCardModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $contentData['depositQuickLinks'] = (new \App\Models\DepositQuickLinkModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    break;
                case 'products':
                    $productModel = new \App\Models\DepositProductModel();
                    $products = $productModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $featureModel = new \App\Models\DepositProductFeatureModel();
                    foreach ($products as &$product) {
                        $product['features'] = $featureModel->where('product_id', $product['id'])
                            ->orderBy('sort_order', 'asc')
                            ->findColumn('feature') ?? [];
                    }
                    $contentData['depositProducts'] = $products;
                    break;
                case 'interest-rates':
                    $depositRateModel = new \App\Models\DepositInterestRateModel();

                    // Fetch normal rates for Below ₹100 Lakh
                    $contentData['depositRatesBelow1Cr'] = $depositRateModel
                        ->where('status', 1)
                        ->where('scheme_type', 'normal')
                        ->where('amount_slab', 'below_1cr')
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    // Fetch normal rates for ₹100 Lakh & Above
                    $contentData['depositRatesAbove1Cr'] = $depositRateModel
                        ->where('status', 1)
                        ->where('scheme_type', 'normal')
                        ->where('amount_slab', 'above_1cr')
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    // Fetch special schemes (tax_saver and special)
                    $contentData['depositSpecialSchemes'] = $depositRateModel
                        ->where('status', 1)
                        ->whereIn('scheme_type', ['tax_saver', 'special'])
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    // Fetch deposit rates PDF from settings
                    $depositSettingsModel = new \App\Models\DepositSettingModel();
                    $depositRatesPdf = $depositSettingsModel->where('key', 'deposit_rates_pdf')->first();
                    $contentData['depositRatesPdf'] = $depositRatesPdf['value'] ?? '';

                    // Fetch rate notes from settings
                    $rateNotes = $depositSettingsModel->where('key', 'interest_rate_notes')->first();
                    $contentData['rateNotes'] = $rateNotes['value'] ?? '';

                    break;
                case 'savings-current':
                    // ============================================================
                    // SAVINGS ACCOUNT - Fetch the active savings account (only one for frontend)
                    // ============================================================
                    $savingsModel = new \App\Models\SavingsAccountModel();
                    $savingsAccount = $savingsModel
                        ->where('status', 1)
                        ->where('show_in_frontend', 1)
                        ->orderBy('sort_order', 'asc')
                        ->first(); // Only one savings account displayed on frontend

                    if ($savingsAccount) {
                        $savingsFeatureModel = new \App\Models\SavingsAccountFeatureModel();
                        $savingsAccount['features'] = $savingsFeatureModel
                            ->where('savings_account_id', $savingsAccount['id'])
                            ->where('status', 1)
                            ->orderBy('sort_order', 'asc')
                            ->findColumn('feature') ?? [];
                    }
                    $contentData['savingsAccount'] = $savingsAccount;

                    // ============================================================
                    // CURRENT ACCOUNT - Fetch the active current account (only one for frontend)
                    // ============================================================
                    $currentModel = new \App\Models\CurrentAccountModel();
                    $currentAccount = $currentModel
                        ->where('status', 1)
                        ->where('show_in_frontend', 1)
                        ->orderBy('sort_order', 'asc')
                        ->first(); // Only one current account displayed on frontend

                    if ($currentAccount) {
                        $currentFeatureModel = new \App\Models\CurrentAccountFeatureModel();
                        $currentAccount['features'] = $currentFeatureModel
                            ->where('current_account_id', $currentAccount['id'])
                            ->where('status', 1)
                            ->orderBy('sort_order', 'asc')
                            ->findColumn('feature') ?? [];
                    }
                    $contentData['currentAccount'] = $currentAccount;

                    // ============================================================
                    // ELITE ACCOUNT - Fetch the active elite account (only one for frontend)
                    // ============================================================
                    $eliteModel = new \App\Models\EliteAccountModel();
                    $eliteAccount = $eliteModel
                        ->where('status', 1)
                        ->where('show_in_frontend', 1)
                        ->orderBy('sort_order', 'asc')
                        ->first(); // Only one elite account displayed on frontend

                    if ($eliteAccount) {
                        $eliteFeatureModel = new \App\Models\EliteAccountFeatureModel();
                        $eliteAccount['features'] = $eliteFeatureModel
                            ->where('elite_account_id', $eliteAccount['id'])
                            ->where('status', 1)
                            ->orderBy('sort_order', 'asc')
                            ->findColumn('feature') ?? [];
                    }
                    $contentData['eliteAccount'] = $eliteAccount;

                    break;
                case 'dicgc':
                    $settingsModel = new \App\Models\DepositSettingModel();

                    $bannerRow = $settingsModel
                        ->where('key', 'dicgc_banner')
                        ->first();

                    $textRow = $settingsModel
                        ->where('key', 'dicgc_banner_text')
                        ->first();

                    $contentData['dicgcBanner']
                        = $bannerRow['value'] ?? '';

                    $contentData['dicgcBannerText']
                        = $textRow['value'] ?? '';
                    $contentData['dicgcFaqs'] = (new \App\Models\DicgcFaqModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    foreach ($contentData['dicgcFaqs'] as &$faq) {
                        // Force answer to string ALWAYS
                        if (is_array($faq['answer'])) {
                            $faq['answer'] = implode(', ', array_map(function ($v) {
                                return is_array($v) ? json_encode($v) : (string) $v;
                            }, $faq['answer']));
                        } else {
                            $faq['answer'] = (string) ($faq['answer'] ?? '');
                        }
                    }
                    unset($faq);
                    $settingsModel = new \App\Models\DepositSettingModel();
                    $dicgcIntro = $settingsModel->where('key', 'dicgc_intro')->first();
                    $contentData['dicgcIntro'] = $dicgcIntro['value'] ?? '';
                    break;
                case 'deaf':
                    $contentData['deafSteps'] = (new \App\Models\DeafStepModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $settingsModel = new \App\Models\DepositSettingModel();
                    $deafIntro = $settingsModel->where('key', 'deaf_intro')->first();
                    $contentData['deafIntro'] = $deafIntro['value'] ?? '';
                    $depositSettingsModel = new \App\Models\DepositSettingModel();

                    // DEAF claim form PDF
                    $contentData['deafClaimFormPdf'] = $depositSettingsModel
                        ->where('key', 'deaf_claim_form_pdf')
                        ->first()['value'] ?? '';

                    // Documents list (already exists as a line‑separated text)
                    $deafDocumentsRow = $depositSettingsModel->where('key', 'deaf_documents')->first();
                    $contentData['deafDocuments'] = $deafDocumentsRow
                        ? array_filter(array_map('trim', explode("\n", $deafDocumentsRow['value'])))
                        : [];

                    // 🔥 NEW: Fetch DEAF deposits from database
                    $deafDepositModel = new \App\Models\DeafDepositModel();
                    $contentData['deafDeposits'] = $deafDepositModel
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    $deafDeposits = $deafDepositModel->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->paginate(15);

                    $contentData['deafDeposits'] = $deafDeposits;
                    $contentData['pager'] = $deafDepositModel->pager;
                    break;
            }
        }

        if ($section === 'loans') {
            switch ($pageKey) {
                case 'overview':
                    $contentData['loanCards'] = (new \App\Models\LoanCardModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    break;
                case 'products':
                    $schemeModel = new \App\Models\LoanSchemeModel();
                    $contentData['loanSchemes'] = $schemeModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $productModel = new \App\Models\LoanProductModel();
                    $products = $productModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $featureModel = new \App\Models\LoanProductFeatureModel();
                    $docModel = new \App\Models\LoanProductDocumentModel();
                    foreach ($products as &$p) {
                        $p['features'] = $featureModel->where('loan_product_id', $p['id'])
                            ->orderBy('sort_order', 'asc')
                            ->findColumn('feature') ?? [];
                        $p['docs'] = $docModel->where('loan_product_id', $p['id'])
                            ->orderBy('sort_order', 'asc')
                            ->findColumn('document') ?? [];
                    }
                    $contentData['loanProducts'] = $products;
                    break;
                case 'interest-rates':
                    $contentData['loanRates'] = (new \App\Models\LoanInterestRateModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $schemeModel = new \App\Models\LoanInterestSchemeModel();
                    $data['retailSchemes'] = $schemeModel->where('category', 'retail')->where('status', 1)->orderBy('serial_no', 'asc')->findAll();
                    $data['wholesaleSchemes'] = $schemeModel->where('category', 'wholesale')->where('status', 1)->orderBy('serial_no', 'asc')->findAll();
                    $contentData = array_merge($contentData, $data);
                    $noteModel = new \App\Models\LoanInterestNoteModel();
                    $contentData['loanInterestNotes'] = $noteModel
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $serviceSettingModel = new \App\Models\ServiceSettingModel();
                    $contentData['loanRatesPdf'] = $serviceSettingModel
                        ->where('key', 'loan_rates_pdf')
                        ->first()['value'] ?? '';
                    break;
                // case 'emi-calculator' – no dynamic data needed
            }
        }

        if ($section === 'services') {
            switch ($pageKey) {
                case 'overview':
                    $contentData['serviceCards'] = (new \App\Models\ServiceCardModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    break;
                case 'charges':
                    $scModel = new \App\Models\ServiceChargeItemsModel();

                    // Get all active items, ordered by tab, section, sort_order
                    $items = $scModel->where('status', 1)
                        ->orderBy('tab', 'asc')
                        ->orderBy('section', 'asc')
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    // Group into tab → section → rows
                    $grouped = [];
                    foreach ($items as $item) {
                        $tab = $item['tab'];
                        $section = $item['section'];
                        $grouped[$tab][$section][] = $item;
                    }
                    $contentData['chargeTabs'] = $grouped;

                    // Effective date
                    $serviceSettingModel = new \App\Models\ServiceSettingModel();
                    $contentData['chargesEffectiveDate'] = $serviceSettingModel
                        ->where('key', 'charges_effective_date')
                        ->first()['value'] ?? '01 October 2025';

                    // Penal Charges note for Advances tab
                    $contentData['penalChargesNote'] = $serviceSettingModel
                        ->where('key', 'charges_advances_penal_note')
                        ->first()['value'] ?? '';

                    $contentData['cashNote'] = $serviceSettingModel
                        ->where('key', 'charges_cash_note')
                        ->first()['value'] ?? '';

                    $serviceSettingModel = new \App\Models\ServiceSettingModel();
                    $contentData['serviceChargesPdf'] = $serviceSettingModel
                        ->where('key', 'service_charges_pdf')
                        ->first()['value'] ?? '';
                    break;
                case 'insurance':
                    $serviceSettingModel = new \App\Models\ServiceSettingModel();
                    $insuranceIntroRow = $serviceSettingModel
                        ->where('key', 'insurance_intro')
                        ->first();

                    $contentData['insuranceIntro'] = $insuranceIntroRow['value'] ?? '';
                    $generalInsuranceNoteRow = $serviceSettingModel
                        ->where('key', 'general_insurance_note')
                        ->first();
                    $contentData['generalInsuranceNote'] = $generalInsuranceNoteRow['value'] ?? '';
                    $planModel = new \App\Models\InsurancePlanModel();

                    // LIC
                    $contentData['lifePlansLIC'] = $planModel
                        ->where('tab', 'life')
                        ->where('provider', 'LIC')
                        ->where('status', 1)
                        ->orderBy('plan_name, sort_order')
                        ->findAll();

                    // SBI Life
                    $contentData['lifePlansSBI'] = $planModel
                        ->where('tab', 'life')
                        ->where('provider', 'SBI Life')
                        ->where('status', 1)
                        ->orderBy("FIELD(category, 'Retirement Plans', 'Protection Plans')", '', false)  // Retirement first
                        ->orderBy('sort_order', 'ASC')
                        ->findAll();

                    // General Insurance Partners
                    $contentData['generalInsurancePartners'] = $planModel
                        ->where('tab', 'general')
                        ->where('category', 'General Insurance Partners')
                        ->findAll();

                    // General Insurance Products
                    $contentData['generalInsuranceProducts'] = $planModel
                        ->where('tab', 'general')
                        ->where('category', 'General Insurance Products')
                        ->findAll();

                    // Health Insurance Intro
                    $healthInsuranceIntroRow = $serviceSettingModel
                        ->where('key', 'health_insurance_intro')
                        ->first();

                    $contentData['healthInsuranceIntro']
                        = $healthInsuranceIntroRow['value'] ?? '';


                    // Health Insurance Partner
                    $contentData['healthInsurancePartner'] = $planModel
                        ->where('tab', 'health')
                        ->where('category', 'Health Insurance Partner')
                        ->where('status', 1)
                        ->first();


                    // Health Insurance Features
                    $contentData['healthInsuranceFeatures'] = $planModel
                        ->where('tab', 'health')
                        ->where('category', 'Health Insurance Features')
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->findAll();

                    // PMJJBY Rows
                    $contentData['pmjjbyPlans'] = $planModel
                        ->where('tab', 'govt')
                        ->where('category', 'PMJJBY')
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->findAll();


                    // PMSBY Rows
                    $contentData['pmsbyPlans'] = $planModel
                        ->where('tab', 'govt')
                        ->where('category', 'PMSBY')
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->findAll();


                    // PMJJBY Note
                    $pmjjbyNoteRow = $serviceSettingModel
                        ->where('key', 'pmjjby_note')
                        ->first();

                    $contentData['pmjjbyNote']
                        = $pmjjbyNoteRow['value'] ?? '';


                    // PMSBY Note
                    $pmsbyNoteRow = $serviceSettingModel
                        ->where('key', 'pmsby_note')
                        ->first();

                    $contentData['pmsbyNote']
                        = $pmsbyNoteRow['value'] ?? '';

                    // Tie-Up Partners
                    $contentData['tieupPartners'] = $planModel
                        ->where('tab', 'tieup')
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->findAll();

                    // Tie-Up Note
                    $tieupNoteRow = $serviceSettingModel
                        ->where('key', 'tieup_partners_note')
                        ->first();

                    $contentData['tieupPartnersNote']
                        = $tieupNoteRow['value'] ?? '';
                    $productModel = new \App\Models\InsuranceProductModel();
                    $products = $productModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $featureModel = new \App\Models\InsuranceProductFeatureModel();
                    foreach ($products as &$p) {
                        $p['features'] = $featureModel->where('product_id', $p['id'])
                            ->orderBy('sort_order', 'asc')
                            ->findColumn('feature') ?? [];
                    }
                    $contentData['insuranceProducts'] = $products;
                    break;
                case 'lockers':
                    $contentData['lockerSizes'] = (new \App\Models\LockerSizeModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $contentData['lockerFaqs'] = (new \App\Models\LockerFaqModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $settingsModel = new \App\Models\ServiceSettingModel();
                    $eligibility = $settingsModel->where('key', 'locker_eligibility_list')->first();
                    $contentData['lockerEligibility'] = $eligibility ? explode("\n", $eligibility['value']) : [];
                    break;
                case 'positive-pay':
                    $sModel = new \App\Models\ServiceSettingModel();
                    $getSetting = function (string $key, $default = '') use ($sModel) {
                        $row = $sModel->where('key', $key)->first();
                        return $row['value'] ?? $default;
                    };

                    $contentData['ppsBanner'] = $getSetting('positive_pay_banner_html');
                    $contentData['ppsHowItWorks'] = $getSetting('positive_pay_how_it_works');
                    $contentData['ppsSampleImage'] = $getSetting('positive_pay_sample_image', 'assets/img/pps-sample-cheque.png');
                    $contentData['ppsSampleNote'] = $getSetting('positive_pay_sample_note');
                    $contentData['ppsFooterNote'] = $getSetting('positive_pay_footer_note');

                    $fieldsRaw = $getSetting('positive_pay_fields', '');
                    $fields = json_decode($fieldsRaw, true);
                    if (!is_array($fields)) {
                        $fields = array_filter(array_map('trim', explode("\n", $fieldsRaw)));
                    }
                    $contentData['ppsFields'] = $fields;

                    $modesRaw = $getSetting('positive_pay_submission_methods', '[]');
                    $contentData['ppsModes'] = json_decode($modesRaw, true) ?: [];
                    break;
            }
        }

        if ($section === 'digital') {
            $digitalSettingsModel = new \App\Models\DigitalSettingModel();
            $settings = [];
            $allKeys = [
                'digital_overview_intro',
                'mobile_banking_intro',
                'google_play_url',
                'app_store_url',
                'mobile_facility_text',
                'rtgs_description',
                'neft_description',
                'rtgs_features',
                'neft_features',
                'rtgs_neft_steps',
                // ATM Overview (Phase 3)
                'atm_overview_intro',
                'atm_quick_block_text',
                'atm_quick_block_sms',
                'atm_quick_block_note',
                'atm_overview_guidelines_heading',
                // Debit Card (Phase 4)
                'debit_card_heading',
                'debit_card_description',
                'debit_card_bullets',
                'debit_card_usage',
                'debit_card_benefits',
                // ATM Green PIN note
                'atm_green_pin_note',
                // Mobile Banking website
                'jpcb_website_url',
                // Transfer limits
                'imps_limit_per_txn',
                'imps_limit_per_day',
                'neft_limit_per_txn',
                'neft_limit_per_day',
                'mobile_facility_heading',
                'mobile_facility_option1_title',
                'mobile_facility_option1_icon',
                'mobile_facility_option1_text',
                'mobile_facility_option2_title',
                'mobile_facility_option2_icon',
                'mobile_facility_option2_text',
                // UPI Header & Features (CMS)
                'upi_header_eyebrow',
                'upi_header_title',
                'upi_header_description',
                'upi_features_title',
                'upi_features_subtitle',
                'upi_features_overview_title',
                'upi_eligibility_title',
                'upi_eligibility_subtitle',
                'upi_transactions_title',
                'upi_transactions_subtitle',
            ];
            foreach ($allKeys as $key) {
                $row = $digitalSettingsModel->where('key', $key)->first();
                $settings[$key] = $row['value'] ?? '';
            }
            $contentData['digitalSettings'] = $settings;
            $eligibilityModel = new \App\Models\MobileBankingEligibilityModel();
            $contentData['eligibilityRules'] = $eligibilityModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();

            switch ($pageKey) {
                case 'overview':
                    $contentData['digitalServices'] = (new \App\Models\DigitalServiceModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    break;
                case 'mobile-banking':
                    $contentData['mobileFeatures'] = (new \App\Models\MobileFeatureModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findColumn('feature') ?? [];
                    $contentData['mobileSteps'] = (new \App\Models\MobileRegistrationStepModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $contentData['mobileFaqs'] = (new \App\Models\MobileFaqModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    foreach ($contentData['mobileFaqs'] as &$faq) {
                        if (is_array($faq['answer'])) {
                            $faq['answer'] = implode(', ', array_map(function ($v) {
                                return is_array($v) ? json_encode($v) : (string) $v;
                            }, $faq['answer']));
                        } else {
                            $faq['answer'] = (string) ($faq['answer'] ?? '');
                        }
                    }
                    unset($faq);
                    break;
                case 'atm':
                    // 1. Load digital settings for ATM texts
                    $digitalSettingsModel = new \App\Models\DigitalSettingModel();
                    $atmKeys = [
                        'atm_overview_intro',
                        'atm_quick_block_text',
                        'atm_quick_block_sms',
                        'atm_quick_block_note',
                        'atm_overview_guidelines_heading'
                    ];
                    $digitalSettings = [];
                    foreach ($atmKeys as $key) {
                        $row = $digitalSettingsModel->where('key', $key)->first();
                        $digitalSettings[$key] = $row ? $row['value'] : '';
                    }

                    // 2. Load ATMs
                    $atmModel = new \App\Models\AtmLocationModel();
                    $atmLocations = $atmModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll() ?? [];
                    $contentData['atmLocations'] = $atmLocations;

                    // 3. Replace placeholder with actual ATM count in overview intro
                    $atmCount = count($atmLocations);
                    $digitalSettings['atm_overview_intro'] = str_replace('COUNT_PLACEHOLDER', (string) $atmCount, $digitalSettings['atm_overview_intro']);

                    // 4. Load other ATM content (guidelines, services, steps, do's, don'ts)
                    $guidelineModel = new \App\Models\AtmGuidelineModel();
                    $contentData['atmGuidelines'] = $guidelineModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();

                    $serviceModel = new \App\Models\AtmServiceModel();
                    $contentData['atmServices'] = $serviceModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();

                    $obtainStepModel = new \App\Models\AtmObtainStepModel();
                    $contentData['atmObtainSteps'] = $obtainStepModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();

                    $doModel = new \App\Models\AtmDoModel();
                    $contentData['atmDos'] = $doModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $dontModel = new \App\Models\AtmDontModel();
                    $contentData['atmDonts'] = $dontModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    
                    $limitsModel = new \App\Models\DigitalTransactionLimitModel();
                    $contentData['digitalLimits'] = $limitsModel
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();


                    // 5. Pass digital settings to view
                    $contentData['digitalSettings'] = $digitalSettings;

                    // 6. Search handling (already present)
                    $atmSearch = trim($query['q'] ?? '');
                    $filteredAtmLocations = $atmLocations;
                    if ($atmSearch !== '') {
                        $needle = strtolower($atmSearch);
                        $filteredAtmLocations = array_values(array_filter($atmLocations, function ($loc) use ($needle) {
                            $haystack = strtolower(($loc['name'] ?? '') . ' ' . ($loc['address'] ?? '') . ' ' . ($loc['city'] ?? '') . ' ' . ($loc['area'] ?? '') . ' ' . ($loc['pin'] ?? ''));
                            return str_contains($haystack, $needle);
                        }));
                    }
                    $contentData['filteredAtmLocations'] = $filteredAtmLocations;
                    $contentData['atmSearch'] = $atmSearch;

                    break;
                case 'block-card':
                    $contentData['blockCardMethods'] = (new \App\Models\BlockCardMethodModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $contentData['blockCardAfterSteps'] = (new \App\Models\BlockCardAfterStepModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findColumn('step') ?? [];
                    break;
                case 'ifsc-micr':
                    // Use branches table (already exists) – no new model needed
                    // We'll reuse BranchModel to get all branches with IFSC/MICR
                    $branchModel = new \App\Models\BranchModel();
                    $contentData['branchCodes'] = $branchModel->where('ifsc IS NOT NULL', null, false)
                        ->orderBy('ifsc', 'asc')
                        ->findAll();
                    break;
                case 'rtgs-neft':
                    $settingsModel = new \App\Models\DigitalSettingModel();
                    $rtgsDesc = $settingsModel->where('key', 'rtgs_description')->first();
                    $neftDesc = $settingsModel->where('key', 'neft_description')->first();
                    $rtgsFeatures = $settingsModel->where('key', 'rtgs_features')->first();
                    $neftFeatures = $settingsModel->where('key', 'neft_features')->first();
                    $steps = $settingsModel->where('key', 'rtgs_neft_steps')->first();
                    $contentData['rtgsDescription'] = $rtgsDesc['value'] ?? '';
                    $contentData['neftDescription'] = $neftDesc['value'] ?? '';
                    $contentData['rtgsFeatures'] = $rtgsFeatures ? explode("\n", $rtgsFeatures['value']) : [];
                    $contentData['neftFeatures'] = $neftFeatures ? explode("\n", $neftFeatures['value']) : [];
                    $contentData['transferSteps'] = $steps ? json_decode($steps['value'], true) : [];
                    $contentData['rtgsNeftFormPdf'] = $digitalSettingsModel
                        ->where('key', 'rtgs_neft_form_pdf')
                        ->first()['value'] ?? '';

                        $limitsModel = new \App\Models\DigitalTransactionLimitModel();
                    $contentData['digitalLimits'] = $limitsModel
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    break;
                case 'upi':
                    // Legacy static models (still used for other tabs or can be left until fully converted)
                    $contentData['upiBenefits'] = (new \App\Models\UpiBenefitModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findColumn('benefit') ?? [];
                    $contentData['upiSafetyTips'] = (new \App\Models\UpiSafetyTipModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findColumn('tip') ?? [];
                    $contentData['upiLinkingSteps'] = (new \App\Models\UpiLinkingStepModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    $limitsModel = new \App\Models\DigitalTransactionLimitModel();
                    $contentData['digitalLimits'] = $limitsModel
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    // New CMS: load UPI items for the features tab (structured content)
                    $upiItemModel = new \App\Models\UpiItemModel();
                    $upiItems = $upiItemModel
                        ->where('tab', 'features')
                        ->where('status', 1)
                        ->orderBy('section, sort_order')
                        ->findAll();


                    // Group by section, then by type
                    $upiFeatures = [];
                    foreach ($upiItems as $item) {
                        $section = $item['section'];
                        $type = $item['type'];
                        if (!isset($upiFeatures[$section])) {
                            $upiFeatures[$section] = [];
                        }
                        if (!isset($upiFeatures[$section][$type])) {
                            $upiFeatures[$section][$type] = [];
                        }
                        $upiFeatures[$section][$type][] = $item;
                    }
                    $contentData['upiFeatures'] = $upiFeatures;
                    // Eligibility tab data
                    $contentData['eligibilityChecklist'] = $upiItemModel
                        ->where('tab', 'eligibility')
                        ->where('section', 'who_can_avail')
                        ->where('status', 1)
                        ->orderBy('sort_order')
                        ->findAll();

                    $linkingStepModel = new \App\Models\UpiLinkingStepModel();
                    $contentData['registrationSteps'] = $linkingStepModel
                        ->where('tab', 'eligibility')
                        ->where('section', 'registration')
                        ->where('status', 1)
                        ->orderBy('sort_order')
                        ->findAll();
                    $contentData['pinSteps'] = $linkingStepModel
                        ->where('tab', 'eligibility')
                        ->where('section', 'pin_generation')
                        ->where('status', 1)
                        ->orderBy('sort_order')
                        ->findAll();
                    // Transactions tab
                    $contentData['financialItems'] = $upiItemModel
                        ->where('tab', 'transactions')
                        ->where('section', 'financial')
                        ->where('status', 1)
                        ->orderBy('sort_order')
                        ->findAll();
                    $contentData['nonFinancialItems'] = $upiItemModel
                        ->where('tab', 'transactions')
                        ->where('section', 'non_financial')
                        ->where('status', 1)
                        ->orderBy('sort_order')
                        ->findAll();
                    $contentData['pushSteps'] = $linkingStepModel
                        ->where('tab', 'transactions')
                        ->where('section', 'push')
                        ->where('status', 1)
                        ->orderBy('sort_order')
                        ->findAll();
                    $contentData['pullSteps'] = $linkingStepModel
                        ->where('tab', 'transactions')
                        ->where('section', 'pull')
                        ->where('status', 1)
                        ->orderBy('sort_order')
                        ->findAll();
                    // Stat pills
                    $contentData['statPills'] = $upiItemModel
                        ->where('tab', 'features')
                        ->where('section', 'stat_pills')
                        ->where('type', 'stat')
                        ->where('status', 1)
                        ->orderBy('sort_order')
                        ->findAll();

                    // Transaction limits
                    $limitsModel = new \App\Models\UpiTransactionLimitModel();
                    $contentData['upiLimits'] = $limitsModel->where('status', 1)->orderBy('sort_order')->findAll();
                    break;
                case 'digisaathi':
                    // Fetch categories (existing)
                    $contentData['digisaathiCategories'] = (new \App\Models\DigisaathiCategoryModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    // Fetch contacts (existing)
                    $contentData['digisaathiContacts'] = (new \App\Models\DigisaathiContactModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    // Fetch settings (new)
                    $contentData['digisaathiSettings'] = [];
                    $settings = (new \App\Models\DigisaathiSettingModel())->findAll();
                    foreach ($settings as $setting) {
                        $contentData['digisaathiSettings'][$setting['key']] = $setting['value'];
                    }

                    // Fetch languages (new) - IMPORTANT: Use the correct variable name
                    $contentData['digisaathiLanguages'] = (new \App\Models\DigisaathiLanguageModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    // Fetch services (new)
                    $contentData['digisaathiServices'] = (new \App\Models\DigisaathiServiceModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    // Fetch support features (new)
                    $contentData['digisaathiSupportFeatures'] = (new \App\Models\DigisaathiSupportFeatureModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    // Fetch images by section (new)
                    $contentData['digisaathiImages'] = [];
                    $images = (new \App\Models\DigisaathiImageModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();

                    foreach ($images as $image) {
                        $contentData['digisaathiImages'][$image['section']] = $image;
                    }
                    break;
            }
        }

        if ($section === 'downloads') {
            $downloadModel = new \App\Models\DownloadModel();
            $categoryModel = new \App\Models\DownloadCategoryModel();

            $allCategories = $categoryModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
            $contentData['categories'] = $allCategories;

            if ($pageKey === 'overview' || $pageKey === 'downloads') {
                $filteredDownloads = $downloadModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                $selectedCategorySlug = 'all';
            } else {
                $category = $categoryModel->where('slug', $pageKey)->first();
                if ($category) {
                    $filteredDownloads = $downloadModel->where('category_id', $category['id'])
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $selectedCategorySlug = $category['slug'];
                } else {
                    // Category not found – return 404
                    return $this->notFound();
                }
            }

            $contentData['filteredDownloads'] = $filteredDownloads ?? [];
            $contentData['selectedCategorySlug'] = $selectedCategorySlug;
        }

        if ($section === 'complaints') {

            // For both sub‑pages, load categories (used in the complaint form)
            $contentData['complaintCategories'] = (new \App\Models\ComplaintCategoryModel())
                ->where('status', 1)
                ->orderBy('sort_order', 'asc')
                ->findColumn('name') ?? [];
            // 🔥 NEW: Fetch all active branches for the complaint form
            $branchModel = new \App\Models\BranchModel();
            $contentData['branches'] = $branchModel
                ->where('status', 1)
                ->orderBy('branch_name', 'asc')
                ->findAll();

            switch ($pageKey) {
                case 'escalation':
                    $contentData['escalationLevels'] = (new \App\Models\ComplaintEscalationLevelModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    break;
                // For 'complaints' page key, we only need categories (the rest of the form is static/JS)
            }
            // For both sub‑pages, load categories (used in the complaint form)
            $contentData['complaintCategories'] = (new \App\Models\ComplaintCategoryModel())
                ->where('status', 1)
                ->orderBy('sort_order', 'asc')
                ->findColumn('name') ?? [];
        }

        if ($section === 'rbi') {
            switch ($pageKey) {
                case 'overview':
                    $contentData['rbiTopics'] = (new \App\Models\RbiTopicModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    break;
                case 'fair-practice':
                    $contentData['fairPracticePrinciples'] = (new \App\Models\RbiFairPracticePrincipleModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findColumn('principle') ?? [];
                    $settingsModel = new \App\Models\RbiSettingModel();

                    $fairPracticePdfRow = $settingsModel
                        ->where('key', 'fair_practice_pdf')
                        ->first();

                    $contentData['fairPracticePdf']
                        = $fairPracticePdfRow['value'] ?? '';
                    break;
                case 'ombudsman':
                    $contentData['ombudsmanReasons'] = (new \App\Models\RbiOmbudsmanReasonModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findColumn('reason') ?? [];
                    $contentData['ombudsmanOfficers']
                        = (new \App\Models\RbiOmbudsmanOfficerModel())
                            ->where('status', 1)
                            ->orderBy('sort_order', 'asc')
                            ->findAll();
                    $settingsModel = new \App\Models\RbiSettingModel();
                    $intro = $settingsModel->where('key', 'ombudsman_intro')->first();
                    $contentData['ombudsmanIntro'] = $intro['value'] ?? '';
                    break;
                case 'booklet':
                    $contentData['bookletTopics'] = (new \App\Models\RbiBookletTopicModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findColumn('topic') ?? [];
                    $rbiSettingsModel = new \App\Models\RbiSettingModel();
                    $contentData['rbiSettings'] = $rbiSettingsModel->findAll() ?: [];
                    // or grab just the key:
                    $contentData['bookletPdf'] = $rbiSettingsModel->where('key', 'booklet_pdf')->first()['value'] ?? '';
                    $settingsModel = new \App\Models\RbiSettingModel();
                    $intro = $settingsModel->where('key', 'booklet_intro')->first();
                    $contentData['bookletIntro'] = $intro['value'] ?? '';
                    break;
                case 'integrated-ombudsman':
                    $contentData['integratedSteps'] = (new \App\Models\RbiIntegratedStepModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $settingsModel = new \App\Models\RbiSettingModel();

                    $bannerRow = $settingsModel
                        ->where('key', 'integrated_ombudsman_banner')
                        ->first();

                    $contentData['integratedOmbudsmanBanner']
                        = $bannerRow['value'] ?? '';

                    $intro = $settingsModel
                        ->where('key', 'integrated_ombudsman_intro')
                        ->first();

                    $contentData['integratedOmbudsmanIntro']
                        = $intro['value'] ?? '';
                    $pdfRow = $settingsModel
                        ->where('key', 'ombudsman_pdf')
                        ->first();

                    $contentData['ombudsmanPdf']
                        = $pdfRow['value'] ?? '';
                    break;
                case 'dos-and-donts':
                    $contentData['dos'] = (new \App\Models\RbiDoModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findColumn('item') ?? [];
                    $contentData['donts'] = (new \App\Models\RbiDontModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findColumn('item') ?? [];
                    break;
            }
        }

        // 🔥 NEW: Fetch branches from DB for the branches page
        if ($pageKey === 'branches') {
            $branchModel = new \App\Models\BranchModel();
            $contentData['branches'] = $branchModel->where('status', 1)
                ->orderBy('ifsc', 'asc')
                ->findAll();
        }

        return $this->renderPage([
            'title' => $pageConfig['title'],
            'breadcrumbs' => $this->buildSectionBreadcrumbs($section, $pageKey, $sectionConfig, $pageConfig),
            'contentView' => $sectionConfig['contentView'],
            'contentData' => $contentData,
            'scriptsView' => $pageConfig['script'] ?? null,
        ]);
    }

    public function single(string $page): string
    {
        $pageConfig = self::SINGLE_PAGES[$page] ?? null;

        if ($pageConfig === null) {
            return $this->notFound();
        }

        $contentData = [
            'pageKey' => $page,
            'query' => $this->request->getGet(),
        ];

        // Fetch data for each dynamic page
        switch ($page) {
            case 'faq':
                $categoryModel = new \App\Models\FaqCategoryModel();
                $faqModel = new \App\Models\FaqModel();

                $contentData['faqCategories'] = $categoryModel
                    ->where('status', 1)
                    ->orderBy('sort_order', 'asc')
                    ->findAll();

                $contentData['faqs'] = $faqModel
                    ->select('faqs.*, faq_categories.name as category_name, faq_categories.slug as category_slug')
                    ->join('faq_categories', 'faq_categories.id = faqs.category_id')
                    ->where('faqs.status', 1)
                    ->orderBy('faqs.sort_order', 'asc')
                    ->findAll();
                break;

            case 'privacy':
                $privacyModel = new \App\Models\PrivacyPolicySectionModel();
                $contentData['privacySections'] = $privacyModel
                    ->where('status', 1)
                    ->orderBy('sort_order', 'asc')
                    ->findAll();
                break;

            case 'accessibility':
                $accessibilityModel = new \App\Models\AccessibilityFeatureModel();
                $contentData['accessibilityFeatures'] = $accessibilityModel
                    ->where('status', 1)
                    ->orderBy('sort_order', 'asc')
                    ->findColumn('feature') ?? [];
                break;

            case 'sitemap':
                $sectionModel = new \App\Models\SitemapSectionModel();
                $linkModel = new \App\Models\SitemapLinkModel();

                $sections = $sectionModel
                    ->where('status', 1)
                    ->orderBy('sort_order', 'asc')
                    ->findAll();

                foreach ($sections as &$section) {
                    $section['links'] = $linkModel
                        ->where('section_id', $section['id'])
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                }

                $contentData['sitemapSections'] = $sections;
                break;
        }

        // ✅ SAFE FALLBACKS (IMPORTANT)
        $contentData['faqCategories'] = $contentData['faqCategories'] ?? [];
        $contentData['faqs'] = $contentData['faqs'] ?? [];
        $contentData['privacySections'] = $contentData['privacySections'] ?? [];
        $contentData['accessibilityFeatures'] = $contentData['accessibilityFeatures'] ?? [];
        $contentData['sitemapSections'] = $contentData['sitemapSections'] ?? [];

        return $this->renderPage([
            'title' => $pageConfig['title'],
            'breadcrumbs' => [['label' => $pageConfig['title']]],
            'contentView' => 'pages/content/utility',
            'contentData' => $contentData,
            'scriptsView' => null,
        ]);
    }

    public function notFound(): string
    {
        $this->response->setStatusCode(404);

        return view('pages/not_found', [
            'title' => 'Page Not Found',
            'description' => 'The requested page could not be found.',
        ]);
    }

    /**
     * @param array<string, mixed> $page
     */
    private function renderPage(array $page): string
    {
        return view('pages/show', [
            'title' => $page['title'],
            'description' => $page['description'] ?? ($page['title'] . ' | The Jalgaon Peoples Co-Op. Bank Ltd.'),
            'breadcrumbs' => $page['breadcrumbs'] ?? [],
            'contentView' => $page['contentView'],
            'contentData' => $page['contentData'] ?? [],
            'scriptsView' => $page['scriptsView'] ?? null,
            'scriptsData' => $page['scriptsData'] ?? [],
        ]);
    }

    /**
     * @param array<string, mixed> $sectionConfig
     * @param array<string, mixed> $pageConfig
     * @return list<array{label: string, href?: string}>
     */
    private function buildSectionBreadcrumbs(string $section, string $pageKey, array $sectionConfig, array $pageConfig): array
    {
        if ($pageKey === $sectionConfig['default']) {
            return [
                ['label' => $pageConfig['title']],
            ];
        }

        return [
            [
                'label' => $sectionConfig['sectionTitle'],
                'href' => $section,
            ],
            [
                'label' => $pageConfig['title'],
            ],
        ];
    }

    public function deafSearch()
    {
        $name = trim($this->request->getGet('name') ?? '');
        $address = trim($this->request->getGet('address') ?? '');

        if (strlen($name) < 4) {
            return redirect()->to('/deposits/deaf')->with('error', 'Please enter at least 4 characters for name search.');
        }

        session()->setFlashdata('search_name', $name);
        session()->setFlashdata('search_address', $address);
        session()->setFlashdata('search_performed', true);

        return redirect()->to('/deposits/deaf')->with('info', 'DEAF search feature is under development. Please contact your branch.');
    }
}

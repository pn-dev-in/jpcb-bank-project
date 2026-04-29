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
                'about'      => ['title' => 'About the Bank'],
                'board'      => ['title' => 'Board of Directors'],
                'management' => ['title' => 'Management'],
                'awards'     => ['title' => 'Awards & Recognition'],
                'gallery'    => ['title' => 'Gallery'],
                'branches'   => ['title' => 'Branches'],
            ],
        ],
        'deposits' => [
            'sectionTitle' => 'Deposits',
            'default' => 'overview',
            'contentView' => 'pages/content/deposits',
            'pages' => [
                'overview'         => ['title' => 'Deposits'],
                'products'         => ['title' => 'Deposit Products'],
                'interest-rates'   => ['title' => 'Deposit Interest Rates'],
                'savings-current'  => ['title' => 'Savings & Current Accounts'],
                'dicgc'            => ['title' => 'DICGC Insurance'],
                'deaf'             => ['title' => 'DEAF'],
            ],
        ],
        'loans' => [
            'sectionTitle' => 'Loans',
            'default' => 'overview',
            'contentView' => 'pages/content/loans',
            'pages' => [
                'overview'       => ['title' => 'Loans'],
                'products'       => ['title' => 'Loan Products'],
                'interest-rates' => ['title' => 'Loan Interest Rates'],
                'emi-calculator' => ['title' => 'EMI Calculator', 'script' => 'pages/scripts/emi_calculator'],
            ],
        ],
        'digital' => [
            'sectionTitle' => 'Digital Banking',
            'default' => 'overview',
            'contentView' => 'pages/content/digital',
            'pages' => [
                'overview'       => ['title' => 'Digital Banking'],
                'mobile-banking' => ['title' => 'Mobile Banking'],
                'atm'            => ['title' => 'ATM Services'],
                'block-card'     => ['title' => 'Block Card'],
                'ifsc-micr'      => ['title' => 'IFSC / MICR Codes'],
                'rtgs-neft'      => ['title' => 'RTGS / NEFT'],
                'upi'            => ['title' => 'UPI Service'],
                'digisaathi'     => ['title' => 'DigiSaathi'],
            ],
        ],
        'services' => [
            'sectionTitle' => 'Services',
            'default' => 'overview',
            'contentView' => 'pages/content/services',
            'pages' => [
                'overview'     => ['title' => 'Services'],
                'charges'      => ['title' => 'Service Charges'],
                'lockers'      => ['title' => 'Lockers'],
                'insurance'    => ['title' => 'Insurance'],
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
            'default' => 'downloads',
            'contentView' => 'pages/content/downloads',
            'pages' => [
                'downloads'      => ['title' => 'Downloads & Forms'],
                'forms'          => ['title' => 'Forms', 'defaultCategory' => 'Forms'],
                'policies'       => ['title' => 'Policies', 'defaultCategory' => 'Policies'],
                'reports'        => ['title' => 'Reports', 'defaultCategory' => 'Reports'],
                'notices'        => ['title' => 'Notices', 'defaultCategory' => 'Notices'],
                'secured-assets' => ['title' => 'Secured Assets', 'defaultCategory' => 'Secured Assets'],
            ],
        ],
        'rbi' => [
            'sectionTitle' => 'RBI Awareness',
            'default' => 'overview',
            'contentView' => 'pages/content/rbi',
            'pages' => [
                'overview'               => ['title' => 'RBI Awareness'],
                'fair-practice'          => ['title' => 'Fair Practice Code'],
                'ombudsman'              => ['title' => 'Banking Ombudsman'],
                'booklet'                => ['title' => 'RBI Booklet'],
                'integrated-ombudsman'   => ['title' => 'Integrated Ombudsman'],
                'dos-and-donts'          => ['title' => 'RBI Dos and Donts'],
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

        $pageKey    = $page ?? $sectionConfig['default'];
        $pageConfig = $sectionConfig['pages'][$pageKey] ?? null;

        if ($pageConfig === null) {
            return $this->notFound();
        }

        $contentData = [
            'pageKey' => $pageKey,
            'query'   => $this->request->getGet(),
        ];

        if (isset($pageConfig['defaultCategory'])) {
            $contentData['defaultCategory'] = $pageConfig['defaultCategory'];
        }

        // Load About section data dynamically
        if ($section === 'about') {
            switch ($pageKey) {
                case 'about':
                    $contentData['stats'] = (new \App\Models\AboutStatModel())->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $contentData['values'] = (new \App\Models\AboutValueModel())->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $contentData['milestones'] = (new \App\Models\AboutMilestoneModel())->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
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
                    $categories = $categoryModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $contentData['galleryCategories'] = array_merge([['name' => 'All', 'slug' => 'all']], $categories);
                    $contentData['galleryItems'] = $itemModel->select('gallery_items.*, gallery_categories.name as category_name, gallery_categories.slug as category_slug')
                        ->join('gallery_categories', 'gallery_categories.id = gallery_items.category_id')
                        ->where('gallery_items.status', 1)
                        ->orderBy('gallery_items.sort_order', 'asc')
                        ->findAll();

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
                    $contentData['depositRates'] = (new \App\Models\DepositInterestRateModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $settingsModel = new \App\Models\DepositSettingModel();
                    $rateNotes = $settingsModel->where('key', 'interest_rate_notes')->first();
                    $contentData['rateNotes'] = $rateNotes['value'] ?? '';
                    break;
                case 'savings-current':
                    $savingsModel = new \App\Models\SavingsAccountModel();
                    $savingsAccounts = $savingsModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $savingsFeatureModel = new \App\Models\SavingsAccountFeatureModel();
                    foreach ($savingsAccounts as &$acc) {
                        $acc['features'] = $savingsFeatureModel->where('savings_account_id', $acc['id'])
                            ->orderBy('sort_order', 'asc')
                            ->findColumn('feature') ?? [];
                    }
                    $contentData['savingsAccounts'] = $savingsAccounts;

                    $currentModel = new \App\Models\CurrentAccountModel();
                    $currentAccounts = $currentModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
                    $currentFeatureModel = new \App\Models\CurrentAccountFeatureModel();
                    foreach ($currentAccounts as &$acc) {
                        $acc['features'] = $currentFeatureModel->where('current_account_id', $acc['id'])
                            ->orderBy('sort_order', 'asc')
                            ->findColumn('feature') ?? [];
                    }
                    $contentData['currentAccounts'] = $currentAccounts;

                    $settingsModel = new \App\Models\DepositSettingModel();
                    $documents = $settingsModel->where('key', 'savings_documents')->first();
                    $contentData['savingsDocuments'] = $documents ? explode("\n", $documents['value']) : [];
                    break;
                case 'dicgc':
                    $contentData['dicgcFaqs'] = (new \App\Models\DicgcFaqModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    foreach ($contentData['dicgcFaqs'] as &$faq) {
                        // Force answer to string ALWAYS
                        if (is_array($faq['answer'])) {
                            $faq['answer'] = implode(', ', array_map(function ($v) {
                                return is_array($v) ? json_encode($v) : (string)$v;
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
                    $contentData['serviceCharges'] = (new \App\Models\ServiceChargeModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    break;
                case 'insurance':
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
                    $settingsModel = new \App\Models\ServiceSettingModel();
                    $fieldsRow = $settingsModel->where('key', 'positive_pay_fields')->first();
                    $contentData['positivePayFields'] = $fieldsRow ? explode("\n", $fieldsRow['value']) : [];
                    $methodsRow = $settingsModel->where('key', 'positive_pay_submission_methods')->first();
                    $contentData['positivePayMethods'] = $methodsRow ? json_decode($methodsRow['value'], true) : [];
                    $importantRow = $settingsModel->where('key', 'positive_pay_important_note')->first();
                    $contentData['positivePayImportantNote'] = $importantRow['value'] ?? '';
                    break;
            }
        }

        if ($section === 'digital') {
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
                                return is_array($v) ? json_encode($v) : (string)$v;
                            }, $faq['answer']));
                        } else {
                            $faq['answer'] = (string) ($faq['answer'] ?? '');
                        }
                    }
                    unset($faq);
                    break;
                case 'atm':
                    $contentData['atmLocations'] = (new \App\Models\AtmLocationModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    // Search handled in view using $query['q']
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
                        ->orderBy('branch_name', 'asc')
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
                    break;
                case 'upi':
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
                    break;
                case 'digisaathi':
                    $contentData['digisaathiCategories'] = (new \App\Models\DigisaathiCategoryModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    $contentData['digisaathiContacts'] = (new \App\Models\DigisaathiContactModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findAll();
                    break;
            }
        }

        if ($section === 'downloads') {
            $downloadModel = new \App\Models\DownloadModel();
            $allDownloads = $downloadModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();

            $contentData['allDownloads'] = $allDownloads;
            $contentData['downloadCategories'] = ['All', 'Forms', 'Policies', 'Reports', 'Notices', 'Secured Assets'];
            // Note: The view will handle filtering based on query params and defaultCategory
        }

        if ($section === 'complaints') {
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
                    break;
                case 'ombudsman':
                    $contentData['ombudsmanReasons'] = (new \App\Models\RbiOmbudsmanReasonModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findColumn('reason') ?? [];
                    $settingsModel = new \App\Models\RbiSettingModel();
                    $intro = $settingsModel->where('key', 'ombudsman_intro')->first();
                    $contentData['ombudsmanIntro'] = $intro['value'] ?? '';
                    break;
                case 'booklet':
                    $contentData['bookletTopics'] = (new \App\Models\RbiBookletTopicModel())
                        ->where('status', 1)
                        ->orderBy('sort_order', 'asc')
                        ->findColumn('topic') ?? [];
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
                    $intro = $settingsModel->where('key', 'integrated_ombudsman_intro')->first();
                    $contentData['integratedOmbudsmanIntro'] = $intro['value'] ?? '';
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
            $contentData['branches'] = $branchModel->where('status', 1)->orderBy('branch_name', 'asc')->findAll();
            $data['branches'] = $branchModel->findAll();
        }

        return $this->renderPage([
            'title'       => $pageConfig['title'],
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
            'query'   => $this->request->getGet(),
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
            'title'       => $pageConfig['title'],
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
            'title'       => 'Page Not Found',
            'description' => 'The requested page could not be found.',
        ]);
    }

    /**
     * @param array<string, mixed> $page
     */
    private function renderPage(array $page): string
    {
        return view('pages/show', [
            'title'       => $page['title'],
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
                'href'  => $section,
            ],
            [
                'label' => $pageConfig['title'],
            ],
        ];
    }
}

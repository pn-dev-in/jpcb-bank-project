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

        // 🔥 NEW: Fetch branches from DB for the branches page
        if ($pageKey === 'branches') {
            $branchModel = new \App\Models\BranchModel();
            $contentData['branches'] = $branchModel->orderBy('branch_name', 'asc')->findAll();
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

        return $this->renderPage([
            'title'       => $pageConfig['title'],
            'breadcrumbs' => [
                ['label' => $pageConfig['title']],
            ],
            'contentView' => 'pages/content/utility',
            'contentData' => [
                'pageKey' => $page,
                'query'   => $this->request->getGet(),
            ],
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

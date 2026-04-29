<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Permissions for <span class="text-primary"><?= esc($role['name']) ?></span></h1>
            <p class="text-muted mt-1">Grant or revoke module‑level permissions. Hover over any action for a detailed description.</p>
        </div>
        <div class="btn-toolbar">
            <button type="button" class="btn btn-outline-primary me-2" id="globalSelectAll">
                <i class="ti ti-select-all me-1"></i> Select All
            </button>
            <button type="button" class="btn btn-outline-secondary" id="globalDeselectAll">
                <i class="ti ti-clear-formatting me-1"></i> Deselect All
            </button>
        </div>
    </div>

    <form method="post" action="<?= base_url('admin/roles/save/'.$role['id']) ?>" id="permForm">
        <?= csrf_field() ?>

        <!-- Search & filter bar -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body py-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="ti ti-search"></i></span>
                            <input type="text" id="moduleSearch" class="form-control" placeholder="Filter modules...">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="badge bg-light text-dark me-2"><i class="ti ti-info-circle"></i> Grey rows = no permissions</span>
                        <span class="badge bg-light-primary text-primary"><i class="ti ti-checkbox"></i> Blue rows = at least one permission</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permission categories (collapsible) -->
        <div class="accordion" id="permAccordion">
            <?php
            // Group modules into categories – Dashboard added at the top
            $categories = [
                'Dashboard' => [
                    'dashboard' => 'Dashboard',
                ],
                'Website & Content' => [
                    'homepage' => 'Hero Content',
                    'notices' => 'Notices',
                    'products' => 'Products & Services',
                    'ticker' => 'Ticker',
                    'quick_actions' => 'Quick Actions',
                    'safety_section' => 'Safety Section',
                    'grievance_steps' => 'Grievance Steps',
                    'trust_stats' => 'Trust Statistics',
                    'alert_banners' => 'Alert Banner Hero',
                ],
                'About Us' => [
                    'about_stats' => 'About Stats',
                    'about_values' => 'Core Values',
                    'about_milestones' => 'Milestones',
                    'board_members' => 'Board Members',
                    'management_team' => 'Management Team',
                    'awards' => 'Awards',
                    'gallery_categories' => 'Gallery Categories',
                    'gallery_items' => 'Gallery Items',
                ],
                'Deposits' => [
                    'deposit_settings' => 'Deposit Settings',
                    'deposit_cards' => 'Deposit Cards',
                    'deposit_quick_links' => 'Quick Links',
                    'deposit_products' => 'Deposit Products',
                    'deposit_interest_rates' => 'Interest Rates',
                    'savings_accounts' => 'Savings Accounts',
                    'current_accounts' => 'Current Accounts',
                    'dicgc_faqs' => 'DICGC FAQs',
                    'deaf_steps' => 'DEAF Steps',
                ],
                'Loans' => [
                    'loan_cards' => 'Loan Cards',
                    'loan_products' => 'Loan Products',
                    'loan_interest_rates' => 'Loan Interest Rates',
                ],
                'Services' => [
                    'service_settings' => 'Service Settings',
                    'service_cards' => 'Service Cards',
                    'service_charges' => 'Service Charges',
                    'insurance_products' => 'Insurance Products',
                    'locker_sizes' => 'Locker Sizes',
                    'locker_faqs' => 'Locker FAQs',
                ],
                'Digital Banking' => [
                    'digital_settings' => 'Digital Settings',
                    'digital_services' => 'Digital Services',
                    'mobile_features' => 'Mobile Features',
                    'mobile_registration_steps' => 'Registration Steps',
                    'mobile_faqs' => 'Mobile FAQs',
                    'atm_locations' => 'ATM Locations',
                    'block_card_methods' => 'Block Card Methods',
                    'block_card_after_steps' => 'After‑Block Steps',
                    'upi_benefits' => 'UPI Benefits',
                    'upi_safety_tips' => 'UPI Safety Tips',
                    'upi_linking_steps' => 'UPI Linking Steps',
                    'digisaathi_categories' => 'DigiSaathi Categories',
                    'digisaathi_contacts' => 'DigiSaathi Contacts',
                ],
                'Downloads & Complaints' => [
                    'downloads' => 'Downloads',
                    'complaints' => 'User Complaints',
                    'complaint_categories' => 'Complaint Categories',
                    'complaint_escalation_levels' => 'Escalation Levels',
                ],
                'RBI Awareness' => [
                    'rbi_settings' => 'RBI Settings',
                    'rbi_topics' => 'RBI Topics',
                    'rbi_fair_practice_principles' => 'Fair Practice Principles',
                    'rbi_dos' => 'Do\'s',
                    'rbi_donts' => 'Don\'ts',
                    'rbi_ombudsman_reasons' => 'Ombudsman Reasons',
                    'rbi_booklet_topics' => 'Booklet Topics',
                    'rbi_integrated_steps' => 'Integrated Steps',
                ],
                'Utility & Configuration' => [
                    'faq_categories' => 'FAQ Categories',
                    'faqs' => 'FAQs',
                    'accessibility_features' => 'Accessibility Features',
                    'privacy_policy_sections' => 'Privacy Policy',
                    'sitemap_sections' => 'Sitemap Sections',
                    'sitemap_links' => 'Sitemap Links',
                    'branches' => 'Branches',
                    'careers' => 'Careers',
                ],
                'System & Security' => [
                    'admin_users' => 'Admin Users',
                    'roles_permissions' => 'Roles & Permissions',
                    'general_settings' => 'General Settings',
                    'social_links' => 'Social Links',
                    'activity_logs' => 'Activity Logs',
                ],
            ];

            $accordionIndex = 0;
            foreach ($categories as $categoryName => $modules):
                $accordionIndex++;
                $collapsed = ($accordionIndex !== 1) ? 'collapsed' : '';
                $show = ($accordionIndex === 1) ? 'show' : '';
            ?>
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header" id="heading<?= $accordionIndex ?>">
                    <button class="accordion-button <?= $collapsed ?> bg-light text-dark fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $accordionIndex ?>" aria-expanded="<?= $accordionIndex === 1 ? 'true' : 'false' ?>">
                        <i class="ti ti-folder-open me-2"></i> <?= $categoryName ?> <span class="badge bg-secondary ms-2"><?= count($modules) ?> modules</span>
                    </button>
                </h2>
                <div id="collapse<?= $accordionIndex ?>" class="accordion-collapse collapse <?= $show ?>" data-bs-parent="#permAccordion">
                    <div class="accordion-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 30px">
                                            <input type="checkbox" class="category-select-all" data-category="<?= $accordionIndex ?>">
                                        </th>
                                        <th>Module</th>
                                        <?php foreach (Config\PermissionModules::$actions as $action): ?>
                                            <th class="text-center"><?= ucfirst($action) ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($modules as $moduleKey => $moduleLabel):
                                        // Skip if the permission data doesn't exist in the passed array
                                        if (!isset($permissionsByModule[$moduleKey])) continue;
                                        $hasAny = false;
                                        foreach (Config\PermissionModules::$actions as $action) {
                                            $permId = $permissionsByModule[$moduleKey][$action] ?? null;
                                            if ($permId && in_array($permId, $assigned)) {
                                                $hasAny = true;
                                                break;
                                            }
                                        }
                                    ?>
                                    <tr class="module-row <?= $hasAny ? 'table-primary' : '' ?>" data-module-key="<?= $moduleKey ?>" data-category="<?= $accordionIndex ?>">
                                        <td class="text-center">
                                            <input type="checkbox" class="module-select-all" data-module="<?= $moduleKey ?>">
                                        </td>
                                        <td class="fw-semibold">
                                            <?= esc($moduleLabel) ?>
                                            <?php if ($hasAny): ?>
                                                <span class="badge bg-primary ms-2">active</span>
                                            <?php endif; ?>
                                        </td>
                                        <?php foreach (Config\PermissionModules::$actions as $action):
                                            $permId = $permissionsByModule[$moduleKey][$action] ?? null;
                                            $checked = ($permId && in_array($permId, $assigned)) ? 'checked' : '';
                                        ?>
                                        <td class="text-center">
                                            <?php if ($permId): ?>
                                                <div class="form-check justify-content-center d-flex">
                                                    <input type="checkbox" class="form-check-input perm-checkbox <?= $moduleKey ?>-perm" name="permissions[]" value="<?= $permId ?>" <?= $checked ?>>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="card-footer bg-white mt-4 p-3 text-end border-0 shadow-sm">
            <button type="submit" class="btn btn-primary px-4">
                <i class="ti ti-device-floppy me-1"></i> Update Permissions
            </button>
            <a href="<?= base_url('admin/roles') ?>" class="btn btn-secondary px-4 ms-2">
                <i class="ti ti-arrow-left me-1"></i> Cancel
            </a>
        </div>
    </form>
</div>

<!-- JavaScript (same as before, no changes needed) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const allPermCheckboxes = () => document.querySelectorAll('.perm-checkbox');

    const globalSelectBtn = document.getElementById('globalSelectAll');
    const globalDeselectBtn = document.getElementById('globalDeselectAll');
    if (globalSelectBtn) {
        globalSelectBtn.addEventListener('click', () => {
            allPermCheckboxes().forEach(cb => cb.checked = true);
            updateRowHighlighting();
        });
    }
    if (globalDeselectBtn) {
        globalDeselectBtn.addEventListener('click', () => {
            allPermCheckboxes().forEach(cb => cb.checked = false);
            updateRowHighlighting();
        });
    }

    document.querySelectorAll('.category-select-all').forEach(catCheck => {
        catCheck.addEventListener('change', function() {
            const categoryId = this.getAttribute('data-category');
            const checkboxesInCategory = document.querySelectorAll(`tr[data-category="${categoryId}"] .perm-checkbox`);
            checkboxesInCategory.forEach(cb => cb.checked = this.checked);
            updateRowHighlighting();
        });
    });

    document.querySelectorAll('.module-select-all').forEach(moduleCheck => {
        moduleCheck.addEventListener('change', function() {
            const moduleKey = this.getAttribute('data-module');
            const checkboxesInModule = document.querySelectorAll(`.${moduleKey}-perm`);
            checkboxesInModule.forEach(cb => cb.checked = this.checked);
            updateRowHighlighting();
        });
    });

    allPermCheckboxes().forEach(cb => {
        cb.addEventListener('change', function() {
            const classes = this.classList;
            let moduleClass = null;
            for (let cls of classes) {
                if (cls.endsWith('-perm')) {
                    moduleClass = cls.replace('-perm', '');
                    break;
                }
            }
            if (moduleClass) {
                const moduleCheckboxes = document.querySelectorAll(`.${moduleClass}-perm`);
                const allChecked = Array.from(moduleCheckboxes).every(c => c.checked);
                const moduleSelectAll = document.querySelector(`.module-select-all[data-module="${moduleClass}"]`);
                if (moduleSelectAll) moduleSelectAll.checked = allChecked;

                const moduleRow = document.querySelector(`tr[data-module-key="${moduleClass}"]`);
                if (moduleRow) {
                    const categoryId = moduleRow.getAttribute('data-category');
                    const categoryCheckboxes = document.querySelectorAll(`tr[data-category="${categoryId}"] .perm-checkbox`);
                    const allCategoryChecked = Array.from(categoryCheckboxes).every(c => c.checked);
                    const categorySelectAll = document.querySelector(`.category-select-all[data-category="${categoryId}"]`);
                    if (categorySelectAll) categorySelectAll.checked = allCategoryChecked;
                }
            }
            updateRowHighlighting();
        });
    });

    function updateRowHighlighting() {
        document.querySelectorAll('.module-row').forEach(row => {
            const moduleKey = row.getAttribute('data-module-key');
            const checkboxes = document.querySelectorAll(`.${moduleKey}-perm`);
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            if (anyChecked) {
                row.classList.add('table-primary');
                const badgeSpan = row.querySelector('.badge.bg-primary');
                if (!badgeSpan) {
                    row.querySelector('td:nth-child(2)')?.insertAdjacentHTML('beforeend', '<span class="badge bg-primary ms-2">active</span>');
                }
            } else {
                row.classList.remove('table-primary');
                const badge = row.querySelector('.badge.bg-primary');
                if (badge) badge.remove();
            }
        });
    }

    const searchInput = document.getElementById('moduleSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('.module-row').forEach(row => {
                const moduleLabel = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
                row.style.display = moduleLabel.includes(filter) ? '' : 'none';
            });
        });
    }

    updateRowHighlighting();
});
</script>

<style>
    .accordion-button:not(.collapsed) {
        background-color: #e9ecef;
        color: #0d6efd;
        box-shadow: none;
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }
    .table-primary {
        --bs-table-bg: #cfe2ff;
    }
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .badge.bg-primary {
        font-weight: 400;
    }
    input[type="checkbox"] {
        cursor: pointer;
    }
</style>

<?= $this->endSection() ?>
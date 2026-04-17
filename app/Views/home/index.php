<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= view('components/hero_section') ?>
<?= view('components/quick_actions', ['quickActions' => $quickActions]) ?>
<?= view('components/products_section', ['products' => $products]) ?>
<?= view('components/notices_section', ['notices' => $notices, 'ticker' => $ticker]) ?>
<?= view('components/safety_section') ?>
<?= view('components/grievance_section', ['grievanceSteps' => $grievanceSteps]) ?>
<?= view('components/branch_locator', ['branches' => $branches]) ?>
<?= view('components/trust_section') ?>
<?= $this->endSection() ?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= view('pages/partials/page_banner', ['title' => $title, 'breadcrumbs' => $breadcrumbs ?? []]) ?>
<?= view($contentView, $contentData ?? []) ?>
<?= $this->endSection() ?>

<?php if (! empty($scriptsView ?? null)): ?>
<?= $this->section('scripts') ?>
<?= view($scriptsView, $scriptsData ?? []) ?>
<?= $this->endSection() ?>
<?php endif; ?>

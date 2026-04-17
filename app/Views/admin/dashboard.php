<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<h2>Dashboard</h2>

<div class="row">

    <div class="col-md-3">
        <div class="card p-3">Total: <?= $totalComplaints ?></div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">Pending: <?= $pendingComplaints ?></div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">Resolved: <?= $resolvedComplaints ?></div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">Delayed: <?= $delayedComplaints ?></div>
    </div>

</div>

<?= $this->endSection() ?>
<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-header"><h3 class="mb-0">Admin Details</h3></div>
    <div class="card-body">
        <p><strong>Name:</strong> <?= esc($admin['name']) ?></p>
        <p><strong>Email:</strong> <?= esc($admin['email']) ?></p>
        <p><strong>Role:</strong> <?= esc($admin['role_name']) ?></p>
        <p><strong>Created At:</strong> <?= date('d M Y H:i', strtotime($admin['created_at'])) ?></p>
        <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Back</a>
    </div>
</div>
<?= $this->endSection() ?>
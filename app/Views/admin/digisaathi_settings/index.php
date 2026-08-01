<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">DigiSaathi Settings</h3>
    <a href="<?= base_url('admin/digisaathi-settings/create') ?>" class="btn btn-primary btn-sm">+ Add New Setting</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><code><?= esc($item['key']) ?></code></td>
                        <td><?= esc(substr($item['value'], 0, 50)) ?>...</td>
                        <td><span class="badge bg-info"><?= $item['type'] ?></span></td>
                        <td>
                            <a href="<?= base_url('admin/digisaathi-settings/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/digisaathi-settings/delete/'.$item['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
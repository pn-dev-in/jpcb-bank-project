<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">DigiSaathi Contact Methods</h3>
    <a href="<?= base_url('admin/digisaathi-contacts/create') ?>" class="btn btn-primary btn-sm">+ Add New Contact</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Type</th>
                        <th>Button Text</th>
                        <th>Link</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= esc($item['icon']) ?></td>
                        <td><?= esc($item['title']) ?></td>
                        <td><?= esc($item['subtitle']) ?></td>
                        <td>
                            <span class="badge bg-<?= $item['type'] == 'call' ? 'danger' : ($item['type'] == 'whatsapp' ? 'success' : 'info') ?>">
                                <?= ucfirst($item['type']) ?>
                            </span>
                        </td>
                        <td><?= esc($item['button_text']) ?></td>
                        <td><?= esc($item['link']) ?></td>
                        <td><?= $item['sort_order'] ?></td>
                        <td>
                            <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                <?= $item['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/digisaathi-contacts/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/digisaathi-contacts/delete/'.$item['id']) ?>" method="post" class="d-inline">
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
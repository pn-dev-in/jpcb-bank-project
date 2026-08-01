<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">UPI Linking Steps – <?= esc(ucfirst($currentTab)) ?></h3>
    <a href="<?= base_url('admin/upi-linking-steps/create') ?>" class="btn btn-primary btn-sm">+ Add New Step</a>
</div>

<ul class="nav nav-tabs mb-3">
    <?php foreach ($tabs as $tabKey => $tabLabel): ?>
        <li class="nav-item">
            <a class="nav-link <?= ($currentTab == $tabKey) ? 'active' : '' ?>"
               href="<?= base_url('admin/upi-linking-steps/' . $tabKey) ?>">
                <?= esc($tabLabel) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tab</th>
                        <th>Section</th>
                        <th>Step #</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= esc($item['tab']) ?></td>
                        <td><?= esc($item['section']) ?></td>
                        <td><?= esc($item['step_number']) ?></td>
                        <td><?= esc($item['title']) ?></td>
                        <td><?= esc(substr($item['description'], 0, 50)) ?>...</td>
                        <td><?= $item['sort_order'] ?></td>
                        <td>
                            <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                <?= $item['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/upi-linking-steps/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/upi-linking-steps/delete/'.$item['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($items)): ?>
                    <tr><td colspan="8" class="text-center text-muted py-3">No steps found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
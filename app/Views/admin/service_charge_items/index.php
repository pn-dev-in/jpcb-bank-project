<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Service Charges – <?= esc(ucwords($currentTab)) ?></h3>
    <a href="<?= base_url('admin/service-charge-items/create') ?>" class="btn btn-primary btn-sm">
        + Add New Item
    </a>
</div>

<!-- Tab Navigation -->
<ul class="nav nav-tabs mb-3">
    <?php foreach ($tabs as $tabKey => $tabLabel): ?>
        <li class="nav-item">
            <a class="nav-link <?= ($currentTab == $tabKey) ? 'active' : '' ?>"
               href="<?= base_url('admin/service-charge-items/' . $tabKey) ?>">
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
                        <th>Section</th>
                        <th>Type</th>
                        <th>Label / Details</th>
                        <th>Charge</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= esc($item['section']) ?></td>
                        <td>
                            <span class="badge bg-secondary"><?= esc(ucfirst(str_replace('_', ' ', $item['type']))) ?></span>
                        </td>
                        <td><?= esc(isset($item['label']) ? implode(' ', array_slice(explode(' ', strip_tags((string)$item['label'])), 0, 5)) : '') ?></td>
                        <td><?= esc($item['charge'] ?? '') ?></td>
                        <td><?= $item['sort_order'] ?></td>
                        <td>
                            <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                <?= $item['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/service-charge-items/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/service-charge-items/delete/'.$item['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($items)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-3">No items found for this tab.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
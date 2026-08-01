<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Insurance Plans – <?= esc(ucfirst($currentTab)) ?></h3>
    <a href="<?= base_url('admin/insurance-plans/create') ?>" class="btn btn-primary btn-sm">+ Add New Plan</a>
</div>

<!-- Tab Navigation -->
<ul class="nav nav-tabs mb-3">
    <?php
    $tabs = [
        'life'    => 'Life Insurance',
        'general' => 'General Insurance',
        'health'  => 'Health Insurance',
        'govt'    => 'Government Schemes',
        'tieup'   => 'Tie-Up Partners'
    ];
    foreach ($tabs as $tabKey => $tabLabel):
    ?>
        <li class="nav-item">
            <a class="nav-link <?= ($currentTab == $tabKey) ? 'active' : '' ?>"
               href="<?= base_url('admin/insurance-plans/' . $tabKey) ?>">
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
                        <th>Category</th>
                        <th>Plan Name</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= esc($item['category']) ?></td>
                        <td><?= esc($item['plan_name']) ?></td>
                        <td><?= $item['sort_order'] ?></td>
                        <td>
                            <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                <?= $item['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/insurance-plans/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/insurance-plans/delete/'.$item['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this plan?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($items)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-3">No plans found for this tab.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
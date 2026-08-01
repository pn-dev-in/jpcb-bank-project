<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h3 class="mb-0">ATM Locations</h3>
    <div>
        <a href="<?= base_url('admin/atm-locations/import') ?>" class="btn btn-info btn-sm"><i class="ti ti-upload"></i> Bulk Import</a>
        <a href="<?= base_url('admin/atm-locations/create') ?>" class="btn btn-primary btn-sm">+ Add New ATM</a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Branch Name</th>
                        <th>City</th>
                        <th>Address</th>
                        <th>Location Type</th>
                        <th>PIN</th>
                        <th>Hours</th>
                        <th>ATM Status</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($items ?? []) as $item): ?>
                        <?php if (!is_array($item))
                            continue; ?>
                        <tr>
                            <td><?= esc((string) ($item['name'] ?? '')) ?></td>
                            <td><?= esc((string) ($item['city'] ?? '')) ?></td>
                            <td>
                                <?= esc((string) ($item['address'] ?? '')) ?>
                            </td>
                            <td>
                                <?= esc((string) ($item['location_type'] ?? 'On Site')) ?>
                            </td>
                            <td><?= esc((string) ($item['pin'] ?? '')) ?></td>
                            <td><?= esc((string) ($item['hours'] ?? '')) ?></td>
                            <td><?= esc((string) ($item['atm_status'] ?? '')) ?></td>
                            <td><?= (int) ($item['sort_order'] ?? 0) ?></td>
                            <td>
                                <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                    <?= $item['status'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/atm-locations/edit/' . $item['id']) ?>"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="<?= base_url('admin/atm-locations/delete/' . $item['id']) ?>" method="post"
                                    class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this ATM location?')">Delete</button>
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
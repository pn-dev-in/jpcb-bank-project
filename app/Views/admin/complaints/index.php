<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">All Complaints</h3>
    <div>
        <a href="<?= base_url('admin/complaints') ?>" class="btn btn-sm btn-secondary">All</a>
        <a href="<?= base_url('admin/complaints?status=Pending') ?>" class="btn btn-sm btn-warning">Pending</a>
        <a href="<?= base_url('admin/complaints?status=Resolved') ?>" class="btn btn-sm btn-success">Resolved</a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ticket</th>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($complaints as $c): 
                        $isDelayed = (strtotime($c['created_at']) < strtotime('-48 hours') && $c['status'] == 'Pending');
                    ?>
                        <tr class="<?= $isDelayed ? 'table-danger' : '' ?>">
                            <td><?= $c['id'] ?></td>
                            <td><?= $c['ticket_number'] ?? 'N/A' ?></td>
                            <td><?= esc($c['name']) ?></td>
                            <td><?= esc(substr($c['message'], 0, 80)) ?>...</td>
                            <td>
                                <span class="badge bg-<?= $c['status'] == 'Pending' ? 'warning' : 'success' ?>">
                                    <?= esc($c['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/complaints/view/'.$c['id']) ?>" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
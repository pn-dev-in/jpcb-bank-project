<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Loan Interest Notes (Bullet Points)</h3>
    <a href="<?= base_url('admin/loan-interest-notes/create') ?>" class="btn btn-primary btn-sm">+ Add Note</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px">Sort</th>
                        <th>Note Text</th>
                        <th style="width: 100px">Status</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    <?php foreach ($items as $item): ?>
                    <tr data-id="<?= $item['id'] ?>">
                        <td><i class="fas fa-grip-vertical text-muted" style="cursor: move;"></i> <?= $item['sort_order'] ?></td>
                        <td><?= esc($item['note']) ?></td>
                        <td>
                            <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                <?= $item['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/loan-interest-notes/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('admin/loan-interest-notes/delete/' . $item['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this note?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection() ?>s
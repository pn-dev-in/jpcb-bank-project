<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-cards"></i> Trust Cards</h5>
        <a href="<?= site_url('admin/homepage/create-card') ?>" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Add New Card
        </a>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($cards)): ?>
                    <?php foreach ($cards as $card): ?>
                        <tr>
                            <td><i class="fas <?= esc($card['icon_name']) ?>"></i> <?= esc($card['icon_name']) ?></td>
                            <td><?= esc($card['title']) ?></td>
                            <td><?= esc($card['description']) ?></td>
                            <td><?= $card['sort_order'] ?></td>
                            <td>
                                <?php if ($card['status']): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= site_url('admin/homepage/edit-card/'.$card['id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= site_url('admin/homepage/delete-card/'.$card['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this card?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No trust cards found. <a href="<?= site_url('admin/homepage/create-card') ?>">Create one</a></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
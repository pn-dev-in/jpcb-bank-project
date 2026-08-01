<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Loan Interest Schemes (Retail & Wholesale)</h3>
    <a href="<?= base_url('admin/loan-interest-schemes/create') ?>" class="btn btn-primary btn-sm">+ Add Scheme</a>
</div>

<ul class="nav nav-tabs mb-3" id="schemeTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="retail-tab" data-bs-toggle="tab" data-bs-target="#retail" type="button" role="tab">Retail Schemes</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="wholesale-tab" data-bs-toggle="tab" data-bs-target="#wholesale" type="button" role="tab">Wholesale Schemes</button>
    </li>
</ul>

<div class="tab-content">
    <!-- Retail Schemes -->
    <div class="tab-pane fade show active" id="retail" role="tabpanel">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Serial</th><th>Scheme Name</th><th>Min ROI</th><th>Max ROI</th><th>Women Benefit</th><th>Order</th><th>Status</th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($retail as $item): ?>
                            <tr>
                                <td><?= $item['serial_no'] ?></td>
                                <td><?= esc($item['scheme_name']) ?></td>
                                <td><?= $item['min_roi'] ?></td>
                                <td><?= $item['max_roi'] ?></td>
                                <td><?= esc($item['women_benefit'] ?? '-') ?></td>
                                <td><?= $item['sort_order'] ?></td>
                                <td><span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>"><?= $item['status'] ? 'Active' : 'Inactive' ?></span></td>
                                <td>
                                    <a href="<?= base_url('admin/loan-interest-schemes/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= base_url('admin/loan-interest-schemes/delete/' . $item['id']) ?>" method="post" class="d-inline">
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
    </div>

    <!-- Wholesale Schemes -->
    <div class="tab-pane fade" id="wholesale" role="tabpanel">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead><tr><th>Serial</th><th>Scheme Name</th><th>Min ROI</th><th>Max ROI</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
                        <tbody>
                            <?php foreach ($wholesale as $item): ?>
                            <tr>
                                <td><?= $item['serial_no'] ?></td>
                                <td><?= esc($item['scheme_name']) ?></td>
                                <td><?= $item['min_roi'] ?></td>
                                <td><?= $item['max_roi'] ?></td>
                                <td><?= $item['sort_order'] ?></td>
                                <td><span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>"><?= $item['status'] ? 'Active' : 'Inactive' ?></span></td>
                                <td>
                                    <a href="<?= base_url('admin/loan-interest-schemes/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= base_url('admin/loan-interest-schemes/delete/' . $item['id']) ?>" method="post" class="d-inline">
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
    </div>
</div>

<?= $this->endSection() ?>
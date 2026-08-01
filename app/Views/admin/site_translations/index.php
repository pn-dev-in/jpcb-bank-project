<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Site Translations</h3>
    <a href="<?= base_url('admin/site-translations/create') ?>" class="btn btn-primary btn-sm">+ Add Translation</a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="get" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Language</label>
                <select name="language" class="form-control">
                    <option value="hi" <?= ($language ?? '') === 'hi' ? 'selected' : '' ?>>Hindi</option>
                    <option value="mr" <?= ($language ?? '') === 'mr' ? 'selected' : '' ?>>Marathi</option>
                </select>
            </div>
            <div class="col-md-7">
                <label class="form-label">Search</label>
                <input type="text" name="q" class="form-control" value="<?= esc($query ?? '') ?>" placeholder="Search source, translation, or context">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 30%;">English Source</th>
                        <th style="width: 35%;">Curated Translation</th>
                        <th>Context</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($items ?? []) as $item): ?>
                        <tr>
                            <td><?= esc($item['source_text']) ?></td>
                            <td><?= esc($item['translation']) ?></td>
                            <td><?= esc($item['context'] ?? '') ?></td>
                            <td><?= (int) $item['sort_order'] ?></td>
                            <td><span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>"><?= $item['status'] ? 'Active' : 'Inactive' ?></span></td>
                            <td>
                                <a href="<?= base_url('admin/site-translations/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form action="<?= base_url('admin/site-translations/delete/' . $item['id']) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this translation?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($items)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">No translations found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

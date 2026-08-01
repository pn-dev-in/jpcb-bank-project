<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Apply Now Panel Settings</h3>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
        + Add New Item
    </button>
</div>

<!-- Settings Card -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Panel Settings</h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/apply-panel/update-settings') ?>">
            <?= csrf_field() ?>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_enabled" value="1" id="is_enabled" <?= ($settings['is_enabled'] ?? 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_enabled">Enable Apply Now Panel</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Panel Position</label>
                    <select name="position" class="form-control">
                        <option value="left" <?= ($settings['position'] ?? 'left') == 'left' ? 'selected' : '' ?>>Left Side</option>
                        <option value="right" <?= ($settings['position'] ?? 'left') == 'right' ? 'selected' : '' ?>>Right Side</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Panel Title</label>
                    <input type="text" name="panel_title" class="form-control" value="<?= old('panel_title', $settings['panel_title'] ?? 'Quick Apply') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Button Text (Mobile)</label>
                    <input type="text" name="button_text" class="form-control" value="<?= old('button_text', $settings['button_text'] ?? 'Apply Now') ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Panel Subtitle</label>
                <input type="text" name="panel_subtitle" class="form-control" value="<?= old('panel_subtitle', $settings['panel_subtitle'] ?? 'Open an account instantly') ?>">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Footer Text</label>
                    <input type="text" name="footer_text" class="form-control" value="<?= old('footer_text', $settings['footer_text'] ?? 'Talk to an advisor') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Footer Link</label>
                    <input type="text" name="footer_link" class="form-control" value="<?= old('footer_link', $settings['footer_link'] ?? '/contact') ?>" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
</div>

<!-- Items Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Apply Now Items</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Label</th>
                        <th>Link</th>
                        <th>Color</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><i data-lucide="<?= esc($item['icon']) ?>" class="w-5 h-5"></i></td>
                        <td><?= esc($item['label']) ?></td>
                        <td><?= esc($item['link']) ?></td>
                        <td><span class="badge" style="background: var(--an-<?= $item['color'] ?>, hsl(152 58% 24%));"><?= ucfirst($item['color']) ?></span></td>
                        <td><?= $item['sort_order'] ?></td>
                        <td><span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>"><?= $item['status'] ? 'Active' : 'Inactive' ?></span></td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-item" data-id="<?= $item['id'] ?>" data-icon="<?= esc($item['icon']) ?>" data-label="<?= esc($item['label']) ?>" data-link="<?= esc($item['link']) ?>" data-color="<?= $item['color'] ?>" data-order="<?= $item['sort_order'] ?>" data-status="<?= $item['status'] ?>">Edit</button>
                            <a href="<?= base_url('admin/apply-panel/delete-item/' . $item['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= base_url('admin/apply-panel/create-item') ?>">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Add Apply Now Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Icon (Lucide name)</label>
                        <input type="text" name="icon" class="form-control" required>
                        <small>e.g., piggy-bank, briefcase, landmark, credit-card</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" name="label" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link URL</label>
                        <input type="text" name="link" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <select name="color" class="form-control">
                            <?php foreach ($colors as $key => $color): ?>
                                <option value="<?= $key ?>"><?= $color ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="editForm">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Apply Now Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label">Icon (Lucide name)</label>
                        <input type="text" name="icon" id="edit_icon" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" name="label" id="edit_label" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link URL</label>
                        <input type="text" name="link" id="edit_link" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <select name="color" id="edit_color" class="form-control">
                            <?php foreach ($colors as $key => $color): ?>
                                <option value="<?= $key ?>"><?= $color ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="edit_order" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" id="edit_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.edit-item').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('edit_icon').value = this.dataset.icon;
        document.getElementById('edit_label').value = this.dataset.label;
        document.getElementById('edit_link').value = this.dataset.link;
        document.getElementById('edit_color').value = this.dataset.color;
        document.getElementById('edit_order').value = this.dataset.order;
        document.getElementById('edit_status').value = this.dataset.status;
        document.getElementById('editForm').action = '<?= base_url('admin/apply-panel/update-item/') ?>' + this.dataset.id;
        new bootstrap.Modal(document.getElementById('editItemModal')).show();
    });
});
</script>

<?= $this->endSection() ?>
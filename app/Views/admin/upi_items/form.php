<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> UPI Item</h3>
    </div>
    <div class="card-body">
        <?php if (session('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post"
              action="<?= isset($item) ? base_url('admin/upi-items/update/' . $item['id']) : base_url('admin/upi-items/store') ?>">
            <?= csrf_field() ?>

            <!-- Tab Selection -->
            <div class="mb-3">
                <label class="form-label">Tab</label>
                <select name="tab" class="form-control" required>
                    <option value="features" <?= old('tab', $item['tab'] ?? 'features') == 'features' ? 'selected' : '' ?>>Features</option>
                    <option value="eligibility" <?= old('tab', $item['tab'] ?? '') == 'eligibility' ? 'selected' : '' ?>>Eligibility</option>
                    <option value="transactions" <?= old('tab', $item['tab'] ?? '') == 'transactions' ? 'selected' : '' ?>>Transactions</option>
                </select>
            </div>

            <!-- Section -->
            <div class="mb-3">
                <label class="form-label">Section</label>
                <input type="text" name="section" class="form-control"
                       value="<?= old('section', $item['section'] ?? '') ?>" required>
                <small class="text-muted">e.g., feature_cards, checklist, who_can_avail</small>
            </div>

            <!-- Type -->
            <div class="mb-3">
                <label class="form-label">Row Type</label>
                <select name="type" class="form-control" id="typeSelect" required>
                    <option value="card" <?= old('type', $item['type'] ?? 'card') == 'card' ? 'selected' : '' ?>>Card (icon + title + description)</option>
                    <option value="checklist" <?= old('type', $item['type'] ?? '') == 'checklist' ? 'selected' : '' ?>>Checklist (single line)</option>
                    <option value="detail" <?= old('type', $item['type'] ?? '') == 'detail' ? 'selected' : '' ?>>Detail (title + description)</option>
                    <option value="stat" <?= old('type', $item['type'] ?? '') == 'stat' ? 'selected' : '' ?>>Stat Pill (value + label)</option>
                </select>
            </div>

            <!-- Icon (only for card) -->
            <div class="mb-3" id="iconGroup">
                <label class="form-label">Icon (for card)</label>
                <input type="text" name="icon" class="form-control"
                       value="<?= old('icon', $item['icon'] ?? '') ?>" placeholder="e.g., globe, shield-check">
                <small class="text-muted">Leave empty if not needed.</small>
            </div>

            <!-- Title -->
            <div class="mb-3">
                <label class="form-label" id="titleLabel">Title</label>
                <input type="text" name="title" class="form-control"
                       value="<?= old('title', $item['title'] ?? '') ?>" id="titleInput">
            </div>

            <!-- Description -->
            <div class="mb-3" id="descGroup">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"><?= old('description', $item['description'] ?? '') ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control"
                           value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (old('status', $item['status'] ?? '1') == '1') ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (old('status', $item['status'] ?? '1') == '0') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/upi-items') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<!-- Toggle fields based on type -->
<script>
(function () {
    var select = document.getElementById('typeSelect');
    var iconGroup = document.getElementById('iconGroup');
    var descGroup = document.getElementById('descGroup');
    var titleInput = document.getElementById('titleInput');
    var titleLabel = document.getElementById('titleLabel');

    function updateFields() {
        var type = select.value;
        if (type === 'checklist') {
            iconGroup.style.display = 'none';
            descGroup.style.display = 'none';
            titleLabel.textContent = 'Checklist Text';
            titleInput.placeholder = 'e.g., Immediate money transfers through mobile device...';
        } else if (type === 'card') {
            iconGroup.style.display = 'block';
            descGroup.style.display = 'block';
            titleLabel.textContent = 'Card Title';
            titleInput.placeholder = 'e.g., Instant Transfers';
        } } else if (type === 'stat') {
    iconGroup.style.display = 'block';
    descGroup.style.display = 'block';
    titleLabel.textContent = 'Stat Value (e.g., 24 × 7)';
    titleInput.placeholder = 'e.g., 24 × 7';
}
        } else { // detail
            iconGroup.style.display = 'none';
            descGroup.style.display = 'block';
            titleLabel.textContent = 'Detail Title';
            titleInput.placeholder = 'e.g., Pay Request (PUSH)';
        }
    }

    select.addEventListener('change', updateFields);
    updateFields(); // run on load
})();
</script>

<?= $this->endSection() ?>
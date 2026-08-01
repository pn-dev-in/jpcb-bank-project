<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Insurance Plan</h3>
    </div>
    <div class="card-body">
        <!-- Display Validation Errors -->
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
              action="<?= isset($item) ? base_url('admin/insurance-plans/update/' . $item['id']) : base_url('admin/insurance-plans/store') ?>">
            <?= csrf_field() ?>

            <!-- Tab Selection -->
            <div class="mb-3">
                <label class="form-label">Tab</label>
                <select name="tab" class="form-control" required>
                    <option value="life" <?= old('tab', $item['tab'] ?? 'life') == 'life' ? 'selected' : '' ?>>Life Insurance</option>
                    <option value="general" <?= old('tab', $item['tab'] ?? '') == 'general' ? 'selected' : '' ?>>General Insurance</option>
                    <option value="health" <?= old('tab', $item['tab'] ?? '') == 'health' ? 'selected' : '' ?>>Health Insurance</option>
                    <option value="govt" <?= old('tab', $item['tab'] ?? '') == 'govt' ? 'selected' : '' ?>>Government Schemes</option>
                    <option value="tieup" <?= old('tab', $item['tab'] ?? '') == 'tieup' ? 'selected' : '' ?>>Tie-Up Partners</option>
                </select>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label class="form-label">Category (e.g., Endowment Plans, Term Plans)</label>
                <input type="text" name="category" class="form-control"
                       value="<?= old('category', $item['category'] ?? '') ?>"
                       placeholder="Optional category">
            </div>

            <!-- Plan Name -->
            <div class="mb-3">
                <label class="form-label">Plan Name *</label>
                <input type="text" name="plan_name" class="form-control"
                       value="<?= old('plan_name', $item['plan_name'] ?? '') ?>" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description (optional – leave blank for regular plan, fill for callout/notes)</label>
                <textarea name="description" class="form-control" rows="4"><?= old('description', $item['description'] ?? '') ?></textarea>
            </div>

            <!-- Sort Order & Status -->
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
            <a href="<?= base_url('admin/insurance-plans') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
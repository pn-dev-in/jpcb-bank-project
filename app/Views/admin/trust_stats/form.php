<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2><?= isset($stat) ? 'Edit' : 'Add' ?> Trust Statistic Card</h2>

<form method="post" action="<?= isset($stat) ? site_url('admin/trust-stats/update/'.$stat['id']) : site_url('admin/trust-stats/store') ?>">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Icon Name (Lucide icon)</label>
        <input type="text" name="icon" class="form-control" value="<?= old('icon', $stat['icon'] ?? '') ?>" required>
        <small class="form-text text-muted">Examples: calendar, users, shield, award, building, hand-coins, etc.</small>
    </div>

    <div class="form-group">
        <label>Value (displayed number/text)</label>
        <input type="text" name="value" class="form-control" value="<?= old('value', $stat['value'] ?? '') ?>" required>
        <small class="form-text text-muted">Examples: 1933, 1L+, 50+, Multi, 24x7, etc.</small>
    </div>

    <div class="form-group">
        <label>Label (description below the value)</label>
        <input type="text" name="label" class="form-control" value="<?= old('label', $stat['label'] ?? '') ?>" required>
        <small class="form-text text-muted">Examples: Established, Happy Customers, Branches & ATMs, State Scheduled Bank</small>
    </div>

    <div class="form-group">
        <label>Sort Order (lower = appears first)</label>
        <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $stat['sort_order'] ?? 0) ?>">
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" <?= (isset($stat) && $stat['status'] == 1) ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= (isset($stat) && $stat['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary"><?= isset($stat) ? 'Update' : 'Create' ?></button>
    <a href="<?= site_url('admin/trust-stats') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>
<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2><?= isset($card) ? 'Edit' : 'Add' ?> Trust Card</h2>
<form method="post" action="<?= isset($card) ? site_url('admin/homepage/update-card/'.$card['id']) : site_url('admin/homepage/store-card') ?>">
    <?= csrf_field() ?>
    <label>Icon Name (lucide name, e.g. landmark, hand-coins, smartphone, shield)</label>
    <input type="text" name="icon_name" value="<?= old('icon_name', $card['icon_name'] ?? '') ?>" required>

    <label>Title</label>
    <input type="text" name="title" value="<?= old('title', $card['title'] ?? '') ?>" required>

    <label>Description</label>
    <input type="text" name="description" value="<?= old('description', $card['description'] ?? '') ?>" required>

    <label>Link (optional, e.g. deposits/overview)</label>
    <input type="text" name="link" value="<?= old('link', $card['link'] ?? '') ?>">

    <label>Sort Order (lower = higher)</label>
    <input type="number" name="sort_order" value="<?= old('sort_order', $card['sort_order'] ?? 0) ?>">

    <label>Status</label>
    <select name="status">
        <option value="1" <?= (isset($card) && $card['status']==1) ? 'selected' : '' ?>>Active</option>
        <option value="0" <?= (isset($card) && $card['status']==0) ? 'selected' : '' ?>>Inactive</option>
    </select>

    <button type="submit"><?= isset($card) ? 'Update' : 'Create' ?></button>
</form>

<?= $this->endSection() ?>
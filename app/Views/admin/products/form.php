<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<h2><?= isset($product) ? 'Edit' : 'Add' ?> Product</h2>
<form method="post" action="<?= isset($product) ? site_url('admin/products/update/'.$product['id']) : site_url('admin/products/store') ?>">
    <?= csrf_field() ?>
    <label>Product Name</label>
    <input type="text" name="name" value="<?= old('name', $product['name'] ?? '') ?>" required>

    <label>Icon Name (Lucide icon, e.g. 'landmark', 'piggy-bank', 'hand-coins')</label>
    <input type="text" name="icon" value="<?= old('icon', $product['icon'] ?? '') ?>" required>

    <label>Category (optional, e.g. savings, loan, agri)</label>
    <input type="text" name="category" value="<?= old('category', $product['category'] ?? '') ?>">

    <label>Link (URL path, e.g. 'deposits/overview')</label>
    <input type="text" name="href" value="<?= old('href', $product['href'] ?? '') ?>" required>

    <label>Sort Order (lower = higher)</label>
    <input type="number" name="sort_order" value="<?= old('sort_order', $product['sort_order'] ?? 0) ?>">

    <label>Status</label>
    <select name="status">
        <option value="1" <?= (isset($product) && $product['status']==1) ? 'selected' : '' ?>>Active</option>
        <option value="0" <?= (isset($product) && $product['status']==0) ? 'selected' : '' ?>>Inactive</option>
    </select>

    <label>Features (one per line)</label>
    <textarea name="features" rows="6" required placeholder="Zero balance options available
Attractive interest rates
Digital payments enabled"><?= old('features', $featuresText ?? '') ?></textarea>

    <button type="submit"><?= isset($product) ? 'Update' : 'Create' ?></button>
</form>
<?= $this->endSection() ?>
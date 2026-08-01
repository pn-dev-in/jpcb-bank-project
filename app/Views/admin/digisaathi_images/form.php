<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Image</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/digisaathi-images/update/'.$item['id']) : base_url('admin/digisaathi-images/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label class="form-label">Section <span class="text-danger">*</span></label>
                <select name="section" class="form-control" required>
                    <option value="">Select Section</option>
                    <option value="about" <?= (isset($item) && $item['section']=='about') ? 'selected' : '' ?>>About Section</option>
                    <option value="qr" <?= (isset($item) && $item['section']=='qr') ? 'selected' : '' ?>>QR Code Section</option>
                    <option value="language" <?= (isset($item) && $item['section']=='language') ? 'selected' : '' ?>>Language Section</option>
                    <option value="support" <?= (isset($item) && $item['section']=='support') ? 'selected' : '' ?>>Support Section</option>
                    <option value="services" <?= (isset($item) && $item['section']=='services') ? 'selected' : '' ?>>Services Section</option>
                </select>
                <small class="text-muted">Which section this image belongs to</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Upload Image</label>
                <input type="file" name="image_file" class="form-control" accept="image/*" <?= !isset($item) ? 'required' : '' ?>>
                <small class="text-muted">Recommended size: 800x600px (JPEG, PNG)</small>
                <?php if (isset($item) && !empty($item['image_path']) && file_exists($item['image_path'])): ?>
                    <div class="mt-2">
                        <img src="<?= base_url($item['image_path']) ?>" width="100" class="rounded border">
                        <p class="text-muted small mt-1">Current image</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Image Path (Optional - if not uploading)</label>
                <input type="text" name="image_path" class="form-control" value="<?= old('image_path', $item['image_path'] ?? '') ?>" placeholder="assets/img/example.jpg">
                <small class="text-muted">You can enter a path manually instead of uploading</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Alt Text (SEO)</label>
                <input type="text" name="alt_text" class="form-control" value="<?= old('alt_text', $item['alt_text'] ?? '') ?>" placeholder="Describe the image for SEO">
                <small class="text-muted">Helps with search engine optimization</small>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($item) && $item['status']==1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($item) && $item['status']==0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/digisaathi-images') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
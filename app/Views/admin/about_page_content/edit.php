<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<?php
$content = $content ?? [];
$mediaUrl = static function (?string $path): string {
    $path = trim((string) $path);
    if ($path === '') {
        return '';
    }
    return preg_match('~^https?://~i', $path) ? $path : base_url($path);
};
?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">About Page Content</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/about-page-content/update') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Hero Title</label>
                    <input type="text" name="hero_title" class="form-control" value="<?= old('hero_title', $content['hero_title'] ?? '') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Hero Image</label>
                    <input type="file" name="hero_image" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
                </div>
            </div>

            <?php if (!empty($content['hero_image'])): ?>
                <div class="mb-3">
                    <img src="<?= $mediaUrl($content['hero_image']) ?>" alt="Current hero image" style="max-width: 220px; border-radius: 8px;">
                    <p class="text-muted small mt-1 mb-0">Current image. Upload a new one to replace it.</p>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Hero Subtitle</label>
                <textarea name="hero_subtitle" class="form-control" rows="2"><?= old('hero_subtitle', $content['hero_subtitle'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Introduction Title</label>
                <input type="text" name="intro_title" class="form-control" value="<?= old('intro_title', $content['intro_title'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Introduction Description</label>
                <textarea name="intro_description" class="form-control" rows="6" required><?= old('intro_description', $content['intro_description'] ?? '') ?></textarea>
                <small class="text-muted">Use separate lines for paragraphs.</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mission Title</label>
                    <input type="text" name="mission_title" class="form-control" value="<?= old('mission_title', $content['mission_title'] ?? '') ?>" required>
                    <label class="form-label mt-2">Mission Description</label>
                    <textarea name="mission_description" class="form-control" rows="4" required><?= old('mission_description', $content['mission_description'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Vision Title</label>
                    <input type="text" name="vision_title" class="form-control" value="<?= old('vision_title', $content['vision_title'] ?? '') ?>" required>
                    <label class="form-label mt-2">Vision Description</label>
                    <textarea name="vision_description" class="form-control" rows="4" required><?= old('vision_description', $content['vision_description'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">SEO Title</label>
                    <input type="text" name="seo_title" class="form-control" value="<?= old('seo_title', $content['seo_title'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">SEO Description</label>
                    <input type="text" name="seo_description" class="form-control" value="<?= old('seo_description', $content['seo_description'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $content['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (int) old('status', $content['status'] ?? 1) === 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (int) old('status', $content['status'] ?? 1) === 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

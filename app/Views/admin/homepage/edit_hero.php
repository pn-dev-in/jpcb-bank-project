<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Edit Hero Section</h2>
<?php if(session()->getFlashdata('message')): ?>
    <div class="alert success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>
<form method="post" action="<?= site_url('admin/homepage/update-hero') ?>">
    <?= csrf_field() ?>
    <label>Badge Text</label>
    <input type="text" name="badge_text" value="<?= old('badge_text', $hero['badge_text']) ?>" required>

    <label>Heading Main (first line)</label>
    <input type="text" name="heading_main" value="<?= old('heading_main', $hero['heading_main']) ?>" required>

    <label>Heading Highlight (second line, primary color)</label>
    <input type="text" name="heading_highlight" value="<?= old('heading_highlight', $hero['heading_highlight']) ?>" required>

    <label>Description</label>
    <textarea name="description" rows="4" required><?= old('description', $hero['description']) ?></textarea>

    <label>Button 1 Text</label>
    <input type="text" name="button1_text" value="<?= old('button1_text', $hero['button1_text']) ?>" required>

    <label>Button 1 Link (relative URL, e.g. deposits)</label>
    <input type="text" name="button1_link" value="<?= old('button1_link', $hero['button1_link']) ?>" required>

    <label>Button 2 Text</label>
    <input type="text" name="button2_text" value="<?= old('button2_text', $hero['button2_text']) ?>" required>

    <label>Button 2 Link</label>
    <input type="text" name="button2_link" value="<?= old('button2_link', $hero['button2_link']) ?>" required>

    <label>Search Placeholder</label>
    <input type="text" name="search_placeholder" value="<?= old('search_placeholder', $hero['search_placeholder']) ?>" required>

    <button type="submit">Update Hero</button>
</form>

<?= $this->endSection() ?>
<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Upload Document</h2>

<form method="post" action="<?= base_url('admin/documents/store') ?>" enctype="multipart/form-data">
    
    <?= csrf_field() ?>

    <input type="text" name="title" placeholder="Title" required><br>

    <select name="category" required>
    <option value="">Select Category</option>
    <option value="Forms">Forms</option>
    <option value="Downloads">Downloads</option>
    <option value="Circular">Circular</option>
    <option value="Report">Report</option>
</select><br>

    <input type="file" name="file" required><br>

    <button type="submit">Upload</button>

</form>

<?= $this->endSection() ?>
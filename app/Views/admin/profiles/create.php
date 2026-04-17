<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Add Profile</h2>

<form method="post" action="<?= base_url('admin/profiles/store') ?>" enctype="multipart/form-data">
    
    <?= csrf_field() ?>

    <input type="text" name="name" placeholder="Name" required><br>

    <input type="text" name="designation" placeholder="Designation" required><br>

    <input type="file" name="image" required><br>

    <button type="submit">Save</button>

</form>

<?= $this->endSection() ?>
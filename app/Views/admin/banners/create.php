<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Add Banner</h2>

<form method="post" action="/admin/banners/store" enctype="multipart/form-data">

    <?= csrf_field() ?>

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control" required>
    </div>

    <button class="btn btn-success">Save</button>

</form>

<?= $this->endSection() ?>
<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Banners</h2>

<a href="/admin/banners/create" class="btn btn-primary mb-3">Add Banner</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Image</th>
        <th>Action</th>
    </tr>

    <?php foreach($banners as $b): ?>
    <tr>
        <td><?= $b['id'] ?></td>
        <td><?= $b['title'] ?></td>
        <td>
            <img src="<?= base_url('uploads/banners/'.$b['image']) ?>" width="100">
        </td>
        <td>
            <a href="/admin/banners/delete/<?= $b['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>
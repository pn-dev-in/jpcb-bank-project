<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Notices</h2>

<a href="/admin/notices/create" class="btn btn-primary mb-3">Add Notice</a>

<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Type</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php foreach($notices as $n): ?>
<tr>
    <td><?= $n['id'] ?></td>
    <td><?= $n['title'] ?></td>
    <td><?= $n['type'] ?></td>
    <td><?= $n['date'] ?></td>
    <td>
        <a href="/admin/notices/delete/<?= $n['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

<?= $this->endSection() ?>
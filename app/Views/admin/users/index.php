<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Admin Users</h2>

<a href="/admin/users/create">Add Admin</a>

<table border="1">
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
</tr>

<?php foreach ($admins as $a): ?>
<tr>
    <td><?= $a['name'] ?></td>
    <td><?= $a['email'] ?></td>
    <td><?= $a['role_name'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<?= $this->endSection() ?>
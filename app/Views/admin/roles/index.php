<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Roles</h2>

<a href="/admin/roles/create">Create Role</a>

<table border="1">
<tr>
    <th>Name</th>
    <th>Action</th>
</tr>

<?php foreach ($roles as $role): ?>
<tr>
    <td><?= $role['name'] ?></td>
    <td>
        <a href="/admin/roles/assign/<?= $role['id'] ?>">Assign Permissions</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

<?= $this->endSection() ?>
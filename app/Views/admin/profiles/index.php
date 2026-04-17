<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Profiles</h2>

<a href="<?= base_url('admin/profiles/create') ?>">Add New Profile</a>

<table border="1">
<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Designation</th>
    <th>Action</th>
</tr>

<?php foreach ($profiles as $profile): ?>
<tr>
    <td>
        <img src="<?= base_url($profile['image']) ?>" width="80">
    </td>
    <td><?= esc($profile['name']) ?></td>
    <td><?= esc($profile['designation']) ?></td>
    <td>
        <!-- DELETE WITH CSRF -->
        <form method="post" action="<?= base_url('admin/profiles/delete/'.$profile['id']) ?>" style="display:inline;">
            <?= csrf_field() ?>
            <button type="submit" onclick="return confirm('Delete this profile?')">
                Delete
            </button>
        </form>
    </td>
</tr>
<?php endforeach; ?>

</table>

<?= $this->endSection() ?>
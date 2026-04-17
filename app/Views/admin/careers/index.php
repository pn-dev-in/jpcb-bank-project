<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Career Applications</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Resume</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php if (!empty($applications)): ?>
    <?php foreach ($applications as $app): ?>
    <tr>
        <td><?= esc($app['name']) ?></td>
        <td><?= esc($app['email']) ?></td>
        <td><?= esc($app['phone']) ?></td>
        <td>
            <a href="<?= base_url($app['resume']) ?>" target="_blank">Download</a>
        </td>
        <td><?= $app['created_at'] ?></td>
        <td>
            <a href="/admin/careers/delete/<?= $app['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6">No applications found</td>
    </tr>
<?php endif; ?>

</table>

<?= $this->endSection() ?>
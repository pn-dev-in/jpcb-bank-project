<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Activity Logs</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Admin ID</th>
    <th>Action</th>
    <th>Module</th>
    <th>Record ID</th>
    <th>Date</th>
</tr>

<?php foreach ($logs as $log): ?>
<tr>
    <td><?= $log['admin_id'] ?></td>
    <td><?= $log['action'] ?></td>
    <td><?= $log['module'] ?></td>
    <td><?= $log['record_id'] ?></td>
    <td><?= $log['created_at'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<?= $this->endSection() ?>
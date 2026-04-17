<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Interest Rates</h2>

<a href="<?= base_url('admin/interest-rates/create') ?>">Add New Rate</a>

<table border="1" cellpadding="10">
<tr>
    <th>Type</th>
    <th>Title</th>
    <th>Rate (%)</th>
    <th>Description</th>
    <th>Action</th>
</tr>

<?php if (!empty($rates)): ?>
    <?php foreach ($rates as $r): ?>
    <tr>
        <td><?= esc($r['type']) ?></td>
        <td><?= esc($r['title']) ?></td>
        <td><?= esc($r['rate']) ?>%</td>
        <td><?= esc($r['description']) ?></td>
        <td>

            <!-- EDIT -->
            <a href="<?= base_url('admin/interest-rates/edit/'.$r['id']) ?>">Edit</a>

            <!-- DELETE (FIXED: POST + CSRF) -->
            <form method="post" action="<?= base_url('admin/interest-rates/delete/'.$r['id']) ?>" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" onclick="return confirm('Delete this rate?')">
                    Delete
                </button>
            </form>

        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5">No interest rates found</td>
    </tr>
<?php endif; ?>

</table>

<?= $this->endSection() ?>
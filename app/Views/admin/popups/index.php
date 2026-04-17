<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Popups</h2>

<a href="<?= base_url('admin/popups/create') ?>">Add Popup</a>

<table border="1">
<tr>
    <th>Title</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php if (!empty($popups)): ?>
    <?php foreach ($popups as $p): ?>
    <tr>
        <td><?= esc($p['title']) ?></td>
        <td><?= $p['status'] ? 'Active' : 'Inactive' ?></td>
        <td>

            <!-- DELETE (FIXED: POST + CSRF) -->
            <form method="post" action="<?= base_url('admin/popups/delete/'.$p['id']) ?>" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" onclick="return confirm('Delete this popup?')">
                    Delete
                </button>
            </form>

        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="3">No popups found</td>
    </tr>
<?php endif; ?>

</table>

<?= $this->endSection() ?>
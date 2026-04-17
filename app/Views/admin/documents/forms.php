<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Forms</h2>

<a href="<?= base_url('admin/documents/create') ?>">Upload New Form</a>

<table border="1">
<tr>
    <th>Title</th>
    <th>File</th>
    <th>Action</th>
</tr>

<?php foreach ($documents as $doc): ?>
<tr>
    <td><?= esc($doc['title']) ?></td>
    <td>
        <a href="<?= base_url($doc['file_path']) ?>" target="_blank">View</a>
    </td>
    <td>
        <!-- DELETE MUST BE POST -->
        <form method="post" action="<?= base_url('admin/documents/delete/'.$doc['id']) ?>" style="display:inline;">
            <?= csrf_field() ?>
            <button type="submit" onclick="return confirm('Delete this form?')">
                Delete
            </button>
        </form>
    </td>
</tr>
<?php endforeach; ?>

</table>

<?= $this->endSection() ?>
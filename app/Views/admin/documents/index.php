<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Documents</h2>

<a href="<?= base_url('admin/documents/create') ?>">Upload New</a>

<table border="1">
<tr>
    <th>Title</th>
    <th>Category</th>
    <th>Action</th>
</tr>

<?php foreach ($documents as $doc): ?>
<tr>
    <td><?= esc($doc['title']) ?></td>
    <td><?= esc($doc['category']) ?></td>
    <td>

        <!-- VIEW FILE -->
        <a href="<?= base_url($doc['file_path']) ?>" target="_blank">View</a>

        <!-- DELETE MUST BE POST + CSRF -->
        <form method="post" action="<?= base_url('admin/documents/delete/'.$doc['id']) ?>" style="display:inline;">
            
            <?= csrf_field() ?>

            <button type="submit" onclick="return confirm('Delete this document?')">
                Delete
            </button>
        </form>

    </td>
</tr>
<?php endforeach; ?>

</table>

<?= $this->endSection() ?>
<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<h2>Social Media Links</h2>
<a href="<?= site_url('admin/social-links/create') ?>" class="btn btn-primary mb-3">+ Add Social Link</a>
<table class="table">
    <thead><tr><th>Platform</th><th>Icon</th><th>URL</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach($links as $link): ?>
    <tr>
        <td><?= esc($link['platform']) ?></td>
        <td><?= esc($link['icon']) ?></td>
        <td><?= esc($link['url']) ?></td>
        <td><?= $link['sort_order'] ?></td>
        <td><?= $link['status'] ? 'Active' : 'Inactive' ?></td>
        <td>
            <a href="<?= site_url('admin/social-links/edit/'.$link['id']) ?>">Edit</a>
            <a href="<?= site_url('admin/social-links/delete/'.$link['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
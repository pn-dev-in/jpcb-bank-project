<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Trust Cards</h2>
<a href="<?= site_url('admin/homepage/create-card') ?>" class="btn">+ Add New Card</a>
<table>
    <thead>
        <tr><th>Icon</th><th>Title</th><th>Description</th><th>Order</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach($cards as $card): ?>
        <tr>
            <td><?= esc($card['icon_name']) ?></td>
            <td><?= esc($card['title']) ?></td>
            <td><?= esc($card['description']) ?></td>
            <td><?= $card['sort_order'] ?></td>
            <td><?= $card['status'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= site_url('admin/homepage/edit-card/'.$card['id']) ?>">Edit</a>
                <a href="<?= site_url('admin/homepage/delete-card/'.$card['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
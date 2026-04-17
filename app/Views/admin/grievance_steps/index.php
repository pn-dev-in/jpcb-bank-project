<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<h2>Manage Grievance Steps</h2>
<a href="<?= site_url('admin/grievance-steps/create') ?>" class="btn">+ Add New Step</a>
<table>
    <thead><tr><th>Step</th><th>Title</th><th>Timeline</th><th>Action</th><th>External</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach($steps as $step): ?>
    <tr>
        <td><?= $step['step'] ?></td>
        <td><?= esc($step['title']) ?></td>
        <td><?= esc($step['timeline']) ?></td>
        <td><?= esc($step['action']) ?></td>
        <td><?= $step['external'] ? 'Yes' : 'No' ?></td>
        <td>
            <a href="<?= site_url('admin/grievance-steps/edit/'.$step['id']) ?>">Edit</a>
            <a href="<?= site_url('admin/grievance-steps/delete/'.$step['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>

<a href="<?= site_url('admin/grievance-section/edit') ?>" class="btn btn-secondary mt-3">Edit Grievance Redressal Section Heading/Subheading</a>
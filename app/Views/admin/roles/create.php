<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Create Role</h2>

<form method="post" action="/admin/roles/store">
<?= csrf_field() ?>

<input type="text" name="name" placeholder="Role Name" required>

<button type="submit">Save</button>

</form>

<?= $this->endSection() ?>
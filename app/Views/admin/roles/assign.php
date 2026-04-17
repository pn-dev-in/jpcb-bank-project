<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Assign Permissions to <?= $role['name'] ?></h2>

<form method="post" action="/admin/roles/save/<?= $role['id'] ?>">
<?= csrf_field() ?>

<?php foreach ($permissions as $p): ?>
    <label>
        <input type="checkbox" name="permissions[]" value="<?= $p['id'] ?>">
        <?= $p['name'] ?>
    </label><br>
<?php endforeach; ?>

<br>
<button type="submit">Save Permissions</button>

</form>

<?= $this->endSection() ?>
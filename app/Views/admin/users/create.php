<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Create Admin User</h2>

<form method="post" action="/admin/users/store">
<?= csrf_field() ?>

<input type="text" name="name" placeholder="Name" required><br><br>

<input type="email" name="email" placeholder="Email" required><br><br>

<input type="password" name="password" placeholder="Password" required><br><br>

<select name="role_id">
    <?php foreach ($roles as $role): ?>
        <option value="<?= $role['id'] ?>">
            <?= $role['name'] ?>
        </option>
    <?php endforeach; ?>
</select><br><br>

<button type="submit">Create</button>

</form>

<?= $this->endSection() ?>
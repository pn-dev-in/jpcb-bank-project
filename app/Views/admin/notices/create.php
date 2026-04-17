<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Add Notice</h2>

<form method="post" action="/admin/notices/store">

<?= csrf_field() ?>

<input type="text" name="title" placeholder="Title" class="form-control mb-2" required>
<textarea name="description" placeholder="Description" class="form-control mb-2"></textarea>

<select name="type" class="form-control mb-2">
    <option value="Announcement">Announcement</option>
    <option value="Alert">Alert</option>
    <option value="Holiday">Holiday</option>
</select>

<input type="date" name="date" class="form-control mb-2" required>

<button class="btn btn-success">Save</button>

</form>

<?= $this->endSection() ?>
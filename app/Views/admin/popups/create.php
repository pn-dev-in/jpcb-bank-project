<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Create Popup</h2>

<form method="post" action="<?= base_url('admin/popups/store') ?>" enctype="multipart/form-data">

    <?= csrf_field() ?>

    <label>Title</label><br>
    <input type="text" name="title" required><br><br>

    <label>Message</label><br>
    <textarea name="message"></textarea><br><br>

    <label>Image</label><br>
    <input type="file" name="image"><br><br>

    <label>Button Text</label><br>
    <input type="text" name="button_text"><br><br>

    <label>Button Link</label><br>
    <input type="text" name="button_link"><br><br>

    <label>
        <input type="checkbox" name="status" value="1" checked> Active
    </label><br><br>

    <button type="submit">Save</button>

</form>

<?= $this->endSection() ?>
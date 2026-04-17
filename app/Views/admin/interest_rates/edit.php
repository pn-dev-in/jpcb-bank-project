<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Edit Interest Rate</h2>

<form method="post" action="<?= base_url('admin/interest-rates/update/'.$rate['id']) ?>">

    <?= csrf_field() ?>

    <label>Type</label><br>
    <select name="type">
        <option value="savings" <?= $rate['type']=='savings'?'selected':'' ?>>Savings</option>
        <option value="fd" <?= $rate['type']=='fd'?'selected':'' ?>>FD</option>
        <option value="loan" <?= $rate['type']=='loan'?'selected':'' ?>>Loan</option>
    </select><br><br>

    <label>Title</label><br>
    <input type="text" name="title" value="<?= esc($rate['title']) ?>"><br><br>

    <label>Rate</label><br>
    <input type="number" step="0.01" name="rate" value="<?= esc($rate['rate']) ?>"><br><br>

    <label>Description</label><br>
    <textarea name="description"><?= esc($rate['description']) ?></textarea><br><br>

    <button type="submit">Update</button>

</form>

<?= $this->endSection() ?>
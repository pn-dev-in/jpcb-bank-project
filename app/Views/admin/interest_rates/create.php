<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Add Interest Rate</h2>

<form method="post" action="<?= base_url('admin/interest-rates/store') ?>">

    <?= csrf_field() ?>

    <label>Type</label><br>
    <select name="type" required>
        <option value="savings">Savings</option>
        <option value="fd">Fixed Deposit</option>
        <option value="loan">Loan</option>
    </select><br><br>

    <label>Title</label><br>
    <input type="text" name="title" required><br><br>

    <label>Rate (%)</label><br>
    <input type="number" step="0.01" name="rate" required><br><br>

    <label>Description</label><br>
    <textarea name="description"></textarea><br><br>

    <button type="submit">Save</button>

</form>

<?= $this->endSection() ?>
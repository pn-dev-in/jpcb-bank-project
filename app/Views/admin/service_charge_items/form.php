<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Charge Item</h3>
    </div>
    <div class="card-body">
        <!-- Display Validation Errors -->
        <?php if (session('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post"
              action="<?= isset($item) ? base_url('admin/service-charge-items/update/' . $item['id']) : base_url('admin/service-charge-items/store') ?>">
            <?= csrf_field() ?>

            <!-- Tab Selection -->
            <div class="mb-3">
                <label class="form-label">Tab</label>
                <select name="tab" class="form-control" required>
                    <option value="advances" <?= old('tab', $item['tab'] ?? 'advances') == 'advances' ? 'selected' : '' ?>>Advances</option>
                    <option value="dd" <?= old('tab', $item['tab'] ?? '') == 'dd' ? 'selected' : '' ?>>DD / Pay Order</option>
                    <option value="cheque" <?= old('tab', $item['tab'] ?? '') == 'cheque' ? 'selected' : '' ?>>Cheque &amp; Passbook</option>
                    <option value="cash" <?= old('tab', $item['tab'] ?? '') == 'cash' ? 'selected' : '' ?>>Cash &amp; ATM</option>
                    <option value="rtgs" <?= old('tab', $item['tab'] ?? '') == 'rtgs' ? 'selected' : '' ?>>RTGS / NEFT / OBC</option>
                    <option value="account" <?= old('tab', $item['tab'] ?? '') == 'account' ? 'selected' : '' ?>>Account Services</option>
                    <option value="misc" <?= old('tab', $item['tab'] ?? '') == 'misc' ? 'selected' : '' ?>>Miscellaneous</option>
                    <option value="scheme" <?= old('tab', $item['tab'] ?? '') == 'scheme' ? 'selected' : '' ?>>Scheme-wise Fees</option>
                </select>
            </div>

            <!-- Section (card heading) -->
            <div class="mb-3">
                <label class="form-label">Section Heading *</label>
                <input type="text" name="section" class="form-control"
                       value="<?= old('section', $item['section'] ?? '') ?>" required>
            </div>

            <!-- Type -->
            <div class="mb-3">
                <label class="form-label">Row Type</label>
                <select name="type" class="form-control" id="typeSelect" required>
                    <option value="row" <?= old('type', $item['type'] ?? 'row') == 'row' ? 'selected' : '' ?>>Row (2 columns)</option>
                    <option value="three_col" <?= old('type', $item['type'] ?? '') == 'three_col' ? 'selected' : '' ?>>Three Columns</option>
                    <option value="sub_header" <?= old('type', $item['type'] ?? '') == 'sub_header' ? 'selected' : '' ?>>Sub-header (full width)</option>
                    <option value="note" <?= old('type', $item['type'] ?? '') == 'note' ? 'selected' : '' ?>>Note (bottom text)</option>
                    <option value="callout" <?= old('type', $item['type'] ?? '') == 'callout' ? 'selected' : '' ?>>Callout / Paragraph</option>
                    <option value="scheme_row" <?= old('type', $item['type'] ?? '') == 'scheme_row' ? 'selected' : '' ?>>Scheme Row (numbered)</option>
                </select>
            </div>

            <!-- Label -->
            <div class="mb-3" id="labelGroup">
                <label class="form-label" id="labelLabel">Label / Description</label>
                <input type="text" name="label" class="form-control" id="labelInput"
                       value="<?= old('label', $item['label'] ?? '') ?>">
            </div>

            <!-- Charge -->
            <div class="mb-3" id="chargeGroup">
                <label class="form-label">Charge / Fee</label>
                <input type="text" name="charge" class="form-control" id="chargeInput"
                       value="<?= old('charge', $item['charge'] ?? '') ?>">
            </div>

            <!-- Description (third column) -->
            <div class="mb-3" id="descGroup">
                <label class="form-label">Description (third column)</label>
                <input type="text" name="description" class="form-control" id="descInput"
                       value="<?= old('description', $item['description'] ?? '') ?>">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control"
                           value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (old('status', $item['status'] ?? '1') == '1') ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (old('status', $item['status'] ?? '1') == '0') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/service-charge-items') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<!-- Dynamic Fields Toggle -->
<script>
(function() {
    var select = document.getElementById('typeSelect');
    var labelGroup = document.getElementById('labelGroup');
    var chargeGroup = document.getElementById('chargeGroup');
    var descGroup = document.getElementById('descGroup');
    var labelInput = document.getElementById('labelInput');
    var labelLbl = document.getElementById('labelLabel');

    function updateFields() {
        var type = select.value;
        // hide all optional groups
        chargeGroup.style.display = 'none';
        descGroup.style.display = 'none';
        labelInput.required = false;
        labelInput.type = 'text';
        labelLbl.textContent = 'Label / Description';

        if (type === 'row' || type === 'scheme_row' || type === 'three_col') {
            chargeGroup.style.display = 'block';
            if (type === 'scheme_row') {
                labelLbl.textContent = 'Scheme Name';
            }
            if (type === 'three_col') {
                descGroup.style.display = 'block';
            }
        } else if (type === 'callout' || type === 'note') {
            labelLbl.textContent = type === 'callout' ? 'Paragraph / Callout Text' : 'Note Text';
            labelInput.required = true;
            // show textarea for long texts
            if (!labelInput.parentNode.querySelector('textarea')) {
                var textarea = document.createElement('textarea');
                textarea.name = 'label';
                textarea.id = 'labelInput';
                textarea.className = 'form-control';
                textarea.rows = 8;
                textarea.required = true;
                textarea.value = labelInput.value;
                labelInput.parentNode.replaceChild(textarea, labelInput);
            }
        } else if (type === 'sub_header') {
            labelLbl.textContent = 'Sub-header Text';
        }
    }

    select.addEventListener('change', updateFields);
    // init on load
    updateFields();
})();
</script>

<?= $this->endSection() ?>
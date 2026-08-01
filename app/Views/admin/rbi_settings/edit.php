<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">RBI Section Settings</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/rbi-settings/update') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Ombudsman Introduction Text</label>
                <textarea name="ombudsman_intro" class="form-control"
                    rows="5"><?= esc($settings['ombudsman_intro'] ?? '') ?></textarea>
                <small class="text-muted d-block">Appears on the Banking Ombudsman page.</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Fair Practice Code PDF</label>
                <?php
                $fairPracticePdf = $settings['fair_practice_pdf'] ?? '';
                ?>
                <?php if (!empty($fairPracticePdf)): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($fairPracticePdf) ?>" target="_blank">View Current Fair Practice PDF</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="fair_practice_pdf" class="form-control" accept=".pdf">
                <small class="text-muted"> Upload a new PDF file to replace the current one.</small>
            </div>


            <div class="mb-3">
                <label class="form-label">Booklet Introduction Text</label>
                <textarea name="booklet_intro" class="form-control"
                    rows="5"><?= esc($settings['booklet_intro'] ?? '') ?></textarea>
                <small class="text-muted d-block">Appears on the RBI Booklet page.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Booklet PDF</label>
                <?php
                $pdfPath = $settings['booklet_pdf'] ?? '';
                if (!empty($pdfPath)): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($pdfPath) ?>" target="_blank">View Current PDF</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="booklet_pdf" class="form-control" accept=".pdf">
                <small class="text-muted">Upload a new PDF file to replace the current one.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Integrated Ombudsman Introduction Text</label>
                <textarea name="integrated_ombudsman_intro" class="form-control"
                    rows="5"><?= esc($settings['integrated_ombudsman_intro'] ?? '') ?></textarea>
                <small class="text-muted d-block">Appears on the Integrated Ombudsman page.</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Banking Ombudsman PDF</label>
                <?php
                $ombudsmanPdf = $settings['ombudsman_pdf'] ?? '';
                ?>
                <?php if (!empty($ombudsmanPdf)): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($ombudsmanPdf) ?>" target="_blank">View Current Ombudsman PDF</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="ombudsman_pdf" class="form-control" accept=".pdf">
                <small class="text-muted d-block mt-1">Upload Banking Ombudsman PDF.</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label">
                    Integrated Ombudsman Banner Image
                </label>
                <?php
                $bannerPath = $settings['integrated_ombudsman_banner'] ?? '';
                ?>
                <?php if (!empty($bannerPath)): ?>
                    <div class="mb-2">
                        <img src="<?= base_url($bannerPath) ?>" alt="Integrated Ombudsman Banner"
                            style="max-width:250px;border-radius:8px;">
                    </div>
                <?php endif; ?>
                <input type="file" name="integrated_ombudsman_banner" class="form-control" accept="image/*">
                <small c lass="text-muted">
                    Upload RBI Integrated Ombudsman Scheme banner image.
                </small>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
            <a href="<?= base_url('admin/rbi-topics') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
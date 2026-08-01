<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Heritage & Legacy Settings</h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/about-heritage/update-settings') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Eyebrow (small top label)</label>
                    <input type="text" name="eyebrow" class="form-control" value="<?= old('eyebrow', $settings['eyebrow'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Main Title</label>
                    <input type="text" name="title" class="form-control" value="<?= old('title', $settings['title'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Left Column Subheading</label>
                    <input type="text" name="subheading_left" class="form-control" value="<?= old('subheading_left', $settings['subheading_left'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Left Column Heading</label>
                    <input type="text" name="heading_left" class="form-control" value="<?= old('heading_left', $settings['heading_left'] ?? '') ?>">
                </div>
            </div>

            <!-- Heritage Image -->
            <div class="mb-3">
                <label class="form-label">Heritage Banner Image</label>
                <input type="file" name="image_file" class="form-control" accept="image/*">
                <?php if (!empty($settings['image'])): ?>
                    <div class="mt-2">
                        <img src="<?= base_url($settings['image']) ?>" width="150" class="img-thumbnail">
                        <p class="text-muted small mt-1">Current image</p>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="image" value="<?= $settings['image'] ?? '' ?>">
            </div>

            <!-- Intro Paragraph (visible first paragraph) -->
            <div class="mb-3">
                <label class="form-label">Intro Paragraph (Bodhi Tree philosophy)</label>
                <textarea name="intro_paragraph" class="form-control" rows="6"><?= old('intro_paragraph', $settings['intro_paragraph'] ?? '') ?></textarea>
                <small class="text-muted">HTML allowed – use &lt;span class="ab-heritage-highlight"&gt;text&lt;/span&gt; to highlight keywords.</small>
            </div>

            <!-- Founding Paragraph (second paragraph) -->
            <div class="mb-3">
                <label class="form-label">Founding Paragraph</label>
                <textarea name="founding_paragraph" class="form-control" rows="6"><?= old('founding_paragraph', $settings['founding_paragraph'] ?? '') ?></textarea>
            </div>

            <!-- Expandable Paragraphs (hidden behind "Read more") -->
            <div class="mb-3">
                <label class="form-label">Expandable Paragraphs (hidden behind "Read more")</label>
                <textarea name="expandable_paragraphs" class="form-control" rows="12"><?= old('expandable_paragraphs', $settings['expandable_paragraphs'] ?? '') ?></textarea>
                <small class="text-muted">HTML allowed – will appear inside the collapsible area.</small>
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
</div>

<!-- Badges Management -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Heritage Badges (Trust Badges)</h5>
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#badgeModal" onclick="resetBadgeForm()">
            <i class="ti ti-plus"></i> Add Badge
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Label</th>
                        <th>Description</th>
                        <th>Color</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($badges as $badge): ?>
                    <tr>
                        <td><i data-lucide="<?= esc($badge['icon']) ?>" class="w-5 h-5"></i></td>
                        <td><?= esc($badge['label']) ?></td>
                        <td><?= esc($badge['description']) ?></td>
                        <td><?= ucfirst(str_replace('-', ' ', $badge['color_theme'])) ?></td>
                        <td><?= $badge['sort_order'] ?></td>
                        <td><span class="badge bg-<?= $badge['status'] ? 'success' : 'secondary' ?>"><?= $badge['status'] ? 'Active' : 'Inactive' ?></span></td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-badge"
                                data-id="<?= $badge['id'] ?>"
                                data-icon="<?= esc($badge['icon']) ?>"
                                data-label="<?= esc($badge['label']) ?>"
                                data-description="<?= esc($badge['description']) ?>"
                                data-color="<?= $badge['color_theme'] ?>"
                                data-order="<?= $badge['sort_order'] ?>"
                                data-status="<?= $badge['status'] ?>"
                                data-bs-toggle="modal"
                                data-bs-target="#badgeModal">
                                <i class="ti ti-edit"></i> Edit
                            </button>
                            <a href="<?= base_url('admin/about-heritage/badge/delete/' . $badge['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this badge?')">
                                <i class="ti ti-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit Badge -->
<div class="modal fade" id="badgeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="badgeForm" action="">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="badgeModalLabel">Add Badge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="badge_id" id="badge_id">
                    <div class="mb-3">
                        <label class="form-label">Icon (Lucide name)</label>
                        <input type="text" name="icon" id="badge_icon" class="form-control" required>
                        <small>e.g., landmark, heart-handshake, shield-check, sprout</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" name="label" id="badge_label" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" id="badge_desc" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color Theme</label>
                        <select name="color_theme" id="badge_color" class="form-control">
                            <option value="primary">Primary (Green)</option>
                            <option value="secondary">Secondary (Teal)</option>
                            <option value="accent">Accent (Gold)</option>
                            <option value="primary-light">Primary Light</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="badge_order" class="form-control" value="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" id="badge_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Badge</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetBadgeForm() {
    document.getElementById('badgeForm').reset();
    document.getElementById('badgeForm').action = '<?= base_url('admin/about-heritage/badge/create') ?>';
    document.getElementById('badge_id').value = '';
    document.getElementById('badgeModalLabel').innerText = 'Add Badge';
}

document.querySelectorAll('.edit-badge').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        document.getElementById('badge_id').value = id;
        document.getElementById('badge_icon').value = this.dataset.icon;
        document.getElementById('badge_label').value = this.dataset.label;
        document.getElementById('badge_desc').value = this.dataset.description;
        document.getElementById('badge_color').value = this.dataset.color;
        document.getElementById('badge_order').value = this.dataset.order;
        document.getElementById('badge_status').value = this.dataset.status;
        document.getElementById('badgeForm').action = '<?= base_url('admin/about-heritage/badge/update/') ?>' + id;
        document.getElementById('badgeModalLabel').innerText = 'Edit Badge';
    });
});
</script>

<?= $this->endSection() ?>
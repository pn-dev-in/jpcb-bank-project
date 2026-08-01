<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Sitemap Sections</h3>
    <a href="<?= base_url('admin/sitemap-sections/create') ?>" class="btn btn-primary btn-sm">+ Add New Section</a>
</div>

<?php foreach ($items as $section): ?>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?= esc($section['title']) ?></h5>
            <div>
                <a href="<?= base_url('admin/sitemap-sections/edit/'.$section['id']) ?>" class="btn btn-sm btn-warning">Edit Section</a>
                <form action="<?= base_url('admin/sitemap-sections/delete/'.$section['id']) ?>" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete section and all its links?')">Delete Section</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <p class="text-muted small mb-3">Sort order: <?= $section['sort_order'] ?> | Status: 
                <span class="badge bg-<?= $section['status'] ? 'success' : 'secondary' ?>">
                    <?= $section['status'] ? 'Active' : 'Inactive' ?>
                </span>
            </p>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>Links under this section</strong>
                <a href="<?= base_url('admin/sitemap-links/create?section_id='.$section['id']) ?>" class="btn btn-xs btn-primary">+ Add Link</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>URL</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($section['links'])): ?>
                            <?php foreach ($section['links'] as $link): ?>
                            <tr>
                                <td><?= esc($link['label']) ?></td>
                                <td><?= esc($link['href']) ?></td>
                                <td><?= $link['sort_order'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $link['status'] ? 'success' : 'secondary' ?>">
                                        <?= $link['status'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/sitemap-links/edit/'.$link['id']) ?>" class="btn btn-xs btn-warning">Edit</a>
                                    <form action="<?= base_url('admin/sitemap-links/delete/'.$link['id']) ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Delete?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">No links in this section.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->endSection() ?>
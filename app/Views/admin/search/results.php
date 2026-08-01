<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Search results for "<?= esc($query) ?>"</h3>
    </div>
    <div class="card-body">
        <!-- Admin Pages Results -->
        <?php if (!empty($pageResults)): ?>
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Admin Pages</h5>
                <ul class="list-group">
                    <?php foreach ($pageResults as $page): ?>
                        <li class="list-group-item list-group-item-action">
                            <a href="<?= $page['url'] ?>" class="text-decoration-none">
                                <i class="ti ti-folder-open me-2"></i> <?= esc($page['label']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Data Records Results (optional) -->
        <?php if (!empty($dataResults)): ?>
            <?php foreach ($dataResults as $category => $items): ?>
                <div class="mb-4">
                    <h5 class="text-secondary border-bottom pb-2"><?= ucfirst(str_replace('_', ' ', $category)) ?></h5>
                    <ul class="list-group">
                        <?php foreach ($items as $item): ?>
                            <li class="list-group-item list-group-item-action">
                                <?php
                                $url = '#';
                                $title = '';
                                switch ($category) {
                                    case 'products':
                                        $url = base_url('admin/products/edit/' . $item['id']);
                                        $title = $item['name'];
                                        break;
                                    case 'notices':
                                        $url = base_url('admin/notices/edit/' . $item['id']);
                                        $title = $item['title'];
                                        break;
                                    case 'branches':
                                        $url = base_url('admin/branches/edit/' . $item['id']);
                                        $title = $item['branch_name'] . ' (' . ($item['city'] ?? '') . ')';
                                        break;
                                }
                                ?>
                                <a href="<?= $url ?>" class="text-decoration-none">
                                    <?= esc($title) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (empty($pageResults) && empty($dataResults)): ?>
            <p class="text-muted">No results found for "<?= esc($query) ?>". Try a different keyword.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
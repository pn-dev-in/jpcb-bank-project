<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Homepage CMS</h2>

<hr>

<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">

    <!-- HERO SECTION -->
    <div style="border:1px solid #ccc; padding:20px;">
        <h3>Hero Section</h3>
        <p>Edit heading, subheading, buttons</p>

        <a href="<?= base_url('admin/homepage/edit-hero') ?>">
            <button>Edit Hero</button>
        </a>
    </div>

    <!-- TRUST CARDS -->
    <div style="border:1px solid #ccc; padding:20px;">
        <h3>Trust Cards</h3>
        <p>Manage cards shown on homepage</p>

        <a href="<?= base_url('admin/homepage/trust-cards') ?>">
            <button>View Cards</button>
        </a>

        <a href="<?= base_url('admin/homepage/create-card') ?>">
            <button>Add New Card</button>
        </a>
    </div>

</div>

<br><br>

<!-- OPTIONAL: QUICK LINKS -->
<div style="margin-top:20px;">
    <h3>Quick Actions</h3>

    <ul>
        <li><a href="<?= base_url('admin/homepage/edit-hero') ?>">Edit Hero Section</a></li>
        <li><a href="<?= base_url('admin/homepage/trust-cards') ?>">Manage Trust Cards</a></li>
    </ul>
</div>
<?= $this->endSection() ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>

    <!-- SIDEBAR -->
    <?= view('admin/partials/sidebar') ?>

    <!-- MAIN CONTENT -->
    <div style="margin-left:200px; padding:20px;">
        <?= $this->renderSection('content') ?>
    </div>

</body>
</html>
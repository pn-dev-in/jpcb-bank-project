<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { overflow-x: hidden; }

        .sidebar {
            height: 100vh;
            overflow-y: auto; 
            overflow-x: hidden;
            background: #2e7d32;
            color: white;
            position: fixed;
            width: 240px;
            top: 0;
    left: 0;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 12px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #245e38;
        }

        .sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

        .content {
            margin-left: 240px;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .navbar {
            background: #2e7d32;
            color: #fff;
        }

        .submenu { display: none; }
        .submenu.show { display: block; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <?= view('admin/layout/sidebar') ?>

    <!-- MAIN CONTENT -->
    <div class="content">

        <!-- NAVBAR -->
        <?= view('admin/layout/navbar') ?>

        <div class="p-4">
            <?= $this->renderSection('content') ?>
        </div>

    </div>

<script>
function toggleMenu(id) {
    let menu = document.getElementById(id);
    menu.classList.toggle("show");
}
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            height: 100vh;
            background: #2e7d32;
            color: white;
            position: fixed;
            width: 240px;
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

        .content {
            margin-left: 240px;
             background: #f8f9fa;
            min-height: 100vh;
        }

        .navbar {
            background: #2e7d32;
            color: #fff;
        }

        .menu a.active {
    background: #e8f5e9;
    color: #2e7d32;
    font-weight: bold;
}

.submenu {
    display: none;
}

.submenu.show {
    display: block;
}
        
    </style>
</head>
<body>
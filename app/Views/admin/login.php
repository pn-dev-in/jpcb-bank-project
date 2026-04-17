<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | JPCB Bank</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">

    <!-- LOGO -->
    <div class="text-center mb-6">
        <img src="<?= base_url('assets/images/bank-logo.png') ?>" class="mx-auto h-16 mb-3">
        <h2 class="text-xl font-bold text-gray-700">JPCB Admin Panel</h2>
        <p class="text-sm text-gray-500">Login to continue</p>
    </div>

    <!-- ERROR -->
    <?php if(session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-600 p-2 rounded mb-4 text-center">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- FORM -->
    <form method="post" action="/admin/login">

        <?= csrf_field() ?>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                   placeholder="Enter your email" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                   placeholder="Enter your password" required>
        </div>

        <div class="flex justify-between items-center mb-4 text-sm">
            <label class="flex items-center gap-2">
                <input type="checkbox">
                Remember me
            </label>
            <a href="#" class="text-green-600 hover:underline">Forgot?</a>
        </div>

        <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
            Login
        </button>

    </form>

</div>

</body>
</html>
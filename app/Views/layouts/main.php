<!DOCTYPE html>
<html lang="en" class="text-scale-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="<?= esc($description ?? 'The Jalgaon Peoples Co-Op. Bank Ltd. – Trusted banking since 1933.') ?>">
  <meta name="keywords" content="JPCB, Jalgaon Bank, cooperative bank, savings account, fixed deposit, loans, Maharashtra banking">
  <meta name="author" content="The Jalgaon Peoples Co-Op. Bank Ltd.">
  <meta name="robots" content="index, follow">

  <!-- Open Graph -->
  <meta property="og:title" content="<?= esc($title ?? 'JPCB – Jalgaon Peoples Co-Op. Bank') ?>">
  <meta property="og:description" content="<?= esc($description ?? 'Trusted banking since 1933.') ?>">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_IN">

  <title><?= esc($title ?? 'The Jalgaon Peoples Co-Op. Bank Ltd.') ?></title>

  <!-- Canonical -->
  <link rel="canonical" href="<?= esc(current_url()) ?>">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <!-- Local Tailwind build -->
  <link rel="stylesheet" href="<?= base_url('assets/css/tailwind.css') ?>?v=<?= filemtime(FCPATH . 'assets/css/tailwind.css') ?>">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>?v=<?= filemtime(FCPATH . 'assets/css/style.css') ?>">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <?= $this->renderSection('head') ?>
</head>
<body class="min-h-screen flex flex-col" style="font-family: var(--font-body); background-color: hsl(var(--background)); color: hsl(var(--foreground));">

  <!-- Skip Links -->
  <a href="#main-content" class="skip-link">Skip to main content</a>
  <a href="#main-nav" class="skip-link">Skip to navigation</a>
  <a href="#contact" class="skip-link">Skip to footer</a>

  <!-- Focus Reading Strip -->
  <div id="focus-strip" class="focus-strip-clear" style="display:none;top:0;" aria-hidden="true"></div>

  <!-- Accessibility Toolbar -->
  <?= view('components/accessibility_toolbar') ?>

  <!-- Header -->
  <?= view('components/header') ?>

  <!-- Main Content -->
  <main id="main-content" role="main" class="flex-1">
    <?= $this->renderSection('content') ?>
  </main>

  <!-- Footer -->
  <?= view('components/footer') ?>

  <!-- Lucide Icons (vanilla JS) -->
  <script src="https://unpkg.com/lucide@0.462.0/dist/umd/lucide.min.js"></script>

  <!-- Main JS -->
  <script src="<?= base_url('assets/js/main.js') ?>?v=<?= filemtime(FCPATH . 'assets/js/main.js') ?>"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <?= $this->renderSection('scripts') ?>
</body>
</html>

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <div class="bank-card p-8 text-center max-w-2xl mx-auto">
      <h1 class="font-heading text-3xl md:text-5xl text-foreground mb-4">404</h1>
      <p class="text-xl text-muted-foreground mb-4">Oops! Page not found</p>
      <a href="<?= site_url('/') ?>" class="btn-primary">Return to Home</a>
    </div>
  </div>
</section>
<?= $this->endSection() ?>

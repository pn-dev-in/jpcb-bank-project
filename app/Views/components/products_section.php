<section id="products" class="section-padding" aria-labelledby="products-heading" style="background-color: hsl(var(--background));">
  <div class="container-bank">
    <div class="text-center mb-10 md:mb-14">
      <h2 id="products-heading" class="font-heading text-2xl md:text-3xl lg:text-4xl mb-3" style="color: hsl(var(--foreground));">
        <?= esc($productsSection['heading'] ?? 'Our Products & Services') ?>
      </h2>
      <p class="readable max-w-2xl mx-auto" style="color: hsl(var(--muted-foreground));">
        <?= esc($productsSection['subheading'] ?? 'Comprehensive banking solutions for individuals, farmers, and businesses. Trusted by generations.') ?>
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
      <?php foreach ($products as $product): ?>
        <article class="bank-card-elevated p-6 md:p-8 group flex flex-col">
          <div class="flex items-start gap-4 mb-4">
            <div class="w-12 h-12 rounded-lg gradient-primary flex items-center justify-center flex-shrink-0">
              <i data-lucide="<?= esc($product['icon']) ?>" class="w-6 h-6" style="color: hsl(var(--primary-foreground));"></i>
            </div>
            <h3 class="font-heading text-lg md:text-xl pt-1" style="color: hsl(var(--foreground));"><?= esc($product['name']) ?></h3>
          </div>
          <ul class="space-y-2 mb-6 flex-1" aria-label="<?= esc($product['name']) ?> features">
            <?php foreach ($product['features'] as $feature): ?>
              <li class="flex items-start gap-2 text-sm" style="color: hsl(var(--muted-foreground));">
                <span class="w-1.5 h-1.5 rounded-full mt-2 flex-shrink-0" style="background-color: hsl(var(--primary));" aria-hidden="true"></span>
                <?= esc($feature) ?>
              </li>
            <?php endforeach; ?>
          </ul>
          <a href="<?= esc($product['href']) ?>" class="inline-flex items-center gap-2 font-medium tap-target text-sm transition-all product-learn-more" style="color: hsl(var(--primary));">
            Learn more <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
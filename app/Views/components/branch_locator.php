<section id="branch-locator" class="section-padding" aria-labelledby="branch-heading" style="background-color: hsl(var(--background));">
  <div class="container-bank">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

      <!-- Left: Search + Branch list -->
      <div>
        <h2 id="branch-heading" class="font-heading text-2xl md:text-3xl mb-3" style="color: hsl(var(--foreground));">
          Find Branch / ATM
        </h2>
        <p class="readable mb-6" style="color: hsl(var(--muted-foreground));">
          Locate our branches and ATMs near you. Enter your pincode, city, or IFSC code.
        </p>

        <form id="branch-search-form" action="<?= site_url('about/branches') ?>" method="get" class="mb-6" role="search">
          <label for="branch-search" class="sr-only">Search by pincode, city, or IFSC</label>
          <div class="relative">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 pointer-events-none" style="color: hsl(var(--muted-foreground));" aria-hidden="true"></i>
            <input id="branch-search" type="text" name="q"
              placeholder="Enter pincode, city name, or IFSC..."
              maxlength="100"
              class="w-full pl-12 pr-24 py-3.5 rounded-lg border focus:outline-none focus:ring-2"
              style="background-color: hsl(var(--card)); border-color: hsl(var(--border)); color: hsl(var(--foreground));"
              autocomplete="off">
            <button type="submit"
              class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 rounded-md font-medium tap-target text-sm transition-opacity hover:opacity-90"
              style="background-color: hsl(var(--primary)); color: hsl(var(--primary-foreground));">
              Search
            </button>
          </div>
        </form>

        <div class="space-y-3">
          <?php foreach ($branches as $branch): ?>
    <article class="bank-card p-4">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5" style="background-color: hsl(var(--primary) / 0.1);">
                <i data-lucide="map-pin" class="w-4 h-4" style="color: hsl(var(--primary));"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2">
                    <h3 class="font-semibold text-sm" style="color: hsl(var(--foreground));"><?= esc($branch['branch_name']) ?></h3>
                    <?php if ($branch['has_atm']): ?>
                        <span class="text-xs px-2 py-0.5 rounded font-medium flex-shrink-0" style="background-color: hsl(var(--primary) / 0.1); color: hsl(var(--primary));">ATM</span>
                    <?php endif; ?>
                </div>
                <p class="text-sm mt-0.5" style="color: hsl(var(--muted-foreground));"><?= esc($branch['address']) ?><?= $branch['area'] ? ', ' . esc($branch['area']) : '' ?></p>
                <div class="flex flex-wrap items-center gap-3 mt-1.5 text-xs" style="color: hsl(var(--muted-foreground));">
                    <span class="flex items-center gap-1"><i data-lucide="phone" class="w-3 h-3"></i><?= esc($branch['phone']) ?></span>
                    <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i><?= esc($branch['timings']) ?></span>
                </div>
            </div>
        </div>
    </article>
<?php endforeach; ?>
        </div>

        <a href="<?= site_url('about/branches') ?>" class="inline-flex items-center gap-2 font-medium tap-target mt-4 text-sm" style="color: hsl(var(--primary));">
          View all branches <i data-lucide="external-link" class="w-4 h-4" aria-hidden="true"></i>
        </a>
      </div>

      <!-- Right: Map placeholder -->
      <!-- Right: Map -->
      <div class="order-first lg:order-last">
        <div class="w-full h-64 lg:h-full min-h-[400px] rounded-lg overflow-hidden border">

          <iframe
            src="https://www.google.com/maps?q=Jalgaon,Maharashtra&output=embed"
            width="100%"
            height="100%"
            style="border:0;"
            loading="lazy">
          </iframe>

        </div>
      </div>

    </div>
  </div>
</section>
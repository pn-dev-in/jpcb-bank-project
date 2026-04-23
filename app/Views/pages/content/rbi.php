<?php if ($pageKey === 'overview'): ?>
<section class="section-padding bg-background">
  <div class="container-bank">
    <p class="readable max-w-3xl mb-10" style="color: hsl(var(--muted-foreground));">We are committed to customer education and awareness as mandated by the Reserve Bank of India. Explore resources to understand your rights, responsibilities, and safety practices.</p>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php if (!empty($rbiTopics)): ?>
        <?php foreach ($rbiTopics as $topic): ?>
        <a href="<?= site_url(ltrim($topic['href'], '/')) ?>" class="bank-card p-6 transition-colors">
          <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background-color: hsl(var(--primary) / 0.1);">
            <i data-lucide="<?= esc($topic['icon']) ?>" class="w-6 h-6 text-primary"></i>
          </div>
          <h3 class="font-semibold text-foreground mb-2"><?= esc($topic['title']) ?></h3>
          <p class="text-sm" style="color: hsl(var(--muted-foreground));"><?= esc($topic['description']) ?></p>
          <span class="inline-flex items-center gap-1 text-sm text-primary font-medium mt-3">Read more <i data-lucide="arrow-right" class="w-4 h-4"></i></span>
        </a>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No RBI topics found.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'fair-practice'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <div class="bank-card p-8 mb-8">
      <p class="readable mb-4" style="color: hsl(var(--muted-foreground));">JPC Bank is committed to fair and transparent banking practices in line with RBI guidelines. Our Fair Practice Code covers loan processing, deposit handling, customer service, and grievance redressal.</p>
      <h2 class="font-heading text-lg text-foreground mb-3">Key Principles</h2>
      <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
        <?php if (!empty($fairPracticePrinciples)): ?>
          <?php foreach ($fairPracticePrinciples as $principle): ?>
          <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><?= esc($principle) ?></li>
          <?php endforeach; ?>
        <?php else: ?>
          <li>No principles available.</li>
        <?php endif; ?>
      </ul>
    </div>
    <button class="btn-primary text-sm flex items-center gap-2" type="button"><i data-lucide="download" class="w-4 h-4"></i> Download Full Fair Practice Code</button>
  </div>
</section>

<?php elseif ($pageKey === 'ombudsman'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <div class="bank-card p-6 mb-8">
      <h2 class="font-heading text-lg text-foreground mb-3">What is the Banking Ombudsman?</h2>
      <p class="readable" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc($ombudsmanIntro ?? 'The Banking Ombudsman is a senior official appointed by the Reserve Bank of India to resolve customer complaints against banks that are not resolved satisfactorily within 30 days.')) ?></p>
    </div>
    <div class="bank-card p-6 mb-8">
      <h2 class="font-heading text-lg text-foreground mb-3">When Can You Approach the Ombudsman?</h2>
      <ul class="space-y-2 text-sm" style="color: hsl(var(--muted-foreground));">
        <?php if (!empty($ombudsmanReasons)): ?>
          <?php foreach ($ombudsmanReasons as $reason): ?>
          <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span><?= esc($reason) ?></li>
          <?php endforeach; ?>
        <?php else: ?>
          <li>No reasons listed.</li>
        <?php endif; ?>
      </ul>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
      <a href="https://cms.rbi.org.in" target="_blank" rel="noopener" class="bank-card p-5 flex items-center gap-3 transition-colors">
        <i data-lucide="external-link" class="w-8 h-8 text-primary"></i>
        <div><p class="font-semibold text-foreground text-sm">File Online Complaint</p><p class="text-xs" style="color: hsl(var(--muted-foreground));">cms.rbi.org.in</p></div>
      </a>
      <a href="tel:14448" class="bank-card p-5 flex items-center gap-3 transition-colors">
        <i data-lucide="phone" class="w-8 h-8 text-primary"></i>
        <div><p class="font-semibold text-foreground text-sm">Call Helpline</p><p class="text-xs" style="color: hsl(var(--muted-foreground));">14448 (Toll-free)</p></div>
      </a>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'booklet'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <div class="bank-card p-8 mb-8">
      <p class="readable mb-6" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc($bookletIntro ?? 'The Reserve Bank of India publishes awareness booklets to educate customers about their rights, banking safety, and responsible financial practices.')) ?></p>
      <h2 class="font-heading text-lg text-foreground mb-4">Key Topics Covered</h2>
      <div class="grid sm:grid-cols-2 gap-3">
        <?php if (!empty($bookletTopics)): ?>
          <?php foreach ($bookletTopics as $topic): ?>
          <div class="flex items-center gap-2 p-3 rounded-lg text-sm text-foreground" style="background-color: hsl(var(--muted));">
            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span><?= esc($topic) ?>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No topics available.</p>
        <?php endif; ?>
      </div>
    </div>
    <button class="btn-primary text-sm flex items-center gap-2" type="button"><i data-lucide="download" class="w-4 h-4"></i> Download RBI Booklet (PDF)</button>
  </div>
</section>

<?php elseif ($pageKey === 'integrated-ombudsman'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <div class="bank-card p-6 mb-8">
      <h2 class="font-heading text-lg text-foreground mb-3">One Nation One Ombudsman</h2>
      <p class="readable" style="color: hsl(var(--muted-foreground));"><?= nl2br(esc($integratedOmbudsmanIntro ?? 'The RBI Integrated Ombudsman Scheme (2021) provides a single-window system for resolution of customer complaints against banks, NBFCs, and payment system participants. One complaint portal, one email, and one postal address for all complaints.')) ?></p>
    </div>
    <div class="bank-card p-6 mb-8">
      <h3 class="font-semibold text-foreground mb-3">How to File a Complaint</h3>
      <div class="grid sm:grid-cols-3 gap-4">
        <?php if (!empty($integratedSteps)): ?>
          <?php foreach ($integratedSteps as $step): ?>
          <div class="text-center">
            <span class="w-10 h-10 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold mx-auto mb-2"><?= esc($step['step_number']) ?></span>
            <h4 class="font-semibold text-foreground text-sm"><?= esc($step['title']) ?></h4>
            <p class="text-xs mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($step['description']) ?></p>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No steps available.</p>
        <?php endif; ?>
      </div>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
      <a href="https://cms.rbi.org.in" target="_blank" rel="noopener" class="bank-card p-5 flex items-center gap-3 transition-colors">
        <i data-lucide="external-link" class="w-8 h-8 text-primary"></i>
        <div><p class="font-semibold text-foreground text-sm">CMS Portal</p><p class="text-xs" style="color: hsl(var(--muted-foreground));">cms.rbi.org.in</p></div>
      </a>
      <a href="tel:14448" class="bank-card p-5 flex items-center gap-3 transition-colors">
        <i data-lucide="phone" class="w-8 h-8 text-primary"></i>
        <div><p class="font-semibold text-foreground text-sm">Helpline: 14448</p><p class="text-xs" style="color: hsl(var(--muted-foreground));">Toll-free</p></div>
      </a>
    </div>
  </div>
</section>

<?php elseif ($pageKey === 'dos-and-donts'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <p class="readable mb-10" style="color: hsl(var(--muted-foreground));">Follow these guidelines to keep your banking safe and secure.</p>
    <div class="grid md:grid-cols-2 gap-8">
      <div class="bank-card p-6">
        <h2 class="font-heading text-xl text-foreground mb-4 flex items-center gap-2"><i data-lucide="circle-check" class="w-6 h-6" style="color: hsl(var(--success, var(--primary)));"></i> Do's</h2>
        <ul class="space-y-2">
          <?php if (!empty($dos)): ?>
            <?php foreach ($dos as $item): ?>
            <li class="text-sm flex items-start gap-2" style="color: hsl(var(--muted-foreground));"><span class="w-1.5 h-1.5 rounded-full flex-shrink-0 mt-2" style="background-color: hsl(var(--success, var(--primary)));"></span><?= esc($item) ?></li>
            <?php endforeach; ?>
          <?php else: ?>
            <li>No do's available.</li>
          <?php endif; ?>
        </ul>
      </div>
      <div class="bank-card p-6">
        <h2 class="font-heading text-xl text-foreground mb-4 flex items-center gap-2"><i data-lucide="alert-triangle" class="w-6 h-6" style="color: hsl(var(--destructive));"></i> Don'ts</h2>
        <ul class="space-y-2">
          <?php if (!empty($donts)): ?>
            <?php foreach ($donts as $item): ?>
            <li class="text-sm flex items-start gap-2" style="color: hsl(var(--muted-foreground));"><span class="w-1.5 h-1.5 rounded-full flex-shrink-0 mt-2" style="background-color: hsl(var(--destructive));"></span><?= esc($item) ?></li>
            <?php endforeach; ?>
          <?php else: ?>
            <li>No don'ts available.</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
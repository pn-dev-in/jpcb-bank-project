<?php if ($pageKey === 'complaints'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-3xl">
    <div class="bank-card p-6 mb-8" style="border-left: 4px solid hsl(var(--destructive));">
      <div class="flex items-start gap-3">
        <i data-lucide="alert-triangle" class="w-6 h-6 flex-shrink-0" style="color: hsl(var(--destructive));"></i>
        <div>
          <p class="font-semibold text-foreground">For unauthorized transactions or card theft</p>
          <p class="text-sm" style="color: hsl(var(--muted-foreground));">Call <a href="tel:02572220055" class="text-primary font-medium">0257-2220055</a> immediately. Quick reporting can help reduce liability.</p>
        </div>
      </div>
    </div>

    <div id="complaint-wizard" data-current-step="1">
      <div class="flex items-center gap-2 mb-8">
        <?php foreach ([1, 2, 3] as $index => $step): ?>
        <div
          data-complaint-indicator="<?= $step ?>"
          class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm <?= $step === 1 ? 'bg-primary text-primary-foreground' : 'bg-muted' ?>"
          style="<?= $step === 1 ? '' : 'color: hsl(var(--muted-foreground));' ?>"
        ><?= $step ?></div>
        <?php if ($index < 2): ?>
        <div
          data-complaint-connector="<?= $step ?>"
          class="flex-1 h-1 rounded <?= $step === 1 ? 'bg-primary' : 'bg-muted' ?>"
        ></div>
        <?php endif; ?>
        <?php endforeach; ?>
      </div>

      <div data-complaint-panel="1" class="bank-card p-6">
        <h2 class="font-heading text-lg text-foreground mb-4">Step 1: Your Details</h2>
        <div class="space-y-4">
          <div>
            <label class="text-sm font-medium text-foreground block mb-1" for="complaint-name">Full Name *</label>
            <input id="complaint-name" data-complaint-required-step="1" class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));" placeholder="Enter your full name">
          </div>
          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-medium text-foreground block mb-1" for="complaint-mobile">Mobile Number *</label>
              <input id="complaint-mobile" data-complaint-required-step="1" class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));" placeholder="10-digit mobile">
            </div>
            <div>
              <label class="text-sm font-medium text-foreground block mb-1" for="complaint-email">Email</label>
              <input id="complaint-email" type="email" class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));" placeholder="your@email.com">
            </div>
          </div>
          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-medium text-foreground block mb-1" for="complaint-account">Account Number</label>
              <input id="complaint-account" class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));" placeholder="Your account number">
            </div>
            <div>
              <label class="text-sm font-medium text-foreground block mb-1" for="complaint-branch">Branch *</label>
              <select id="complaint-branch" data-complaint-required-step="1" class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));">
                <option value="">Select branch</option>
                <option>Head Office</option>
                <option>Market Yard</option>
                <option>Bhusawal</option>
                <option>Pachora</option>
                <option>Chopda</option>
                <option>Amalner</option>
              </select>
            </div>
          </div>
          <button type="button" data-complaint-next="2" class="btn-primary">Continue to Step 2</button>
        </div>
      </div>

      <div data-complaint-panel="2" class="bank-card p-6 hidden">
        <h2 class="font-heading text-lg text-foreground mb-4">Step 2: Complaint Details</h2>
        <div class="space-y-4">
          <div>
            <label class="text-sm font-medium text-foreground block mb-1" for="complaint-category">Category *</label>
            <select id="complaint-category" data-complaint-required-step="2" class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));">
              <option value="">Select category</option>
              <?php if (!empty($complaintCategories)): ?>
                <?php foreach ($complaintCategories as $category): ?>
                <option><?= esc($category) ?></option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
          <div>
            <label class="text-sm font-medium text-foreground block mb-1" for="complaint-description">Description *</label>
            <textarea id="complaint-description" data-complaint-required-step="2" rows="5" class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));" placeholder="Describe your complaint in detail..."></textarea>
          </div>
          <div>
            <label class="text-sm font-medium text-foreground block mb-1" for="complaint-date">Date of Incident</label>
            <input id="complaint-date" type="date" class="w-full p-3 rounded-lg border bg-background text-foreground focus:ring-2 focus:outline-none" style="border-color: hsl(var(--border));">
          </div>
          <div>
            <label class="text-sm font-medium text-foreground block mb-1">Attachments (optional)</label>
            <div class="border-2 border-dashed rounded-lg p-6 text-center" style="border-color: hsl(var(--border));">
              <i data-lucide="upload" class="w-8 h-8 mx-auto mb-2" style="color: hsl(var(--muted-foreground));"></i>
              <p class="text-sm" style="color: hsl(var(--muted-foreground));">File upload preview area</p>
            </div>
          </div>
          <div class="flex gap-3">
            <button type="button" data-complaint-prev="1" class="btn-outline">Back</button>
            <button type="button" id="complaint-submit" class="btn-primary">Submit Complaint</button>
          </div>
        </div>
      </div>

      <div data-complaint-panel="3" class="bank-card p-6 hidden text-center">
        <div class="py-8">
          <i data-lucide="circle-check" class="w-16 h-16 text-primary mx-auto mb-4"></i>
          <h2 class="font-heading text-2xl text-foreground mb-2">Complaint Submitted</h2>
          <p class="mb-2" style="color: hsl(var(--muted-foreground));">Reference Number: <strong class="text-foreground" id="complaint-reference">JPCB-2026-04-00127</strong></p>
          <p class="text-sm mb-6" style="color: hsl(var(--muted-foreground));">We aim to respond within 7 working days. You may escalate if the issue is not resolved.</p>
          <div class="flex gap-3 justify-center">
            <a href="<?= site_url('complaints/escalation') ?>" class="btn-outline text-sm">View Escalation Matrix</a>
            <a href="<?= site_url('/') ?>" class="btn-primary text-sm">Back to Home</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php elseif ($pageKey === 'escalation'): ?>
<section class="section-padding bg-background">
  <div class="container-bank max-w-4xl">
    <p class="readable mb-8" style="color: hsl(var(--muted-foreground));">If your complaint is not resolved satisfactorily, you may escalate it through the following levels.</p>
    <div class="space-y-4">
      <?php if (!empty($escalationLevels)): ?>
        <?php foreach ($escalationLevels as $index => $level): ?>
        <div class="bank-card p-6 relative">
          <?php if ($index < count($escalationLevels) - 1): ?>
          <div class="absolute left-10 bottom-0 translate-y-full w-0.5 h-4 bg-border z-10" aria-hidden="true"></div>
          <?php endif; ?>
          <div class="flex items-start gap-4">
            <span class="w-12 h-12 rounded-full bg-primary text-primary-foreground flex items-center justify-center font-bold flex-shrink-0 text-sm"><?= esc(preg_replace('/[^0-9]/', '', $level['level'])) ?></span>
            <div class="flex-1">
              <h3 class="font-semibold text-foreground"><?= esc($level['level']) ?>: <?= esc($level['title']) ?></h3>
              <p class="text-sm text-primary font-medium"><?= esc($level['name']) ?></p>
              <p class="text-sm mt-1" style="color: hsl(var(--muted-foreground));"><?= esc($level['description']) ?></p>
              <div class="flex flex-wrap gap-4 mt-3 text-sm" style="color: hsl(var(--muted-foreground));">
                <span class="flex items-center gap-1"><i data-lucide="phone" class="w-4 h-4"></i><?= esc($level['phone']) ?></span>
                <span class="flex items-center gap-1"><i data-lucide="mail" class="w-4 h-4"></i><?= esc($level['email']) ?></span>
                <span class="flex items-center gap-1"><i data-lucide="clock" class="w-4 h-4"></i><?= esc($level['timeline']) ?></span>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No escalation levels available.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>
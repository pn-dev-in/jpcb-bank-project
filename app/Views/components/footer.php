<footer id="contact" role="contentinfo" class="footer-bank">

    <!-- ── Main footer body ── -->
    <div class="container-bank py-4 md:py-6">

        <!--
      STRUCTURAL CHANGE:
      Replaced the old nested-grid soup (grid-cols-1 lg:grid-cols-4 wrapping multiple
      inner grids of grid-cols-2) with a single two-column wrapper:
        • footer-left  → logo, contact, DICGC, social icons
        • footer-links-grid → all 5 link columns as direct siblings in ONE grid
    -->
        <div class="footer-wrapper">

            <!-- ════════════════════════════════════
           LEFT SECTION  –  brand / contact / social
           (content unchanged; only the wrapping div changed)
           ════════════════════════════════════ -->
            <div class="footer-left">

                <img src="<?= base_url('assets/images/bank-logo.png') ?>" alt="JPC Bank"
                    class="footer-logo h-10 w-auto mb-4">

                <div class="space-y-1 text-sm footer-muted">

                    <!-- Phone numbers (unchanged) -->
                    <div class="flex flex-col gap-1">
                        <?php if (!empty($siteSettings['phone'])): ?>
                            <div class="flex items-center gap-1 transition-colors"
                                onmouseover="this.style.color='rgba(255,255,255,1)'"
                                onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                                <i data-lucide="phone" class="w-4 h-4 flex-shrink-0"></i>
                                Ph.No: <?= esc($siteSettings['phone']) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($siteSettings['phone_alternate'])): ?>
                            <div class="flex items-center gap-1 transition-colors"
                                onmouseover="this.style.color='rgba(255,255,255,1)'"
                                onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                                <i data-lucide="phone" class="w-4 h-4 flex-shrink-0"></i>
                                Contact: <?= esc($siteSettings['phone_alternate']) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($siteSettings['toll_free'])): ?>
                            <div class="flex items-center gap-1 transition-colors"
                                onmouseover="this.style.color='rgba(255,255,255,1)'"
                                onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                                <i data-lucide="phone" class="w-4 h-4 flex-shrink-0"></i>
                                Toll Free: <?= esc($siteSettings['toll_free']) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($siteSettings['helpline'])): ?>
                            <div class="flex items-center gap-1 transition-colors"
                                onmouseover="this.style.color='rgba(255,255,255,1)'"
                                onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                                <i data-lucide="phone" class="w-4 h-4 flex-shrink-0"></i>
                                Helpline: <?= esc($siteSettings['helpline']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Emails (unchanged) -->
                    <?php if (!empty($siteSettings['email'])): ?>
                        <div class="flex items-center gap-2 transition-colors"
                            onmouseover="this.style.color='rgba(255,255,255,1)'"
                            onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                            <i data-lucide="mail" class="w-4 h-4 flex-shrink-0"></i>
                            <?= esc($siteSettings['email']) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($siteSettings['email_support'])): ?>
                        <div class="flex items-center gap-2 transition-colors"
                            onmouseover="this.style.color='rgba(255,255,255,1)'"
                            onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                            <i data-lucide="mail" class="w-4 h-4 flex-shrink-0"></i>
                            <span style="white-space: nowrap;">
                                24x7 Support: <?= esc($siteSettings['email_support']) ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <!-- Address (unchanged) -->
                    <?php
                    $address = $siteSettings['footer_address'] ?? $siteSettings['address'] ?? '';
                    if (empty($address)) {
                        $address = 'Near Railway Station,<br>Jalgaon - 425001, Maharashtra';
                    }
                    ?>
                    <div class="flex items-start gap-2 hover:text-white transition-colors duration-200">
                        <i data-lucide="map-pin" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
                        <span class="footer-address">
                            <?= str_replace('<br>', ', ', nl2br(esc($address))) ?>
                        </span>
                    </div>


                </div><!-- /.space-y-1 -->
            </div><!-- /.footer-left -->


            <!-- ════════════════════════════════════
           RIGHT SECTION  –  all 5 link columns
           STRUCTURAL CHANGE:
           Old code had THREE separate <div class="grid grid-cols-2"> blocks:
             • grid 1 → About + Products
             • grid 2 → Services + Help
             • grid 3 → Policies (orphaned, outside both grids)
           New code uses ONE .footer-links-grid that holds all five
           .footer-column divs as direct siblings.  On desktop this
           becomes a 5-column row; on tablet 2-3 columns; on mobile
           a single stacked column.  No nesting, no orphans.
           ════════════════════════════════════ -->

            <div class="footer-right">
                <div class="footer-links-grid">

                    <!-- Column 1 – About (unchanged content) -->
                    <div class="footer-column">
                        <h3 class="footer-heading capitalize">About</h3>
                        <ul class="space-y-1">
                            <li><a href="<?= site_url('about') ?>" class="footer-link">About Us</a></li>
                            <li><a href="<?= site_url('about/board') ?>" class="footer-link">Board of Directors</a></li>
                            <li><a href="<?= site_url('about/management') ?>" class="footer-link">Management Team</a>
                            </li>
                            <li><a href="<?= site_url('about/awards') ?>" class="footer-link">Awards</a></li>
                            <li><a href="<?= site_url('about/gallery') ?>" class="footer-link">Gallery</a></li>
                        </ul>
                    </div>

                    <!-- Column 2 – Products (unchanged content) -->
                    <div class="footer-column">
                        <h3 class="footer-heading capitalize">Products</h3>
                        <ul class="space-y-1">
                            <li><a href="<?= site_url('deposits/savings-current') ?>" class="footer-link">Savings
                                    Account</a></li>
                            <li><a href="<?= site_url('deposits/products') ?>" class="footer-link">Fixed Deposit</a>
                            </li>
                            <li><a href="<?= site_url('loans') ?>" class="footer-link">Loans</a></li>
                            <li><a href="<?= site_url('deposits/interest-rates') ?>" class="footer-link">Interest
                                    Rates</a></li>
                            <li><a href="<?= site_url('loans/emi-calculator') ?>" class="footer-link">EMI Calculator</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Column 3 – Services (unchanged content) -->
                    <div class="footer-column">
                        <h3 class="footer-heading capitalize">Services</h3>
                        <ul class="space-y-1">
                            <li><a href="<?= site_url('digital/mobile-banking') ?>" class="footer-link">Mobile
                                    Banking</a></li>
                            <li><a href="<?= site_url('digital/rtgs-neft') ?>" class="footer-link">UPI / RTGS / NEFT</a>
                            </li>
                            <li><a href="<?= site_url('digital/atm') ?>" class="footer-link">ATM Locator</a></li>
                            <li><a href="<?= site_url('services/lockers') ?>" class="footer-link">Lockers</a></li>
                            <li><a href="<?= site_url('services/charges') ?>" class="footer-link">Service Charges</a>
                            </li>
                            <li><a href="<?= site_url('downloads') ?>" class="footer-link">Downloads</a></li>
                        </ul>
                    </div>

                    <!-- Column 4 – Help (unchanged content) -->
                    <div class="footer-column">
                        <h3 class="footer-heading capitalize">Help</h3>
                        <ul class="space-y-1">
                            <li><a href="<?= site_url('contact') ?>" class="footer-link">Contact Us</a></li>
                            <li><a href="<?= site_url('faq') ?>" class="footer-link">FAQs</a></li>
                            <li><a href="<?= site_url('complaints') ?>" class="footer-link">Lodge Complaint</a></li>
                            <li><a href="<?= site_url('complaints/escalation') ?>" class="footer-link">Escalation
                                    Matrix</a></li>
                            <li><a href="<?= site_url('rbi') ?>" class="footer-link">RBI Awareness</a></li>
                        </ul>
                    </div>

                    <!-- Column 5 – Policies (unchanged content) -->
                    <div class="footer-column">
                        <h3 class="footer-heading capitalize">Policies</h3>
                        <ul class="space-y-1">
                            <li><a href="<?= site_url('privacy') ?>" class="footer-link">Privacy Policy</a></li>
                            <li><a href="<?= site_url('accessibility') ?>" class="footer-link">Accessibility</a></li>
                            <li><a href="<?= site_url('rbi/fair-practice') ?>" class="footer-link">Fair Practice
                                    Code</a></li>
                            <li><a href="<?= site_url('sitemap') ?>" class="footer-link">Sitemap</a></li>
                        </ul>
                    </div>

                </div><!-- /.footer-links-grid -->
                <div class="footer-bottom-center">

                    <div class="dicgc-box">
                        <img src="<?= base_url('assets/images/dicgc-logo.png') ?>" alt="DICGC Registered Bank"
                            class="dicgc-logo">
                    </div>

                    <div class="footer-social-group">
                        <?php foreach ($socialLinks as $social): ?>
                            <a href="<?= filter_var(trim($social['url']), FILTER_SANITIZE_URL) ?>" target="_blank"
                                rel="noopener noreferrer external" class="footer-social">
                                <i class="fab fa-<?= strtolower(trim($social['icon'])) ?> text-white"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>

                </div><!-- /.footer-bottom-center -->

            </div><!-- /.footer-right -->

        </div><!-- /.footer-wrapper -->
    </div><!-- /.container-bank.py-4 -->


    <!-- ── Bottom copyright bar (unchanged) ── -->
    <div class="border-t footer-divider">
        <div class="container-bank py-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-3 text-xs"
                style="color: rgba(255,255,255,0.5);">
                <p>© <?= date('Y') ?>
                    <?= esc($siteSettings['copyright_text'] ?? 'The Jalgaon Peoples Co-Op. Bank Ltd. All rights reserved.') ?>
                </p>
                <div class="flex items-center gap-3">
                    <a href="<?= esc($siteSettings['rbi_guidelines_link'] ?? 'https://rbi.org.in') ?>" target="_blank"
                        rel="noopener" class="transition-colors flex items-center gap-1"
                        onmouseover="this.style.color='rgba(255,255,255,1)'"
                        onmouseout="this.style.color='rgba(255,255,255,0.5)'">
                        <?= esc($siteSettings['rbi_guidelines_text'] ?? 'RBI Guidelines') ?>
                        <i data-lucide="external-link" class="w-3 h-3" aria-hidden="true"></i>
                    </a>
                    <span>|</span>
                    <span><?= esc($siteSettings['bank_type_text'] ?? 'Multi-State Scheduled Co-operative Bank') ?></span>
                </div>
            </div>
        </div>
    </div>

    <a href="#top" class="scroll-top-btn" aria-label="Back to top">
        <i data-lucide="arrow-up"></i>
    </a>

</footer>

<style>
    /* ─────────────────────────────────────────────────────────────
   ALL EXISTING STYLES (colors, typography, links, social,
   DICGC, dividers, logo filter) ARE KEPT 100% UNCHANGED.
   Only the two new layout classes below are additions.
───────────────────────────────────────────────────────────────

   STRUCTURAL CHANGE – .footer-wrapper
   Replaces: <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
   Reason:   The old single grid forced the left block and ALL link
             sub-grids to share the same 4-column grid, which meant
             the columns spanning col-span-2 / col-span-3 gave the
             left area disproportionate room and the link columns
             had to nest inside each other.
   New role: A simple flex row that separates the left brand block
             from the right link grid.  On mobile it stacks (column).
─────────────────────────────────────────────────────────────── */

    .scroll-top-btn {
        position: fixed;
        right: 20px;
        bottom: 90px;

        width: 48px;
        height: 48px;

        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;

        background: #16a34a;
        color: #fff;

        z-index: 999;
        text-decoration: none;

        box-shadow: 0 8px 25px rgba(0, 0, 0, .25);

        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);

        transition: all .3s ease;
    }

    .scroll-top-btn.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .footer-wrapper {
        display: flex;
        flex-direction: column;
        /* mobile: stacked */
        gap: 2rem;
        align-items: flex-start;
    }

    @media (min-width: 1024px) {
        .footer-wrapper {
            flex-direction: row;
            /* desktop: side-by-side */
            gap: 4rem;
            align-items: flex-start;
        }
    }

    .footer-left .flex.items-center {
        min-height: auto !important;
        padding: 0 !important;
        margin: 0 !important;
        line-height: 1.8;
    }


    /* ─────────────────────────────────────────────────────────────
   STRUCTURAL CHANGE – .footer-left
   Replaces: <div class="col-span-2 md:col-span-3 lg:col-span-2">
   Reason:   col-span-* only worked relative to the old 4-col grid.
             Now it's a plain flex child with a fixed min-width on
             desktop so it never collapses below the logo width.
─────────────────────────────────────────────────────────────── */
    .footer-left {
        flex-shrink: 0;
        width: 100%;
    }

    @media (min-width: 1024px) {
        .footer-left {
            width: 240px;
            /* fixed width; enough for contact lines */
        }
    }

    .footer-left .space-y-1 {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .footer-left .flex-col.gap-1 {
        gap: 2px !important;
    }

    .footer-left .space-y-1>div {
        margin: 0 !important;
    }

    .footer-address {
        white-space: nowrap;
        font-size: 13px;
    }

    .footer-left .flex {
        margin-bottom: 2px;
    }

    /* ─────────────────────────────────────────────────────────────
   STRUCTURAL CHANGE – .footer-links-grid
   Replaces: THREE separate <div class="grid grid-cols-2 gap-8">
             blocks (About+Products / Services+Help / Policies)
   Reason:   The old three-grid approach caused About to float away
             from the other columns and produced uneven spacing
             because each grid had its own independent sizing.
   New role: ONE flat CSS grid with 5 equal columns on desktop.
             All five .footer-column children are direct siblings —
             no nesting, no orphans.
─────────────────────────────────────────────────────────────── */
    .footer-links-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        /* mobile: 2 columns */
        gap: 2rem;
        flex: 1;
        /* fill remaining row space */
        width: 100%;
    }

    @media (min-width: 640px) {
        .footer-links-grid {
            grid-template-columns: repeat(3, 1fr);
            /* tablet: 3 columns */
        }
    }

    @media (min-width: 1024px) {
        .footer-links-grid {
            grid-template-columns: repeat(5, 1fr);
            /* desktop: 5 equal columns */
            gap: 1.25rem;
        }
    }

    .footer-right {
        position: relative;
    }

    .footer-social-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .footer-bottom-center {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        width: 100%;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    @media (max-width: 768px) {
        .footer-bottom-center {
            flex-direction: column;
        }
    }


    .dark .footer-bottom-center {
        border-top-color: hsl(var(--border));
    }

    /* ─────────────────────────────────────────────────────────────
   .footer-column
   Simple wrapper for each link group; no structural role beyond
   grouping heading + list.  Margin/padding intentionally zero —
   the parent grid gap handles all spacing.
─────────────────────────────────────────────────────────────── */
    .footer-column {
        display: flex;
        flex-direction: column;
    }

    .footer-column ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .footer-column li {
        margin-bottom: 4px;
    }

    /* ─────────────────────────────────────────────────────────────
   ALL ORIGINAL STYLES BELOW — ZERO CHANGES
─────────────────────────────────────────────────────────────── */
    .footer-bank {
        background: hsl(var(--foreground));
        color: hsl(var(--background));
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        transition:
            background-color 0.3s ease,
            color 0.3s ease,
            border-color 0.3s ease;
    }

    .dark .footer-bank {
        background: #0f172a;
        color: hsl(var(--foreground));
        border-top: 1px solid hsl(var(--border));
    }

    @media (min-width: 1024px) {
        .footer-bank .footer-links-grid {
            align-items: flex-start;
        }

        .footer-bank ul {
            margin: 0;
        }

        .footer-bank li {
            margin-bottom: 4px;
        }
    }

    .footer-link {
        display: block;
        padding: 4px 0;
        line-height: 1.4;
        min-height: auto;
        font-size: 14px;
    }

    .footer-link:hover {
        color: white;
    }

    .dark .footer-link {
        color: hsl(var(--muted-foreground));
    }

    .dark .footer-link:hover {
        color: hsl(var(--foreground));
    }

    .footer-muted {
        color: rgba(255, 255, 255, 0.72);
    }

    .dark .footer-muted {
        color: hsl(var(--muted-foreground));
    }

    .footer-social {
        width: 34px;
        height: 34px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.08);
        color: white;
        transition:
            background-color 0.25s ease,
            color 0.25s ease,
            transform 0.25s ease;
    }

    .footer-social:hover {
        background: hsl(var(--primary));
        color: white;
    }

    .dark .footer-social {
        background: rgba(255, 255, 255, 0.06);
        color: hsl(var(--foreground));
    }

    .dicgc-box {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 8px 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .dark .dicgc-box {
        background: hsl(var(--card));
        border: 1px solid hsl(var(--border));
    }

    .dicgc-logo {
        max-height: 38px;
        width: auto;
        object-fit: contain;
    }

    .footer-divider {
        border-color: rgba(255, 255, 255, 0.08);
    }

    .dark .footer-divider {
        border-color: hsl(var(--border));
    }

    .footer-heading {
        color: white;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .dark .footer-heading {
        color: hsl(var(--foreground));
    }

    .footer-small {
        color: rgba(255, 255, 255, 0.6);
        font-size: 13px;
    }

    .dark .footer-small {
        color: hsl(var(--muted-foreground));
    }

    .footer-bank img.footer-logo {
        filter: brightness(0) invert(1);
    }

    .dark .footer-bank img.footer-logo {
        filter: none;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const footer = document.querySelector("footer");
        const scrollBtn = document.querySelector(".scroll-top-btn");

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        scrollBtn.classList.add("show");
                    } else {
                        scrollBtn.classList.remove("show");
                    }
                });
            },
            {
                threshold: 0.2
            }
        );

        observer.observe(footer);

    });
</script>
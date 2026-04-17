<div class="bg-primary text-primary-foreground" role="toolbar" aria-label="Accessibility options" style="background-color: hsl(var(--primary)); color: hsl(var(--primary-foreground));">
  <div class="container-bank">

    <!-- Compact Bar -->
    <div class="flex items-center justify-between py-1.5">
      <div class="flex items-center gap-1">
        <span class="text-xs font-medium mr-1 hidden sm:inline opacity-80">Text Size:</span>

        <button id="btn-text-minus" class="a11y-btn" aria-label="Decrease text size" title="A-">
          <i data-lucide="minus" class="w-3.5 h-3.5"></i>
          <span class="hidden sm:inline text-xs">A-</span>
        </button>

        <span id="a11y-scale-display" class="text-xs min-w-[2.5rem] text-center opacity-80">100%</span>

        <button id="btn-text-plus" class="a11y-btn" aria-label="Increase text size" title="A+">
          <i data-lucide="plus" class="w-3.5 h-3.5"></i>
          <span class="hidden sm:inline text-xs">A+</span>
        </button>

        <button id="btn-text-reset" class="a11y-btn" aria-label="Reset text size" title="Reset">
          <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
        </button>

        <span class="mx-1 opacity-30 hidden md:inline">|</span>

        <button id="btn-dark" class="a11y-btn" aria-label="Dark mode" aria-pressed="false" title="Dark mode">
          <i data-lucide="moon" class="w-3.5 h-3.5"></i>
          <span id="dark-label" class="hidden md:inline text-xs">Dark</span>
        </button>

        <button id="btn-contrast" class="a11y-btn" aria-label="High contrast" aria-pressed="false" title="High contrast">
          <i data-lucide="contrast" class="w-3.5 h-3.5"></i>
          <span class="hidden lg:inline text-xs">Contrast</span>
        </button>
      </div>

      <div class="flex items-center gap-1">
        <!-- Language selector -->
        <div class="flex items-center gap-0.5 mr-1">
          <i data-lucide="globe" class="w-3.5 h-3.5 opacity-70" aria-hidden="true"></i>
          <button data-lang="en" class="a11y-lang-btn a11y-lang-active" aria-label="Switch to English">EN</button>
          <button data-lang="hi" class="a11y-lang-btn" aria-label="Switch to Hindi">हि</button>
          <button data-lang="mr" class="a11y-lang-btn" aria-label="Switch to Marathi">मरा</button>
        </div>

        <button id="btn-more" class="a11y-btn" aria-label="More accessibility options" aria-expanded="false" title="More options">
          <i data-lucide="settings" class="w-3.5 h-3.5"></i>
          <span class="hidden sm:inline text-xs">More</span>
        </button>
      </div>
    </div>

    <!-- Expanded Panel (hidden by default) -->
    <div id="a11y-expanded" class="hidden pb-3 pt-1 border-t animate-fade-in" style="border-color: rgba(255,255,255,0.2);">
      <div class="flex flex-wrap items-center gap-1.5">

        <button id="btn-grayscale" class="a11y-btn" aria-label="Grayscale mode" aria-pressed="false" title="Grayscale">
          <i data-lucide="eye" class="w-3.5 h-3.5"></i><span class="text-xs">Grayscale</span>
        </button>

        <button id="btn-reader" class="a11y-btn" aria-label="Reader mode" aria-pressed="false" title="Reader mode">
          <i data-lucide="book-open" class="w-3.5 h-3.5"></i><span class="text-xs">Reader</span>
        </button>

        <button id="btn-links" class="a11y-btn" aria-label="Highlight links" aria-pressed="false" title="Highlight links">
          <i data-lucide="link-2" class="w-3.5 h-3.5"></i><span class="text-xs">Links</span>
        </button>

        <button id="btn-headings" class="a11y-btn" aria-label="Highlight headings" aria-pressed="false" title="Highlight headings">
          <i data-lucide="heading" class="w-3.5 h-3.5"></i><span class="text-xs">Headings</span>
        </button>

        <button id="btn-spacing" class="a11y-btn" aria-label="Text spacing" aria-pressed="false" title="Text spacing">
          <i data-lucide="align-justify" class="w-3.5 h-3.5"></i><span class="text-xs">Spacing</span>
        </button>

        <button id="btn-focus" class="a11y-btn" aria-label="Focus reading strip" aria-pressed="false" title="Focus reading strip">
          <i data-lucide="scan-line" class="w-3.5 h-3.5"></i><span class="text-xs">Focus Strip</span>
        </button>

        <button id="btn-motion" class="a11y-btn" aria-label="Pause animations" aria-pressed="false" title="Pause animations">
          <i data-lucide="pause" class="w-3.5 h-3.5"></i><span class="text-xs">Motion</span>
        </button>

        <button id="btn-read" class="a11y-btn" aria-label="Read aloud" aria-pressed="false" title="Read aloud">
          <i data-lucide="volume-2" class="w-3.5 h-3.5"></i><span class="text-xs">Read</span>
        </button>

        <span class="mx-1 opacity-30">|</span>

        <button id="btn-reset-all" class="tap-target px-3 py-1.5 rounded-md text-xs font-medium transition-colors"
          style="background-color: rgba(255,255,255,0.1);"
          onmouseover="this.style.backgroundColor='rgba(255,255,255,0.2)'"
          onmouseout="this.style.backgroundColor='rgba(255,255,255,0.1)'"
          aria-label="Reset all accessibility settings">
          Reset All
        </button>

      </div>
    </div>
  </div>
</div>

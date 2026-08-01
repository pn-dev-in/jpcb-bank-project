/**
 * JPCB Website – Main JavaScript
 * Handles: Accessibility toolbar, navigation, focus strip, search.
 * No external dependencies beyond Lucide (loaded separately).
 */

'use strict';

/* =============================================================
   ACCESSIBILITY TOOLBAR
   ============================================================= */
const A11y = {
  state: {
    textScale:        100,
    darkMode:         false,
    highContrast:     false,
    grayscale:        false,
    readerMode:       false,
    highlightLinks:   false,
    highlightHeadings: false,
    textSpacing:      false,
    focusStrip:       false,
    pauseMotion:      false,
    language:         'en',
  },

  speaking: false,

  /* Load saved preferences and apply them */
  init() {
    try {
      const saved = localStorage.getItem('jpcb_a11y');
      if (saved) {
        const parsed = JSON.parse(saved);
        // Only copy known keys to prevent prototype pollution
        const known = Object.keys(this.state);
        for (const key of known) {
          if (Object.prototype.hasOwnProperty.call(parsed, key)) {
            this.state[key] = parsed[key];
          }
        }
      }
    } catch (_) { /* ignore storage errors */ }

    const pageLang = document.documentElement.getAttribute('lang');
    if (['en', 'hi', 'mr'].includes(pageLang)) {
      this.state.language = pageLang;
    }

    this.applyAll();
    this.bindUI();
  },

  /* Persist state to localStorage */
  save() {
    try {
      localStorage.setItem('jpcb_a11y', JSON.stringify(this.state));
    } catch (_) { /* ignore quota errors */ }
  },

  /* Apply all state to the DOM */
  applyAll() {
    const html = document.documentElement;

    // Text scale: remove old class, add new one
    html.className = html.className.replace(/\btext-scale-\d+\b/g, '').trim();
    html.classList.add('text-scale-' + this.state.textScale);

    // Boolean toggles → CSS classes
    html.classList.toggle('dark',              this.state.darkMode);
    html.classList.toggle('high-contrast',     this.state.highContrast);
    html.classList.toggle('grayscale-mode',    this.state.grayscale);
    html.classList.toggle('reader-mode',       this.state.readerMode);
    html.classList.toggle('highlight-links',   this.state.highlightLinks);
    html.classList.toggle('highlight-headings', this.state.highlightHeadings);
    html.classList.toggle('text-spacing',      this.state.textSpacing);
    html.classList.toggle('focus-strip-active', this.state.focusStrip);
    html.classList.toggle('pause-motion',      this.state.pauseMotion);

    this.updateUI();
  },

  /* Sync UI buttons with current state */
  updateUI() {
    const scaleEl = document.getElementById('a11y-scale-display');
    if (scaleEl) scaleEl.textContent = this.state.textScale + '%';

    // Dark mode: toggle icon between moon and sun
    const darkIcon = document.querySelector('#btn-dark [data-lucide]');
    if (darkIcon) {
      darkIcon.setAttribute('data-lucide', this.state.darkMode ? 'sun' : 'moon');
      if (window.lucide) lucide.createIcons({ nodes: [darkIcon] });
    }

    // Motion: toggle icon between pause and play
    const motionIcon = document.querySelector('#btn-motion [data-lucide]');
    if (motionIcon) {
      motionIcon.setAttribute('data-lucide', this.state.pauseMotion ? 'play' : 'pause');
      if (window.lucide) lucide.createIcons({ nodes: [motionIcon] });
    }

    // Read aloud: toggle icon between volume-2 and volume-x
    const readIcon = document.querySelector('#btn-read [data-lucide]');
    if (readIcon) {
      readIcon.setAttribute('data-lucide', this.speaking ? 'volume-x' : 'volume-2');
      if (window.lucide) lucide.createIcons({ nodes: [readIcon] });
    }

    // Toggle button active states
    const toggleMap = {
      'btn-dark':      'darkMode',
      'btn-contrast':  'highContrast',
      'btn-grayscale': 'grayscale',
      'btn-reader':    'readerMode',
      'btn-links':     'highlightLinks',
      'btn-headings':  'highlightHeadings',
      'btn-spacing':   'textSpacing',
      'btn-focus':     'focusStrip',
      'btn-motion':    'pauseMotion',
      'btn-read':      null, // handled via this.speaking
    };
    for (const [id, key] of Object.entries(toggleMap)) {
      const btn = document.getElementById(id);
      if (!btn) continue;
      const active = key ? this.state[key] : this.speaking;
      btn.classList.toggle('a11y-btn-active', active);
      btn.setAttribute('aria-pressed', active ? 'true' : 'false');
    }

    // Language buttons
    document.querySelectorAll('[data-lang]').forEach(btn => {
      btn.classList.toggle('a11y-lang-active', btn.dataset.lang === this.state.language);
    });
  },

  increaseText() {
    if (this.state.textScale < 150) {
      this.state.textScale += 10;
      this.applyAll();
      this.save();
    }
  },

  decreaseText() {
    if (this.state.textScale > 80) {
      this.state.textScale -= 10;
      this.applyAll();
      this.save();
    }
  },

  resetText() {
    this.state.textScale = 100;
    this.applyAll();
    this.save();
  },

  toggle(key) {
    this.state[key] = !this.state[key];
    this.applyAll();
    this.save();
  },

  setLanguage(lang) {
    const allowed = ['en', 'hi', 'mr'];
    if (!allowed.includes(lang)) return;
    this.state.language = lang;
    this.updateUI();
    this.save();
    document.cookie = `site_language=${lang}; path=/; max-age=31536000; SameSite=Lax`;
    const target = document.querySelector(`[data-lang="${lang}"]`)?.dataset.langUrl;
    window.location.href = target || `${window.location.pathname}?lang=${lang}`;
  },

  resetAll() {
    this.state = {
      textScale: 100, darkMode: false, highContrast: false,
      grayscale: false, readerMode: false, highlightLinks: false,
      highlightHeadings: false, textSpacing: false, focusStrip: false,
      pauseMotion: false, language: 'en',
    };
    if (this.speaking) {
      window.speechSynthesis && window.speechSynthesis.cancel();
      this.speaking = false;
    }
    this.applyAll();
    this.save();
  },

  toggleReadAloud() {
    if (this.speaking) {
      window.speechSynthesis && window.speechSynthesis.cancel();
      this.speaking = false;
      this.updateUI();
    } else {
      if (!('speechSynthesis' in window)) return;
      const main = document.querySelector('main');
      if (!main) return;
      const text = (main.textContent || '').substring(0, 500).trim();
      const utter = new SpeechSynthesisUtterance(text);
      const langMap = { en: 'en-IN', hi: 'hi-IN', mr: 'mr-IN' };
      utter.lang = langMap[this.state.language] || 'en-IN';
      utter.onend = () => {
        this.speaking = false;
        this.updateUI();
      };
      window.speechSynthesis.speak(utter);
      this.speaking = true;
      this.updateUI();
    }
  },

  bindUI() {
    const bind = (id, fn) => document.getElementById(id)?.addEventListener('click', fn);

    bind('btn-text-minus', () => this.decreaseText());
    bind('btn-text-plus',  () => this.increaseText());
    bind('btn-text-reset', () => this.resetText());
    bind('btn-dark',       () => this.toggle('darkMode'));
    bind('btn-contrast',   () => this.toggle('highContrast'));
    bind('btn-grayscale',  () => this.toggle('grayscale'));
    bind('btn-reader',     () => this.toggle('readerMode'));
    bind('btn-links',      () => this.toggle('highlightLinks'));
    bind('btn-headings',   () => this.toggle('highlightHeadings'));
    bind('btn-spacing',    () => this.toggle('textSpacing'));
    bind('btn-focus',      () => this.toggle('focusStrip'));
    bind('btn-motion',     () => this.toggle('pauseMotion'));
    bind('btn-reset-all',  () => this.resetAll());
    bind('btn-read',       () => this.toggleReadAloud());

    // More / Close panel toggle
    const moreBtn   = document.getElementById('btn-more');
    const morePanel = document.getElementById('a11y-expanded');
    if (moreBtn && morePanel) {
      moreBtn.addEventListener('click', () => {
        const isOpen = !morePanel.classList.contains('hidden');
        morePanel.classList.toggle('hidden');
        moreBtn.setAttribute('aria-expanded', (!isOpen).toString());
        const icon = moreBtn.querySelector('[data-lucide]');
        if (icon) {
          icon.setAttribute('data-lucide', isOpen ? 'settings' : 'x');
          if (window.lucide) lucide.createIcons({ nodes: [icon] });
        }
        const label = moreBtn.querySelector('span');
        if (label) label.textContent = isOpen ? (label.dataset.moreText || 'More') : (label.dataset.closeText || 'Close');
      });
    }

    // Language buttons
    document.querySelectorAll('[data-lang]').forEach(btn => {
      btn.addEventListener('click', () => this.setLanguage(btn.dataset.lang));
    });
  },
};

/* =============================================================
   FOCUS READING STRIP
   ============================================================= */
const FocusStrip = {
  el: null,
  init() {
    this.el = document.getElementById('focus-strip');
    if (!this.el) return;
    document.addEventListener('mousemove', (e) => {
      if (!document.documentElement.classList.contains('focus-strip-active')) {
        if (this.el) this.el.style.display = 'none';
        return;
      }
      this.el.style.display = 'block';
      this.el.style.top = (e.clientY - 40) + 'px';
    });
  },
};

/* =============================================================
   NAVIGATION (mega menu + mobile)
   ============================================================= */
const Navigation = {
  menuTimer:   null,
  mobileOpen:  false,
  searchOpen:  false,

  init() {
    this.bindDesktopMenu();
    this.bindMobileMenu();
    this.bindSearch();
  },

  /* Desktop mega menus */
  bindDesktopMenu() {
    const items     = document.querySelectorAll('[data-mega-menu]');
    const dropdowns = document.querySelectorAll('[data-dropdown]');

    items.forEach(item => {
      item.addEventListener('mouseenter', () => {
        clearTimeout(this.menuTimer);
        const id = item.dataset.megaMenu;
        dropdowns.forEach(d => d.classList.add('hidden'));
        const dropdown = document.querySelector('[data-dropdown="' + id + '"]');
        if (dropdown) dropdown.classList.remove('hidden');
        // Mark active link
        items.forEach(i => i.querySelector('a')?.classList.remove('text-primary', 'bg-muted'));
        item.querySelector('a')?.classList.add('text-primary');
      });
      item.addEventListener('mouseleave', () => {
        this.menuTimer = setTimeout(() => {
          dropdowns.forEach(d => d.classList.add('hidden'));
          items.forEach(i => i.querySelector('a')?.classList.remove('text-primary', 'bg-muted'));
        }, 200);
      });
    });

    dropdowns.forEach(d => {
      d.addEventListener('mouseenter', () => clearTimeout(this.menuTimer));
      d.addEventListener('mouseleave', () => {
        this.menuTimer = setTimeout(() => {
          dropdowns.forEach(x => x.classList.add('hidden'));
          items.forEach(i => i.querySelector('a')?.classList.remove('text-primary', 'bg-muted'));
        }, 200);
      });
    });

    // Close dropdown on ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        dropdowns.forEach(d => d.classList.add('hidden'));
        items.forEach(i => i.querySelector('a')?.classList.remove('text-primary', 'bg-muted'));
      }
    });
  },

  /* Mobile hamburger menu */
  bindMobileMenu() {
    const btn  = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const icon = document.getElementById('mobile-menu-icon');

    btn?.addEventListener('click', () => {
      this.mobileOpen = !this.mobileOpen;
      menu?.classList.toggle('hidden', !this.mobileOpen);
      btn.setAttribute('aria-expanded', this.mobileOpen.toString());
      if (icon) {
        icon.setAttribute('data-lucide', this.mobileOpen ? 'x' : 'menu');
        if (window.lucide) lucide.createIcons({ nodes: [icon] });
      }
    });

    // Mobile submenu accordions
    document.querySelectorAll('[data-mobile-submenu-btn]').forEach(submenuBtn => {
      submenuBtn.addEventListener('click', () => {
        const target  = submenuBtn.dataset.mobileSubmenuBtn;
        const submenu = document.getElementById('mobile-sub-' + target);
        const chevron = submenuBtn.querySelector('[data-lucide="chevron-down"]');
        const isOpen  = submenu && !submenu.classList.contains('hidden');

        // Close all submenus first
        document.querySelectorAll('[data-mobile-sub]').forEach(s => s.classList.add('hidden'));
        document.querySelectorAll('[data-mobile-submenu-btn]').forEach(b => {
          b.setAttribute('aria-expanded', 'false');
          b.querySelector('[data-lucide]')?.classList.remove('rotate-180');
        });

        if (!isOpen && submenu) {
          submenu.classList.remove('hidden');
          submenuBtn.setAttribute('aria-expanded', 'true');
          chevron?.classList.add('rotate-180');
        }
      });
    });

    // Close mobile menu when a link is clicked
    document.querySelectorAll('#mobile-menu a').forEach(a => {
      a.addEventListener('click', () => {
        this.mobileOpen = false;
        menu?.classList.add('hidden');
        if (icon) {
          icon.setAttribute('data-lucide', 'menu');
          if (window.lucide) lucide.createIcons({ nodes: [icon] });
        }
        btn?.setAttribute('aria-expanded', 'false');
      });
    });
  },

  /* Header search toggle */
  bindSearch() {
    const btn   = document.getElementById('search-btn');
    const bar   = document.getElementById('search-bar');
    const input = document.getElementById('global-search');

    btn?.addEventListener('click', () => {
      this.searchOpen = !this.searchOpen;
      bar?.classList.toggle('hidden', !this.searchOpen);
      if (this.searchOpen) input?.focus();
    });
  },
};

/* =============================================================
   INIT
   ============================================================= */
document.addEventListener('DOMContentLoaded', () => {
  // Render Lucide icons
  if (window.lucide) {
    lucide.createIcons();
  }

  A11y.init();
  FocusStrip.init();
  Navigation.init();
});

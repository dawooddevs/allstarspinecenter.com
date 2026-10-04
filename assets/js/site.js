/* All Star Health — site interactions (no dependencies) */
(function () {
  'use strict';

  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var desktop = window.matchMedia('(min-width: 1100px)');

  /* ---------- Sticky header + mobile action bar ---------- */
  var header = $('[data-header]');
  var mbar = $('.mbar');
  var ticking = false;
  function onScroll() {
    var y = window.scrollY || window.pageYOffset;
    if (header) header.classList.toggle('is-scrolled', y > 12);
    if (mbar) mbar.classList.toggle('is-visible', y > 320);
    updateSteps();
    ticking = false;
  }
  window.addEventListener('scroll', function () {
    if (!ticking) { window.requestAnimationFrame(onScroll); ticking = true; }
  }, { passive: true });

  /* ---------- Desktop navigation (hover + click + keyboard) ---------- */
  var navItems = $$('.nav__item.has-drop, .nav__item.has-mega');
  var closeTimer = null;
  function closeAll(except) {
    navItems.forEach(function (li) {
      if (li !== except) {
        li.classList.remove('is-open');
        var b = $('.nav__link', li);
        if (b) b.setAttribute('aria-expanded', 'false');
      }
    });
  }
  function openItem(li) {
    clearTimeout(closeTimer);
    closeAll(li);
    li.classList.add('is-open');
    $('.nav__link', li).setAttribute('aria-expanded', 'true');
  }
  navItems.forEach(function (li) {
    var btn = $('.nav__link', li);
    btn.addEventListener('click', function () {
      if (li.classList.contains('is-open')) { closeAll(); } else { openItem(li); }
    });
    li.addEventListener('mouseenter', function () { if (desktop.matches) openItem(li); });
    li.addEventListener('mouseleave', function () {
      if (!desktop.matches) return;
      clearTimeout(closeTimer);
      closeTimer = setTimeout(function () { li.classList.remove('is-open'); btn.setAttribute('aria-expanded', 'false'); }, 180);
    });
    li.addEventListener('focusout', function (e) {
      if (!li.contains(e.relatedTarget)) { li.classList.remove('is-open'); btn.setAttribute('aria-expanded', 'false'); }
    });
    li.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { closeAll(); btn.focus(); }
      if (e.key === 'ArrowDown' && document.activeElement === btn) {
        e.preventDefault();
        openItem(li);
        var first = $('.dropdown a, .mega a', li);
        if (first) first.focus();
      }
    });
  });
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.nav__item')) closeAll();
  });

  /* ---------- Mobile navigation ---------- */
  var mnav = $('[data-mnav]');
  var openBtn = $('[data-menu-open]');
  var lastFocus = null;
  function openMenu() {
    if (!mnav) return;
    lastFocus = document.activeElement;
    mnav.hidden = false;
    document.body.classList.add('menu-open');
    requestAnimationFrame(function () { requestAnimationFrame(function () { mnav.classList.add('is-open'); }); });
    openBtn.setAttribute('aria-expanded', 'true');
    setTimeout(function () { var c = $('.mnav__close', mnav); if (c) c.focus(); }, 60);
  }
  function closeMenu() {
    if (!mnav || mnav.hidden) return;
    mnav.classList.remove('is-open');
    document.body.classList.remove('menu-open');
    openBtn.setAttribute('aria-expanded', 'false');
    setTimeout(function () { mnav.hidden = true; }, reduced ? 0 : 450);
    if (lastFocus) lastFocus.focus();
  }
  if (openBtn) openBtn.addEventListener('click', openMenu);
  $$('[data-menu-close]').forEach(function (el) { el.addEventListener('click', closeMenu); });
  if (mnav) {
    mnav.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeMenu();
      if (e.key === 'Tab') {
        var f = $$('a[href], button:not([disabled])', mnav).filter(function (el) { return el.offsetParent !== null; });
        if (!f.length) return;
        if (e.shiftKey && document.activeElement === f[0]) { e.preventDefault(); f[f.length - 1].focus(); }
        else if (!e.shiftKey && document.activeElement === f[f.length - 1]) { e.preventDefault(); f[0].focus(); }
      }
    });
    $$('a', mnav).forEach(function (a) { a.addEventListener('click', function () { if (a.hash && a.pathname === location.pathname) closeMenu(); }); });
    $$('.mnav__toggle', mnav).forEach(function (btn) {
      btn.addEventListener('click', function () {
        var sub = btn.nextElementSibling;
        var open = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', open ? 'false' : 'true');
        slide(sub, !open);
      });
    });
  }
  desktop.addEventListener && desktop.addEventListener('change', function (m) { if (m.matches) closeMenu(); });

  /* Smooth height open/close */
  function slide(el, open) {
    if (!el) return;
    if (reduced) { el.hidden = !open; return; }
    if (open) {
      el.hidden = false;
      var h = el.scrollHeight;
      el.style.height = '0px';
      el.style.overflow = 'hidden';
      el.style.transition = 'height .38s cubic-bezier(.2,.7,.2,1)';
      requestAnimationFrame(function () { el.style.height = h + 'px'; });
      el.addEventListener('transitionend', function done() { el.style.height = ''; el.style.overflow = ''; el.style.transition = ''; el.removeEventListener('transitionend', done); });
    } else {
      el.style.height = el.scrollHeight + 'px';
      el.style.overflow = 'hidden';
      el.style.transition = 'height .32s cubic-bezier(.2,.7,.2,1)';
      requestAnimationFrame(function () { el.style.height = '0px'; });
      el.addEventListener('transitionend', function done() { el.hidden = true; el.style.height = ''; el.style.overflow = ''; el.style.transition = ''; el.removeEventListener('transitionend', done); });
    }
  }

  /* ---------- FAQ accordions ---------- */
  $$('[data-accordion]').forEach(function (acc) {
    $$('.faq__q button', acc).forEach(function (btn) {
      btn.addEventListener('click', function () {
        var item = btn.closest('.faq__item');
        var panel = document.getElementById(btn.getAttribute('aria-controls'));
        var open = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', open ? 'false' : 'true');
        item.classList.toggle('is-open', !open);
        slide(panel, !open);
      });
    });
  });

  /* ---------- Scroll reveal ---------- */
  var revealEls = $$('[data-reveal]');
  if ('IntersectionObserver' in window && !reduced) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-in'); });
  }

  /* ---------- Count-up statistics ---------- */
  var counters = $$('[data-count]');
  function countUp(el) {
    var target = parseInt(el.getAttribute('data-count'), 10) || 0;
    if (reduced || target < 3) { el.textContent = target; return; }
    var start = null, dur = 1600;
    el.textContent = '0';
    function step(ts) {
      if (!start) start = ts;
      var p = Math.min(1, (ts - start) / dur);
      var eased = 1 - Math.pow(1 - p, 4);
      el.textContent = Math.round(target * eased);
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }
  if ('IntersectionObserver' in window) {
    var co = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { countUp(en.target); co.unobserve(en.target); } });
    }, { threshold: 0.6 });
    counters.forEach(function (el) { co.observe(el); });
  }

  /* ---------- Card filtering helper ---------- */
  function animateIn(cards) {
    cards.forEach(function (c, i) {
      c.classList.remove('is-entering');
      void c.offsetWidth;
      c.style.setProperty('--n', Math.min(i, 12));
      c.classList.add('is-entering');
    });
  }

  /* Homepage treatment explorer */
  var exTabs = $('[data-explorer-tabs]');
  var exGrid = $('[data-explorer-grid]');
  if (exTabs && exGrid) {
    var exCards = $$('.tcard', exGrid);
    function exFilter(f) {
      var shown = [];
      exCards.forEach(function (c) {
        var show = f === 'featured' ? c.classList.contains('is-featured') : c.getAttribute('data-cat') === f;
        c.classList.toggle('is-hidden', !show);
        if (show) shown.push(c);
      });
      animateIn(shown);
    }
    $$('.tab', exTabs).forEach(function (t) {
      t.addEventListener('click', function () {
        $$('.tab', exTabs).forEach(function (o) { o.classList.remove('is-active'); o.setAttribute('aria-selected', 'false'); });
        t.classList.add('is-active');
        t.setAttribute('aria-selected', 'true');
        exFilter(t.getAttribute('data-filter'));
      });
    });
    exFilter('featured');
  }

  /* Treatments index: search + category filters */
  var tIndex = $('[data-tindex]');
  if (tIndex) {
    var tGrid = $('[data-tgrid]', tIndex);
    var tCards = $$('.tcard', tGrid);
    var tSearch = $('[data-tsearch]', tIndex);
    var tCount = $('[data-tcount]', tIndex);
    var tEmpty = $('[data-tempty]', tIndex);
    var params = new URLSearchParams(location.search);
    var cat = tGrid.getAttribute('data-initial') || 'all';
    if (params.get('q')) tSearch.value = params.get('q');
    function tApply(animate) {
      var q = tSearch.value.trim().toLowerCase();
      var shown = [];
      tCards.forEach(function (c) {
        var okCat = cat === 'all' || c.getAttribute('data-cat') === cat;
        var okQ = !q || q.split(/\s+/).every(function (w) { return c.getAttribute('data-search').indexOf(w) > -1; });
        var show = okCat && okQ;
        c.classList.toggle('is-hidden', !show);
        if (show) shown.push(c);
      });
      tEmpty.hidden = shown.length > 0;
      tCount.textContent = shown.length + (shown.length === 1 ? ' treatment' : ' treatments') + (q ? ' matching “' + tSearch.value.trim() + '”' : '');
      if (animate) animateIn(shown);
    }
    $$('.tab', tIndex).forEach(function (t) {
      t.addEventListener('click', function () {
        cat = t.getAttribute('data-filter');
        $$('.tab', tIndex).forEach(function (o) { o.classList.toggle('is-active', o === t); o.setAttribute('aria-pressed', o === t ? 'true' : 'false'); });
        var url = new URL(location.href);
        if (cat === 'all') url.searchParams.delete('category'); else url.searchParams.set('category', cat);
        history.replaceState(null, '', url);
        tApply(true);
      });
    });
    var deb;
    tSearch.addEventListener('input', function () { clearTimeout(deb); deb = setTimeout(function () { tApply(true); }, 120); });
    tApply(false);
  }

  /* Provider directory */
  var pIndex = $('[data-pindex]');
  if (pIndex) {
    var pCards = $$('.pcard', pIndex);
    var pSearch = $('[data-psearch]', pIndex);
    var pType = 'all';
    function pApply() {
      var q = (pSearch.value || '').trim().toLowerCase();
      var shown = [];
      pCards.forEach(function (c) {
        var show = (pType === 'all' || c.getAttribute('data-type') === pType) && (!q || c.getAttribute('data-search').indexOf(q) > -1);
        c.classList.toggle('is-hidden', !show);
        if (show) shown.push(c);
      });
      $('[data-pempty]', pIndex).hidden = shown.length > 0;
      animateIn(shown);
    }
    $$('.tab', pIndex).forEach(function (t) {
      t.addEventListener('click', function () {
        pType = t.getAttribute('data-filter');
        $$('.tab', pIndex).forEach(function (o) { o.classList.toggle('is-active', o === t); o.setAttribute('aria-pressed', o === t ? 'true' : 'false'); });
        pApply();
      });
    });
    pSearch.addEventListener('input', pApply);
  }

  /* ---------- Where does it hurt? ---------- */
  var bm = $('[data-bodymap]');
  if (bm) {
    var data = {};
    try { data = JSON.parse($('[data-bodymap-data]', bm).textContent); } catch (e) {}
    var list = $('[data-bodymap-list]', bm);
    var label = $('[data-bodymap-label]', bm);
    var arrow = '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';
    var esc = function (s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; };
    function pick(area) {
      $$('[data-area]', bm).forEach(function (el) {
        var on = el.getAttribute('data-area') === area;
        el.classList.toggle('is-active', on);
        if (el.tagName === 'BUTTON') el.setAttribute('aria-pressed', on ? 'true' : 'false');
      });
      var chip = $('.chip[data-area="' + area + '"]', bm);
      label.textContent = chip ? chip.textContent : area;
      var items = data[area] || [];
      list.innerHTML = items.length ? items.map(function (s, i) {
        return '<li style="--n:' + i + '"><a href="' + esc(s.url) + '"><span><strong>' + esc(s.title) + '</strong><small>' + esc(s.category) + '</small></span>' + arrow + '</a></li>';
      }).join('') : '<li><a href="' + (document.querySelector('.bodymap__note a') || {}).href + '"><span><strong>Request an evaluation</strong><small>Our team will help find the right place to start</small></span>' + arrow + '</a></li>';
    }
    $$('[data-area]', bm).forEach(function (el) {
      el.addEventListener('click', function () { pick(el.getAttribute('data-area')); });
    });
  }

  /* ---------- Testimonials slider ---------- */
  // Videos: size each frame to the clip's real shape and play one at a time
  $$('[data-video-frame] video').forEach(function (v) {
    var fit = function () { if (v.videoWidth && v.videoHeight) v.parentNode.style.setProperty('--ar', v.videoWidth + ' / ' + v.videoHeight); };
    if (v.readyState >= 1) fit(); else v.addEventListener('loadedmetadata', fit);
    v.addEventListener('play', function () {
      $$('[data-video-frame] video').forEach(function (o) { if (o !== v && !o.paused) o.pause(); });
    });
  });

  $$('[data-slider]').forEach(function (sl) {
    var track = $('[data-slider-track]', sl);
    function by(dir) {
      var card = track.firstElementChild;
      var w = card ? card.getBoundingClientRect().width + 22 : track.clientWidth;
      track.scrollBy({ left: dir * w, behavior: reduced ? 'auto' : 'smooth' });
    }
    $('[data-slider-prev]', sl).addEventListener('click', function () { by(-1); });
    $('[data-slider-next]', sl).addEventListener('click', function () { by(1); });
  });

  /* ---------- How it works progress line ---------- */
  var steps = $('[data-steps]');
  var fill = steps ? $('[data-steps-fill]', steps) : null;
  function updateSteps() {
    if (!steps || !fill) return;
    var r = steps.getBoundingClientRect();
    var vh = window.innerHeight;
    var p = (vh * 0.8 - r.top) / (r.height + vh * 0.3);
    fill.parentNode.style.setProperty('--p', Math.max(0, Math.min(1, p)).toFixed(3));
    fill.style.setProperty('--p', Math.max(0, Math.min(1, p)).toFixed(3));
  }

  /* ---------- Generic tabs (patient guide) ---------- */
  $$('[data-tabs]').forEach(function (wrap) {
    var tabs = $$('[role=tab]', wrap);
    function activate(t, focus) {
      tabs.forEach(function (o) {
        var on = o === t;
        o.classList.toggle('is-active', on);
        o.setAttribute('aria-selected', on ? 'true' : 'false');
        o.tabIndex = on ? 0 : -1;
        document.getElementById(o.getAttribute('aria-controls')).hidden = !on;
      });
      if (focus) t.focus();
    }
    tabs.forEach(function (t, i) {
      t.addEventListener('click', function () { activate(t); });
      t.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowRight') activate(tabs[(i + 1) % tabs.length], true);
        if (e.key === 'ArrowLeft') activate(tabs[(i - 1 + tabs.length) % tabs.length], true);
      });
    });
    function fromHash() {
      if (location.hash === '#patient-forms') {
        var t = $('#tab-forms', wrap);
        if (t) { activate(t); setTimeout(function () { wrap.scrollIntoView({ behavior: reduced ? 'auto' : 'smooth' }); }, 50); }
      }
    }
    fromHash();
    window.addEventListener('hashchange', fromHash);
  });

  /* ---------- Native forms (AJAX with graceful fallback) ---------- */
  $$('[data-form]').forEach(function (form) {
    var status = $('.form__status', form);
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      status.textContent = '';
      var firstBad = null;
      $$('[required]', form).forEach(function (el) {
        var field = el.closest('.field');
        var bad = el.type === 'checkbox' ? !el.checked : !el.value.trim();
        if (!bad && el.type === 'email') bad = !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(el.value.trim());
        if (!bad && el.type === 'tel') bad = el.value.replace(/\D/g, '').length < 10;
        if (field) field.classList.toggle('is-invalid', bad);
        el.setAttribute('aria-invalid', bad ? 'true' : 'false');
        if (bad && !firstBad) firstBad = el;
      });
      if (firstBad) {
        status.textContent = 'Please complete the highlighted fields.';
        firstBad.focus();
        return;
      }
      form.classList.add('is-sending');
      var btn = $('button[type=submit] span', form);
      var orig = btn ? btn.textContent : '';
      if (btn) btn.textContent = 'Sending…';
      fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
        .then(function (r) { return r.json().catch(function () { return { ok: false, error: 'Something went wrong. Please call us.' }; }); })
        .then(function (res) {
          form.classList.remove('is-sending');
          if (btn) btn.textContent = orig;
          if (res.ok) {
            form.classList.add('is-sent');
            var ok = document.createElement('div');
            ok.className = 'form__success';
            ok.setAttribute('role', 'status');
            ok.innerHTML = '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg><div><strong>Thank you!</strong><p></p></div>';
            ok.querySelector('p').textContent = res.message;
            form.insertBefore(ok, form.firstChild);
            ok.scrollIntoView({ behavior: reduced ? 'auto' : 'smooth', block: 'center' });
            if (window.gtag) window.gtag('event', 'generate_lead', { form: ($('[name=_form]', form) || {}).value });
            if (window.dataLayer) window.dataLayer.push({ event: 'form_submit', form: ($('[name=_form]', form) || {}).value });
          } else {
            status.textContent = res.error || 'Something went wrong. Please try again or call us.';
          }
        })
        .catch(function () {
          form.classList.remove('is-sending');
          if (btn) btn.textContent = orig;
          status.textContent = 'Network error. Please try again or call us.';
        });
    });
    $$('input, select, textarea', form).forEach(function (el) {
      el.addEventListener('input', function () { var f = el.closest('.field'); if (f) f.classList.remove('is-invalid'); });
      el.addEventListener('change', function () { var f = el.closest('.field'); if (f) f.classList.remove('is-invalid'); });
    });
  });

  /* ---------- Cookie notice ---------- */
  var cookie = $('[data-cookie]');
  if (cookie) {
    var seen = false;
    try { seen = localStorage.getItem('ash-cookie') === '1'; } catch (e) {}
    if (!seen) cookie.hidden = false;
    $('[data-cookie-ok]', cookie).addEventListener('click', function () {
      try { localStorage.setItem('ash-cookie', '1'); } catch (e) {}
      cookie.hidden = true;
    });
    var reset = $('[data-cookie-reset]');
    if (reset) reset.addEventListener('click', function () { cookie.hidden = false; });
  }

  /* ---------- Click tracking for calls / texts ---------- */
  document.addEventListener('click', function (e) {
    var a = e.target.closest('a[href^="tel:"], a[href^="sms:"]');
    if (!a) return;
    var type = a.getAttribute('href').indexOf('tel:') === 0 ? 'phone_call' : 'text_message';
    if (window.gtag) window.gtag('event', type, { link_url: a.href });
    if (window.dataLayer) window.dataLayer.push({ event: type });
  });

  onScroll();
})();

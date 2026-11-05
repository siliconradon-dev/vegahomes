/* =====================================================================
   Vega Homes – Architectural Design Fee estimator wizard (vanilla JS)
   Opens from any [data-vd-open="package-slug"] button.
   ===================================================================== */
(function () {
    'use strict';

    var root = document.getElementById('vhDesign');
    if (!root) { return; }

    var cfg;
    try { cfg = JSON.parse(root.getAttribute('data-config')); } catch (e) { return; }

    var form = root.querySelector('#vdForm');
    var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

    var STEPS = ['details', 'addons', 'estimate', 'contact', 'review'];
    var TITLES = {
        details: 'Package & house details',
        addons: 'Optional add-on services',
        estimate: 'Your indicative design fee',
        contact: 'Your contact details',
        review: 'Review your enquiry'
    };
    var ADDON_NAMES = {};
    qa('input[name="addons"]').forEach(function (i) {
        var b = i.parentNode.querySelector('b');
        ADDON_NAMES[i.value] = b ? b.textContent : i.value;
    });

    var state = { pkg: null, index: 0, busy: false, done: false, ref: '' };

    /* ---------------- helpers ---------------- */
    function q(sel, ctx) { return (ctx || root).querySelector(sel); }
    function qa(sel, ctx) { return Array.prototype.slice.call((ctx || root).querySelectorAll(sel)); }
    function fmt(n) { return Number(n || 0).toLocaleString('en-US', { maximumFractionDigits: 2 }); }
    function money(n) { return 'LKR ' + Math.round(n || 0).toLocaleString('en-US'); }
    function plain(n) { return String(+Number(n).toFixed(2)); }
    function el(tag, cls, text) {
        var e = document.createElement(tag);
        if (cls) { e.className = cls; }
        if (text !== undefined) { e.textContent = text; }
        return e;
    }
    function bind(key, value) {
        qa('[data-bind="' + key + '"]').forEach(function (n) { n.textContent = value; });
    }
    function field(name) { return q('[name="' + name + '"]', form); }
    function pkgObj() {
        for (var i = 0; i < cfg.packages.length; i++) {
            if (cfg.packages[i].slug === state.pkg) { return cfg.packages[i]; }
        }
        return null;
    }
    function showError(msg) {
        var e = q('#vdError');
        if (!msg) { e.hidden = true; e.textContent = ''; return; }
        e.textContent = msg;
        e.hidden = false;
        e.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }

    /* ---------------- approximate ranges (rates stay on the server) ---------------- */
    var quote = { seq: 0, timer: null, key: '', fee: '', construction: '' };

    function calc() {
        var p = pkgObj();
        var area = Math.max(0, parseFloat(field('area').value) || 0);
        var out = { p: p, area: area, construction: 0, fee: 0, basis: '' };
        if (cfg.publicRates && p) {
            out.construction = area * p.construction_rate;
            if (area > 0) {
                if (p.type === 'percent') {
                    out.fee = out.construction * p.rate / 100;
                    out.basis = plain(p.rate) + '% \u00d7 ' + money(out.construction);
                } else {
                    out.fee = area * p.rate;
                    out.basis = fmt(area) + ' \u00d7 LKR ' + plain(p.rate);
                }
            }
        }
        return out;
    }

    function rateLabel(p) {
        return p.type === 'percent' ? plain(p.rate) + '% of construction estimate' : 'LKR ' + Number(p.rate).toLocaleString('en-US', { maximumFractionDigits: 2 }) + ' / sq.ft.';
    }

    function setCost(fee, construction, note) {
        bind('fee', fee);
        bind('constEst', construction);
        bind('basis', note || '');
    }

    function rangeNote(area, p) {
        return 'Approximate range for ' + fmt(area) + ' sq.ft. \u2013 ' + (p ? p.name + ' package.' : '');
    }

    function feeText() {
        if (!cfg.showEstimates) { return 'Detailed proposal from our team'; }
        return quote.fee || 'Calculating\u2026';
    }
    function constText() {
        if (!cfg.showEstimates) { return 'Not shown'; }
        return quote.construction || 'Calculating\u2026';
    }

    function scheduleQuote(area, p) {
        if (!cfg.showEstimates) {
            quote.fee = quote.construction = '';
            setCost('Quotation from our team', '\u2014', 'Your detailed proposal is prepared after our team reviews your requirements.');
            return;
        }
        if (!(area > 0) || !p) {
            quote.fee = quote.construction = ''; quote.key = '';
            setCost('LKR 0', 'LKR 0', 'Enter your floor area to see the fee.');
            return;
        }

        var key = p.slug + '|' + area;
        if (quote.key === key && quote.fee) { setCost(quote.fee, quote.construction, rangeNote(area, p)); return; }

        quote.key = key;
        quote.fee = quote.construction = '';
        setCost('Calculating\u2026', 'Calculating\u2026', rangeNote(area, p));
        clearTimeout(quote.timer);
        var seq = ++quote.seq;

        quote.timer = setTimeout(function () {
            fetch(cfg.quoteEndpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ package: p.slug, area: area }),
                credentials: 'same-origin'
            }).then(function (r) { return r.json(); }).then(function (j) {
                if (seq !== quote.seq) { return; }
                if (j && j.ok && j.fee_range) {
                    quote.fee = j.fee_range; quote.construction = j.construction_range;
                    setCost(quote.fee, quote.construction, rangeNote(area, p));
                } else {
                    setCost('Estimate unavailable', '\u2014', 'Please continue \u2013 our team will send your proposal.');
                }
            }).catch(function () {
                if (seq === quote.seq) { setCost('Estimate unavailable', '\u2014', 'Please continue \u2013 our team will send your proposal.'); }
            });
        }, 450);
    }

    function refresh() {
        var c = calc();
        var p = c.p;
        bind('area', fmt(c.area));
        bind('houseType', field('house_type').value);

        if (p) {
            bind('pkgName', p.name);
            bind('pkgRate', cfg.publicRates ? rateLabel(p) : (p.tagline || ''));
            if (cfg.publicRates) {
                bind('constNote', 'Calculated using LKR ' + Math.round(p.construction_rate).toLocaleString('en-US') + ' per sq.ft. \u00d7 floor area.' +
                    (p.type === 'percent' ? ' The design fee is ' + plain(p.rate) + '% of this estimate.' : ''));
                qa('[data-luxury-note]').forEach(function (n) { n.hidden = p.type !== 'percent'; });
            }
            var list = q('[data-list="features"]');
            if (list) {
                list.innerHTML = '';
                (p.features || []).forEach(function (f) { list.appendChild(el('li', '', f)); });
            }
        }
        if (cfg.publicRates) {
            bind('constEst', c.area > 0 ? money(c.construction) : 'LKR 0');
            bind('fee', c.area > 0 ? money(c.fee) : 'LKR 0');
            bind('basis', c.area > 0 ? c.basis : 'Enter your floor area to see the fee.');
            return;
        }
        scheduleQuote(c.area, p);
    }

    /* ---------------- package switch (steps 1 and 3) ---------------- */
    function buildSwitches() {
        qa('[data-package-switch]').forEach(function (box, n) {
            box.innerHTML = '';
            cfg.packages.forEach(function (p) {
                var l = el('label');
                var i = el('input');
                i.type = 'radio'; i.name = 'pkg_switch_' + n; i.value = p.slug;
                i.checked = p.slug === state.pkg;
                i.addEventListener('change', function () {
                    state.pkg = p.slug;
                    buildSwitches();
                    refresh();
                });
                var s = el('span', '', p.name);
                if (cfg.publicRates) {
                    s.appendChild(el('small', '', p.type === 'percent' ? plain(p.rate) + '% of construction' : 'LKR ' + Math.round(p.rate).toLocaleString('en-US') + '/sq.ft.'));
                }
                l.appendChild(i); l.appendChild(s);
                box.appendChild(l);
            });
        });
    }

    /* ---------------- steps ---------------- */
    function showStep(i) {
        state.index = Math.max(0, Math.min(i, STEPS.length - 1));
        var key = STEPS[state.index];

        qa('.vh-step', form).forEach(function (s) { s.classList.toggle('is-active', s.getAttribute('data-step') === key); });
        bind('stepCount', 'Step ' + (state.index + 1) + ' of ' + STEPS.length);
        bind('stepTitle', TITLES[key]);
        q('[data-bind="bar"]').style.width = ((state.index + 1) / STEPS.length * 100) + '%';

        q('#vdBack').style.visibility = state.index === 0 ? 'hidden' : 'visible';
        var next = q('#vdNext');
        if (key === 'review') { next.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit enquiry'; }
        else if (key === 'contact') { next.innerHTML = 'Review enquiry <i class="fa-solid fa-arrow-right"></i>'; }
        else { next.innerHTML = 'Next <i class="fa-solid fa-arrow-right"></i>'; }

        if (key === 'review') { buildReview(); }
        showError('');
        form.scrollTop = 0;
    }

    function markInvalid(input, on) { input.classList.toggle('is-invalid', !!on); }

    function validate(key) {
        showError('');

        if (key === 'details') {
            if (!pkgObj()) { showError('Please choose a design package.'); return false; }
            var a = field('area');
            if (!(parseFloat(a.value) > 0)) {
                markInvalid(a, true);
                showError('Please enter your total proposed floor area in square feet.');
                a.focus();
                return false;
            }
            return true;
        }

        if (key === 'contact') {
            var step = q('.vh-step[data-step="contact"]', form);
            var bad = null;
            qa('[required]', step).forEach(function (i) {
                var ok = i.type === 'checkbox' ? i.checked : i.value.trim() !== '';
                markInvalid(i, !ok);
                if (!ok && !bad) { bad = i; }
            });
            var email = field('email');
            if (email.value && !/^\S+@\S+\.\S+$/.test(email.value)) {
                markInvalid(email, true);
                bad = bad || email;
                showError('Please enter a valid email address or leave it empty.');
            }
            if (bad) {
                if (!q('#vdError').textContent) {
                    showError(bad.type === 'checkbox' ? 'Please tick the consent box so we can contact you.' : 'Please fill in the highlighted fields.');
                }
                bad.focus();
                return false;
            }
        }
        return true;
    }

    /* ---------------- review ---------------- */
    function selectedAddons() {
        return qa('input[name="addons"]:checked').map(function (i) { return i.value; });
    }

    function buildReview() {
        var box = q('#vdReview');
        box.innerHTML = '';
        var c = calc();
        var p = c.p;

        function item(label, value, cls) {
            var d = el('div', cls || '');
            d.appendChild(el('span', '', label));
            d.appendChild(el('b', '', value));
            box.appendChild(d);
        }

        item('Package', p ? (cfg.publicRates ? p.name + ' \u00b7 ' + rateLabel(p) : p.name) : '\u2014');
        if (cfg.publicRates) { item('Calculation basis', c.basis || '\u2014'); }
        item('Proposed floor area', fmt(c.area) + ' sq.ft.');
        item('House type', field('house_type').value);
        item('District', field('district').value || 'Not provided');
        item(cfg.publicRates ? 'Estimated construction cost' : 'Approx. construction cost',
            cfg.publicRates && p ? money(c.construction) + ' (LKR ' + Math.round(p.construction_rate).toLocaleString('en-US') + '/sq.ft.)' : constText());
        item('Indicative design fee', cfg.publicRates ? money(c.fee) : feeText(), 'is-total is-wide');
        var add = selectedAddons().map(function (s) { return ADDON_NAMES[s] || s; });
        item('Optional add-ons', add.length ? add.join(', ') : 'None selected', 'is-wide');
        item('Name', field('name').value);
        item('Contact number', field('phone').value);
        item('Email', field('email').value || 'Not provided');
        item('Expected design start', field('start_date').value || 'Not specified');
        item('Additional requirements', field('comments').value || 'None', 'is-wide');
    }

    /* ---------------- print / save PDF ---------------- */
    function printSummary() {
        var review = q('.vh-step[data-step="review"]', form);
        buildReview();
        bind('printRef', state.ref || 'Draft \u2013 not yet submitted');
        bind('printDate', new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }));

        var html = document.documentElement;
        function cleanup() {
            window.removeEventListener('afterprint', cleanup);
            html.classList.remove('vh-printing');
            review.classList.remove('is-printing');
        }
        window.addEventListener('afterprint', cleanup);
        html.classList.add('vh-printing');
        review.classList.add('is-printing');
        setTimeout(function () { window.print(); }, 60);
    }

    /* ---------------- submit ---------------- */
    function submit() {
        if (state.busy) { return; }
        var next = q('#vdNext');

        var payload = {
            package: state.pkg,
            area: parseFloat(field('area').value) || 0,
            house_type: field('house_type').value,
            district: field('district').value,
            addons: selectedAddons(),
            name: field('name').value,
            phone: field('phone').value,
            email: field('email').value,
            start_date: field('start_date').value,
            comments: field('comments').value,
            consent: field('consent').checked,
            hp_extra: field('hp_extra').value
        };

        state.busy = true;
        next.setAttribute('disabled', 'disabled');
        next.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending\u2026';
        showError('');

        fetch(cfg.endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify(payload),
            credentials: 'same-origin'
        }).then(function (res) {
            return res.json().catch(function () { return {}; }).then(function (json) { return { res: res, json: json }; });
        }).then(function (r) {
            if (r.res.ok && r.json.ok) { return success(r.json); }

            var msg = 'Something went wrong. Please try again, or contact us on WhatsApp.';
            if (r.res.status === 422 && r.json.errors) {
                msg = r.json.errors[Object.keys(r.json.errors)[0]][0];
            } else if (r.res.status === 419) {
                msg = 'Your session expired. Please refresh the page and try again.';
            } else if (r.res.status === 429) {
                msg = 'Too many attempts. Please wait a minute and try again.';
            }
            showError(msg);
        }).catch(function () {
            showError('Network error. Please check your connection and try again.');
        }).then(function () {
            state.busy = false;
            next.removeAttribute('disabled');
            if (!state.done) { showStep(state.index); }
        });
    }

    function success(json) {
        state.done = true;
        state.ref = json.reference;
        qa('.vh-step', form).forEach(function (s) { s.classList.toggle('is-active', s.getAttribute('data-step') === 'success'); });
        q('#vdFoot').hidden = true;
        bind('stepCount', 'Done');
        bind('stepTitle', 'Enquiry received');
        q('[data-bind="bar"]').style.width = '100%';
        bind('reference', json.reference);
        bind('doneFee', json.design_fee);
        var wa = q('#vdWhatsapp');
        if (json.whatsapp_url) { wa.href = json.whatsapp_url; } else { wa.style.display = 'none'; }
        form.scrollTop = 0;
        try { if (json.whatsapp_url) { window.open(json.whatsapp_url, '_blank', 'noopener'); } } catch (e) { /* popup blocked - button remains */ }
    }

    /* ---------------- navigation ---------------- */
    q('#vdNext').addEventListener('click', function () {
        var key = STEPS[state.index];
        if (!validate(key)) { return; }
        if (key === 'review') { submit(); return; }
        showStep(state.index + 1);
    });
    q('#vdBack').addEventListener('click', function () { showStep(state.index - 1); });

    form.addEventListener('submit', function (e) { e.preventDefault(); });
    form.addEventListener('input', function (e) {
        if (e.target.classList) { e.target.classList.remove('is-invalid'); }
        refresh();
    });
    form.addEventListener('change', refresh);

    /* ---------------- open / close / reset ---------------- */
    function reset() {
        form.reset();
        qa('.is-invalid', form).forEach(function (i) { i.classList.remove('is-invalid'); });
        state.done = false;
        state.ref = '';
        state.index = 0;
        q('#vdFoot').hidden = false;
    }

    var opener = null;

    function open(slug) {
        if (state.done) { reset(); }
        if (slug && cfg.packages.some(function (p) { return p.slug === slug; })) { state.pkg = slug; }
        if (!state.pkg && cfg.packages.length) { state.pkg = cfg.packages[0].slug; }

        root.hidden = false;
        root.setAttribute('aria-hidden', 'false');
        document.documentElement.classList.add('vh-lock');
        buildSwitches();
        refresh();
        showStep(state.index);
        setTimeout(function () { var c = q('.vh-close'); if (c) { c.focus(); } }, 50);
    }

    function close() {
        root.hidden = true;
        root.setAttribute('aria-hidden', 'true');
        document.documentElement.classList.remove('vh-lock');
        if (opener && opener.focus) { opener.focus(); }
    }

    document.addEventListener('click', function (e) {
        var t = e.target.closest ? e.target.closest('[data-vd-open]') : null;
        if (t) { e.preventDefault(); opener = t; open(t.getAttribute('data-vd-open')); return; }
        var pr = e.target.closest ? e.target.closest('[data-vh-print]') : null;
        if (pr && root.contains(pr)) { e.preventDefault(); printSummary(); return; }
        var c = e.target.closest ? e.target.closest('[data-vh-close]') : null;
        if (c && root.contains(c)) { e.preventDefault(); close(); }
    });

    // Stop the site's smooth-scroll script from hijacking scroll/keys inside the popup.
    ['wheel', 'mousewheel', 'DOMMouseScroll', 'touchstart', 'touchmove'].forEach(function (ev) {
        root.addEventListener(ev, function (e) { e.stopPropagation(); }, { passive: true });
    });
    root.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { close(); }
        e.stopPropagation();
    });

    buildSwitches();
    refresh();
})();

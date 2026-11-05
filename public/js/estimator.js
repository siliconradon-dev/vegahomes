/* =====================================================================
   Vega Homes – Dream Home Estimator wizard (vanilla JS)
   Opens from any [data-vh-open="package-slug"] button.
   ===================================================================== */
(function () {
    'use strict';

    var root = document.getElementById('vhEstimator');
    if (!root) { return; }

    var cfg;
    try { cfg = JSON.parse(root.getAttribute('data-config')); } catch (e) { return; }

    var form = root.querySelector('#vhForm');
    var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

    var FLOORS = ['ground', 'first', 'second'];
    var FLOOR_LABEL = { ground: 'Ground Floor', first: 'First Floor', second: 'Second Floor' };
    var HOUSE = { 1: 'Single-Storey', 2: 'Two-Storey', 3: 'Three-Storey' };
    var TITLES = {
        config: 'House configuration',
        ground: 'Ground floor rooms',
        first: 'First floor rooms',
        second: 'Second floor rooms',
        estimate: 'Your indicative estimate',
        contact: 'Your contact details',
        review: 'Review your enquiry'
    };
    var DEFAULT_ROOMS = {
        ground: ['Bedroom', 'Bathroom', 'Living Room', 'Dining Room', 'Kitchen', 'Pantry', 'Veranda'],
        first: ['Bedroom', 'Bathroom', 'Other'],
        second: ['Bedroom', 'Bathroom', 'Other']
    };
    var MAX_FILES = 8;
    var MAX_TOTAL = 20 * 1024 * 1024;

    var state = { pkg: null, steps: [], index: 0, busy: false, done: false, files: [], ref: '' };

    /* ---------------- helpers ---------------- */
    function q(sel, ctx) { return (ctx || root).querySelector(sel); }
    function qa(sel, ctx) { return Array.prototype.slice.call((ctx || root).querySelectorAll(sel)); }
    function fmt(n) { return Number(n || 0).toLocaleString('en-US', { maximumFractionDigits: 2 }); }
    function money(n) { return 'LKR ' + Math.round(n || 0).toLocaleString('en-US'); }
    function el(tag, cls, text) {
        var e = document.createElement(tag);
        if (cls) { e.className = cls; }
        if (text !== undefined) { e.textContent = text; }
        return e;
    }
    function bind(key, value) {
        qa('[data-bind="' + key + '"]').forEach(function (n) { n.textContent = value; });
    }
    function levels() {
        var r = q('input[name="floors"]:checked');
        return r ? parseInt(r.value, 10) : 1;
    }
    function field(name) { return q('[name="' + name + '"]', form); }
    function pkgObj() {
        for (var i = 0; i < cfg.packages.length; i++) {
            if (cfg.packages[i].slug === state.pkg) { return cfg.packages[i]; }
        }
        return null;
    }
    function showError(msg) {
        var e = q('#vhError');
        if (!msg) { e.hidden = true; e.textContent = ''; return; }
        e.textContent = msg;
        e.hidden = false;
        e.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }

    /* ---------------- rooms ---------------- */
    function addRoom(floor, type, qty, len, wid) {
        var box = q('[data-rows="' + floor + '"]');
        var row = el('div', 'vh-room');
        row.setAttribute('data-room', floor);

        function lab(text, input) {
            var l = el('label');
            l.appendChild(el('span', '', text));
            l.appendChild(input);
            return l;
        }
        function inp(cls, attrs) {
            var i = el('input', 'vh-in ' + cls);
            Object.keys(attrs).forEach(function (k) { i.setAttribute(k, attrs[k]); });
            return i;
        }

        var t = inp('r-type', { type: 'text', list: 'vhRoomTypes', maxlength: '60', placeholder: 'Room type' });
        t.value = type || '';
        var n = inp('r-qty', { type: 'number', min: '1', max: '99', step: '1', inputmode: 'numeric' });
        n.value = qty || 1;
        var l = inp('r-len', { type: 'number', min: '0', max: '500', step: '0.1', inputmode: 'decimal', placeholder: '0' });
        l.value = len || '';
        var w = inp('r-wid', { type: 'number', min: '0', max: '500', step: '0.1', inputmode: 'decimal', placeholder: '0' });
        w.value = wid || '';

        var area = el('div', 'vh-room__area');
        area.appendChild(el('span', '', 'Area'));
        var ab = el('b');
        ab.appendChild(el('span', 'r-area', '0'));
        ab.appendChild(document.createTextNode(' sq.ft.'));
        area.appendChild(ab);

        var rm = el('button', 'vh-room__rm', '\u00d7');
        rm.type = 'button';
        rm.setAttribute('aria-label', 'Remove room');

        row.appendChild(lab('Room', t));
        row.appendChild(lab('Qty', n));
        row.appendChild(lab('Length (ft)', l));
        row.appendChild(lab('Width (ft)', w));
        row.appendChild(area);
        row.appendChild(rm);
        box.appendChild(row);

        qa('input', row).forEach(function (i) { i.addEventListener('input', refresh); });
        rm.addEventListener('click', function () { row.remove(); refresh(); });
        refresh();
        return row;
    }

    function readRoom(row) {
        var qty = Math.max(0, parseFloat(q('.r-qty', row).value) || 0);
        var len = Math.max(0, parseFloat(q('.r-len', row).value) || 0);
        var wid = Math.max(0, parseFloat(q('.r-wid', row).value) || 0);
        return {
            type: q('.r-type', row).value.trim(),
            qty: qty, length: len, width: wid,
            area: qty * len * wid
        };
    }

    function floorArea(floor) {
        var total = 0;
        qa('[data-room="' + floor + '"]').forEach(function (row) {
            var r = readRoom(row);
            q('.r-area', row).textContent = fmt(r.area);
            total += r.area;
        });
        return total;
    }

    function collectRooms() {
        var out = [];
        var lv = levels();
        FLOORS.forEach(function (f, i) {
            if (i + 1 > lv) { return; }
            qa('[data-room="' + f + '"]').forEach(function (row) {
                var r = readRoom(row);
                if (r.type && r.length > 0 && r.width > 0) {
                    out.push({ floor: f, type: r.type, qty: Math.max(1, Math.round(r.qty) || 1), length: r.length, width: r.width });
                }
            });
        });
        return out;
    }

    function totals() {
        var lv = levels();
        var g = floorArea('ground');
        var f = lv >= 2 ? floorArea('first') : 0;
        var s = lv >= 3 ? floorArea('second') : 0;
        // keep hidden floors' rows calculated for display but excluded from totals
        if (lv < 2) { floorArea('first'); }
        if (lv < 3) { floorArea('second'); }
        return { g: g, f: f, s: s, total: g + f + s };
    }

    /* ---------------- live summary ---------------- */
    function refresh() {
        var t = totals();
        var p = pkgObj();
        var lv = levels();

        FLOORS.forEach(function (f) {
            var n = q('[data-floor-total="' + f + '"]');
            if (n) { n.textContent = fmt(f === 'ground' ? t.g : f === 'first' ? t.f : t.s); }
        });

        bind('gArea', fmt(t.g));
        bind('fArea', fmt(t.f));
        bind('sArea', fmt(t.s));
        bind('totalArea', fmt(t.total));
        bind('houseType', HOUSE[lv]);
        qa('[data-only-floor="first"]').forEach(function (n) { n.style.display = lv >= 2 ? '' : 'none'; });
        qa('[data-only-floor="second"]').forEach(function (n) { n.style.display = lv >= 3 ? '' : 'none'; });

        if (!p) {
            bind('pkgName', '\u2014'); bind('pkgRate', '');
            setCost('LKR 0', 'Enter your room sizes to see the estimate.');
            return;
        }

        bind('pkgName', p.name);

        if (cfg.publicRates) {
            // exact figures (rates are public)
            var prefix = p.starting ? 'From ' : '';
            bind('pkgRate', prefix + money(p.rate) + ' / sq.ft.');
            bind('totalCost', t.total > 0 ? prefix + money(t.total * p.rate) : 'LKR 0');
            bind('formula', t.total > 0
                ? fmt(t.total) + ' sq.ft. \u00d7 ' + money(p.rate) + ' per sq.ft.' + (p.starting ? ' (starting estimate)' : '')
                : 'Enter your room sizes to see the estimate.');
            return;
        }

        // rates hidden: ask the server for an approximate range
        bind('pkgRate', p.tagline || '');
        scheduleQuote(t.total);
    }

    /* ---------------- approximate range (rates stay on the server) ---------------- */
    var quote = { seq: 0, timer: null, key: '', text: '' };

    function setCost(text, note) {
        bind('totalCost', text);
        bind('formula', note || '');
    }

    function rangeNote(area) {
        var p = pkgObj();
        return 'Approximate range for ' + fmt(area) + ' sq.ft. \u2013 ' + (p ? p.name + ' package.' : '');
    }

    function costText() {
        if (!cfg.showEstimates) { return 'Detailed quotation from our team'; }
        return quote.text || 'Calculating\u2026';
    }

    function scheduleQuote(area) {
        var p = pkgObj();

        if (!cfg.showEstimates) {
            quote.text = '';
            setCost('Quotation from our team', 'Your detailed quotation is prepared after our team reviews your plans.');
            return;
        }
        if (!(area > 0) || !p) {
            quote.text = ''; quote.key = '';
            setCost('LKR 0', 'Enter your room sizes to see the estimate.');
            return;
        }

        var key = p.slug + '|' + area;
        if (quote.key === key && quote.text) { setCost(quote.text, rangeNote(area)); return; }

        quote.key = key;
        quote.text = '';
        setCost('Calculating\u2026', rangeNote(area));
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
                if (j && j.ok && j.range) { quote.text = j.range; setCost(j.range, rangeNote(area)); }
                else { setCost('Estimate unavailable', 'Please continue \u2013 our team will send your quotation.'); }
            }).catch(function () {
                if (seq === quote.seq) { setCost('Estimate unavailable', 'Please continue \u2013 our team will send your quotation.'); }
            });
        }, 450);
    }

    /* ---------------- package switch (estimate step) ---------------- */
    function buildSwitch() {
        var box = q('[data-package-switch]');
        box.innerHTML = '';
        cfg.packages.forEach(function (p) {
            var l = el('label');
            var i = el('input');
            i.type = 'radio'; i.name = 'pkg_switch'; i.value = p.slug;
            i.checked = p.slug === state.pkg;
            i.addEventListener('change', function () { state.pkg = p.slug; refresh(); });
            var s = el('span', '', p.name);
            if (cfg.publicRates) {
                s.appendChild(el('small', '', (p.starting ? 'from ' : '') + Math.round(p.rate).toLocaleString('en-US') + '/sq.ft.'));
            }
            l.appendChild(i); l.appendChild(s);
            box.appendChild(l);
        });
    }

    /* ---------------- steps ---------------- */
    function buildSteps() {
        var lv = levels();
        var s = ['config', 'ground'];
        if (lv >= 2) { s.push('first'); }
        if (lv >= 3) { s.push('second'); }
        s.push('estimate', 'contact', 'review');
        state.steps = s;
    }

    function showStep(i) {
        state.index = Math.max(0, Math.min(i, state.steps.length - 1));
        var key = state.steps[state.index];

        qa('.vh-step', form).forEach(function (s) {
            s.classList.toggle('is-active', s.getAttribute('data-step') === key);
        });

        bind('stepCount', 'Step ' + (state.index + 1) + ' of ' + state.steps.length);
        bind('stepTitle', TITLES[key] || '');
        var pct = ((state.index + 1) / state.steps.length) * 100;
        q('[data-bind="bar"]').style.width = pct + '%';

        q('#vhBack').style.visibility = state.index === 0 ? 'hidden' : 'visible';
        var next = q('#vhNext');
        if (key === 'review') { next.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit enquiry'; }
        else if (key === 'contact') { next.innerHTML = 'Review enquiry <i class="fa-solid fa-arrow-right"></i>'; }
        else { next.innerHTML = 'Next <i class="fa-solid fa-arrow-right"></i>'; }

        if (key === 'estimate') { buildSwitch(); }
        if (key === 'review') { buildReview(); }

        showError('');
        form.scrollTop = 0;
    }

    /* ---------------- validation ---------------- */
    function markInvalid(input, on) { input.classList.toggle('is-invalid', !!on); }

    function validate(key) {
        showError('');

        if (key === 'config' || key === 'contact') {
            var step = q('.vh-step[data-step="' + key + '"]', form);
            var bad = null;
            qa('[required]', step).forEach(function (i) {
                var ok = i.type === 'checkbox' ? i.checked : i.value.trim() !== '';
                markInvalid(i, !ok);
                if (!ok && !bad) { bad = i; }
            });
            var email = field('email');
            if (key === 'contact' && email.value && !/^\S+@\S+\.\S+$/.test(email.value)) {
                markInvalid(email, true);
                bad = bad || email;
                showError('Please enter a valid email address or leave it empty.');
            }
            if (bad) {
                if (!q('#vhError').textContent) {
                    showError(bad.type === 'checkbox' ? 'Please tick the consent box so we can contact you.' : 'Please fill in the highlighted fields.');
                }
                bad.focus();
                return false;
            }
            if (key === 'contact') { return validateFiles(); }
            return true;
        }

        if (key === 'ground' || key === 'first' || key === 'second') {
            var ok = qa('[data-room="' + key + '"]').some(function (row) {
                var r = readRoom(row);
                return r.type && r.length > 0 && r.width > 0;
            });
            if (!ok) {
                showError('Please enter the length and width of at least one room on the ' + FLOOR_LABEL[key].toLowerCase() + '.');
                return false;
            }
            return true;
        }

        if (key === 'estimate') {
            if (!pkgObj()) { showError('Please choose a package.'); return false; }
            if (totals().total <= 0) { showError('Your total area is zero. Please go back and enter room sizes.'); return false; }
        }
        return true;
    }

    function validateFiles() {
        if (state.files.length > MAX_FILES) {
            showError('You can attach up to ' + MAX_FILES + ' files.');
            return false;
        }
        var size = state.files.reduce(function (n, f) { return n + f.size; }, 0);
        if (size > MAX_TOTAL) {
            showError('Your files total ' + (size / 1048576).toFixed(1) + ' MB. Please keep the total under 20 MB.');
            return false;
        }
        for (var i = 0; i < state.files.length; i++) {
            if (state.files[i].size > 10 * 1024 * 1024) {
                showError('"' + state.files[i].name + '" is larger than 10 MB.');
                return false;
            }
        }
        return true;
    }

    /* ---------------- review ---------------- */
    function buildReview() {
        var box = q('#vhReview');
        box.innerHTML = '';
        var p = pkgObj();
        var t = totals();
        var lv = levels();

        function item(label, value, cls) {
            var d = el('div', cls || '');
            d.appendChild(el('span', '', label));
            d.appendChild(el('b', '', value));
            box.appendChild(d);
        }

        var prefix = p && p.starting ? 'From ' : '';
        item('Package', p ? (cfg.publicRates ? p.name + ' \u00b7 ' + prefix + money(p.rate) + ' / sq.ft.' : p.name) : '\u2014');
        item('House type', HOUSE[lv]);
        item('District', field('district').value);
        item('Town / area', field('town_area').value);
        item('Design status', field('design_status').value);
        item('Plan approval', field('approval_status').value);
        item('Ground floor', fmt(t.g) + ' sq.ft.');
        if (lv >= 2) { item('First floor', fmt(t.f) + ' sq.ft.'); }
        if (lv >= 3) { item('Second floor', fmt(t.s) + ' sq.ft.'); }
        item('Total proposed area', fmt(t.total) + ' sq.ft.');
        item(cfg.publicRates ? 'Estimated construction cost' : 'Indicative construction cost', cfg.publicRates && p ? prefix + money(t.total * p.rate) : costText(), 'is-total is-wide');
        item('Name', field('name').value);
        item('Contact number', field('phone').value);
        item('Email', field('email').value || 'Not provided');
        item('Land ownership', field('land_ownership').value);
        item('Expected start', field('start_date').value || 'Not specified');
        item('Attachments', state.files.length ? state.files.map(function (f) { return f.name; }).join(', ') : 'None');
        item('Comments', field('comments').value || 'None', 'is-wide');

        var rooms = collectRooms();
        var d = el('div', 'is-wide');
        d.appendChild(el('span', '', 'Room schedule'));
        var ul = el('ul');
        rooms.forEach(function (r) {
            ul.appendChild(el('li', '', FLOOR_LABEL[r.floor] + ' \u2014 ' + r.type + ' \u00d7 ' + r.qty + ': ' + r.length + ' ft \u00d7 ' + r.width + ' ft = ' + fmt(r.qty * r.length * r.width) + ' sq.ft.'));
        });
        d.appendChild(ul);
        box.appendChild(d);
    }

    /* ---------------- files ---------------- */
    function renderFiles() {
        var ul = q('#vhFileList');
        ul.innerHTML = '';
        state.files.forEach(function (f, idx) {
            var li = el('li');
            li.appendChild(el('span', '', f.name));
            li.appendChild(el('em', '', (f.size / 1048576).toFixed(2) + ' MB'));
            var x = el('button', 'vh-room__rm', '\u00d7');
            x.type = 'button';
            x.style.width = '26px'; x.style.height = '26px'; x.style.fontSize = '15px';
            x.setAttribute('aria-label', 'Remove file');
            x.addEventListener('click', function () { state.files.splice(idx, 1); renderFiles(); });
            li.appendChild(x);
            ul.appendChild(li);
        });
    }

    q('#vhFiles').addEventListener('change', function (e) {
        Array.prototype.forEach.call(e.target.files, function (f) { state.files.push(f); });
        e.target.value = '';
        renderFiles();
    });

    /* ---------------- submit ---------------- */
    function submit() {
        if (state.busy) { return; }
        var p = pkgObj();
        var t = totals();
        var lv = levels();
        var next = q('#vhNext');

        var fd = new FormData();
        fd.append('package', state.pkg);
        fd.append('floors', lv);
        ['district', 'town_area', 'design_status', 'approval_status', 'name', 'phone', 'email', 'land_ownership', 'start_date', 'comments', 'hp_extra'].forEach(function (n) {
            fd.append(n, field(n).value);
        });
        fd.append('consent', field('consent').checked ? '1' : '');
        fd.append('rooms', JSON.stringify(collectRooms()));
        state.files.forEach(function (f) { fd.append('attachments[]', f); });

        state.busy = true;
        next.disabled = true;
        next.setAttribute('disabled', 'disabled');
        next.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending\u2026';
        showError('');

        fetch(cfg.endpoint, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: fd,
            credentials: 'same-origin'
        }).then(function (res) {
            return res.json().catch(function () { return {}; }).then(function (json) { return { res: res, json: json }; });
        }).then(function (r) {
            if (r.res.ok && r.json.ok) { return success(r.json, p, t); }

            var msg = 'Something went wrong. Please try again, or contact us on WhatsApp.';
            if (r.res.status === 422 && r.json.errors) {
                var first = Object.keys(r.json.errors)[0];
                msg = r.json.errors[first][0];
            } else if (r.res.status === 413) {
                msg = 'Your files are too large to upload. Please remove some and try again.';
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
            next.disabled = false;
            if (!state.done) { showStep(state.index); }
        });
    }

    function success(json, p, t) {
        state.done = true;
        state.ref = json.reference;
        qa('.vh-step', form).forEach(function (s) { s.classList.toggle('is-active', s.getAttribute('data-step') === 'success'); });
        q('#vhFoot').hidden = true;
        bind('stepCount', 'Done');
        bind('stepTitle', 'Enquiry received');
        q('[data-bind="bar"]').style.width = '100%';
        bind('reference', json.reference);
        bind('doneCost', json.estimated_cost);
        var wa = q('#vhWhatsapp');
        if (json.whatsapp_url) { wa.href = json.whatsapp_url; } else { wa.style.display = 'none'; }
        form.scrollTop = 0;
        try { if (json.whatsapp_url) { window.open(json.whatsapp_url, '_blank', 'noopener'); } } catch (e) { /* popup blocked - button remains */ }
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

    /* ---------------- navigation ---------------- */
    q('#vhNext').addEventListener('click', function () {
        var key = state.steps[state.index];
        if (!validate(key)) { return; }

        if (key === 'config') { buildSteps(); }
        if (key === 'review') { submit(); return; }
        showStep(state.index + 1);
    });
    q('#vhBack').addEventListener('click', function () { showStep(state.index - 1); });

    form.addEventListener('submit', function (e) { e.preventDefault(); });
    form.addEventListener('input', function (e) { if (e.target.classList) { e.target.classList.remove('is-invalid'); } });

    qa('input[name="floors"]').forEach(function (r) {
        r.addEventListener('change', function () { buildSteps(); refresh(); });
    });
    qa('[data-add-room]').forEach(function (b) {
        b.addEventListener('click', function () {
            var row = addRoom(b.getAttribute('data-add-room'), 'Other', 1);
            var first = q('.r-len', row);
            if (first) { first.focus(); }
        });
    });

    /* ---------------- open / close / reset ---------------- */
    function seed() {
        FLOORS.forEach(function (f) {
            q('[data-rows="' + f + '"]').innerHTML = '';
            DEFAULT_ROOMS[f].forEach(function (t) { addRoom(f, t, 1); });
        });
    }

    function reset() {
        form.reset();
        qa('.is-invalid', form).forEach(function (i) { i.classList.remove('is-invalid'); });
        state.files = [];
        state.done = false;
        state.ref = '';
        state.index = 0;
        renderFiles();
        seed();
        q('#vhFoot').hidden = false;
        buildSteps();
    }

    function open(slug) {
        if (state.done) { reset(); }
        if (slug && cfg.packages.some(function (p) { return p.slug === slug; })) { state.pkg = slug; }
        if (!state.pkg && cfg.packages.length) { state.pkg = cfg.packages[0].slug; }

        root.hidden = false;
        root.setAttribute('aria-hidden', 'false');
        document.documentElement.classList.add('vh-lock');
        buildSteps();
        refresh();
        showStep(state.done ? state.steps.length - 1 : state.index);
        setTimeout(function () { var c = q('.vh-close'); if (c) { c.focus(); } }, 50);
    }

    function close() {
        root.hidden = true;
        root.setAttribute('aria-hidden', 'true');
        document.documentElement.classList.remove('vh-lock');
        if (opener && opener.focus) { opener.focus(); }
    }

    var opener = null;
    document.addEventListener('click', function (e) {
        var t = e.target.closest ? e.target.closest('[data-vh-open]') : null;
        if (t) { e.preventDefault(); opener = t; open(t.getAttribute('data-vh-open')); return; }
        var pr = e.target.closest ? e.target.closest('[data-vh-print]') : null;
        if (pr && root.contains(pr)) { e.preventDefault(); printSummary(); return; }
        var c = e.target.closest ? e.target.closest('[data-vh-close]') : null;
        if (c && root.contains(c)) { e.preventDefault(); close(); }
    });

    // Stop the site's smooth-scroll / cursor scripts from hijacking scroll and keys inside the popup.
    ['wheel', 'mousewheel', 'DOMMouseScroll', 'touchstart', 'touchmove'].forEach(function (ev) {
        root.addEventListener(ev, function (e) { e.stopPropagation(); }, { passive: true });
    });
    root.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { close(); }
        e.stopPropagation();
    });

    seed();
    buildSteps();
    refresh();
})();

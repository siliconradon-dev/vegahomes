/* Smooth-scroll to the Design / Construction package sections (navbar + hero buttons).
   On pages that don't contain the sections, the link simply opens the home page at that anchor. */
(function () {
    'use strict';

    var OFFSET = 100; // height of the sticky header

    function target(hash) {
        if (!hash) { return null; }
        try { return document.querySelector(hash); } catch (e) { return null; }
    }

    function go(el) {
        var top = el.getBoundingClientRect().top + (window.pageYOffset || document.documentElement.scrollTop) - OFFSET;
        window.scrollTo({ top: top, behavior: 'smooth' });
    }

    document.addEventListener('click', function (e) {
        var a = e.target.closest ? e.target.closest('a[data-pkg-link]') : null;
        if (!a) { return; }

        var hash = a.getAttribute('data-pkg-link');
        var el = target(hash);
        if (!el) { return; } // section not on this page -> normal navigation to home#section

        e.preventDefault();

        // close the mobile menu if it is open
        var off = document.getElementById('offcanvasExample');
        if (off && window.bootstrap && bootstrap.Offcanvas) {
            var inst = bootstrap.Offcanvas.getInstance(off);
            if (inst) { inst.hide(); }
        }

        setTimeout(function () { go(el); }, off && off.classList.contains('show') ? 300 : 0);
        if (history.replaceState) { history.replaceState(null, '', hash); }
    });

    // arriving from another page with #packages / #design-packages in the URL
    window.addEventListener('load', function () {
        var el = (location.hash === '#packages' || location.hash === '#design-packages') ? target(location.hash) : null;
        if (el) { setTimeout(function () { go(el); }, 700); }
    });
})();

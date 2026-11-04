@extends('layouts.app')

@section('title', 'Our Projects | Vega Homes (Pvt) Ltd')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/projects-page.css') }}?v=1">
@endpush

@section('content')
    <!-- Page Header Start -->
    <div class="page-header parallaxie">
        <!-- Swiper hero wrapper -->
        <div class="page-header-swiper">
            <div class="swiper page-header-swiper-instance">
                <div class="swiper-wrapper">
                    <!-- Slides: using images from images/downloads/hero/New/SH-/ -->
                    <div class="swiper-slide" style="background-image:url('{{ asset('images/downloads/hero/New/SH-30.jpg') }}')"></div>

                </div>


            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Projects</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Projects</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    <!-- Our Project Start -->
    @php
        $projectCounts = $projects->groupBy('status')->map->count();
        $tabs = collect(\App\Models\Project::STATUSES)->filter(fn ($label, $key) => ($projectCounts[$key] ?? 0) > 0);
    @endphp

    <div class="page-project vp">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">our projects</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Explore our <span>ongoing &amp; completed</span> work</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-title-content">
                        <p class="wow fadeInUp" data-wow-delay="0.2s">
                            Follow the progress of homes currently under construction, browse the projects we have delivered and
                            explore our 3D design showcases. Tap any project to view its photos.
                        </p>
                    </div>
                </div>
            </div>

            @if ($projects->isEmpty())
                <p class="vp-empty">Projects will appear here soon.</p>
            @else
                @if ($tabs->count() > 1)
                    <div class="our-Project-nav wow fadeInUp">
                        <ul>
                            <li><a href="#" class="active-btn" data-filter="*">all <sup>{{ $projects->count() }}</sup></a></li>
                            @foreach ($tabs as $key => $label)
                                <li><a href="#" data-filter=".st-{{ $key }}">{{ $label }} <sup>{{ $projectCounts[$key] }}</sup></a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row project-item-boxes align-items-start">
                    @foreach ($projects as $p)
                        @php
                            $urls = $p->image_urls;
                            $meta = collect([
                                $p->location,
                                $p->status === 'completed' && $p->completed_on ? 'Completed ' . $p->completed_on->format('M Y') : null,
                                $p->status === 'ongoing' && $p->started_on ? 'Started ' . $p->started_on->format('M Y') : null,
                            ])->filter()->implode(' · ');
                        @endphp
                        <div class="col-md-6 col-lg-4 project-item-box st-{{ $p->status }}">
                            <div class="project-item vp-item wow fadeInUp" data-wow-delay="0.2s"
                                 data-gallery="{{ json_encode($urls) }}"
                                 data-title="{{ $p->title }}"
                                 data-status="{{ $p->status_label }}"
                                 data-meta="{{ $meta }}"
                                 data-desc="{{ $p->description }}"
                                 @if (count($urls)) tabindex="0" role="button" aria-label="View photos of {{ $p->title }}" @endif>
                                <div class="project-image">
                                    <div class="project-featured-image">
                                        <figure class="image-anime">
                                            @if ($p->cover_url)
                                                <img src="{{ $p->cover_url }}" alt="{{ $p->title }}">
                                            @else
                                                <span class="vp-noimg"><i class="fa-solid fa-image"></i></span>
                                            @endif
                                        </figure>
                                    </div>
                                    <span class="vp-badge vp-badge--{{ $p->status }}">{{ $p->status_label }}</span>
                                    @if (count($urls) > 1)
                                        <span class="vp-count"><i class="fa-solid fa-images"></i> {{ count($urls) }}</span>
                                    @endif
                                </div>
                                <div class="project-content">
                                    <h3>{{ $p->status_label }}</h3>
                                    <h2><a href="#" onclick="return false;">{{ $p->title }}</a></h2>
                                    @if ($meta)<p class="vp-meta"><i class="fa-solid fa-location-dot"></i> {{ $meta }}</p>@endif
                                    @if ($p->status === 'ongoing' && $p->progress !== null)
                                        <div class="vp-progress" title="{{ $p->progress }}% complete">
                                            <div><span>Progress</span><b>{{ $p->progress }}%</b></div>
                                            <i><u style="width: {{ $p->progress }}%"></u></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!-- Our Project End -->

    {{-- Photo viewer --}}
    <div class="vp-lb" id="vpLightbox" hidden aria-hidden="true">
        <div class="vp-lb__backdrop" data-vp-close></div>
        <div class="vp-lb__dialog" role="dialog" aria-modal="true" aria-label="Project photos">
            <button type="button" class="vp-lb__close" data-vp-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            <div class="vp-lb__stage">
                <button type="button" class="vp-lb__nav vp-lb__nav--prev" id="vpPrev" aria-label="Previous photo"><i class="fa-solid fa-chevron-left"></i></button>
                <img id="vpImage" src="" alt="">
                <button type="button" class="vp-lb__nav vp-lb__nav--next" id="vpNext" aria-label="Next photo"><i class="fa-solid fa-chevron-right"></i></button>
                <span class="vp-lb__counter" id="vpCounter"></span>
            </div>
            <div class="vp-lb__info">
                <div>
                    <span class="vp-badge" id="vpStatus"></span>
                    <h3 id="vpTitle"></h3>
                    <p class="vp-lb__meta" id="vpMeta"></p>
                </div>
                <p class="vp-lb__desc" id="vpDesc"></p>
            </div>
            <div class="vp-lb__thumbs" id="vpThumbs"></div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function () {
    var box = document.getElementById('vpLightbox');
    if (!box) { return; }
    var img = document.getElementById('vpImage');
    var thumbs = document.getElementById('vpThumbs');
    var counter = document.getElementById('vpCounter');
    var gallery = [], index = 0, lastFocus = null, startX = null;

    function $(id) { return document.getElementById(id); }

    function show(i) {
        if (!gallery.length) { return; }
        index = (i + gallery.length) % gallery.length;
        img.src = gallery[index];
        counter.textContent = (index + 1) + ' / ' + gallery.length;
        Array.prototype.forEach.call(thumbs.children, function (t, n) {
            t.classList.toggle('is-active', n === index);
            if (n === index && t.scrollIntoView) { t.scrollIntoView({ block: 'nearest', inline: 'center' }); }
        });
        // preload neighbours
        [index + 1, index - 1].forEach(function (n) {
            var k = (n + gallery.length) % gallery.length;
            var pre = new Image(); pre.src = gallery[k];
        });
        $('vpPrev').style.display = $('vpNext').style.display = gallery.length > 1 ? '' : 'none';
        counter.style.display = gallery.length > 1 ? '' : 'none';
    }

    function open(card) {
        try { gallery = JSON.parse(card.getAttribute('data-gallery') || '[]'); } catch (e) { gallery = []; }
        if (!gallery.length) { return; }
        lastFocus = card;

        $('vpTitle').textContent = card.getAttribute('data-title') || '';
        var st = $('vpStatus');
        var label = card.getAttribute('data-status') || '';
        st.textContent = label;
        st.className = 'vp-badge vp-badge--' + (label === 'Ongoing' ? 'ongoing' : label === 'Completed' ? 'completed' : 'design');
        $('vpMeta').textContent = card.getAttribute('data-meta') || '';
        $('vpDesc').textContent = card.getAttribute('data-desc') || '';
        $('vpDesc').style.display = card.getAttribute('data-desc') ? '' : 'none';

        thumbs.innerHTML = '';
        thumbs.style.display = gallery.length > 1 ? '' : 'none';
        gallery.forEach(function (src, n) {
            var b = document.createElement('button');
            b.type = 'button';
            var t = document.createElement('img');
            t.src = src; t.alt = ''; t.loading = 'lazy';
            b.appendChild(t);
            b.addEventListener('click', function () { show(n); });
            thumbs.appendChild(b);
        });

        box.hidden = false;
        box.setAttribute('aria-hidden', 'false');
        document.documentElement.classList.add('vp-lock');
        show(0);
        box.querySelector('.vp-lb__close').focus();
    }

    function close() {
        box.hidden = true;
        box.setAttribute('aria-hidden', 'true');
        document.documentElement.classList.remove('vp-lock');
        img.src = '';
        if (lastFocus && lastFocus.focus) { lastFocus.focus(); }
    }

    document.querySelectorAll('.vp-item').forEach(function (card) {
        card.addEventListener('click', function (e) { e.preventDefault(); open(card); });
        card.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(card); } });
    });
    box.querySelectorAll('[data-vp-close]').forEach(function (b) { b.addEventListener('click', close); });
    $('vpPrev').addEventListener('click', function () { show(index - 1); });
    $('vpNext').addEventListener('click', function () { show(index + 1); });

    box.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { close(); }
        else if (e.key === 'ArrowLeft') { show(index - 1); }
        else if (e.key === 'ArrowRight') { show(index + 1); }
        e.stopPropagation();
    });
    ['wheel', 'mousewheel', 'DOMMouseScroll'].forEach(function (ev) {
        box.addEventListener(ev, function (e) { e.stopPropagation(); }, { passive: true });
    });

    // swipe on touch screens
    var stage = box.querySelector('.vp-lb__stage');
    stage.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; e.stopPropagation(); }, { passive: true });
    stage.addEventListener('touchend', function (e) {
        if (startX === null) { return; }
        var dx = e.changedTouches[0].clientX - startX;
        if (Math.abs(dx) > 45) { show(index + (dx < 0 ? 1 : -1)); }
        startX = null;
    }, { passive: true });
})();
// Re-layout the filter grid once images have loaded (keeps cards from collapsing/overlapping).
(function () {
    function relayout() {
        if (!window.jQuery || !jQuery.fn.isotope) { return; }
        jQuery('.project-item-boxes').isotope('layout');
    }
    window.addEventListener('load', function () {
        setTimeout(relayout, 300);
        setTimeout(relayout, 1200);
        document.querySelectorAll('.vp-item img').forEach(function (i) {
            if (!i.complete) { i.addEventListener('load', relayout); }
        });
    });
})();
</script>
@endpush

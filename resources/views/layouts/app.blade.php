<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Vega Homes (Pvt) Ltd - smart, eco-friendly home construction in Sri Lanka.')">
    <meta name="author" content="Vega Homes (Pvt) Ltd">
    <title>@yield('title', 'Vega Homes (Pvt) Ltd')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/downloads/favicon.png') }}">
    <meta property="og:image" content="{{ asset('images/downloads/favicon.png') }}" />
    @include('partials.head-css')
    <style>
        .value-content h3 { text-transform: capitalize; }
        .value-icon img { height: 100px; padding-bottom: 10px; }
        .hero-slider-image, .hero-slide { height: 100%; }
        .hero-slider-image img { height: 100%; aspect-ratio: 16/9; object-fit: cover; }
        .main-header::after { position: absolute; left: 0; top: 0; content: ''; width: 100%; height: 100%; opacity: .5; background-color: black; }
        .bg-white { background-color: white !important; }
        .service-content { background-color: rgba(255, 255, 255, 0.592); padding: 8px; border-radius: 12px; }
        .service-content h3 a, .service-content p { color: black; }
        .col-2 img { width: 100%; height: 80px; object-fit: contain; }
    </style>
    @stack('styles')
</head>

<body>
    @include('partials.preloader')
    @include('partials.header')

    @include('partials.flash')

    @yield('content')

    @include('partials.footer')
    @include('partials.floating')
    @include('partials.scripts')
    @stack('scripts')
</body>
</html>

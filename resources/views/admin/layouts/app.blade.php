<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title', 'Dashboard') · Vega Homes Admin</title>
    <link rel="shortcut icon" href="{{ asset('images/downloads/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1">
    @stack('styles')
</head>
<body class="adm">
    <div class="adm-shell">
        <aside class="adm-side" id="admSide">
            <a class="adm-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/downloads/logo.png') }}" alt="Vega Homes">
                <span>Admin</span>
            </a>

            <nav class="adm-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard
                </a>
                <a href="{{ route('admin.inquiries.index') }}" class="{{ request()->routeIs('admin.inquiries.*') ? 'is-active' : '' }}">
                    <i class="fa-solid fa-calculator"></i> Build enquiries
                    @if (($navCounts['inquiries'] ?? 0) > 0)<em>{{ $navCounts['inquiries'] }}</em>@endif
                </a>
                <a href="{{ route('admin.packages.index') }}" class="{{ request()->routeIs('admin.packages.*') ? 'is-active' : '' }}">
                    <i class="fa-solid fa-gem"></i> Build packages
                </a>
                <a href="{{ route('admin.design-inquiries.index') }}" class="{{ request()->routeIs('admin.design-inquiries.*') ? 'is-active' : '' }}">
                    <i class="fa-solid fa-compass-drafting"></i> Design enquiries
                    @if (($navCounts['design'] ?? 0) > 0)<em>{{ $navCounts['design'] }}</em>@endif
                </a>
                <a href="{{ route('admin.design-packages.index') }}" class="{{ request()->routeIs('admin.design-packages.*') ? 'is-active' : '' }}">
                    <i class="fa-solid fa-pen-ruler"></i> Design packages
                </a>
                <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}">
                    <i class="fa-solid fa-envelope"></i> Contact messages
                    @if (($navCounts['messages'] ?? 0) > 0)<em>{{ $navCounts['messages'] }}</em>@endif
                </a>
                <a href="{{ route('admin.subscribers.index') }}" class="{{ request()->routeIs('admin.subscribers.*') ? 'is-active' : '' }}">
                    <i class="fa-solid fa-newspaper"></i> Subscribers
                </a>
            </nav>

            <div class="adm-side__foot">
                <a href="{{ route('home') }}" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i> View website</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"><i class="fa-solid fa-right-from-bracket"></i> Sign out</button>
                </form>
            </div>
        </aside>

        <div class="adm-main">
            <header class="adm-top">
                <button class="adm-burger" type="button" onclick="document.getElementById('admSide').classList.toggle('is-open')" aria-label="Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>@yield('heading', 'Dashboard')</h1>
                <div class="adm-user">
                    <span class="adm-user__avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="adm-user__name">{{ auth()->user()->name }}</span>
                </div>
            </header>

            <main class="adm-content">
                @if (session('status'))
                    <div class="adm-flash adm-flash--ok"><i class="fa-solid fa-circle-check"></i> {{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="adm-flash adm-flash--err"><i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>

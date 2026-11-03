<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Sign in · Vega Homes Admin</title>
    <link rel="shortcut icon" href="{{ asset('images/downloads/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1">
</head>
<body class="adm adm-login">
    <div class="adm-login__art" style="background-image:url('{{ asset('images/downloads/hero/New/SH-30.jpg') }}')">
        <div class="adm-login__art-in">
            <img src="{{ asset('images/downloads/logo.png') }}" alt="Vega Homes">
            <h2>Build dreams.<br><em>Manage them beautifully.</em></h2>
            <p>Track every estimate enquiry, update your package rates and follow up with clients – all in one place.</p>
        </div>
    </div>

    <div class="adm-login__panel">
        <form class="adm-login__card" method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <span class="adm-eyebrow">Admin panel</span>
            <h1>Welcome back</h1>
            <p class="adm-muted">Sign in to continue to the Vega Homes dashboard.</p>

            @if ($errors->any())
                <div class="adm-flash adm-flash--err"><i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}</div>
            @endif

            <label class="adm-field">
                <span>Email</span>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </label>
            <label class="adm-field">
                <span>Password</span>
                <input type="password" name="password" required autocomplete="current-password">
            </label>
            <label class="adm-check">
                <input type="checkbox" name="remember" value="1"> <span>Keep me signed in</span>
            </label>

            <button class="adm-btn adm-btn--gold adm-btn--block" type="submit">Sign in <i class="fa-solid fa-arrow-right"></i></button>
            <a class="adm-login__back" href="{{ route('home') }}">&larr; Back to website</a>
        </form>
    </div>
</body>
</html>

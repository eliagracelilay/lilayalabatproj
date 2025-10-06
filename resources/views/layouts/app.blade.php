<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Academic Portal') }}</title>

    <!-- Scripts (local if compiled) -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap 5 CDN (ensures styling even if Mix assets not built) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        :root {
            --brand-start: #f8b0c1;
            --brand-mid: #ff9bb3;
            --brand-end: #bde9e6;
        }
        html, body { height: 100%; }
        body {
            font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background: linear-gradient(180deg, var(--brand-end) 0%, #f6acb9 45%, #e6e6e6 100%);
            min-height: 100vh;
        }
        .navbar { background: rgba(255,255,255,0.6) !important; backdrop-filter: blur(6px); }
        .brand-gradient {
            font-weight: 700; letter-spacing: .5px; text-transform: uppercase;
            background: linear-gradient(90deg, #ff4db8, #ffb3e1, #ffffff);
            -webkit-background-clip: text; background-clip: text; color: transparent;
        }
        .brand-banner { position:absolute; top: 14px; left: 18px; z-index: 1; }
        .brand-banner .brand-gradient { font-size: 28px; letter-spacing: 1px; }
        .auth-shell { min-height: 100vh; display: grid; place-items: center; }
        .card.soft {
            border: 0; border-radius: 16px; overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            background: linear-gradient(180deg, rgba(189,233,230,.7), rgba(246,172,185,.85));
        }
        .card.soft .card-body { backdrop-filter: blur(4px); }
        .btn-brand { background: #ffffff; border: 0; box-shadow: 0 2px 0 rgba(0,0,0,.1) inset; }
        .btn-brand:hover { background: #f7f7f7; }
        .form-control, .form-select { border-radius: 8px; background: rgba(255,255,255,.8); border-color: #ddd; }
        label.form-label { color: #343a40; font-weight: 500; }
        /* Login portal sizing */
        .portal-card { max-width: 680px; border-radius: 28px; }
        .portal-card .card-body { padding: 3rem 3.5rem; }
        .portal-input { height: 38px; }
        .portal-submit { max-width: 340px; margin: 16px auto 0; display: block; }
    </style>
</head>
<body>
    <div id="app">
        <div class="brand-banner d-none d-md-block">
            <span class="brand-gradient">FENKABLE UNIVERSITY</span>
        </div>

        <main class="py-4 auth-shell">
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

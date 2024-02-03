<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Atelier') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <canvas id="canvas"></canvas>
    <div id="app" class="auth-wrappwer">
        <nav class="navbar navbar-expand-md">
                <h1 class="title">
                    <a class="navbar-brand" href="{{ route('top') }}">
                        <div class="logo">
                            <img src="{{ asset('images\laravelsns-icon.png') }}" alt="logo">
                            <span class="logo-text">
                                {{ config('app.name', 'Atelier') }}
                            </span>
                        </div>
                    </a>
                </h1>
        </nav>

        <main class="py-5">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/bg-animation.js') }}"></script>
</body>

</html>

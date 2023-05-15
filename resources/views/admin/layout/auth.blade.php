<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('system_settings')->site_title ?? config('app.name') }} | Admin Login</title>
    <link rel="icon" href="{{ asset(config('system_settings')->favicon ?? '') }}">
    <!-- General CSS Files -->
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ mix('stisla-theme/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('stisla-theme/css/stisla.css') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>


    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>

    <div id="app">
        @yield('content')
    </div>

    <script src="{{ mix('stisla-theme/js/app.js') }}"></script>
</body>
</html>

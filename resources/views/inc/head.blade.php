<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>{{ $page->meta_title ?? config('system_settings')->site_title ?? '' }}</title>
    <meta name="description" content="{{ $page->meta_description ?? asset(config('system_settings')->site_description ?? '')  }}">


    {{--<meta name="description" content="{{ asset(config('system_settings')->site_description ?? '') }}">--}}
    <meta name="keywords" content="{{ $page->meta_keywords ?? asset(config('system_settings')->site_keyword ?? '')   }}">
    {{--<meta name="keywords" content="{{ asset(config('system_settings')->site_keyword ?? '') }}">--}}
    <link rel="canonical" href="{{ str_replace('https://www.', 'https://', url()->current()) }}" />
    <!-- <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://*.singpass.gov.sg; connect-src 'self' https://*.singpass.gov.sg; style-src 'self' https://*.singpass.gov.sg; img-src 'self' https://*.singpass.gov.sg data:; font-src https://fonts.gstatic.com;"> -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset(config('system_settings')->favicon ?? '') }}">

    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" />

    <script src="{{ asset('js/jquery.min.js') }}"></script>



    <link rel="preload" as="logo" href="{{asset('images/diy-cars-logo.png')}}" />

    {!! config('system_settings')->google_anaytics_code ?? '' !!}

    @stack('header-scripts')
    @yield('header-script')


</head>

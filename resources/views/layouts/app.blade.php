<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('inc.head')

<body>



    <div class="mm-page" id="toppage">
			 @include('inc.header')
			 @yield('content')

    </div><!-- //page -->


    @include('inc.footer')
    @include('inc.footer_script')
    @stack('footer-scripts')
    @yield('footer-js')
</body>

</html>

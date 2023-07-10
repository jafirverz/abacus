<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('inc.head')

<body class="temptpage">


    <div class="mm-page" id="toppage">
			 @include('inc.headerstudent')
			 @yield('content')

    </div><!-- //page -->


    @include('inc.footer')
    @include('inc.footer_script')
    @stack('footer-scripts')
    @yield('footer-js')
    <script type="text/javascript">
        $(function () {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD H:i:s',
            });
        });
    </script>
</body>

</html>

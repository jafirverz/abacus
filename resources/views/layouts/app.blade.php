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

        // window.onload = function () {
        //     if (typeof history.pushState === "function") {
        //         history.pushState("jibberish", null, null);
        //         window.onpopstate = function () {
        //             history.pushState('newjibberish', null, null);
        //         };
        //     }
        //     else {
        //         var ignoreHashChange = true;
        //         window.onhashchange = function () {
        //             if (!ignoreHashChange) {
        //                 ignoreHashChange = true;
        //                 window.location.hash = Math.random();
        //             }
        //             else {
        //                 ignoreHashChange = false;
        //             }
        //         };
        //     }
        // };


        //     $(window).keydown(function (event) {
        //         if (event.keyCode == 116) {

        //             event.preventDefault();

        //             return false;

        //         }

        //     });

    </script>
</body>

</html>
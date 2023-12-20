<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('system_settings')->site_title ?? config('app.name') }} | Admin Dashboard</title>
    <?php /*?><link rel="icon" href="{{ asset(config('system_settings')->favicon ?? '') }}"><?php */?>
    <link rel="icon" href="{{ asset(config('system_settings')->favicon ?? '') }}">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('stisla-theme/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla-theme/css/stisla.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla-theme/css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla-theme/css/bootstrap-select.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="{{ asset('stisla-theme/js/app.js') }}"></script>
    <script src="{{ asset('stisla-theme/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('tinymce/tinymce.js') }}"></script>




    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

    </script>
    <!-- daterangepicker -->

<script src="{{ asset('assets/plugins/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('stisla-theme/js/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('stisla-theme/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('stisla-theme/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.numeric.js') }}"></script>
</head>

<body>

    <div id="app">
        <div class="main-wrapper">
            @include('admin.inc.navbar')
            @include('admin.inc.main_sidebar')
            @yield('content')
            @include('admin.inc.footer')
        </div>
    </div>


</body>
<script src="{{ asset('stisla-theme/js/custom.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('.datepicker1').datetimepicker({
            format: 'YYYY-MM-DD',
        });

        $('.timepicker').datetimepicker({
            format: 'HH:mm',
            icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-calendar-check',
                clear: 'far fa-trash-alt',
                close: 'far fa-times-circle'
            }
        });
    });
</script>
<script>
setInterval("my_function();",100000);

    function my_function(){
        $('#notificationIcon').load(location.href + " #notificationIcon>*", "");
        // $('#chatList').load(location.href + " #chatList>*", "");
        // $('#chatListAll').load(location.href + " #chatListAll>*", "");
    }
  $( function() {
    $( ".attachment_data" ).sortable({
      placeholder: "ui-state-highlight"
    });
    $( ".attachment_data" ).disableSelection();
  } );
  </script>
</html>

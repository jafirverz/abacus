<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('inc.head')

<body>
   
    
    <div class="mm-page" >		
			 @include('inc.header')
			 @yield('content')
            		
    </div><!-- //page -->
   
    @include('inc.footer')
    @include('inc.footer_script')
    @stack('footer-scripts')
    
    @php
    Session::forget('previous_urlforseo')
    @endphp
</body>

</html>
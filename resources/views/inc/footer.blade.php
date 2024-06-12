<footer class="footer-container">
    <div class="bgfoot">
        <img class="bg-1" src="{{asset('images/bg-footer-top.png')}}" alt="bg foot" />
        <img class="bg-2" src="{{asset('images/3g-abacus-mascot.png')}}" alt="3g abacus mascot" />
    </div>
    <div class="container">
        <div class="row sp-col-30 align-items-center footer-info">
            <div class="col-xl-auto sp-col">
                <div class="logo">
                    <a href="{{url('/')}}"><img src="{{asset('images/3g-abacus-logo-2.png')}}" alt="3G Abacus" /></a>
                </div>
            </div>
            <div class="col-xl sp-col">
                    @if(isset($page->id) && $page->id>0)
                    {!! get_footer_menu(__('constant.FOOTER'),$page->id, true, 'links') !!}
                    @else
                    {!! get_footer_menu(__('constant.FOOTER'),3, true, 'links') !!}
                    @endif

            </div>
            <div class="col-xl-auto sp-col">
                <ul class="socials">
                    <li><a href="{{ config('system_settings')->facebook_url ?? ''}}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                    {{-- <li><a href="{{ config('system_settings')->twitter_url ?? ''}}" target="_blank"><i class="fa-brands fa-twitter"></i></a></li> --}}
                    <li><a href="{{ config('system_settings')->instagram_url ?? ''}}" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="row sp-col-20">
            <div class="col-md-6 sp-col fcol-1">
                <div class="icon icomap">
                    <i class="icon-map"></i>
                    <h4>Location</h4>
                    <address>{{ config('system_settings')->contact_address ?? ''}}</address>
                </div>
            </div>
            <div class="col-md-6 sp-col fcol-2">
                <div class="icon">
                    <i class="icon-phone"></i>
                    <h4><a href="{{ config('system_settings')->contact_link ?? ''}}" target="_blank">Contact US/ FEEDBACK</a></h4>
                    Tel: <a href="tel:+{{ config('system_settings')->contact_number ?? ''}}">+{{ config('system_settings')->contact_number ?? ''}}</a>
                </div>
            </div>
            <div class="col-lg-6 sp-col fcol-3">
                <div class="icon icomail">
                    <i class="icon-email"></i>
                    <h4>Email</h4>
                    <a class="lnktype" href="mailto:{{ config('system_settings')->contact_email ?? ''}}">{{ config('system_settings')->contact_email ?? ''}}</a>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            Copyright &copy; <script>
                            document.write(new Date().getFullYear());
                        </script> UE 3G Abacus Pte. Ltd. All rights reserved.
        </div>
    </div>
</footer>

<a href="#toppage" class="gotop"><i class="fas fa-chevron-up"></i></a>

<script src="{{ asset('js/plugin.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

<footer class="footer-container">
    <div class="container">
        <div class="row align-items-center first">
            <div class="col-lg-4">
                <ul class="links">
                    <?php
                    $privacyUrl = create_menu_link(['page_id'=> __('constant.TERM_PAGE_ID')]);
                    $termUrl= create_menu_link(['page_id'=> __('constant.PRIVACY_PAGE_ID')]);
                    ?>
                    @if($privacyUrl)
                    <li><a href="{{ $privacyUrl  }}">Terms.</a>
                    </li>
                    @endif
                    @if($termUrl)
                    <li><a href="{{ $termUrl }}">Privacy.</a>
                    </li>
                    @endif
                </ul>
                <p>Copyright &copy; {{ date("Y") }}. {{ config('system_settings')->site_name }} All Rights Reserved.</p>
            </div>
            <div class="col-lg-8 last">
                <ul class="socials">
                    @if(config('system_settings')->facebook_url)
                    <li><a href="{{ config('system_settings')->facebook_url}}" target="_blank"><i class="fab fa-facebook-f"></i>
                            Facebook</a></li>
                    @endif
                    @if(config('system_settings')->twitter_url)
                    <li><a href="{{ config('system_settings')->twitter_url }}" target="_blank"><i class="fab fa-twitter"></i> twitter</a>
                    </li>
                    @endif
                    @if(config('system_settings')->instagram_url)
                    <li><a href="{{ config('system_settings')->instagram_url }}" target="_blank"><i class="fab fa-instagram"></i>
                            instagram</a></li>
                    @endif
                    @if(config('system_settings')->linkedin_url)
                    <li><a href="{{ config('system_settings')->linkedin_url }}" target="_blank"><i class="fab fa-linkedin-in"></i>
                            linkedin</a></li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
</footer>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>DIY Cars</title>

    <link href="css/plugins.css" rel="stylesheet" />
    <link href="css/main.css" rel="stylesheet" />

    <script src="js/jquery.min.js"></script>

</head>

<body>

    <div class="mm-page">

        <header class="header-container">
            <div class="container clearfix">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/diy-cars-logo.png') }}" alt="DIY Cars" />
                    </a>
                </div>

            </div>
        </header>
        <div class="modal fade pp-search" id="pp-search">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <form action="post" class="input-group">
                        <input type="text" class="form-control" placeholder="Search" />
                        <div class="input-group-append">
                            <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="main-wrap thanks-wrap">
            <div class="container main-inner">
                <div class="content">
                    <h1><strong>UH OH! You're lost.</strong></h1>
                    <h1>@yield('code')</h1>
                    <p>@yield('code')</p>
                    <a class="btn-1" href="{{ url('/') }}">Home <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

    </div><!-- //page -->

    {{-- <footer class="footer-container">
        <div class="container">
            <div class="row break-425">
                <div class="col-lg-4 col-md-12 sp-col align-self-center">
                    <div class="logo">
                        <a href="index.html">
                            <img src="images/diy-cars-logo-2.png" alt="DIY Cars" />
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-7 sp-col mt-md-30">
                    <h4>Sitemap</h4>
                    <div class="row">
                        <div class="col-6">
                            <ul class="links">
                                <li><a href="index.html">Home</a></li>
                                <li><a href="about.html">About Us</a></li>
                                <li><a href="marketplace.html">Marketplace</a></li>
                                <li><a href="loan.html">Loan</a></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="links">
                                <li><a href="insurance.html">Insurance</a></li>
                                <li><a href="#">Sell My Car</a></li>
                                <li><a href="forms.html">Forms</a></li>
                                <li class="active"><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-5 sp-col mt-md-30">
                    <h4>Useful Info</h4>
                    <ul class="links">
                        <li><a href="policy.html">Privacy Policy</a></li>
                        <li><a href="faqs.html">FAQs</a></li>
                        <li><a href="terms.html">Terms and Conditions</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-7 sp-col mt-md-30">
                    <h4>CONTACT DETAILS</h4>
                    <address class="ico-fa"><i class="fas fa-map-marker-alt"></i> 210 Turf Club Rd, Lot C1 Turf
                        City<br />Auto Emporium, Singapore 287995</address>
                    <p class="ico-fa"><i class="fas fa-phone"></i> (65) 1234 5678</p>
                    <p class="ico-fa email"><i class="fas fa-envelope"></i> <a
                            href="mailto:loan@diycars.com">loan@diycars.com</a></p>
                    <ul class="socials">
                        <li><a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i>
                                Facebook</a></li>
                        <li><a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i>
                                Instagram</a></li>
                        <li><a href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin-in"></i>
                                Linkedin</a></li>
                        <li><a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i>
                                Youtube</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                Copyright &copy; 2020 Autolink Holdings Pte Ltd. All rights reserved. Web Excellence by <span
                    class="verz">Verz</span>
            </div>
        </div>
    </footer>
    <a href="#toppage" class="smoothscroll gotop fal fa-arrow-up">Go Top</a> --}}

    <script src="js/plugin.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
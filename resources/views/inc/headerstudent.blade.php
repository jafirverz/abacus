<header class="header-container">
    <div class="logo">
        <a href="{{ url('home') }}">
            <img src="{{ asset('images/3g-abacus-logo.png') }}" alt="3G Abacus" />
        </a>
    </div>
    <div class="actions">
        <a class="cart" href="checkout-step-1.html"><i class="icon-cart"></i><strong>+99</strong></a>
        <div class="headuser hide-991"><span class="welcome">Welcome back {{ Auth::user()->name }},</span>
            <a href="{{url('logout')}}">Logout</a>
        </div>
        <div class="dropdown show-991">
            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-user"></i></a>
            <ul class="dropdown-menu">
                <li class="active"><a href="be-overview.html">Overview</a></li>
                <li><a href="be-achievements.html">My Achievements</a></li>
                <li><a href="{{url('my-profile')}}">My Profile</a></li>
                <li><a href="{{url('logout')}}">Logout</a></li>
            </ul>
        </div>
    </div>
</header>

<div class="menu-aside">
    <h3>My Dashboard</h3>
    <ul>
        <li @if(Request::segment(1) == 'home' || Request::segment(1) == '') class="active" @endif>
            <a href="{{ url('home') }}">
                <span><img src="{{ asset('images/tempt/ico-overview.png') }}" alt="Overview icon" /></span>
                <strong>Overview</strong>
            </a>
        </li>
        <li @if(Request::segment(1) == 'achievements') class="active" @endif>
            <a href="{{ route('normal.achievements') }}">
                <span><img src="{{ asset('images/tempt/ico-achievements.png') }}" alt="Achievements icon" /></span>
                <strong>My Achievements</strong>
            </a>
        </li>
        <li @if(Request::segment(1) == 'my-profile') class="active" @endif>
            <a href="{{url('my-profile')}}">
                <span><img src="{{ asset('images/tempt/ico-profile.png') }}" alt="Profile icon" /></span>
                <strong>My Profile</strong>
            </a>
        </li>
        @php 
        $checkUserOrder = \App\Order::where('user_id', Auth::user()->id)->where('payment_status', 'COMPLETED')->pluck('id')->toArray();
        $checkOrderDetails = \App\OrderDetail::whereIn('order_id', $checkUserOrder)->where('order_type', 'level')->get();
        @endphp
        @if(isset($checkOrderDetails) && count($checkOrderDetails) > 0)
        <li @if(Request::segment(1) == 'membership') class="active" @endif>
            <a href="{{url('membership')}}">
                <span><img src="{{ asset('images/tempt/ico-profile.png') }}" alt="Profile icon" /></span>
                <strong>Membership</strong>
            </a>
        </li>
        @endif
    </ul>
</div>

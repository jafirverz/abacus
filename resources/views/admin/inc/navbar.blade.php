<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <div class="mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        @if(Auth::check())
        {{-- @if(Auth::user()->admin_role==__('constant.USER_PARTNER')) --}}
        <li class="dropdown dropdown-list-toggle show"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg @if(getNotifications()) beep @endif"
                aria-expanded="true"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right" id="notificationIcon">
                <div class="dropdown-list-content dropdown-list-icons"
                    style="overflow: hidden; outline: currentcolor none medium;" tabindex="3">
                    @if(getNotifications())
                    @foreach(getNotifications() as $value)
                    <a href="@if($value->link!=NULL) {{ $value->link }} @else {{ route('notification.show-redirect', $value->id) }} @endif"
                        class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-primary text-white">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            {{ $value->message ?? '' }}
                            <div class="time text-primary">{{ $value->created_at->diffForHumans() ?? '' }}</div>
                        </div>
                    </a>
                    @endforeach
                    @else
                    <a href="javascript:void(0);" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-desc">
                            No new notification
                        </div>
                    </a>
                    @endif
                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ route('notification.index') }}">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>
        {{-- @endif --}}
        @endif

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset(Auth::user()->profile) }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->firstname }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in
                    {{ Auth::user()->lastLoginAt()? Auth::user()->lastLoginAt()->diffForHumans():'' }}</div>
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{ __('constant.PROFILE') }}
                </a>
                <a href="{{ route('activitylog.index') }}" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> {{ __('constant.ACTIVITYLOG') }}
                </a>
                <a href="{{ route('admin.system-settings') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> {{ __('constant.SYSTEM_SETTING') }}
                </a>
                <a href="{{ url('admin/loan-calculator-settings') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> {{ __('constant.LOAN_CALCULATOR_SETTINGS') }}
                </a>

                <div class="dropdown-divider"></div>
                <a href="{{ route('admin_logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('admin_logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

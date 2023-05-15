@if(Auth::check())
@php
$enquiry_id=get_enquiry_by_user( Auth::user()->id);
@endphp
<div class="user">
    <div class="dropdown-wrap">
        <a class="dropdown-wrap-toggle" href="#drop-content">HI, {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</a>
        <div id="drop-content" class="dropdown-content">
            <div class="content">
                <ul>
                    
                    @include('inc.account_dropdown')
                    <li>
                        <a href="{{ url('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <a href="{{url('conversation')}}" class="comment">
        <i class="fas fa-comments"></i> 
        <span id="unread_chat">{{count_chat($enquiry_id,__('constant.ENQUIRY_TYPE_BUYER'))}}</span>
    </a>
</div>
@else
<div class="login"><a href="{{ url('login') }}">Login</a>/<a href="{{url('registration-info') }}">Register</a></div>
@endif
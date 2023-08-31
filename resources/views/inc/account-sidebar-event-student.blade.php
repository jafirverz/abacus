<div class="menu-aside">
  <h3>My Dashboard</h3>
  <ul>
      <li  @if(Request::segment(1) == 'home' || Request::segment(1) == '') class="active" @endif>
          <a href="{{ url('home') }}">
              <span><img src="{{ asset('images/tempt/ico-overview.png') }}" alt="Overview icon" /></span>
              <strong>Overview</strong>
          </a>
      </li>
      
      <li @if(Request::segment(1) == 'my-profile') class="active" @endif>
          <a href="{{url('my-profile')}}">
              <span><img src="{{ asset('images/tempt/ico-profile.png') }}" alt="Profile icon" /></span>
              <strong>My Profile</strong>
          </a>
      </li>
     
  </ul>
</div>

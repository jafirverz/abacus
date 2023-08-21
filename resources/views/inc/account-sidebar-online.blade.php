<div class="menu-aside">
    <h3>My Dashboard</h3>
    <ul>
      <li @if(Request::segment(1) == '') class="active" @endif>
        <a href="{{ url('/') }}">
          <span><img src="{{ asset('images/tempt/ico-profile.png') }}" alt="Profile icon" /></span>
          <strong>My Profile</strong>
        </a>
      </li>
      <li @if(Request::segment(1) == 'online-student' && Request::segment(2) == 'my-course') class="active" @endif>
        <a href="{{ url('online-student/my-course')}}">
          <span><img src="{{ asset('images/tempt/ico-courses.png') }}" alt="Courses icon" /></span>
          <strong>My Courses</strong>
        </a>
      </li>
      <li @if(Request::segment(1) == 'online-student' && Request::segment(2) == 'about-3g-abacus') class="active" @endif>
        <a href="{{ url('online-student/about-3g-abacus') }}">
          <span><img src="{{ asset('images/tempt/ico-abacus.png') }}" alt="Abacus icon" /></span>
          <strong>About 3G Abacus</strong>
        </a>
      </li>
      <li @if(Request::segment(1) == 'online-student' && Request::segment(2) == 'feedback') class="active" @endif>
        <a href="{{ url('online-student/feedback') }}">
          <span><img src="{{ asset('images/tempt/ico-feedback.png') }}" alt="Feedback icon" /></span>
          <strong>Feedback/ Contact Us</strong>
        </a>
      </li>
    </ul>
    
</div>
<div class="menu-aside">
    <h3>My Dashboard</h3>
    <ul>
      <li class="active">
        <a href="{{ url('/') }}">
          <span><img src="{{ asset('images/tempt/ico-profile.png') }}" alt="Profile icon" /></span>
          <strong>My Profile</strong>
        </a>
      </li>
      <li>
        <a href="{{ url('online-student/my-course')}}">
          <span><img src="{{ asset('images/tempt/ico-courses.png') }}" alt="Courses icon" /></span>
          <strong>My Courses</strong>
        </a>
      </li>
      <li>
        <a href="be-online-student-dashboard-about-3g-abacus.html">
          <span><img src="{{ asset('images/tempt/ico-abacus.png') }}" alt="Abacus icon" /></span>
          <strong>About 3G Abacus</strong>
        </a>
      </li>
      <li>
        <a href="{{ url('online-student/feedback') }}">
          <span><img src="{{ asset('images/tempt/ico-feedback.png') }}" alt="Feedback icon" /></span>
          <strong>Feedback/ Contact Us</strong>
        </a>
      </li>
    </ul>
    
</div>
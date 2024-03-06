<h3>My Dashboard</h3>
<ul>
    <li @if(Request::segment(1) == 'home' || Request::segment(1) == '') class="active" @endif>
        <a href="{{ url('/') }}">
            <span><img src="{{ url('/') }}/images/tempt/ico-profile.png" alt="Profile icon" /></span>
            <strong>My Profile</strong>
        </a>
    </li>
    <li @if(Request::segment(1) == 'external-profile') class="active" @endif>
        <a href="{{ route('external-profile.my-students') }}">
            <span><img src="{{ url('/') }}/images/tempt/ico-students.png" alt="Students icon" /></span>
            <strong>My Students</strong>
        </a>
    </li>
    <li @if(Request::segment(1) == 'grading-examination' || Request::segment(1) == 'grading-examination-listing' || Request::segment(1) == 'register-grading-examination') class="active" @endif>
        <a href="{{ url('grading-examination-listing') }}">
            <span><img src="{{ asset('images/tempt/ico-grading.png') }}" alt="Grading icon" /></span>
            <strong>Grading Examinations</strong>
        </a>
    </li>
    <li @if(Request::segment(1) == 'instructor-competition') class="active" @endif>
        <a href="{{ url('instructor-competition') }}">
            <span><img src="{{ url('/') }}/images/tempt/ico-competitions.png" alt="Competitions icon" /></span>
            <strong>Competitions</strong>
        </a>
    </li>

</ul>

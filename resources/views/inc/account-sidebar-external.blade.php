<h3>My Dashboard</h3>
<ul>
    <li class="active">
        <a href="{{ url('/') }}">
            <span><img src="{{ url('/') }}/images/tempt/ico-profile.png" alt="Profile icon" /></span>
            <strong>My Profile</strong>
        </a>
    </li>
    <li>
        <a href="{{ route('external-profile.my-students') }}">
            <span><img src="{{ url('/') }}/images/tempt/ico-students.png" alt="Students icon" /></span>
            <strong>My Students</strong>
        </a>
    </li>
    <li>
        <a href="{{ url('grading-examination') }}">
            <span><img src="{{ url('/') }}/images/tempt/ico-grading.png" alt="Grading icon" /></span>
            <strong>Grading Examinations</strong>
        </a>
    </li>
    <li>
        <a href="{{ url('instructor-competition') }}">
            <span><img src="{{ url('/') }}/images/tempt/ico-competitions.png" alt="Competitions icon" /></span>
            <strong>Competitions</strong>
        </a>
    </li>

</ul>

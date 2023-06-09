<h3>My Dashboard</h3>
<ul>
    <li>
        <a href="{{ url('/') }}">
            <span><img src="{{ asset('images/tempt/ico-overview.png') }}" alt="Overview icon" /></span>
            <strong>Overview</strong>
        </a>
    </li>
    <li class="active">
        <a href="{{ url('instructor-profile') }}">
            <span><img src="{{ asset('images/tempt/ico-profile.png') }}" alt="Profile icon" /></span>
            <strong>My Profile</strong>
        </a>
    </li>
    <li>
        <a href="{{ url('/instructor-students') }}">
            <span><img src="{{ asset('images/tempt/ico-students.png') }}" alt="Students icon" /></span>
            <strong>My Students</strong>
        </a>
    </li>
    <li>

        <a href="{{ url('teaching-materials') }}">

            <span><img src="{{ asset('images/tempt/ico-teaching.png') }}" alt="Teaching icon" /></span>
            <strong>Teaching Materials</strong>
        </a>
    </li>
    <li>
        <a href="{{ url('/') }}">
            <span><img src="{{ asset('images/tempt/ico-grading.png') }}" alt="Grading icon" /></span>
            <strong>Grading Examinations</strong>
        </a>
    </li>
    <li>
        <a href="{{ url('instructor-competition') }}">
            <span><img src="{{ asset('images/tempt/ico-competitions.png') }}" alt="Competitions icon" /></span>
            <strong>Competitions</strong>
        </a>
    </li>
    <li>
        <a href="{{ url('allocation') }}">
            <span><img src="{{ asset('images/tempt/ico-allocation.png') }}" alt="Allocation icon" /></span>
            <strong>Test and Survey Allocation</strong>
        </a>
    </li>
</ul>

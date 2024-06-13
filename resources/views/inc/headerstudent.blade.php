<header class="header-container">
    <div class="logo">
        <a href="{{ url('home') }}">
            <img src="{{ asset('images/3g-abacus-logo.png') }}" alt="3G Abacus" />
        </a>
    </div>
    <div class="actions">
        <a class="cart" href="{{ url('cart') }}"><i class="icon-cart"></i>
            @php
            $userId = Auth::user()->id ?? '';
            if($userId){
                $checkTempCart = \App\TempCart::where('user_id', $userId)->get();
                if($checkTempCart){
                    $cartN = count($checkTempCart);
                }else{
                    $cartN = 0;
                }
            }else{
                $cartN = 0;
            }

            @endphp
            <strong>+{{ $cartN }}</strong>
        </a>
        <div class="headuser hide-991"><span class="welcome">Welcome back {{ Auth::user()->name ?? '' }},</span>
            <a href="{{url('logout')}}">Logout</a>
        </div>
        <div class="dropdown show-991">
            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-user"></i></a>
            <ul class="dropdown-menu">


                @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
                <li @if(Request::segment(1) == 'home' || Request::segment(1) == '' || Request::segment(1) == 'level' || Request::segment(1) == 'worksheet' || Request::segment(1) == 'grading-overview' || Request::segment(1) == 'competition' || Request::segment(1) == 'leaderboard') class="active" @endif>

                    <a href="{{ url('home') }}">
                        Overview
                    </a>
                </li>
                <li @if(Request::segment(1) == 'achievements') class="active" @endif>
                    <a href="{{ route('normal.achievements') }}">
                        My Achievements
                    </a>
                </li>
                <li @if(Request::segment(1) == 'my-profile') class="active" @endif>
                    <a href="{{url('my-profile')}}">
                        My Profile
                    </a>
                </li>
                    @php
                    $checkUserOrder = \App\Order::where('user_id', Auth::user()->id)->where('payment_status', 'COMPLETED')->pluck('id')->toArray();
                    $checkOrderDetails = \App\OrderDetail::whereIn('order_id', $checkUserOrder)->where('order_type', 'level')->get();
                    @endphp
                    @if(isset($checkOrderDetails) && count($checkOrderDetails) > 0)
                    <li @if(Request::segment(1) == 'membership') class="active" @endif>
                        <a href="{{url('membership')}}">
                            Membership
                        </a>
                    </li>
                    @endif

                @endif

                @if(Auth::user()->user_type_id == 3)
                <li @if(Request::segment(1)=='' || Request::segment(1)=='home' ) class="active" @endif>
                    <a href="{{ url('/') }}">
                        My Profile
                    </a>
                  </li>
                  <li @if(Request::segment(1)=='online-student' && Request::segment(2)=='my-course' ) class="active" @endif>
                    <a href="{{ url('online-student/my-course')}}">
                      My Courses
                    </a>
                  </li>
                  <li @if(Request::segment(1)=='online-student' && Request::segment(2)=='about-3g-abacus' ) class="active" @endif>
                    <a href="{{ url('online-student/about-3g-abacus') }}">
                        About 3G Abacus
                    </a>
                  </li>
                  <li @if(Request::segment(1)=='online-student' && Request::segment(2)=='feedback' ) class="active" @endif>
                    <a href="{{ url('online-student/feedback') }}">
                        Feedback/ Contact Us
                    </a>
                  </li>
                  @php
                  $allocation = \App\Allocation::where('student_id', Auth::user()->id)->where('is_finished', null)->orderBy('id',
                  'desc')->first();
                  if(!$allocation){
                  $url = 'javascript::void(0)';
                  }else{
                  $url = url('/survey-form');
                  }
                  @endphp
                  <li @if(Request::segment(1)=='survey-form' ) class="active" @endif>
                    <a href="{{ $url }}">
                        Survey Form
                    </a>
                  </li>
                @endif

                @if(Auth::user()->user_type_id == 4)
                <li  @if(Request::segment(1) == 'home' || Request::segment(1) == '') class="active" @endif>
                    <a href="{{ url('home') }}">
                        Overview
                    </a>
                </li>

                <li @if(Request::segment(1) == 'my-profile') class="active" @endif>
                    <a href="{{url('my-profile')}}">
                        My Profile
                    </a>
                </li>
                @endif

                @if(Auth::user()->user_type_id == 6)

                <li @if(Request::segment(1) == 'home' || Request::segment(1) == '') class="active" @endif>
                    <a href="{{ url('/') }}">
                        My Profile
                    </a>
                </li>
                <li @if(Request::segment(1) == 'external-profile') class="active" @endif>
                    <a href="{{ route('external-profile.my-students') }}">
                        My Students
                    </a>
                </li>
                <li @if(Request::segment(1) == 'grading-examination' || Request::segment(1) == 'grading-examination-listing' || Request::segment(1) == 'register-grading-examination') class="active" @endif>
                    <a href="{{ url('grading-examination-listing') }}">
                        Grading Examinations
                    </a>
                </li>
                <li @if(Request::segment(1) == 'instructor-competition') class="active" @endif>
                    <a href="{{ url('instructor-competition') }}">
                        Competitions
                    </a>
                </li>
                @endif

                @if(Auth::user()->user_type_id == 5)
                <li @if(Request::segment(1) == '' || Request::segment(1) == 'home') class="active" @endif>
                    <a href="{{ url('/') }}">
                        Overview
                    </a>
                </li>
                <li @if(Request::segment(1) == 'instructor-profile') class="active" @endif>
                    <a href="{{ url('instructor-profile') }}">
                        My Profile
                    </a>
                </li>
                <li @if(Request::segment(1) == 'instructor-students' || Request::segment(1) == 'students'  || Request::segment(1) == 'add-students') class="active" @endif>
                    <a href="{{ url('/instructor-students') }}">
                        My Students
                    </a>
                </li>
                <li @if(Request::segment(1) == 'teaching-materials') class="active" @endif>

                    <a href="{{ url('teaching-materials') }}">

                        Teaching Materials
                    </a>
                </li>
                <li @if(Request::segment(1) == 'grading-examination' || Request::segment(1) == 'grading-examination-listing' || Request::segment(1) == 'register-grading-examination') class="active" @endif>
                    <a href="{{ url('grading-examination-listing') }}">
                        Grading Examinations
                    </a>
                </li>
                <li @if(Request::segment(1) == 'instructor-competition') class="active" @endif>
                    <a href="{{ url('instructor-competition') }}">
                        Competitions
                    </a>
                </li>
                <li @if(Request::segment(1) == 'allocation') class="active" @endif>
                    <a href="{{ url('allocation') }}">
                        Test and Survey Allocation
                    </a>
                </li>
                @endif

                <li><a href="{{url('logout')}}">Logout</a></li>
            </ul>
        </div>
    </div>
</header>

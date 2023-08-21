@extends('layouts.app')
@section('content')
<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      <div class="menu-aside">
        @include('inc.account-sidebar-online')
      </div>
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
        <div class="tempt-2-content">
            <h1 class="title-3">My Courses</h1>
            <div class="box-1">
                <div class="accordion">
                    @if($level)
                    @php $i=0; @endphp
                     @foreach($level as $item)
                     @php $i++; @endphp
                     @if($item->courses)
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button @if($i!=1) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#course-{{ $i }}" aria-expanded="false" aria-controls="course-{{ $i }}">{{ $item->title }}</button>
                            </h3>
                            <div id="course-{{ $i }}" class="accordion-collapse collapse @if($i==1) show @endif">
                                <div class="accordion-body">
                                    <ul class="list-2">
                                        
                                        @foreach($item->courses as $val)
                                        @php
                                        $is_course_submitted = \App\CourseSubmitted::where('user_id', Auth::user()->id)->where('course_id', $val->id)->first();
                                        @endphp
                                            @if(isset($is_course_submitted))
                                            @php
                                            $test = \App\TestManagement::where('course_id', $val->id)->first();
                                            @endphp
                                             @if($test)
                                             @php
                                                $is_test_submitted = \App\TestSubmission::where('user_id', Auth::user()->id)->where('test_id', $test->id)->first();
                                             @endphp
                                              @if($is_test_submitted)
                                                <li>{{ $test->title}} Submitted</li>
                                              @else
                                              <li><a href="{{ url('my-test/detail/'.$test->id)}}">{{ $test->title}}</a></li>
                                              @endif
                                             @endif
                                            @else
                                            <li><a href="{{ url('/online-student/my-course/detail/'.$val->id)}}">{{ $val->title}}</a></li>
                                            @endif
                                        @endforeach
                                    
                                        
                                    </ul>
                                </div>
                            </div>
                        </div> 
                    @endif
                    @endforeach
                    @endif
                </div>
            </div>
            <h2 class="title-1 mt-30">My Certificates</h2>
            <div class="box-1">
                <div class="row grid-6">
                    <div class="col-md-6">
                        <a class="item" href="#">Certificate of Completion (Online Elementary)</a>
                    </div>
                    <div class="col-md-6">
                        <a class="item" href="#">Certificate of Completion (Online Elementary)</a>
                    </div>
                    <div class="col-md-6">
                        <a class="item" href="#">Certificate of Completion (Online Elementary)</a>
                    </div>
                    <div class="col-md-6">
                        <a class="item" href="#">Certificate of Completion (Online Elementary)</a>
                    </div>
                    <div class="col-md-6">
                        <a class="item" href="#">Certificate of Completion (Online Elementary)</a>
                    </div>
                    <div class="col-md-6">
                        <a class="item" href="#">Certificate of Completion (Online Elementary)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</main>
@endsection

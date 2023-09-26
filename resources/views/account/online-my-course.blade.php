@extends('layouts.app')
@section('content')
<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
        @include('inc.account-sidebar-online')
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
        <div class="tempt-2-content">
            <h1 class="title-3">My Courses</h1>
            <div class="box-1">
                <div class="accordion">
                    @if($level)
                    @php $i=$k=0; @endphp
                     @foreach($level as $item)
                     @php

                     $courses = \App\Course::join('course_assign_to_users','course_assign_to_users.course_id','courses.id')->where('course_assign_to_users.user_id', Auth::user()->id)->where('courses.level_id', $item->id)->select('courses.*')->get();

                     @endphp
                     @if(isset($courses) && $courses->count() > 0)
                       @php
                        //dd($courses);
                        $k++;
                       @endphp
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button @if($k!=1) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#course-{{ $k }}" aria-expanded="false" aria-controls="course-{{ $k }}">{{ $item->title }}</button>
                            </h3>
                            <div id="course-{{ $k }}" class="accordion-collapse collapse @if($k==1) show @endif">
                                <div class="accordion-body">
                                    <ul class="list-2">
                                        @php $j=0; @endphp
                                        @foreach($courses as $val)
                                        @php

                                        $is_course_submitted = \App\CourseSubmitted::where('user_id', Auth::user()->id)->where('course_id', $val->id)->first();
                                        @endphp
                                            @if(isset($is_course_submitted))
                                             <li><a href="{{ url('/online-student/my-course/detail/'.$val->id)}}">{{ $val->title}} @if(isset($is_course_submitted) && $is_course_submitted->is_submitted==2) (In-Progress) @endif</a></li>
                                            @else
                                            @php $i++; @endphp
                                            @php  $j++; @endphp
                                                @if($i.$j==11)

                                                <li><a href="{{ url('/online-student/my-course/detail/'.$val->id)}}">{{ $val->title}} </a></li>
                                                @else
                                                <li><a href="javascript::void(0)">{{ $val->title}}</a></li>
                                                @endif
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
                    @if($courseCertificate)
                    @foreach($courseCertificate as $certificate)
                    <div class="col-md-6">
                        <a class="item" href="{{ url('download-certificate', $certificate->id) }}">{{ $certificate->course->title ?? '' }}</a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
  </div>
</main>
@endsection

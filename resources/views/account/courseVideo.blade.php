@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
        @include('inc.account-sidebar-online')
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
        <div class="tempt-2-content">
            <div class="mb-20">
                <a class="link-1 lico" href="{{ route('my-course') }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
            </div>
            <ul class="breadcrumb bctype">
                <li><a href="{{ url('online-student/my-course')}}">My Courses</a></li>
                <li><strong>{{ $test_paper->title ?? ''}}</strong></li>
            </ul>
            <div class="box-1">
                <h2 class="title-2">{{ $test_paper->title ?? ''}}</h2>
                <article class="document mt-20">
                {!! $test_paper->description ?? '' !!}
                </article>
            </div>
            <div class="row sp-col-30 grid-7">
                <div class="col-lg-6 sp-col videowrap">
                    <video width="400" controls>
                        <source src="{{asset($test_paper->video_file)}}" type="video/mp4"  controlsList="nodownload">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="col-lg-6 sp-col countwrap">
                    <iframe width="500" height="400" src="{{ $test_paper->simulator_link }}" ></iframe>
                </div>
            </div>
            <form method="post" action="{{ route('course.answer.submit') }}">
            @csrf
            @php
            //dd($courseSubmitted);
            @endphp
            <div class="row grid-5">
                @if(isset($courseSubmitted) && $courseSubmitted->is_submitted==2)
                <input type="hidden" name="course_submitted_id" value="{{ $courseSubmitted->id }}">
                @endif
            <input type="hidden" name="test_paper_question_id" value="{{ $paper_detail->id }}">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="question_type" value="{{ $course->paper->question_template_id }}">
                @php

                $k=0;
                $i = 1;
                foreach($paper_detail->questionsCourse as $question){
                @endphp
                <div class="col-lg-4 col-md-6">
                <div class="inner">
                    <strong class="number">Q{{ $i }}</strong>
                    <div class="vdwrap">
                    <video width="400">
                        <source src="{{ url('/upload-file/'.$question->input_1) }}" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                    <a class="link-fix" data-fancybox href="{{ url('/upload-file/'.$question->input_1) }}"><i class="fa-solid fa-play"></i></a>
                    </div>
                    <textarea @if(isset($courseSubmitted) && $courseSubmitted->is_submitted==1) disabled="disabled" @endif class="form-control" rows="3" cols="30" name="answer[{{ $question->id }}]" placeholder="Answer">@if(isset($courseSubmitted)) {{ getCourseAnswer($courseSubmitted->id,$question->id)->question_answer ?? '' }} @endif</textarea>
                </div>
                </div>
                @php
                $i++;
                $k++;
                }
                @endphp
          </div>
          <div class="output-1">
            @if(isset($courseSubmitted) && $courseSubmitted->is_submitted==2)
            <button class="btn-1" name="is_submitted" value="1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
            @elseif(isset($courseSubmitted) && $courseSubmitted->is_submitted==1)
            <button class="btn-1" name="is_submitted" value="1" disabled>Submitted <i class="fa-solid fa-arrow-right-long"></i></button>
            @else
            <button class="btn-2" name="is_submitted" value="2" type="submit">Save <i class="fa-solid fa-arrow-right-long"></i></button>
            <button class="btn-1" name="is_submitted" value="1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
            @endif
        </div>
            </form>
        </div>
  </div>
  </div>
</main>
@endsection

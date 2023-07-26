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
                <a class="link-1 lico" href="#"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
            </div>
            <ul class="breadcrumb bctype">
                <li><a href="{{ url('online-student/my-course')}}">My Courses</a></li>
                <li><strong>{{ $course->level->title}}</strong></li>
            </ul>
            <div class="box-1">
                <h2 class="title-2">{{ $course->title}}</h2>
                <article class="document mt-20">
                    {!! $course->content !!}
                </article>
            </div>
            <div class="row sp-col-30 grid-7">
                <div class="col-lg-6 sp-col videowrap">
                    <video width="400" controls>
                        <source src="video/mov.mp4" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="col-lg-6 sp-col countwrap">
                    <img src="images/tempt/count.jpg" alt="" />
                </div>
            </div>
            <form method="post" action="{{ route('course.answer.submit') }}">
            @csrf

            <input type="hidden" name="test_paper_question_id" value="{{ $paper_detail->id }}">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="question_type" value="{{ $course->paper->question_template_id }}">

            <div class="row grid-3">
                @php
                $k=0;
                foreach($paper_detail->questionsCourse as $question){
                @endphp
                <div class="col-md-4 col-6 sp-col">
                  <div class="item">
                    <div class="inner">
                      <figure>
                        <img src="{{ url('/'.$question->input_1) }}" alt="" />
                      </figure>
                      <textarea class="form-control" cols="10" rows="3" placeholder="Answer" name="answer[{{ $question->id }}]"></textarea>
                    </div>
                  </div>
                </div>
                @php
                    $k++;
                  }
                  @endphp

              </div>

            <div class="output-1">
                <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
            </div>
            </form>
        </div>
  </div>
  </div>
</main>
@endsection

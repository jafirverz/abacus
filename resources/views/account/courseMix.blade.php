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
            <div class="box-1">
                <div class="xscrollbar">
                  <table class="tb-2 tbtype-1">
                    <thead>
                      <tr>
                        <th class="wcol-1 text-center">NO</th>
                        <th class="wcol-2 text-center">Division</th>
                        <th>Answer</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $i = 1;
                      @endphp
                      @foreach($paper_detail->questionsCourse as $ques)
                      @php
                      if($ques->input_3 == 'multiply'){
                        $symbol='*';
                      }
                      elseif($ques->input_3 == 'add'){
                        $symbol='+';
                      }
                      elseif($ques->input_3 == 'add'){
                        $symbol='-';
                      }
                      else{
                        $symbol='÷';
                      }
                      @endphp
                      <tr>
                        <td class="colnumber">{{ $i }}</td>
                        <td class="text-center">{{ $ques->input_1 }} {{ $symbol }} {{ $ques->input_2 }}  =</td>
                        <td class="colanswer"><input class="form-control" type="number" name="answer[{{ $ques->id }}]" /></td>
                      </tr>
                      @php
                      $i++;
                      @endphp
                      @endforeach

                    </tbody>
                  </table>
                </div>
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

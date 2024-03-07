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
                <a class="link-1 lico"  href="{{ route('my-course') }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
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
                        <source src="{{asset($test_paper->video_file)}}" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="col-lg-6 sp-col countwrap">
                    <iframe width="500" height="400" src="{{ $test_paper->simulator_link }}" ></iframe>
                </div>
            </div>
            <form method="post" action="{{ route('course.answer.submit') }}">
            @csrf
            @if(isset($courseSubmitted) && $courseSubmitted->is_submitted==2)
            <input type="hidden" name="course_submitted_id" value="{{ $courseSubmitted->id }}">
            @endif
            <input type="hidden" name="test_paper_question_id" value="{{ $paper_detail->id }}">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="question_type" value="{{ $course->paper->question_template_id }}">
            <div class="row sp-col-20">
                <div class="col-xl-6 col-md-5 sp-col mt-30 order-md-last">
                  <iframe src="" width="500px"></iframe>
                </div>
                <div class="col-xl-6 col-md-7 sp-col order-md-first">

                      @php
                      $countQ = count($paper_detail->questionsCourse);
                      @endphp
                      <div class="xscrollbar mt-30">
                        <table class="tb-2 tbtype-5">
                          <thead>
                            <tr>
                              <th class="wcol-1 text-center"></th>
                              @for($i = 1; $i <= $countQ; $i++)
                              <th class="text-center">{{ $i }}</th>
                              @endfor
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td></td>
                              @foreach($paper_detail->questionsCourse as $ques)
                              @php
                              $explo = explode(',', $ques->input_1);
                              $m = 0;
                              @endphp
                              <td>
                                @for($m=0; $m < count($explo); $m++)
                                <div class="row sp-col-5 inrow-1">
                                  <div class="col sp-col">{{ $explo[$m] }}</div>
                                </div>
                                @endfor

                              </td>
                              @endforeach


                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td class="lbtb-1">Your<br/>Answer:</td>
                              @foreach($paper_detail->questionsCourse as $ques)
                              <td class="colanswer text-center"><input @if(isset($courseSubmitted) && $courseSubmitted->is_submitted==1) disabled="disabled" @endif class="form-control minwinpt-1" type="text" value="@if(isset($courseSubmitted)) {{ getCourseAnswer($courseSubmitted->id,$ques->id)->question_answer ?? '' }} @endif" name="answer[{{ $ques->id }}]" /></td>
                              @endforeach

                            </tr>

                          </tfoot>
                        </table>
                      </div>



                </div>
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

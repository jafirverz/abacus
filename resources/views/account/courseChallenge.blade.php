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
                        <source src="{{asset($test_paper->video_file)}}" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="col-lg-6 sp-col countwrap">
                    <img src="{{asset($test_paper->powerpoint_file)}}" alt="" />
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
            <div class="xscrollbar mt-50">
                <table class="tb-2 tbtype-1">
                    <thead>
                      <tr>
                        <th class="wcol-1 text-center">NO</th>
                        <th class="wcol-2 text-center">Multiplication</th>
                        <th>Answer</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $getQues = \App\TestPaperQuestionDetail::where('test_paper_question_id', $paper_detail->id)->get();
                      $i = 1;
                      @endphp

                      @foreach($getQues as $ques)
                      @php
                      if($ques->input_3 == 'add'){
                        $symbol = '+';
                      }elseif($ques->input_3 == 'multiply'){
                        $symbol = '*';
                      }elseif($ques->input_3 == 'divide'){
                        $symbol = '/';
                      }elseif($ques->input_3 == 'subtract'){
                        $symbol = '-';
                      }
                      @endphp
                      <tr>
                        <td class="colnumber">{{ $i }}</td>
                        <td class="text-center">{{ $ques->input_1 }} {{ $symbol }} {{ $ques->input_2 }}  =</td>
                        <td class="colanswer"><input @if(isset($courseSubmitted) && $courseSubmitted->is_submitted==1) disabled="disabled" @endif class="form-control" value="@if(isset($courseSubmitted)) {{ getCourseAnswer($courseSubmitted->id,$ques->id)->question_answer ?? '' }} @endif" name="answer[{{ $ques->id }}]" type="number" /></td>
                      </tr>
                      @php
                      $i++;
                      @endphp
                      @endforeach

                    </tbody>
                  </table>
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

<script>


  // initAudioPlayer();

    function initAudioPlayer(val){
      var audio = new Audio();
      // audio.pause();
      var aContainer = document.getElementById("audio-"+val);
      // assign the audio src
      audio.src = aContainer.querySelectorAll('source')[0].getAttribute('src');
      audio.load();
      audio.loop = false;
      audio.play();

      // Set object references
      var playbtn = document.getElementById("play_btn"+val);

        // Add Event Handling
        playbtn.addEventListener("click", playPause(audio, playbtn));
      }

      // Functions
      function playPause(audio, playbtn){
          return function () {
             if(audio.paused){
               audio.play();
               $('.link-2').html('<i class="bi bi-pause"></i>')
             } else {
               audio.pause();
               $('.link-2').html('<i class="fa-solid fa-volume-high"></i>')
             }
          }
      }

  </script>
@endsection

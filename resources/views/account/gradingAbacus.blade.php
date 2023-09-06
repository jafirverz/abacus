@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      <div class="menu-aside">
      @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
        @include('inc.account-sidebar')
      @endif
      </div>
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="#"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <ul class="breadcrumb bctype">
            <li><a href="{{ url('home') }}">Overview</a></li>
            <li><strong>{{ $gradingExam->title }}</strong></li>
        </ul>

        <h1 class="title-3">{{ $gradingExam->title }}</h1>
        <div> {!! $gradingExam->important_note !!}</div>
        <form method="post" action="{{ route('grading_answer.submit') }}">
          @csrf
          <input type="hidden" name="grading_exam_id" value="{{ $grading_exam_id }}">
            <input type="hidden" name="listing_id" value="{{ $listing_id }}">
            <input type="hidden" name="paper_id" value="{{ $paper->listing_paper_id }}">
            <input type="hidden" name="question_type" value="{{ $paper->question_type }}">
        <div class="row sp-col-20">
          <div class="col-xl-6 col-md-5 sp-col mt-30 order-md-last">
            <iframe src="" width="500px"></iframe>
          </div>
          <div class="col-xl-6 col-md-7 sp-col order-md-first">

                @php
                $countQ = count($paper->questionsGrade);
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
                        @foreach($paper->questionsGrade as $ques)
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
                        @foreach($paper->questionsGrade as $ques)
                        <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" value="" name="answer[{{ $ques->id }}]" /></td>
                        @endforeach

                      </tr>

                    </tfoot>
                  </table>
                </div>



          </div>
        </div>
        <div class="output-1 mt-50">
          <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
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

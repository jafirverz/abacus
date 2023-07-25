@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
        @include('inc.account-sidebar')
      @endif
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="be-overview-preparatory.html"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <ul class="breadcrumb bctype">
            <li><a href="{{ url('grading-overview') }}">Grading Overview</a></li>
            <li><strong>{{ $gradingExam->title }}</strong></li>
        </ul>
        <div class="box-1">
            {!! $gradingExam->important_note !!}
        </div>

        <div class="timer-wrap">
          <div class="timer"><i class="icon-clock"></i> <strong>Timer: HH: MM: SS</strong></div>
        </div>
        <form method="post" action="{{ route('grading_answer.submit') }}">
            @csrf
            <input type="hidden" name="grading_exam_id" value="{{ $grading_exam_id }}">
              <input type="hidden" name="listing_id" value="{{ $listing_id }}">
              <input type="hidden" name="paper_id" value="{{ $paper->id }}">
              <input type="hidden" name="question_type" value="{{ $paper->question_type }}">
          <div class="box-1">
            <div class="note-3 mb-20">Sections 2 &amp; 3: Each question is worth 1 mark for each correct answer.</div>
            <div class="xscrollbar">
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
                  $getQues = \App\GradingPaperQuestion::where('grading_paper_question_id', $paper->id)->get();
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
                    <td class="colanswer"><input class="form-control" name="answer[{{ $ques->id }}]" type="number" /></td>
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

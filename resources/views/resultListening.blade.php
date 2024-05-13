@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      @if(Auth::user()->user_type_id == 3)
      @include('inc.account-sidebar-online')
      @endif
      @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
      @include('inc.account-sidebar')
      @endif
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="{{ url('level/'.$level->slug) }}"><i class="fa-solid fa-arrow-left"></i> Go
            Back</a>
        </div>
        <ul class="breadcrumb bctype">
          <li><a href="{{ url('home') }}">Overview</a></li>
          <li><a href="{{ url('level/'.$level->slug) }}">{{ $level->title }}</a></li>
          <li><strong>{{ $worksheet->title }}</strong></li>
        </ul>
        <div class="box-1">
          {{ $worksheet->description }}
        </div>

        <div class="row grid-4">

          @php
          $k=1;
          $questionns = \App\MiscQuestion::where('question_id', $questions->id)->groupBy('block')->get();
          foreach($questionns as $questionn){
          @endphp

          <div class="col-xl-4 col-sm-6">
            <div class="inner">
              @php
              $questionnss = \App\MiscQuestion::where('question_id', $questions->id)->where('block',
              $questionn->block)->get();

              foreach($questionnss as $question){
                $questionnsCheck = \App\WorksheetQuestionSubmitted::where('misc_question_id', $question->id)->where('worksheet_submitted_id', $worksheetSubmittedId)->first();
              @endphp
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q{{ $k }} {{ $questionnsCheck->id }}</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" type="button"><i class="fa-solid fa-volume-high"></i></button>
                  <!--audio id="audio-6">
                    <source src="audio/track.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio-->
                </div>
                <div class="col sp-col">
                  @if($questionnsCheck->question_answer == $questionnsCheck->user_answer)
                  <div class="answer-true">
                    <span>{{ $questionnsCheck->user_answer }}</span>
                    <i class="fa-solid fa-circle-check"></i>
                  </div>
                  @else
                  <div class="answer-false">
                    <span class="ansfalse">{{ $questionnsCheck->user_answer }}</span>
                    <!-- <strong>{{ $questionnsCheck->question_answer }}</strong> -->
                    <i class="fa-solid fa-circle-xmark"></i>
                  </div>
                  @endif
                </div>
              </div>
              @php
              $k++;
              }
              @endphp
              
            </div>
          </div>
          @php
          }
          @endphp

        </div>


      </div>
    </div>
  </div>
</main>

<script>


  // initAudioPlayer();

  function initAudioPlayer(val) {
    var audio = new Audio();
    // audio.pause();
    var aContainer = document.getElementById("audio-" + val);
    // assign the audio src
    audio.src = aContainer.querySelectorAll('source')[0].getAttribute('src');
    audio.load();
    audio.loop = false;
    audio.play();

    // Set object references
    var playbtn = document.getElementById("play_btn" + val);

    // Add Event Handling
    playbtn.addEventListener("click", playPause(audio, playbtn));
  }

  // Functions
  function playPause(audio, playbtn) {
    return function () {
      if (audio.paused) {
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
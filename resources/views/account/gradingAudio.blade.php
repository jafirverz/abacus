@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      @if(Auth::user()->user_type_id == 1)
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
        <form method="post" action="{{ route('grading_answer.submit') }}">
            @csrf
            <input type="hidden" name="grading_exam_id" value="{{ $grading_exam_id }}">

            <input type="hidden" name="listing_id" value="{{ $listing_id }}">
            <input type="hidden" name="paper_id" value="{{ $paper->listing_paper_id }}">
            <input type="hidden" name="question_type" value="{{ $paper->question_type }}">
        <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i class="icon-info"></i></button> <strong><a href="?s=1">Shuffle the Questions <i class="icon-shuffle"></i></a></strong></div>
        </div>
        <div class="row grid-4">

          @php
          $k=1;
          if(isset($_GET['s']) && $_GET['s'] == 1){
            $questionns = \App\GradingPaperQuestion::where('grading_paper_question_id', $paper->id)->groupBy('input_2')->inRandomOrder()->get();
          }else{
            $questionns = \App\GradingPaperQuestion::where('grading_paper_question_id', $paper->id)->groupBy('input_2')->get();
          }
          foreach($questionns as $questionn){
          @endphp
            <div class="col-xl-4 col-sm-6">
              <div class="inner">
                @php
                $questionnss = \App\GradingPaperQuestion::where('grading_paper_question_id', $questionn->grading_paper_question_id)->where('input_2', $questionn->input_2)->get();

                foreach($questionnss as $question){
                @endphp
                <div class="row sp-col-10 grow">
                  <input type="hidden" value="{{ $question->id }}">
                  <div class="col-auto sp-col"><strong>Q{{ $k }}</strong></div>
                  <div class="col-auto sp-col">
                    <button class="link-2 play-wrap" id="play_btn{{ $k }}" type="button" value="{{ $k }}" >
                      <!-- <i class="fa-solid fa-volume-high"></i> -->
                    </button>
                    <audio id="audio-{{ $k }}" controls controlsList="nodownload">
                      <source src="{{ url('/upload-file/'.$question->input_1) }}" type="audio/mp3">
                      <source src="{{ url('/upload-file/'.$question->input_1) }}" type="audio/ogg">
                      Your browser does not support the audio element.
                    </audio>
                  </div>
                  <div class="col sp-col">
                    <input class="form-control" type="text" name="answer[{{ $question->id }}]" required placeholder="Answer" />
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
    <div class="output-1">
      <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
    </div>
  </form>

  </div>
</main>

<script>
jQuery(document).ready(function ($) {
    $(".play").click(function () {
      var music_id = $(this).data('music_id');
      var audio = document.getElementById(music_id);
      var test = music_id.split("-");
      var iclass = 'audio'+test[1];
      //alert(music_id);
      if (audio.paused) {
        audio.play();
        $(this).removeClass('fa-solid fa-volume-high')
        $(this).addClass('fa fa-pause')
      } else {
        audio.pause();
        //audio.currentTime = 0
        $(this).removeClass('fa fa-pause')
        $(this).addClass('fa-solid fa-volume-high')
      }
    });
  });

  // initAudioPlayer();

    // function initAudioPlayer(val){
    //   var audio = new Audio();
    //   // audio.pause();
    //   var aContainer = document.getElementById("audio-"+val);
    //   // assign the audio src
    //   audio.src = aContainer.querySelectorAll('source')[0].getAttribute('src');
    //   audio.load();
    //   audio.loop = false;
    //   audio.play();

    //   // Set object references
    //   var playbtn = document.getElementById("play_btn"+val);

    //     // Add Event Handling
    //     playbtn.addEventListener("click", playPause(audio, playbtn));
    //   }

    //   // Functions
    //   function playPause(audio, playbtn){
    //       return function () {
    //          if(audio.paused){
    //            audio.play();
    //            $('.link-2').html('<i class="bi bi-pause"></i>')
    //          } else {
    //            audio.pause();
    //            $('.link-2').html('<i class="fa-solid fa-volume-high"></i>')
    //          }
    //       }
    //   }

  </script>
@endsection

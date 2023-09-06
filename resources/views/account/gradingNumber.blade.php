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
            <li><a href="{{ url('home') }}">Overview</a></li>
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
        <div class="row grid-3">
          @php
          $k=0;
          foreach($paper->questionsGrade as $question){
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

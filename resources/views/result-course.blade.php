@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">

        @if(Auth::user()->user_type_id == 3)
        @include('inc.account-sidebar-online')
        @endif
        @if(Auth::user()->user_type_id == 1)
        @include('inc.account-sidebar')
        @endif

    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="{{ route('my-course') }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        @if(isset($courseSub) && $courseSub->is_submitted && $courseSub->is_submitted==2)
        <div class="box-msg-2 mt-50">
            <h4>Thank you for your submission. You records has been saved successfully.</h4>
          </div>
        @else
        <h1 class="title-3">Result</h1>

        <div class="box-msg-2 mt-50">
          <h4>Thank you for your submission.</h4>
          <h2>Here is your marks {{ $userMarks }} out of {{ $totalMarks }}.</h2>
          @if(checkAllLessonSubitted()==NULL)
          {{-- Click <a href="{{ url('/') }}/survey-form">here</a> to survey. --}}
          @endif
        </div>
        @endif
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

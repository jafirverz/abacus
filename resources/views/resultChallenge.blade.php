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
          <a class="link-1 lico" href="{{ url('/') }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>								
        <ul class="breadcrumb bctype">
          <li><a href="{{ url('/') }}">Overview</a></li>
          <li><a href="{{ url('/level/'.$level->slug) }}">{{ $level->title }}</a></li>
          <li><strong>Scores</strong></li> 
        </ul>
        <div class="box-1 box-msg-1">
          <h4>You have submitted the challenge</h4>
          <h2>Here are your scores <br/><strong>{{ $userMarks }}</strong></h2>
          <a href="{{ url('leaderboard/'.$level->id.'/'.$worksheet->id) }}" class="btn-1">Back to Leaderboard <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>

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
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
          <li><a href="{{ url('') }}">Competition</a></li>
          {{--  <li><strong>{{ $worksheet->title }}</strong></li> --}}
        </ul>
        <div class="box-1">
          {{-- $worksheet->description --}}
        </div>
        <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i class="icon-info"></i></button> <strong><a href="#">Shuffle the Questions <i class="icon-shuffle"></i></a></strong></div>
        </div>
        <div class="row grid-4">
          <div class="col-xl-4 col-sm-6">
            <div class="inner">
              @php 
              $k = 1;
              @endphp
              @foreach($questions as $question)
              <div class="row sp-col-10 grow">
                <div class="col-auto sp-col"><strong>Q1</strong></div>
                <div class="col-auto sp-col">
                  <button class="link-2" id="play_btn{{ $k }}" type="button" value="{{ $k }}" onclick="initAudioPlayer(this.value);"><i class="fa-solid fa-volume-high"></i></button>
                  <audio id="audio-{{ $k }}">
                    <source src="{{ url('/upload-file/'.$question->question_1) }}" type="audio/mp3">
                    <source src="{{ url('/upload-file/'.$question->question_1) }}" type="audio/ogg">
                    Your browser does not support the audio element.
                  </audio>
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" placeholder="Answer" />
                </div>
              </div>
              @php 
              $k++;
              @endphp
              @endforeach

          
        </div>
        <div class="output-1">
          <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
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
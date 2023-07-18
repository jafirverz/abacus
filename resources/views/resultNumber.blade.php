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
          <li><a href="{{ url('') }}">Preparatory Level</a></li>
          <li><strong>{{ $worksheet->title }}</strong></li> 
        </ul>
        <div class="box-1">
          {{ $worksheet->description }}
        </div>
       
        <div class="row grid-3">
          @php 
          $flag = 0;
          $questionns = \App\MiscQuestion::where('question_id', $questions->id)->get();
          $k=1;
          //$count = count($questionns->input_1);
          foreach($questionns as $question){
            $questionSub = \App\WorksheetQuestionSubmitted::where('misc_question_id', $question->id)->first();
            if($questionSub->question_answer != $questionSub->user_answer){
              $addClass = 'ans-wrong';
              $flag = 1;
            }else{
              $addClass = 'ans-right';
              $flag = 0;
            }
          @endphp
          <div class="col-md-4 col-6 sp-col">
            <div class="item">
              <div class="inner" style="height: 306.133px;">
                <div class="number">Q{{ $k }}</div>
                <figure>
                  <img src="{{ url('/upload-file/'.$question->question_1) }}" alt="" />
                </figure>
                @if($flag == 1)
                <div class="answer wrong">{{ $questionSub->user_answer }}</div>
                @endif
                <div class="answer">{{ $questionSub->question_answer }}</div>
                
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
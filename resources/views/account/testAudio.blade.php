@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="tempt-3">
    <div class="mb-20">
            <a class="link-1 lico" href="javascript::void(0)" onclick="window.history.go(-1); return false;"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <h1 class="title-3 mb-20">{{ $test->title }}</h1>
        {{-- <div class="title-11">Elementary I - Test</div> --}}
        <div class="box-1">
            <div class="row sp-col-20">
                <div class="col-xl-5 col-lg-6 col-sm-7 sp-col">
                    <label class="lb-1 mt-0">Name</label>
                    <input class="form-control inptype-1" type="text" value="{{ Auth::user()->name }}"  disabled placeholder="Michelle Tan"  />
                </div>
                <div class="col-lg-4 col-sm-5 sp-col">
                    <label class="lb-1 mt-0">Date</label>
                    <div class="date-wrap">
                        <i class="fa-solid fa-calendar-days ico"></i>
                        <input class="form-control inptype-1" type="text" placeholder="{{ date('Y-m-d') }}" disabled />
                    </div>
                </div>
            </div>
        </div>
        <form method="post" action="{{ route('test.answer.submit') }}">
            @csrf

            <input type="hidden" name="test_id" value="{{ $test->id }}">
            <input type="hidden" name="allocation_id" value="{{ $test->allocation_id }}">
            <input type="hidden" name="question_type" value="{{ $test->paper->question_template_id }}">
            @if($all_paper_detail)
            @foreach($all_paper_detail as $paper_detail)
            <input type="hidden" name="test_paper_question_id[]" value="{{ $paper_detail->id }}">
            <div class="row grid-5">
            @php

            $k=0;
            $i = 1;
            foreach($paper_detail->questionsCourse as $question){
            @endphp
                <div class="row sp-col-10 grow">
                  <input type="hidden" value="{{ $question->id }}">
                  <div class="col-auto sp-col"><strong>Q{{ $k }}</strong></div>
                  <div class="col-auto sp-col">
                    <button class="link-2" id="play_btn{{ $k }}" type="button" value="{{ $k }}" onclick="initAudioPlayer(this.value);"><i class="fa-solid fa-volume-high"></i></button>
                    <audio id="audio-{{ $k }}">
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
            $i++;
            $k++;
            }
            @endphp
            </div>
            @endforeach
            @endif

            <div class="output-1">
                <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
            </div>
        </form>
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

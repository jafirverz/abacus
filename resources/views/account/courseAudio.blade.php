@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
    @include('inc.account-sidebar-online')
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="javascript: history.go(1)"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <ul class="breadcrumb bctype">
                <li><a href="{{ url('online-student/my-course')}}">My Courses</a></li>
                <li><strong>{{ $test_paper->title ?? ''}}</strong></li>
         </ul>
         <div class="box-1">
                <h2 class="title-2">{{ $test_paper->title ?? ''}}</h2>
                <article class="document mt-20">
                    {!! $test_paper->description ?? '' !!}
                </article>
            </div>
            <div class="row sp-col-30 grid-7">
                <div class="col-lg-6 sp-col videowrap">
                    <video width="400" controls>
                        <source src="{{asset($test_paper->video_file)}}" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
                <div class="col-lg-6 sp-col countwrap">
                    <img src="{{asset($test_paper->powerpoint_file)}}" alt="" />
                </div>
            </div>   
            <form method="post" action="{{ route('course.answer.submit') }}">
            @csrf

            <input type="hidden" name="test_paper_question_id" value="{{ $paper_detail->id }}">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="question_type" value="{{ $course->paper->question_template_id }}">
        <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i class="icon-info"></i></button> <strong><a href="?s=1">Shuffle the Questions <i class="icon-shuffle"></i></a></strong></div>
        </div>
        <div class="row grid-4">

          
            <div class="col-xl-4 col-sm-6">
              <div class="inner">
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
                $k++;
                }

              @endphp
              </div>
            </div>
          

        </div>
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

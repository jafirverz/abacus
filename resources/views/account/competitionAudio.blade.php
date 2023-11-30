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
          <a class="link-1 lico" href="{{ URL::previous() }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <ul class="breadcrumb bctype">
          <li><a href="{{ url('home') }}">Overview</a></li>
          <li>{{ $compeTitle }}</li>
          <li><strong>{{ $compPaperTitle }}</strong></li>
        </ul>
        @if($compPaper->time)
          @php
          $timeinSec = $compPaper->time * 60 + 2;
          $today = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." + $timeinSec seconds"));
          $dateTime = strtotime($today);
          $getDateTime = date("F d, Y H:i:s", $dateTime); 
          @endphp
          <div class="timer-wrap">
            <div class="timer"><i class="icon-clock"></i> <strong>Timer: <div id="counter"> MM: SS </div></strong></div>
          </div>
        @endif
        <form method="post" enctype="multipart/form-data" action="{{ route('competition.submit') }}" id="submitform">
          @csrf
          <input type="hidden" name="paperId" value="{{ $compPaper->id }}">
          <input type="hidden" name="categoryId" value="{{ $compPaper->category_id }}">
          <input type="hidden" name="compId" value="{{ $compPaper->competition_controller_id }}">
          <input type="hidden" name="questionTemp" value="{{ $compPaper->question_template_id }}">
          <input type="hidden" name="paperType" value="{{ $compPaper->paper_type }}">
          <div class="row grid-4">
            @php
            $k=1;
            @endphp
            @foreach($questions as $question)
            <div class="col-xl-4 col-sm-6">
              <div class="inner">
                @php
                $questionnss = \App\CompetitionQuestions::where('competition_paper_id',
                $question->competition_paper_id)->where('block', $question->block)->get();
                @endphp
                @foreach($questionnss as $question)
                <div class="row sp-col-10 grow">
                  <div class="col-auto sp-col"><strong>Q{{ $k }}</strong></div>
                  <div class="col-auto sp-col">
                    <button class="link-2 play-wrap" id="play_btn{{ $k }}" type="button" value="{{ $k }}">
                      <!-- <i class="fa-solid fa-volume-high play" id="audio{{ $k }}" data-music_id="audio-{{ $k }}"></i> -->
                    </button>
                    <audio id="audio-{{ $k }}" controls controlsList="nodownload">
                      <source src="{{ url('/upload-file/'.$question->question_1) }}" type="audio/mp3">
                      <source src="{{ url('/upload-file/'.$question->question_1) }}" type="audio/ogg">
                      Your browser does not support the audio element.
                    </audio>
                  </div>
                  <div class="col sp-col">
                    <input class="form-control" type="text" name="answer[{{ $question->id }}]" placeholder="Answer" />
                  </div>
                </div>
                @php
                $k++;
                @endphp
                @endforeach
              </div>
            </div>
            @endforeach
          </div>

          <div class="output-1">
            <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
          </div>
        </form>


      </div>
</main>

@if($compPaper->paper_type == 'actual')

<script>
  var countDownTimer = new Date("{{ $getDateTime }}").getTime();
  // Update the count down every 1 second
  var interval = setInterval(function() {
      var current = new Date().getTime();
      // Find the difference between current and the count down date
      var diff = countDownTimer - current;
      // Countdown Time calculation for days, hours, minutes and seconds
      var days = Math.floor(diff / (1000 * 60 * 60 * 24));
      var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((diff % (1000 * 60)) / 1000);

      //document.getElementById("counter").innerHTML = days + "Day : " + hours + "h " +
      //minutes + "m " + seconds + "s ";
      document.getElementById("counter").innerHTML = minutes + "m " + seconds + "s ";
      // Display Expired, if the count down is over
      if (diff < 0) {
          clearInterval(interval);
          document.getElementById("counter").innerHTML = "EXPIRED";
      }
  }, 1000);
</script>

@else

<script>
  var countDownTimer = new Date("{{ $getDateTime }}").getTime();
  // Update the count down every 1 second
  var interval = setInterval(function() {
      var current = new Date().getTime();
      // Find the difference between current and the count down date
      var diff = countDownTimer - current;
      // Countdown Time calculation for days, hours, minutes and seconds
      var days = Math.floor(diff / (1000 * 60 * 60 * 24));
      var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((diff % (1000 * 60)) / 1000);

      //document.getElementById("counter").innerHTML = days + "Day : " + hours + "h " +
      //minutes + "m " + seconds + "s ";
      document.getElementById("counter").innerHTML = minutes + "m " + seconds + "s ";
      // Display Expired, if the count down is over
      if (diff < 0) {
          clearInterval(interval);
          document.getElementById("counter").innerHTML = "EXPIRED";
          $('form#submitform').submit();
      }
  }, 1000);
</script>

@endif

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

  // function initAudioPlayer(val) {
  //   var audio = new Audio();
  //   var aContainer = document.getElementById("audio-" + val);
  //   // assign the audio src
  //   audio.src = aContainer.querySelectorAll('source')[0].getAttribute('src');
  //   audio.load();
  //   audio.loop = false;
  //   audio.play();

  //   var playbtn = document.getElementById("play_btn" + val);

  //   playbtn.addEventListener("click", playPause(audio, playbtn));
  // }

  // function playPause(audio, playbtn) {
  //   return function () {
  //     if (audio.paused) {
  //       audio.play();
  //       $('.link-2').html('<i class="bi bi-pause"></i>')
  //     } else {
  //       audio.pause();
  //       $('.link-2').html('<i class="fa-solid fa-volume-high"></i>')
  //     }
  //   }
  // }

</script>


@endsection
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
        <div class="box-1">
            {!! $compPaper->description !!}
        </div>
        @if($compPaper->time)
        <div class="timer-wrap">
          <div class="timer"><i class="icon-clock"></i> <strong>Timer: <span id="time"></span></strong></div>
        </div>
        @endif
        <form method="post" enctype="multipart/form-data" action="{{ route('grading.submit') }}" id="submitform">
          @csrf
          <input type="hidden" name="paperId" value="{{ $compPaper->id }}">
          <input type="hidden" name="categoryId" value="{{ $compPaper->category_id }}">
          <input type="hidden" name="compId" value="{{ $compPaper->grading_exam_id  }}">
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
                $questionnss = \App\GradingPaperQuestion::where('grading_paper_id',
                $question->grading_paper_id)->where('block', $question->block)->get();
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

          @if($compPaper->paper_type == 'actual')
          @else
          <div class="output-1">
            <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
          </div>
          @endif
        </form>



      </div>
</main>

@if($compPaper->paper_type == 'actual')
<script>
  function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
            $('form#submitform').submit();
        }
    }, 1000);
}
$(window).on('load', function() {
    var compTime = {{$compPaper->time}};
    var fiveMinutes = 60 * compTime;
    var display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
});

</script>
@else

<script>
  function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
            document.getElementById("time").innerHTML = "EXPIRED";
            //$('form#submitform').submit();
        }
    }, 1000);
}
$(window).on('load', function() {
    var compTime = {{$compPaper->time}};
    var fiveMinutes = 60 * compTime;
    var display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
});

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

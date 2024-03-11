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
          {{ $compPaper->description ?? '' }}
        </div>
        @if($compPaper->time)
        <div class="timer-wrap">
          <div class="timer"><i class="icon-clock"></i> <strong>Timer: <span id="time"></span></strong></div>
        </div>
        @endif
        <form id="submitform" method="post" enctype="multipart/form-data" action="{{ route('grading.submit') }}">
          @csrf
          <input type="hidden" name="paperId" value="{{ $compPaper->id }}">
          <input type="hidden" name="categoryId" value="{{ $compPaper->category_id }}">
          <input type="hidden" name="compId" value="{{ $compPaper->grading_exam_id  }}">
          <input type="hidden" name="questionTemp" value="{{ $compPaper->question_template_id }}">
          <input type="hidden" name="paperType" value="{{ $compPaper->paper_type }}">
          <div class="row grid-3">
            @php
            $k = 1;
            @endphp
            @foreach($questions as $key=>$question)
            <div class="col-md-4 col-6 sp-col">
              <div class="item">
                <div class="inner">
                  <div class="number">Q{{ $key+1 }}</div>
                  <figure>
                    <img src="{{ url('/upload-file/'.$question->question_1) }}" alt="" />
                  </figure>
                  <textarea class="form-control" cols="10" rows="3" placeholder="Answer"
                    name="answer[{{ $question->id }}]"></textarea>
                </div>
              </div>
            </div>
            @php
            $k++;
            @endphp
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
    </div>
  </div>
</main>

<script>


  // initAudioPlayer();

  function initAudioPlayer(val) {
    var audio = new Audio();
    // audio.pause();
    var aContainer = document.getElementById("audio-" + val);
    // assign the audio src
    audio.src = aContainer.querySelectorAll('source')[0].getAttribute('src');
    audio.load();
    audio.loop = false;
    audio.play();

    // Set object references
    var playbtn = document.getElementById("play_btn" + val);

    // Add Event Handling
    playbtn.addEventListener("click", playPause(audio, playbtn));
  }

  // Functions
  function playPause(audio, playbtn) {
    return function () {
      if (audio.paused) {
        audio.play();
        $('.link-2').html('<i class="bi bi-pause"></i>')
      } else {
        audio.pause();
        $('.link-2').html('<i class="fa-solid fa-volume-high"></i>')
      }
    }
  }

</script>
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
@endsection

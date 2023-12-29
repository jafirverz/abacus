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
          <li>{{ $categoryTitle }}</li>
          <li><strong>{{ $compPaperTitle }}</strong></li>
        </ul>
        <div class="box-1">
          {{ $compPaper->description ?? '' }}
        </div>
        @php 
        $datetime = new DateTime(date("Y-m-d H:i:s"));
        //echo $datetime->format('Y-m-d H:i:s') . "\n";
        $sg_time = new DateTimeZone('Asia/Singapore');
        $datetime->setTimezone($sg_time);
        //echo $datetime->format('Y-m-d H:i:s');
        $today1 = date("Y-m-d H:i:s", strtotime(gmdate("Y-m-d H:i:s")." + 8 hours"));
        @endphp
        @if($compPaper->time)
         @php
          $timeinSec = $compPaper->time * 60;
          $today = date("Y-m-d H:i:s", strtotime($today1." + $timeinSec seconds"));
          $dateTime = strtotime($today);
          //echo "-----";
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
  $(document).ready(function () {
  var countDownTimer = new Date("{{ $getDateTime }}").getTime();
  // Update the count down every 1 second
  var interval = setInterval(function() {
       var date = new Date();
    // Get the timezone the user has selected
    var timeZone = 'Asia/Singapore';
    var time = date.toLocaleString('en-US', { timeZone  });
      var current = new Date(time).getTime();
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
  });
</script>
@else

<script>
  $(document).ready(function () {
  var countDownTimer = new Date("{{ $getDateTime }}").getTime();
  // Update the count down every 1 second
  var interval = setInterval(function() {
      var date = new Date();
    // Get the timezone the user has selected
    var timeZone = 'Asia/Singapore';
    var time = date.toLocaleString('en-US', { timeZone  });
      var current = new Date(time).getTime();
      //alert(time);
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
          //$('form#submitform').submit();
      }
  }, 1000);
  });
</script>

@endif
@endsection
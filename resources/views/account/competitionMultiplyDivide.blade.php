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
        <!-- <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i class="icon-info"></i></button> <strong><a href="#">Shuffle the Questions <i class="icon-shuffle"></i></a></strong></div>
        </div> -->
        @php 
        $datetime = new DateTime(date("Y-m-d H:i:s"));
        //echo $datetime->format('Y-m-d H:i:s') . "\n";
        $sg_time = new DateTimeZone('Asia/Kolkata');
        $datetime->setTimezone($sg_time);
        //echo $datetime->format('Y-m-d H:i:s');
        @endphp
        @if($compPaper->time)
         @php
          $timeinSec = $compPaper->time * 60;
          $today = date("Y-m-d H:i:s", strtotime($datetime->format('Y-m-d H:i:s')." + $timeinSec seconds"));
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
          <div class="box-1">
            <div class="xscrollbar">
              <table class="tb-2 tbtype-1">
                <thead>
                  <tr>
                    <th class="wcol-1 text-center">NO</th>
                    <th class="wcol-4 text-center">Division</th>
                    <th>Answer</th>
                  </tr>
                </thead>
                <tbody>
                  @php 
                  $i = 1;
                  @endphp
                  @foreach($questions as $ques)
                  @php
                  if($ques->symbol == 'multiply'){
                    $symbol='x';
                  }else{
                    $symbol='÷';
                  }
                  @endphp
                  <tr>
                    <td class="colnumber">{{ $i }}</td>
                    <td class="text-center">{{ $ques->question_1 }} {{ $symbol }} {{ $ques->question_2 }}  =</td>
                    <td class="colanswer"><input class="form-control number-separator" type="text" name="answer[{{ $ques->id }}]" /></td>
                  </tr>
                  @php 
                  $i++;
                  @endphp
                  @endforeach
                  
                </tbody>
              </table>
            </div>
          </div>
          <div class="output-1">
            <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
          </div>
        </form>
    </div>
  </div>	
  </div>
</main>

<script src="https://cdn.jsdelivr.net/gh/amiryxe/easy-number-separator/easy-number-separator.js"></script>
<script>
  $(function () {
    easyNumberSeparator({
      selector: '.number-separator',
      separator: ',',
      //resultInput: '.number-separator',
    })
  });
  
</script>

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

@if($compPaper->paper_type == 'actual')

<script>
$(document).ready(function () {

  var countDownTimer = new Date("{{ $getDateTime }}").getTime();
  // Update the count down every 1 second
  var interval = setInterval(function() {
    var date = new Date();
    // Get the timezone the user has selected
    //var timeZone = 'Asia/Singapore';
    var timeZone = 'Asia/Kolkata';
    var time = date.toLocaleString('en-IN', { timeZone  });
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
    //var timeZone = 'Asia/Singapore';
    var timeZone = 'Asia/Kolkata';
    var time = date.toLocaleString('en-IN', { timeZone  });
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
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
          {{ $compPaper->description }}
        </div>
        <!-- <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip"
              data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i
                class="icon-info"></i></button> <strong><a href="#">Shuffle the Questions <i
                  class="icon-shuffle"></i></a></strong></div>
        </div> -->

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

        <form method="post" enctype="multipart/form-data" action="{{ route('competition.submit') }}">
          @csrf
          <input type="hidden" name="paperId" value="{{ $compPaper->id }}">
          <input type="hidden" name="categoryId" value="{{ $compPaper->category_id }}">
          <input type="hidden" name="compId" value="{{ $compPaper->competition_controller_id }}">
          <input type="hidden" name="questionTemp" value="{{ $compPaper->question_template_id }}">
          <input type="hidden" name="paperType" value="{{ $compPaper->paper_type }}">
          <div class="row grid-5">
            @php
            $k = 1;
            $i = 1;
            @endphp
            @foreach($questions as $question)
            <div class="col-lg-4 col-md-6">
              <div class="inner">
                <strong class="number">Q{{ $i }}</strong>
                <div class="vdwrap">
                  <video controls width="400">
                    <source src="{{ url('/upload-file/'.$question->question_1) }}" type="video/mp4">
                    Your browser does not support HTML video.
                  </video>
                  <!-- <a class="link-fix" data-fancybox href="{{ url('/upload-file/'.$question->question_1) }}"><i
                      class="fa-solid fa-play"></i></a> -->
                </div>
                <textarea class="form-control" rows="3" cols="30" name="answer[{{ $question->id }}]"
                  placeholder="Answer"></textarea>
              </div>
            </div>
            @php
            $k++;
            $i++;
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
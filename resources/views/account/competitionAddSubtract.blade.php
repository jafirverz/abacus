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
          <li><a href="{{ url('') }}">Preparatory Level</a></li>
        </ul>
        <div class="box-1">
          {{-- $worksheet->description --}}
        </div>
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
          <div class="box-1">
            <div class="xscrollbar">
              <table class="tb-2 tbtype-1">
                <thead>
                  <tr>
                    <th class="wcol-1 text-center">NO</th>
                    <th class="wcol-2 text-center">Add/Subtract</th>
                    <th>Answer</th>
                  </tr>
                </thead>
                <tbody>
                  @php 
                  $i = 1;
                  @endphp
                  @foreach($questions as $ques)
                  @php
                  if($ques->symbol == 'add'){
                    $symbol='+';
                  }else{
                    $symbol='-';
                  }
                  @endphp
                  <tr>
                    <td class="colnumber">{{ $i }}</td>
                    <td class="text-center">{{ $ques->question_1 }} {{ $symbol }} {{ $ques->question_2 }}  =</td>
                    <td class="colanswer"><input class="form-control" type="number" name="answer[{{ $ques->id }}]" /></td>
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
@endsection
@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
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
          <li><a href="{{ URL::previous() }}">{{ $level->title }}</a></li>
          <li><strong>{{ $worksheet->title }}</strong></li>
        </ul>
        <div class="box-1">
          {{ $worksheet->description }}
        </div>

        @php
        $checkOrderDetails = '';
        $checkOrder = \App\Order::where('user_id', Auth::user()->id)->pluck('id')->toArray();
        if($checkOrder){
        $checkOrderDetails = \App\OrderDetail::whereIn('order_id', $checkOrder)->where('level_id', $level->id)->first();
        if($checkOrderDetails){
        $url = '?s=1';
        }else{
        $url = 'javascript::void(0)';
        }

        }else{
        $url = 'javascript::void(0)';
        }

        @endphp

        <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip"
              data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i
                class="icon-info"></i></button> <strong><a href="{{ $url }}" disabled>Shuffle the Questions <i
                  class="icon-shuffle"></i></a></strong></div>
        </div>

        @php 
        $datetime = new DateTime(date("Y-m-d H:i:s"));
        //echo $datetime->format('Y-m-d H:i:s') . "\n";
        $sg_time = new DateTimeZone('Asia/Kolkata');
        $datetime->setTimezone($sg_time);
        //echo $datetime->format('Y-m-d H:i:s');
        @endphp

        @if($worksheet->timing)
          @php
          $timeinSec = $worksheet->timing * 60;
          //$today = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." + $timeinSec seconds"));
          $today = date("Y-m-d H:i:s", strtotime($datetime->format('Y-m-d H:i:s')." + $timeinSec seconds"));
          $dateTime = strtotime($today);
          $getDateTime = date("F d, Y H:i:s", $dateTime); 
          @endphp
          <div class="timer-wrap">
            <div class="timer"><i class="icon-clock"></i> <strong>Timer: <div id="counter"> MM: SS </div></strong></div>
          </div>
        @endif


        <form method="post" action="{{ route('answer.submit') }}">
          @csrf
          <input type="hidden" name="worksheetId" value="{{ $questions->worksheet_id }}">
          <input type="hidden" name="levelId" value="{{ $level->id }}">
          <input type="hidden" name="questionTypeId" value="{{ $questions->question_type }}">
          <div class="box-1">
            <div class="xscrollbar">
              <table class="tb-2 tbtype-2">
                <thead>
                  <tr>
                    <th class="wcol-2"></th>
                    @php
                    if(isset($_GET['s']) && $_GET['s'] == 1){
                    $questionns = \App\MiscQuestion::where('question_id', $questions->id)->inRandomOrder()->get();
                    }else{
                    $questionns = \App\MiscQuestion::where('question_id', $questions->id)->get();
                    }

                    $count = count($questionns);
                    $i = 1;
                    foreach($questionns as $question){
                    @endphp
                    <th class="text-center">{{ $i }}</th>
                    @php
                    $i++;
                    }
                    @endphp
                  </tr>
                </thead>
                <tbody>

                  <tr>
                    <td></td>
                    @php
                    foreach($questionns as $question){
                    @endphp
                    <td>
                      @php
                      $arrVal = explode('|', $question->question_1);
                      foreach($arrVal as $val){
                      @endphp
                      <div class="row sp-col-5 inrow-1">
                        <!-- <div class="col-auto sp-col">$</div> -->
                        <div class="col sp-col">{{ $val }}</div>
                      </div>
                      @php
                      }
                      @endphp
                    </td>
                    @php
                    }
                    @endphp

                  </tr>

                </tbody>
                <tfoot>
                  <tr>
                    <td class="lb">Answer</td>
                    @php
                    foreach($questionns as $question){
                    @endphp
                    <td class="coltype">
                      <div class="row sp-col-5 inrow-1">
                        <!-- <div class="col-auto sp-col">$</div> -->
                        <div class="col colanswer sp-col"><input class="form-control number-separator" type="text"
                            value="" id="ans{{ $question->id }}" name="answer[{{ $question->id }}]" /></div>
                      </div>
                    </td>
                    @php
                    }
                    @endphp
                  </tr>
                </tfoot>
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

@if(empty($worksheet->preset_timing) && !empty($worksheet->timing))

<script>
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
          $('form#submitform').submit();
      }
  }, 1000);
</script>


@elseif($worksheet->timing && !empty($worksheet->preset_timing))
<script>
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
      }
  }, 1000);
</script>
@endif


@endsection
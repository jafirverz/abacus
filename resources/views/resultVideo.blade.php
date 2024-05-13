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
          <a class="link-1 lico" href="{{ url('level/'.$level->slug) }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <ul class="breadcrumb bctype">
          <li><a href="{{ url('home') }}">Overview</a></li>
          <li><a href="{{ url('level/'.$level->slug) }}">{{ $level->title }}</a></li>
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
        
        
        
        
        
        <div class="row grid-5">
          <input type="hidden" name="worksheetId" value="{{ $questions->worksheet_id }}">
          <input type="hidden" name="levelId" value="{{ $level->id }}">
          <input type="hidden" name="questionTypeId" value="{{ $questions->question_type }}">
          @php 
          if(isset($_GET['s']) && $_GET['s'] == 1){
            $questionns = \App\MiscQuestion::where('question_id', $questions->id)->inRandomOrder()->get();
          }else{
            $questionns = \App\MiscQuestion::where('question_id', $questions->id)->get();
          }
          //$questionns = \App\MiscQuestion::where('question_id', $questions->id)->get();
          //$count = count($questionns->input_1);
          $k=0;
          $i = 1;
          foreach($questionns as $question){
            $questionnsCheck = \App\WorksheetQuestionSubmitted::where('misc_question_id', $question->id)->where('worksheet_submitted_id', $worksheetSubmittedId)->first();
          @endphp
          <div class="col-lg-4 col-md-6">
            <div class="inner">
              <strong class="number">Q{{ $i }}</strong>
              <div class="vdwrap">
                <video controls width="400" controlsList="nodownload">
                  <source src="{{ url('/upload-file/'.$question->question_1) }}" type="video/mp4">
                  Your browser does not support HTML video.
                </video>
                <!--<a class="link-fix" data-fancybox href="{{ url('/upload-file/'.$question->question_1) }}"><i class="fa-solid fa-play"></i></a>-->
              </div>
              @if($questionnsCheck->question_answer == $questionnsCheck->user_answer)
              <div class="answer-true">
                <span>{{ $questionnsCheck->user_answer }}</span>
                <i class="fa-solid fa-circle-check"></i>
              </div>
              @else
              <div class="answer-false">
                <span class="ansfalse">{{ $questionnsCheck->user_answer }}</span>
                <!-- <strong>{{ $questionnsCheck->question_answer }}</strong> -->
                <i class="fa-solid fa-circle-xmark"></i>
              </div>
              @endif
            </div>
          </div>
          @php
          $i++;
          $k++;
          }
          @endphp
          
          
        </div>


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
    var compTime = {{$worksheet->timing}};
    var fiveMinutes = 60 * compTime;
    var display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
});

</script>
@elseif($worksheet->timing && !empty($worksheet->preset_timing))

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
    var compTime = {{$worksheet->timing}};
    var fiveMinutes = 60 * compTime;
    var display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
});

</script>


@endif

@endsection
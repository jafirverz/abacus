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
                      $questionns = \App\MiscQuestion::where('question_id', $questions->id)->where('symbol', 'vertical')->inRandomOrder()->get();
                    }else{
                      $questionns = \App\MiscQuestion::where('question_id', $questions->id)->where('symbol', 'vertical')->get();
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
                    <th></th>
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
                      $questionnsCheck = \App\WorksheetQuestionSubmitted::where('misc_question_id', $question->id)->where('worksheet_submitted_id', $worksheetSubmittedId)->first();
                      @endphp
                      @if($questionnsCheck->question_answer != $questionnsCheck->user_answer)
                      <td class="coltype answer-false">
                        <div class="row sp-col-5 inrow-1">
                          <!-- <div class="col-auto sp-col">$</div> -->
                          <div class="col colanswer sp-col"><span class="ansfalse">{{ $questionnsCheck->user_answer }}</span></div>
                        </div>
                        <i class="fa-solid fa-circle-xmark"></i>
                        <div class="row sp-col-5 inrow-1">
                          <!-- <div class="col-auto sp-col">$</div> -->
                          <!-- <div class="col colanswer sp-col">{{ $questionnsCheck->question_answer }}</div> -->
                        </div>
                      </td>
                      @else
                      <td class="coltype answer-true">
                        <div class="row sp-col-5 inrow-1">
                          <!-- <div class="col-auto sp-col">$</div> -->
                          <div class="col colanswer sp-col">{{ $questionnsCheck->user_answer }}</div>
                        </div>
                          <i class="fa-solid fa-circle-check"></i>
                      </td>
                      @endif
                    @php
                  }
                  @endphp
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>

          <div class="box-1">
            <!-- <div class="note-3 mb-20">Sections 2 &amp; 3: Each question is worth 1 mark for each correct answer.</div> -->
            <div class="xscrollbar">
              <table class="tb-2 tbtype-1">
                <thead>
                  <tr>
                    <th class="wcol-1 text-center">NO</th>
                    <th class="wcol-4 text-center">Questions</th>
                    <th>Answer</th>
                  </tr>
                </thead>
                <tbody>
                  @php 
                  //$questionns = json_decode($questions->json_question);
                  $getQues = \App\MiscQuestion::where('question_id', $questions->id)->where('symbol', '!=', 'vertical')->get();
                  $i = 1;
                  @endphp
                  
                  @foreach($getQues as $ques)
                  @php
                  $questionnsCheck = \App\WorksheetQuestionSubmitted::where('misc_question_id', $ques->id)->where('worksheet_submitted_id', $worksheetSubmittedId)->first();
                  if($ques->symbol == 'add'){
                    $symbol = '+';
                  }elseif($ques->symbol == 'multiply'){
                    $symbol = 'x';
                  }elseif($ques->symbol == 'divide'){
                    $symbol = '÷';
                  }elseif($ques->symbol == 'subtract'){
                    $symbol = '-';
                  }
                  @endphp
                  <tr>
                    <td class="colnumber">{{ $i }}</td>
                    <td class="text-center">{{ $ques->question_1 }} {{ $symbol }} {{ $ques->question_2 }}  =</td>
                    @if($questionnsCheck->question_answer == $questionnsCheck->user_answer)
                    <td class="colanswer answer-true">
                      <span>{{ $questionnsCheck->user_answer }}</span>
                      <i class="fa-solid fa-circle-check"></i>
                    </td>
                    @else
                    <td class="colanswer answer-false">
                      <span class="ansfalse">{{ $questionnsCheck->user_answer }}</span>
                      <!-- <strong>{{ $questionnsCheck->question_answer }}</strong> -->
                      <i class="fa-solid fa-circle-xmark"></i>
                    </td>
                    @endif
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
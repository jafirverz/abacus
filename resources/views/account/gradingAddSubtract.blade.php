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
          <div class="box-1">
            <div class="xscrollbar">
              <table class="tb-2 tbtype-2">
                <thead>
                  <tr>
                    <th class="wcol-2"></th>

                    @php
                    //if(isset($_GET['s']) && $_GET['s'] == 1){
                    //$questionns = \App\MiscQuestion::where('question_id', $questions->id)->inRandomOrder()->get();
                    //}else{
                    //$questionns = \App\MiscQuestion::where('question_id', $questions->id)->get();
                    //}

                    //$count = count($questionns);
                    $i = 1;
                    foreach($questions as $question){
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
                    foreach($questions as $question){
                    @endphp
                    <td>
                      @php
                      $arrVal = explode('|', $question->question_1);
                      foreach($arrVal as $val){
                      @endphp
                      <div class="row sp-col-5 inrow-1">
                        <!-- <div class="col-auto sp-col">$</div> -->
                        <div class="col sp-col">{{ number_format($val) }}</div>
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
                    foreach($questions as $question){
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

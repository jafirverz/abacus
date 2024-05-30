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
        <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip"
              data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i
                class="icon-info"></i></button> <strong><a href="#">Shuffle the Questions <i
                  class="icon-shuffle"></i></a></strong></div>
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
          <input type="hidden" name="compId" value="{{ $compPaper->grading_exam_id }}">
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
                  <video controls width="400"  controlsList="nodownload">
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

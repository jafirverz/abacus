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
        <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i class="icon-info"></i></button> <strong><a href="#">Shuffle the Questions <i class="icon-shuffle"></i></a></strong></div>
        </div>
        <form method="post" enctype="multipart/form-data" action="{{ route('grading.submit') }}">
          @csrf
          <input type="hidden" name="paperId" value="{{ $compPaper->id }}">
          <input type="hidden" name="categoryId" value="{{ $compPaper->category_id }}">
          <input type="hidden" name="compId" value="{{ $compPaper->grading_exam_id }}">
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
                            <div class="col-auto sp-col"></div>
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
          <div class="box-1">
            <div class="xscrollbar">
              <table class="tb-2 tbtype-1">
                <thead>
                  <tr>
                    <th class="wcol-1 text-center">NO</th>
                    <th class="wcol-4 text-center">Question</th>
                    <th>Answer</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i = 1;
                  @endphp
                  @foreach($questions_divide as $ques)
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
@endsection

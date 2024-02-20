@extends('layouts.app')
@section('content')


<main class="main-wrap">
    <div class="tempt-3">
        <div class="mb-20">
            <a class="link-1 lico" href="javascript::void(0)" onclick="window.history.go(-1); return false;"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <h1 class="title-3 mb-20">{{ $test->title }}</h1>
        {{-- <div class="title-11">Elementary I - Test</div> --}}
        <div class="box-1">
            <div class="row sp-col-20">
                <div class="col-xl-5 col-lg-6 col-sm-7 sp-col">
                    <label class="lb-1 mt-0">Name</label>
                    <input class="form-control inptype-1" type="text" value="{{ Auth::user()->name }}"  disabled placeholder="Michelle Tan"  />
                </div>
                <div class="col-lg-4 col-sm-5 sp-col">
                    <label class="lb-1 mt-0">Date</label>
                    <div class="date-wrap">
                        <i class="fa-solid fa-calendar-days ico"></i>
                        <input class="form-control inptype-1" type="text" placeholder="{{ date('Y-m-d') }}" disabled />
                    </div>
                </div>
            </div>
        </div>
        <form method="post" action="{{ route('test.answer.submit') }}">
            @csrf
            <input type="hidden" name="allocation_id" value="{{ $test->allocation_id }}">
            <input type="hidden" name="test_id" value="{{ $test->id }}">
            <input type="hidden" name="question_type" value="{{ $test->paper->question_template_id }}">
            @if($all_paper_detail)
            @foreach($all_paper_detail as $paper_detail)
            <input type="hidden" name="test_paper_question_id[]" value="{{ $paper_detail->id }}">
            <div class="box-1">
                <div class="note-4 mb-20">A. {{ $paper_detail->question }}</div>
                <div class="xscrollbar">
                    <table class="tb-2 tbtype-1">
                        <thead>
                            <tr>
                              <th class="wcol-1 text-center">NO</th>
                              <th class="wcol-2 text-center">Question</th>
                              <th>Answer</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                            $getQues = \App\TestPaperQuestionDetail::where('test_paper_question_id', $paper_detail->id)->get();
                            $i = 1;
                            @endphp

                            @foreach($getQues as $ques)
                            @php
                            if($ques->input_3 == 'add'){
                              $symbol = '+';
                            }elseif($ques->input_3 == 'multiply'){
                              $symbol = '*';
                            }elseif($ques->input_3 == 'divide'){
                              $symbol = '/';
                            }elseif($ques->input_3 == 'subtract'){
                              $symbol = '-';
                            }
                            @endphp
                            <tr>
                              <td class="colnumber">{{ $i }}</td>
                              <td class="text-center">{{ $ques->input_1 }} {{ $symbol }} {{ $ques->input_2 }}  =</td>
                              <td class="colanswer"><input class="number-separator form-control" name="answer[{{ $ques->id }}]" type="text" /></td>
                            </tr>
                            @php
                            $i++;
                            @endphp
                            @endforeach

                          </tbody>
                    </table>
                </div>
            </div>
            @endforeach
            @endif
            <div class="output-1">
                <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
            </div>
        </form>
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

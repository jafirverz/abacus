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
                <a class="link-1 lico" href="be-overview-elementary.html"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
            </div>
            <ul class="breadcrumb bctype">
                <li><a href="{{ url('grading-overview') }}">Grading Overview</a></li>
                <li><strong>{{ $paper->title }}</strong></li>
            </ul>
            <div class="box-1 mb-30">
                {!! $gradingExam->important_note !!}
            </div>
            <div class="box-3">
                <div class="row title-wrap-1">
                    <div class="col-xl-8 col-md-7">
                        <h1 class="title-1">{{ $gradingExam->title }}</h1>
                    </div>
                    <div class="col-xl-4 col-md-5 lastcol">
                        <a class="btn-2" href="example.pdf" target="_blank">Download Sample PDF</a>
                    </div>
                </div>
                <div class="xscrollbar">
                    <form method="post" action="{{ route('grading_answer.submit') }}">
                        @csrf
                        <input type="hidden" name="grading_exam_id" value="{{ $grading_exam_id }}">
                        <input type="hidden" name="listing_id" value="{{ $listing_id }}">
                        <input type="hidden" name="paper_id" value="{{ $paper->listing_paper_id }}">
                        <input type="hidden" name="question_type" value="{{ $paper->question_type }}">
                        <table class="tb-2 tbtype-1">
                            <thead>
                                <tr>
                                    <th class="wcol-1 text-center">NO</th>
                                    <th class="wcol-2 text-center">Multiplication</th>
                                    <th class="wcol-3 text-center">Answer</th>
                                    <th>Correction</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                @endphp
                                @foreach($paper->questionsGrade as $ques)
                                    @if($ques->input_3=='multiply')
                                    @php
                                    $operator='x';
                                    @endphp
                                    @else
                                    @php
                                    $operator='÷';
                                    @endphp
                                    @endif
                                    <tr>
                                        <td class="colnumber">{{ $i }}</td>
                                        <td class="text-center">{{ $ques->input_1 }} {{ $operator }} {{ $ques->input_2 }}  =</td>
                                        <td class="colanswer"><input class="form-control" type="number" name="answer[{{ $ques->id }}]" /></td>
                                        <td><input class="form-control" type="number" /></td>
                                    </tr>
                                    @php
                                    $i++;
                                    @endphp
                                @endforeach

                            </tbody>
                        </table>
                        <div class="output-1">
                            <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>

  </div>
</main>

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


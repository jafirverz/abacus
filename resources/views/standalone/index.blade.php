@extends('layouts.app')
@section('content')

<main class="main-wrap">	
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      <div class="menu-aside">
        @if(Auth::user()->user_type_id == 3)
        @include('inc.account-sidebar-online')
      @endif
      </div>
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="#"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>								
        <h1 class="title-3">{{ $standalonePage->title }}</h1>
        <div>{!! $standalonePage->description !!}</div>
        <div class="row sp-col-20">
          <div class="col-xl-6 col-md-5 sp-col mt-30 order-md-last">
            <iframe src="https://3gabacus.com/interactive_abacus_frame/" width="500px"></iframe>
          </div>
          <div class="col-xl-6 col-md-7 sp-col order-md-first">

            @if($standalonePage->questions)
              @foreach($standalonePage->questions as $questions)
                @if($questions->question_template_id == 4)
                @php 
                $questi = \App\StandaloneQuestions::where('question_template_id', $questions->question_template_id)->get();
                $countQ = count($questi);
                @endphp
                <div class="xscrollbar mt-30">
                  <table class="tb-2 tbtype-5">
                    <thead>
                      <tr>
                        <th class="wcol-1 text-center"></th>
                        @for($i = 1; $i <= $countQ; $i++)
                        <th class="text-center">{{ $i }}</th>
                        @endfor
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        @foreach($questi as $ques)
                        @php 
                        $explo = explode(',', $ques->question_1);
                        $m = 0;
                        @endphp
                        <td>
                          @for($m=0; $m < count($explo); $m++)
                          <div class="row sp-col-5 inrow-1">
                            <div class="col sp-col">{{ $explo[$m] }}</div>
                          </div>
                          @endfor
                          
                        </td>
                        @endforeach
                        
                        
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td class="lbtb-1">Your<br/>Answer:</td>
                        @for($i = 1; $i <= $countQ; $i++)
                        <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" /></td>
                        @endfor
                        
                      </tr>
                    </tfoot>
                  </table>
                </div>
                @endif

                @if($questions->question_template_id == 5 || $questions->question_template_id == 6 || $questions->question_template_id == 7)
                @php 
                $questi = \App\StandaloneQuestions::where('question_template_id', $questions->question_template_id)->get();
                @endphp
                <div class="xscrollbar">
                  <table class="tb-2 tbtype-1">
                    <thead>
                      <tr>
                        <th class="wcol-1 text-center">NO</th>
                        <th class="wcol-2 text-center">Numbers</th>
                        <th>Answer</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php 
                      $k = 1;
                      @endphp
                      @foreach($questi as $ques)
                      @php
                      $symbol = '';
                      if($ques->symbol == 'multiply'){
                        $symbol = '*';
                      }elseif($ques->symbol == 'add'){
                        $symbol = '+';
                      }elseif($ques->symbol == 'subtract'){
                        $symbol = '-';
                      }elseif($ques->symbol == 'divide'){
                        $symbol = '÷';
                      }
                      @endphp
                      <tr>
                        <td class="colnumber">{{ $k }}</td>
                        <td class="text-center">{{ $ques->question_1 }} {{ $symbol }} {{ $ques->question_2 }}  =</td>
                        <td class="colanswer"><input class="form-control" type="number" /></td>
                      </tr>
                      @php 
                      $k++;
                      @endphp
                      @endforeach
                      
                    </tbody>
                  </table>
                </div>
                @endif
              @endforeach
            
            @endif

          </div>
        </div>
        <div class="output-1 mt-50">
          <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
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
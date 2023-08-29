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
                class="icon-info"></i></button> <strong><a href="{{ $url }}">Shuffle the Questions <i
                  class="icon-shuffle"></i></a></strong></div>
        </div>
        <form method="post" action="{{ route('answer.submit') }}">
          @csrf
          <div class="row grid-4">
            <input type="hidden" name="worksheetId" value="{{ $questions->worksheet_id }}">
            <input type="hidden" name="levelId" value="{{ $level->id }}">
            <input type="hidden" name="questionTypeId" value="{{ $questions->question_type }}">
            @php
            $k=1;
            if(isset($_GET['s']) && $_GET['s'] == 1){
            $questionns = \App\MiscQuestion::where('question_id',
            $questions->id)->groupBy('block')->inRandomOrder()->get();
            }else{
            $questionns = \App\MiscQuestion::where('question_id', $questions->id)->groupBy('block')->get();
            }
            //$questionns = \App\MiscQuestion::where('question_id', $questions->id)->groupBy('block')->get();
            foreach($questionns as $questionn){
            @endphp
            <div class="col-xl-4 col-sm-6">
              <div class="inner">
                @php
                $questionnss = \App\MiscQuestion::where('question_id', $questions->id)->where('block',
                $questionn->block)->get();

                foreach($questionnss as $question){
                @endphp
                <div class="row sp-col-10 grow">
                  <input type="hidden" value="{{ $question->id }}">
                  <div class="col-auto sp-col"><strong>Q{{ $k }}</strong></div>
                  <div class="col-auto sp-col">
                    <button class="link-2 play-wrap" id="play_btn{{ $k }}" type="button" value="{{ $k }}">
                      <i class="fa-solid fa-volume-high play" id="audio{{ $k }}" data-music_id="audio-{{ $k }}"></i>
                    </button>
                    <audio id="audio-{{ $k }}">
                      <source src="{{ url('/upload-file/'.$question->question_1) }}" type="audio/mp3">
                      <source src="{{ url('/upload-file/'.$question->question_1) }}" type="audio/ogg">
                      Your browser does not support the audio element.
                    </audio>
                  </div>
                  <div class="col sp-col">
                    <input class="form-control" type="text" name="answer[{{ $question->id }}]" required
                      placeholder="Answer" />
                  </div>
                </div>

                @php
                $k++;
                }

                @endphp
              </div>
            </div>
            @php
            }
            @endphp

          </div>
          <div class="output-1">
            <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
          </div>
        </form>

      </div>
</main>

<script>

  jQuery(document).ready(function ($) {
    $(".play").click(function () {
      var music_id = $(this).data('music_id');
      var audio = document.getElementById(music_id);
      var test = music_id.split("-");
      var iclass = 'audio'+test[1];
      //alert(music_id);
      if (audio.paused) {
        audio.play();
        $(this).removeClass('fa-solid fa-volume-high')
        $(this).addClass('fa fa-pause')
      } else {
        audio.pause();
        //audio.currentTime = 0
        $(this).removeClass('fa fa-pause')
        $(this).addClass('fa-solid fa-volume-high')
      }
    });
  });

// function initAudioPlayer(val){
//   document.getElementById("play_btn"+val).addEventListener("click", function(){
//     var audio = document.getElementById("audio-"+val);
//     if(this.className == 'is-playing'){
//       this.className = "";
//       this.innerHTML = "Play"
//       audio.pause();
//     }else{
//       this.className = "is-playing";
//       this.innerHTML = "Pause";
//       audio.play();
//     }

//   });
// }
  // initAudioPlayer();

    // function initAudioPlayer(val){
    //   var audio = new Audio();
    //   var aContainer = document.getElementById("audio-"+val);
    //   audio.src = aContainer.querySelectorAll('source')[0].getAttribute('src');
    //   audio.load();
    //   audio.loop = false;
    //   audio.play();

    //   var playbtn = document.getElementById("play_btn"+val);

    //     playbtn.addEventListener("click", playPause(audio, playbtn));
    //   }

    //   function playPause(audio, playbtn){
    //       return function () {
    //          if(audio.paused){
    //            audio.play();
    //            $('.link-2').html('<i class="bi bi-pause"></i>')
    //          } else {
    //            audio.pause();
    //            $('.link-2').html('<i class="fa-solid fa-volume-high"></i>')
    //          }
    //       }
    //   }

</script>
@endsection
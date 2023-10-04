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
        <div class="box-1 mb-30">
          {{ $worksheet->description }}
        </div>
        
        <div class="box-3">
          <div class="row title-wrap-1">
            <div class="col-xl-8 col-md-7">
              <h1 class="title-1">{{ $worksheet->title }}</h1>
            </div>
            <div class="col-xl-4 col-md-5 lastcol">
              <a class="btn-2" href="{{ asset($questions->link ?? '') }}" target="_blank">Download Sample PDF</a>
            </div>
          </div>
          <div class="xscrollbar">
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
                <tr>
                  <td class="colnumber">1</td>
                  <td class="text-center">21 x 9  =</td>
                  <td class="text-center"></td>
                  <td></td>
                </tr>
                <tr>
                  <td class="colnumber">2</td>
                  <td class="text-center">18 x 6  =</td>
                  <td class="text-center"></td>
                  <td></td>
                </tr>
                <tr>
                  <td class="colnumber">3</td>
                  <td class="text-center">30 x 8  =</td>
                  <td class="text-center"></td>
                  <td></td>
                </tr>
                <tr>
                  <td class="colnumber">4</td>
                  <td class="text-center">21 x 2  =</td>
                  <td class="text-center"></td>
                  <td></td>
                </tr>
                <tr>
                  <td class="colnumber">5</td>
                  <td class="text-center">42 x 7  =</td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                </tr>
                <tr>
                  <td class="colnumber">6</td>
                  <td class="text-center">66 ÷ 3  =</td>
                  <td class="text-center"></td>
                  <td></td>
                </tr>
                <tr>
                  <td class="colnumber">7</td>
                  <td class="text-center">22 ÷ 2  =</td>
                  <td class="text-center"></td>
                  <td></td>
                </tr>
                <tr>
                  <td class="colnumber">8</td>
                  <td class="text-center">704 ÷ 8  =</td>
                  <td class="text-center"></td>
                  <td></td>
                </tr>
                <tr>
                  <td class="colnumber">9</td>
                  <td class="text-center">320 ÷ 5  =</td>
                  <td class="text-center"></td>
                  <td></td>
                </tr>
                <tr>
                  <td class="colnumber">10</td>
                  <td class="text-center">369 ÷ 9  =</td>
                  <td class="text-center"></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
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
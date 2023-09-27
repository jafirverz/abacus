@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      @if(Auth::user()->user_type_id == 3)
      @include('inc.account-sidebar-online')
      @endif
      @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
      @include('inc.account-sidebar')
      @endif
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="{{ url('/') }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <ul class="breadcrumb bctype">
          <li><a href="{{ url('/') }}">Overview</a></li>
          <li><a href="{{ url('/level/'.$level->slug) }}">{{ $level->title }}</a></li>
          <li><strong>Scores</strong></li>
        </ul>
        <div class="box-1">
          {!! $page->content ?? '' !!}
        </div>
        <div class="box-1">
          <div class="row title-wrap-1">
            <div class="col-md-6">
              <h1 class="title-1">Leaderboard</h1>
              <!-- <div class="mt-10">From dd/mm/yyyy To dd/mm/yyyy</div> -->
            </div>
            <div class="col-md-6 lastcol">
              <label>Filter By:</label>
              <div class="selectwrap">
                <select class="selectpicker">
                  <option>Top 10</option>
                </select>
              </div>
            </div>
          </div>
          <div class="xscrollbar">
            <table class="tb-2 tbtype-3">
              <thead>
                <tr>
                  <th class="wcol-1 text-center">NO</th>
                  <th class="wcol-4">STUDENT NAME</th>
                  <th class="wcol-5 text-center">BEST SCORES</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($worksheetSubmitted as $key=>$studend)
                @php
                if($key <= 11){
                    break;
                }
                @endphp
                <tr>
                  <td class="colnumber">{{ $key+1 }}</td>
                  <td><em>{{ $studend->user->name }}</em></td>
                  <td class="text-center">{{ $studend->user_marks }}</td>
                  <td></td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-1">
          <div class="row">
            @php
            $loggedInUser = \App\WorksheetSubmitted::where('level_id', $levelid)->where('worksheet_id', $worksheetId)->where('question_template_id', 6)->where('user_id', Auth::user()->id)->orderBy('user_marks', 'desc')->first();

            $loggedInUserr = \App\WorksheetSubmitted::where('level_id', $levelid)->where('worksheet_id', $worksheetId)->where('question_template_id', 6)->orderBy('user_marks', 'desc')->get()->unique('user_id');
            foreach($loggedInUserr as $key=>$value){
              if($value->user_id == Auth::user()->id){
                $rank = $key+1;
              }
            }
            @endphp
            <div class="col-xl-3 col-lg-5 col-sm-6">
              <em>My Best Scores: {{ $loggedInUser->user_marks ?? 0 }}</em>
            </div>
            <div class="col-xl-9 col-lg-7 col-sm-6">
              <em>My Rank in Leaderboard: {{ $rank ?? 0 }}</em>
            </div>
          </div>
        </div>
        <div class="output-1">
          <a class="btn-1" href="{{ url('worksheet/'.$worksheetId.'/qId/6/lId/'.$levelid) }}">Start the Challenge <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>
        <div class="box-4 mt-30">
          <h4>Instruction</h4>
          {!! $page->instruction ?? '' !!}
        </div>

      </div>
    </div>
  </div>
</main>



<script>
  // initAudioPlayer();

  function initAudioPlayer(val) {
    var audio = new Audio();
    // audio.pause();
    var aContainer = document.getElementById("audio-" + val);
    // assign the audio src
    audio.src = aContainer.querySelectorAll('source')[0].getAttribute('src');
    audio.load();
    audio.loop = false;
    audio.play();

    // Set object references
    var playbtn = document.getElementById("play_btn" + val);

    // Add Event Handling
    playbtn.addEventListener("click", playPause(audio, playbtn));
  }

  // Functions
  function playPause(audio, playbtn) {
    return function() {
      if (audio.paused) {
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
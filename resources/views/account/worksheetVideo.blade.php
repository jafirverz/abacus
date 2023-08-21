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
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i class="icon-info"></i></button> <strong><a href="{{ $url }}">Shuffle the Questions <i class="icon-shuffle"></i></a></strong></div>
        </div>
        <form method="post" action="{{ route('answer.submit') }}">
          @csrf
        <div class="row grid-5">
          <input type="hidden" name="worksheetId" value="{{ $questions->worksheet_id }}">
          <input type="hidden" name="levelId" value="{{ $level->id }}">
          <input type="hidden" name="questionTypeId" value="{{ $questions->question_type }}">
          @php 
          if(isset($_GET['s']) && $_GET['s'] == 1){
            $questionns = \App\MiscQuestion::where('question_id', $questions->id)->inRandomOrder()->get();
          }else{
            $questionns = \App\MiscQuestion::where('question_id', $questions->id)->get();
          }
          //$questionns = \App\MiscQuestion::where('question_id', $questions->id)->get();
          //$count = count($questionns->input_1);
          $k=0;
          $i = 1;
          foreach($questionns as $question){
          @endphp
          <div class="col-lg-4 col-md-6">
            <div class="inner">
              <strong class="number">Q{{ $i }}</strong>
              <div class="vdwrap">
                <video width="400">
                  <source src="{{ url('/upload-file/'.$question->question_1) }}" type="video/mp4">
                  Your browser does not support HTML video.
                </video>
                <a class="link-fix" data-fancybox href="{{ url('/upload-file/'.$question->question_1) }}"><i class="fa-solid fa-play"></i></a>
              </div>
              <textarea class="form-control" rows="3" cols="30" name="answer[{{ $question->id }}]" placeholder="Answer"></textarea>
            </div>
          </div>
          @php
          $i++;
          $k++;
          }
          @endphp
          
          
        </div>
        <div class="output-1">
          <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
        </div>
      </form>

      </div>
    </div>
  </div>	
</main>
@endsection
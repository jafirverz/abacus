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
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i class="icon-info"></i></button> <strong><a href="{{ $url }}" disabled>Shuffle the Questions <i class="icon-shuffle"></i></a></strong></div>
        </div>
        <form method="post" action="{{ route('answer.submit') }}">
          @csrf
          <input type="hidden" name="worksheetId" value="{{ $questions->worksheet_id }}">
          <input type="hidden" name="levelId" value="{{ $level->id }}">
          <input type="hidden" name="questionTypeId" value="{{ $questions->question_type }}">
          <div class="box-1">
            <div class="xscrollbar">
              <table class="tb-2 tbtype-2">
                <thead>
                  <tr>
                    <th class="wcol-2"></th>
                    @php 
                    if(isset($_GET['s']) && $_GET['s'] == 1){
                      $questionns = \App\MiscQuestion::where('question_id', $questions->id)->where('symbol', 'vertical')->inRandomOrder()->get();
                    }else{
                      $questionns = \App\MiscQuestion::where('question_id', $questions->id)->where('symbol', 'vertical')->get();
                    }
                    
                    $count = count($questionns);
                    $i = 1;
                    foreach($questionns as $question){
                    @endphp
                    <th class="text-center">{{ $i }}</th>
                    @php
                    $i++;
                    }
                    @endphp
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  
                    <tr>
                      <td></td>
                      @php 
                    foreach($questionns as $question){
                    @endphp
                      <td>
                        @php
                        $arrVal = explode('|', $question->question_1);
                        foreach($arrVal as $val){
                        @endphp
                        <div class="row sp-col-5 inrow-1">
                          <!-- <div class="col-auto sp-col">$</div> -->
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
                    foreach($questionns as $question){
                      @endphp
                    <td class="coltype">
                      <div class="row sp-col-5 inrow-1">
                        <!-- <div class="col-auto sp-col">$</div> -->
                        <div class="col colanswer sp-col"><input class="form-control number-separator" type="text" name="answer[{{ $question->id }}]" /></div>
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
            <!-- <div class="note-3 mb-20">Sections 2 &amp; 3: Each question is worth 1 mark for each correct answer.</div> -->
            <div class="xscrollbar">
              <table class="tb-2 tbtype-1">
                <thead>
                  <tr>
                    <th class="wcol-1 text-center">NO</th>
                    <th class="wcol-4 text-center">Questions</th>
                    <th>Answer</th>
                  </tr>
                </thead>
                <tbody>
                  @php 
                  //$questionns = json_decode($questions->json_question);
                  $getQues = \App\MiscQuestion::where('question_id', $questions->id)->where('symbol', '!=', 'vertical')->get();
                  $i = 1;
                  @endphp
                  
                  @foreach($getQues as $ques)
                  @php
                  if($ques->symbol == 'add'){
                    $symbol = '+';
                  }elseif($ques->symbol == 'multiply'){
                    $symbol = 'x';
                  }elseif($ques->symbol == 'divide'){
                    $symbol = '÷';
                  }elseif($ques->symbol == 'subtract'){
                    $symbol = '-';
                  }
                  @endphp
                  <tr>
                    <td class="colnumber">{{ $i }}</td>
                    <td class="text-center">{{ $ques->question_1 }} {{ $symbol }} {{ $ques->question_2 }}  =</td>
                    <td class="colanswer"><input class="form-control" name="answer[{{ $ques->id }}]" type="text" /></td>
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
@endsection
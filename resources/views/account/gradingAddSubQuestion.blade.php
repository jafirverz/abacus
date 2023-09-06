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
          <a class="link-1 lico" href="be-overview-preparatory.html"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <ul class="breadcrumb bctype">
            <li><a href="{{ url('grading-overview') }}">Grading Overview</a></li>
            <li><strong>{{ $gradingExam->title }}</strong></li>
        </ul>
        <div class="box-1">
            {!! $gradingExam->important_note !!}
        </div>
        <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i class="icon-info"></i></button> <strong><a href="?s=1">Shuffle the Questions <i class="icon-shuffle"></i></a></strong></div>
        </div>
        <form method="post" action="{{ route('grading_answer.submit') }}">
          @csrf
          <input type="hidden" name="grading_exam_id" value="{{ $grading_exam_id }}">
            <input type="hidden" name="listing_id" value="{{ $listing_id }}">
            <input type="hidden" name="paper_id" value="{{ $paper->listing_paper_id }}">
            <input type="hidden" name="question_type" value="{{ $paper->question_type }}">
          <div class="box-1">
            <div class="xscrollbar">
              <table class="tb-2 tbtype-2">
                <thead>
                  <tr>
                    <th class="wcol-2"></th>
                    @php
                    if(isset($_GET['s']) && $_GET['s'] == 1){
                      $questionns = \App\GradingPaperQuestion::where('grading_paper_question_id', $paper->id)->inRandomOrder()->get();
                    }else{
                      $questionns = \App\GradingPaperQuestion::where('grading_paper_question_id', $paper->id)->get();
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
                        $arrVal = explode(',', $question->input_1);
                        foreach($arrVal as $val){
                        @endphp
                        <div class="row sp-col-5 inrow-1">
                          <div class="col-auto sp-col">$</div>
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
                        <div class="col-auto sp-col">$</div>
                        <div class="col colanswer sp-col"><input class="form-control" type="number" name="answer[{{ $question->id }}]" /></div>
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
          <div class="output-1">
            <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
@endsection

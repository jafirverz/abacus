@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="tempt-3">
        <div class="mb-20">
            <a class="link-1 lico"  href="javascript::void(0)" onclick="window.history.go(-1); return false;"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
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
            @if($all_paper_detail_v)
            @foreach($all_paper_detail_v as $paper_detail)
            <input type="hidden" name="test_paper_question_id[]" value="{{ $paper_detail->id }}">
            <div class="box-1">
                <div class="note-4 mb-20">A. {{ $paper_detail->question }}</div>
                <div class="xscrollbar">
                    <table class="tb-2 tbtype-1">
                        <thead>
                            <tr>
                              <th class="wcol-2"></th>
                              @php

                              $questionns = \App\TestPaperQuestionDetail::where('test_paper_question_id', $paper_detail->id)->get();

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
            @endforeach
            @endif
            @if($all_paper_detail_h)
            @foreach($all_paper_detail_h as $paper_detail)
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
                            $i = 1;
                            @endphp
                            @foreach($paper_detail->questionsCourse as $ques)
                            @php
                            if($ques->input_3 == 'multiply'){
                              $symbol='*';
                            }
                            elseif($ques->input_3 == 'add'){
                              $symbol='+';
                            }
                            elseif($ques->input_3 == 'subtract'){
                              $symbol='-';
                            }
                            else{
                              $symbol='÷';
                            }
                            @endphp
                            <tr>
                              <td class="colnumber">{{ $i }}</td>
                              <td class="text-center">{{ $ques->input_1 }} {{ $symbol }} {{ $ques->input_2 }}  =</td>
                              <td class="colanswer"><input class="form-control" type="number" name="answer[{{ $ques->id }}]" /></td>
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


@endsection

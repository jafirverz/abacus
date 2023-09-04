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
                <div class="row sp-col-20">
                    <div class="col-xl-6 col-md-5 sp-col mt-30 order-md-last">
                      <iframe src="" width="500px"></iframe>
                    </div>
                    <div class="col-xl-6 col-md-7 sp-col order-md-first">

                          @php
                          $countQ = count($paper_detail->questionsCourse);
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
                                  @foreach($paper_detail->questionsCourse as $ques)
                                  @php
                                  $explo = explode(',', $ques->input_1);
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
                                  @foreach($paper_detail->questionsCourse as $ques)
                                  <td class="colanswer text-center"><input class="form-control minwinpt-1" type="number" value="" name="answer[{{ $ques->id }}]" /></td>
                                  @endforeach

                                </tr>

                              </tfoot>
                            </table>
                          </div>
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

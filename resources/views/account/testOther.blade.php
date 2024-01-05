@extends('layouts.app')
@section('content')


<main class="main-wrap">
    <div class="tempt-3">
        <div class="mb-20">
            <a class="link-1 lico" href="javascript::void(0)" onclick="window.history.go(-1); return false;"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <h1 class="title-3">{{ $test->title }}</h1>
        {{-- <div class="title-11">Preparatory Book 1 - Assessment</div> --}}
        <div class="box-1">
            <div class="row sp-col-20">
                <div class="col-lg-6 sp-col">
                    <label class="lb-1 mt-0">Name</label>
                    <input class="form-control inptype-1" type="text" value="{{ Auth::user()->name }}">
                </div>

                <div class="col-lg-6 col-sm-6 sp-col mt-991-15">
                    <label class="lb-1 mt-0">Date</label>
                    <div class="date-wrap">
                        <i class="fa-solid fa-calendar-days ico"></i>
                        <input class="form-control inptype-1" type="text" value="{{ date('d/m/Y') }}">
                    </div>
                </div>
            </div>
        </div>
        <form method="post" action="{{ route('test.answer.submit') }}">
            @csrf
            <input type="hidden" name="allocation_id" value="{{ $test->allocation_id }}">
            <input type="hidden" name="test_id" value="{{ $test->id }}">
            <input type="hidden" name="question_type" value="{{ $test->paper->question_template_id }}">
            <input type="hidden" name="test_paper_question_id[]" value="{{ $all_paper_detail->id }}">
            <div class="box-1">
                <div class="note-4">Write {{ $all_paper_detail->write_from }} to {{ $all_paper_detail->write_to }}</div>
                <div class="gtb-1">
                    @php for($i=$all_paper_detail->write_from;$i<=$all_paper_detail->write_to;$i++){ @endphp
                    <div class="col"><input name="answer2[]" class="form-control" type="number"></div>
                    @php } @endphp
            </div>
            <div class="row">
                <div class="col-xl-7">
                    <div class="row">
                        @php
                        $detail_beads=\App\TestPaperQuestionDetail::where('test_paper_question_id',$all_paper_detail->id)->where('input_3','file')->get();
                        $k=0;
                        @endphp
                        @if(isset($detail_beads) && $detail_beads->count() > 0)
                        <div class="col-md-6">
                            <div class="box-1">
                                <label class="lb-1 mt-0">Recognise Beads</label>
                                <div class="row sp-col-10">
                                  @foreach($detail_beads as $bead)
                                  @php $k++; @endphp
                                    <div class="col-6 sp-col mt-10">
                                        <input class="form-control inptype-2" name="answer[{{ $bead->id }}]" type="number">
                                        <div class="imgwrap-3">
                                            <img src="{{ url($bead->input_1) }}" alt="">
                                        </div>
                                    </div>
                                    @if($detail_beads->count() > 2 && $k%2==0)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box-1">
                                            <label class="lb-1 mt-0">Recognise Beads</label>
                                            <div class="row sp-col-10">
                                    @endif
                                  @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="box-1">
                        <label class="lb-1 mt-0">Complete these sums using abacus:</label>
                        <div class="row sp-col-10">
                            @php
                        $detail_number=\App\TestPaperQuestionDetail::where('test_paper_question_id',$all_paper_detail->id)->where('input_3','text')->get();
                        @endphp
                        @foreach($detail_number as $num)
                            <div class="col-sm-4 col-6 sp-col mt-10">
                                @php
                                    $input_1=explode('|',$num->input_1);
                                @endphp
                                @foreach($input_1 as $input)
                                <div class="sumrow">{{ $input }}</div>
                                @endforeach
                                <hr class="bdrtype-2">
                                <input class="form-control inptype-2" type="number" name="answer[{{ $num->id }}]">
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="output-1">
                <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
            </div>
        </form>
    </div>
</main>
@endsection

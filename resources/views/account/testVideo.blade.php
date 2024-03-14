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

            <input type="hidden" name="test_id" value="{{ $test->id }}">
            <input type="hidden" name="allocation_id" value="{{ $test->allocation_id }}">
            <input type="hidden" name="question_type" value="{{ $test->paper->question_template_id }}">
            @if($all_paper_detail)
            @foreach($all_paper_detail as $paper_detail)
            <input type="hidden" name="test_paper_question_id[]" value="{{ $paper_detail->id }}">
            <div class="row grid-5">
            @php

            $k=0;
            $i = 1;
            foreach($paper_detail->questionsCourse as $question){
            @endphp
            <div class="col-lg-4 col-md-6">
            <div class="inner">
                <strong class="number">Q{{ $i }}</strong>
                <div class="vdwrap">
                <video width="400">
                    <source src="{{ url('/upload-file/'.$question->input_1) }}" type="video/mp4"  controlsList="nodownload">
                    Your browser does not support HTML video.
                </video>
                <a class="link-fix" data-fancybox href="{{ url('/upload-file/'.$question->input_1) }}"><i class="fa-solid fa-play"></i></a>
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
            @endforeach
            @endif

            <div class="output-1">
                <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
            </div>
        </form>
    </div>
</main>

@endsection

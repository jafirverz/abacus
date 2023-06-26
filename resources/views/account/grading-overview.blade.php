@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            @include('inc.account-sidebar')
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <div class="mb-20">
                    <a class="link-1 lico" href="be-overview.html"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
                </div>
                <h1 class="title-3">My Overview</h1>
                <div class="box-1">
                    <div class="row grid-2 sp-col-15">
                        <div class="col-xl-3 col-sm-5 sp-col gcol-1">
                            <img class="image" src="images/tempt/img-level-6-big.jpg" alt="" />
                        </div>
                        <div class="col-xl-9 col-sm-7 sp-col gcol-2 mt-574-30">
                            <h2 class="title-4">Grading Examination</h2>
                            <div class="row sp-col-15">
                                <div class="col-lg-12 sp-col gincol-1">
                                    <div class="inrow">
                                        <strong>Title:</strong> <?=$gradingExam->title?>
                                    </div>
                                    <div class="inrow">
                                        <strong>Date:</strong> <?=$gradingExam->exam_date?>
                                    </div>
                                    <div class="inrow">
                                        <strong>Exam Venue:</strong> XXXX
                                    </div>
                                </div>
                                <div class="col-lg-12 sp-col gincol-2">
                                    <div class="inrow">
                                        <strong>Exam Type:</strong> <span class="status-1">{{ gradingExamLayout($gradingExam->layout) ?? '' }}</span>
                                    </div>
                                    <div class="inrow">
                                        <strong>My Registered Grades:</strong> <br/>
                                        <div class="mt-5px">Mental Grade: XXXX</div>
                                        <div class="mt-5px">Abacus Grade: XXXX</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sp-col-15 grid-2">
                        <div class="col-xl-9 sp-col gcol-3">
                            <div class="gcontent">
                                <h4 class="title-6">Important Note</h4>
                                {!! $gradingExam->important_note ?? '' !!}
                            </div>
                        </div>
                        <div class="col-xl-3 sp-col gcol-4">
                            <a class="btn-1" href="#">Download Examination Pass <i class="fa-solid fa-arrow-right-long"></i></a>
                            <div class="note-2"><i class="icon-info"></i> Note: This page will be disabled after the exam finishes.</div>
                        </div>
                    </div>
                    <div class="accordion mt-30">
                        @if($gradingExamList->count())
                        @php $i=0;@endphp
                            @foreach ($gradingExamList as $key => $item)
                            @php $i++;@endphp
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button @if($i!=1) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?=$i?>" aria-expanded="false" aria-controls="faq-<?=$i?>">{{ $item->heading }}</button>
                                </h3>
                                <div id="faq-<?=$i?>" class="accordion-collapse collapse @if($i==1) show @endif">
                                    <div class="accordion-body">
                                        <div class="row break-1500">

                                            <div class="col-xl-6 sp-col">
                                                <div class="box-2">
                                                    @php
                                                    $json_content=json_decode($item->json_content);
                                                    for($k=0;$k<count($json_content->input_1);$k++)
                                                    {
                                                    @endphp
                                                    <div class="bxrow">
                                                        <div class="checkbxtype nocheck">
                                                            <label><span>{{ $json_content->input_1[$k] ?? '' }}</span> <strong>${{ $json_content->input_2[$k] ?? '' }}</strong></label>
                                                        </div>
                                                        <a class="lnk btn-2" href="#">Download</a>
                                                    </div>
                                                    @php } @endphp
                                                </div>
                                            </div>

                                        </div>
                                        <div class="output-2 mt-0">
                                            <a class="btn-1" href="#">Add to Cart <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        @else
                                    {{ __('constant.NO_DATA_FOUND') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

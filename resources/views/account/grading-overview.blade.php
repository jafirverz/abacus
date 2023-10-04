@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            @if(Auth::user()->user_type_id == 4)
              @include('inc.account-sidebar-event-student')
            @else
              @include('inc.account-sidebar')
            @endif
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <div class="mb-20">
                    <a class="link-1 lico" onclick="window.history.go(-1); return false;" href="javascript::void(0)"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
                </div>
                <h1 class="title-3">My Overview</h1>
                <div class="box-1">
                    <div class="row grid-2 sp-col-15">
                        <div class="col-xl-3 col-sm-5 sp-col gcol-1">
                            <img class="image" src="{{Auth::user()->profile_picture ?? asset('images/tempt/img-user.jpg')}}" alt="" />
                        </div>
                        <div class="col-xl-9 col-sm-7 sp-col gcol-2 mt-574-30">
                            <h2 class="title-4">Grading Examination</h2>
                            <div class="row sp-col-15">
                                <div class="col-lg-12 sp-col gincol-1">
                                    <div class="inrow">
                                        <strong>Title:</strong> {{$gradingExam->title ?? ''}}
                                    </div>
                                    <div class="inrow">
                                        <strong>Date:</strong> {{ date('j F Y',strtotime($gradingExam->exam_date)) }} | {{ date('H:i A',strtotime($gradingExam->exam_date)) }}
                                    </div>
                                    <div class="inrow">
                                        <strong>Exam Venue:</strong> {{$gradingExam->exam_venue ?? ''}}
                                    </div>
                                </div>
                                <div class="col-lg-12 sp-col gincol-2">
                                    <div class="inrow">
                                        <strong>Exam Type:</strong> <span class="status-1">{{ gradingExamType($gradingExam->type) ?? '' }}</span>
                                    </div>
                                    <div class="inrow">
                                        <strong>My Registered Grades:</strong> <br/>
                                        <div class="mt-5px">Mental Grade: {{ $gradingStu->mental->title ?? '' }}</div>
                                        <div class="mt-5px">Abacus Grade: {{ $gradingStu->abacus->title ?? '' }}</div>
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
                          @php $i=0; @endphp
                            @if($gradingExam->type==1)
                                <form method="post" action="{{ route('cart') }}">
                                @csrf
                                <input type="hidden" name="type" value="physicalgrading">
                            @endif

                            @foreach ($gradingExamList as $key => $item)
                            @php $i++;@endphp


                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button @if($i!=1) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?=$i?>" aria-expanded="false" aria-controls="faq-<?=$i?>">{{ $item->heading }}</button>
                                </h3>
                                <div id="faq-<?=$i?>" class="accordion-collapse collapse @if($i==1) show @endif">
                                    <div class="accordion-body">


                                    @if($gradingExam->type==1)
                                    @php
                                        $userId = Auth::user()->id;
                                        $orderDetails = \App\OrderDetail::where('user_id', $userId)->where('order_type', 'physicalgrading')->pluck('comp_paper_id')->toArray();
                                    @endphp
                                    @else
                                    @php
                                        $userId = Auth::user()->id;
                                        $orderDetails = \App\OrderDetail::where('user_id', $userId)->where('order_type', 'onlinegrading')->pluck('comp_paper_id')->toArray();
                                    @endphp
                                    @endif
                                        <div class="row break-1500">

                                            <div class="col-xl-6 sp-col">
                                                <div class="box-2">
                                                    @if(getAllGradingExamListDetail($item->id))
                                                        @php $k=0;@endphp
                                                        @foreach(getAllGradingExamListDetail($item->id) as $key => $val)
                                                        @php $k++;@endphp


                                                          @if($gradingExam->type==1)
                                                            <div class="bxrow">
                                                                @if($val->price>0 && $gradingExam->exam_type==1)

                                                                    @if(isset($orderDetails) && in_array($val->id,$orderDetails))
                                                                    <div class="checkbxtype nocheck">
                                                                    <label><span>{{ $val->title ?? '' }}</span> <strong>${{ $val->price ?? '' }}</strong></label>
                                                                    </div>
                                                                     <a class="lnk btn-2" href="{{ url('/') }}/{{ $val->uploaded_file }}">Download</a>
                                                                    @else
                                                                    <div class="checkbxtype">
                                                                        <input type="checkbox"  onclick="checkchecked();" id="practice-{{ $val->id }}" name="paper[]" value="{{ $val->id }}" id="exercise-{{ $i.$k }}">
                                                                        <label for="exercise-{{ $i.$k }}"><span>{{ $val->title ?? '' }}</span> <strong>${{ $val->price ?? '' }}</strong></label>
                                                                    </div>
                                                                    @endif
                                                                @else
                                                                <div class="checkbxtype nocheck">
                                                                    <label><span>{{ $val->title ?? '' }}</span> <strong>Included</strong></label>
                                                                </div>
                                                                <a class="lnk btn-2" href="{{ url('/') }}/{{ $val->uploaded_file ?? '' }}">Download</a>
                                                                @endif
                                                            </div>
                                                          @else
                                                            @if($val->price>0 && $gradingExam->exam_type==1)

                                                                @if(isset($orderDetails) && in_array($val->id,$orderDetails))
                                                                <div class="bxrow">
                                                                    <label for="exercise-{{ $i.$k }}"><span>{{ $val->title ?? '' }}</span> <strong>${{ $val->price ?? '' }}</strong></label>

                                                                    @if(is_grading_paper_submitted($val->id))
                                                                    <a class="lnk btn-2" href="jquery::void()">Submitted</a>
                                                                    @else
                                                                    <a class="lnk btn-2" href="{{ url('grading-overview/'.$gradingExam->id.'/'.$val->grading_listing_id.'/'.$val->id.'') }}">View</a>
                                                                    @endif

                                                                </div>
                                                                @else
                                                                <div class="bxrow">
                                                                    <div class="checkbxtype nocheck">
                                                                        <input name="grade_pay[]" type="checkbox" id="exercise-{{ $i.$k }}" />
                                                                        <label for="exercise-{{ $i.$k }}"><span>{{ $val->title ?? '' }}</span> <strong>${{ $val->price ?? '' }}</strong></label>
                                                                    </div>
                                                                    <form method="post" action="{{ route('cart') }}">
                                                                        @csrf
                                                                        <input type="hidden" name="type" value="onlinegrading">
                                                                        <input type="hidden" name="paper" value="{{ $val->id }}">
                                                                    <button class="lnk btn-2" type="submit" >Add to Cart</button>
                                                                    </form>
                                                                </div>
                                                                @endif
                                                            @else
                                                                <div class="bxrow">
                                                                    <label for="exercise-{{ $i.$k }}"><span>{{ $val->title ?? '' }}</span> <strong>${{ $val->price ?? '' }}</strong></label>
                                                                    @if(is_grading_paper_submitted($val->id))
                                                                    <a class="lnk btn-2" href="jquery::void()">Submitted</a>
                                                                    @else
                                                                    <a class="lnk btn-2" href="{{ url('grading-overview/'.$gradingExam->id.'/'.$val->grading_listing_id.'/'.$val->id.'') }}">View</a>
                                                                    @endif

                                                                </div>
                                                            @endif
                                                          @endif
                                                          @if($k%4==0)
                                                            </div>
                                                          </div>
                                                          <div class="col-xl-6 sp-col">
                                                            <div class="box-2">
                                                          @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            @endforeach

                            @if($gradingExam->type==1)
                            <div class="output-2 mt-0">
                                    <button class="btn-1 addtocart" type="submit" style="display: none;">Add to Cart <i class="fa-solid fa-arrow-right-long"></i></button>
                            </div>
                            </form>
                            @endif
                        @else
                                    {{ __('constant.NO_DATA_FOUND') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    function checkchecked(){
        var atLeastOneIsChecked = $('input[name="paper[]"]:checked').length > 0;
        if(atLeastOneIsChecked){
            $('.addtocart').show();
        }else{
            $('.addtocart').hide();
        }
    }
</script>
@endsection

@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
                @include('inc.account-sidebar')
            @endif
            @if(Auth::user()->user_type_id == 3)
                @include('inc.account-sidebar-online')
            @endif
            @if(Auth::user()->user_type_id == 4)
                @include('inc.account-sidebar-event-student')
            @endif
        </div>
        @include('inc.messages')
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <div class="mb-20">
                    <a class="link-1 lico" href="{{ url('/') }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
                </div>
                <h1 class="title-3">My Overview</h1>
                <div class="box-1">
                    <div class="row grid-2 sp-col-15">
                        <div class="col-xl-3 col-sm-5 sp-col gcol-1">
                            <img class="image" src="{{ asset($competition->comp_image) }}" alt="" />
                        </div>
                        <div class="col-xl-9 col-sm-7 sp-col gcol-2 mt-574-30">
                            <h2 class="title-4">Grading Examination</h2>
                            <div class="row sp-col-15">
                                <div class="col-lg-12 sp-col gincol-1">
                                    <div class="inrow">
                                        <strong>Title:</strong> {{$competition->title ?? ''}}
                                    </div>
                                    <div class="inrow">
                                        <strong>Date:</strong> {{ date('j F Y',strtotime($competition->date_of_competition)) }} | {{ date('H:i A',strtotime($competition->date_of_competition)) }}
                                    </div>
                                    <div class="inrow">
                                        <strong>Exam Venue:</strong> {{$competition->exam_venue ?? ''}}
                                    </div>
                                </div>
                                <div class="col-lg-12 sp-col gincol-2">
                                    <div class="inrow">
                                        <strong>Exam Type:</strong> <span class="status-1">{{ $competition->competition_type ?? '' }}</span>
                                    </div>
                                    <div class="inrow">
                                        <strong>My Registered Grades:</strong> <br/>
                                        <div class="mt-5px">Mental Grade: {{ $gradingStu->mental->category_name ?? '' }}</div>
                                        <div class="mt-5px">Abacus Grade: {{ $gradingStu->abacus->category_name ?? '' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sp-col-15 grid-2">
                        <div class="col-xl-9 sp-col gcol-3">
                            <div class="gcontent">
                                <h4 class="title-6">Important Note</h4>
                                {!! $competition->description !!}
                            </div>
                        </div>
                        <div class="col-xl-3 sp-col gcol-4">
                            <a class="btn-1" href="{{ route('grading.pass', ['id'=>$competition->id, 'user_id'=> Auth::user()->id]) }}">Download Examination Pass <i class="fa-solid fa-arrow-right-long"></i></a>
                            <div class="note-2"><i class="icon-info"></i> Note: This page will be disabled after the exam finishes.</div>
                        </div>
                    </div>


                    <div class="accordion mt-30">

                        @php
                        $compId = $competition->id;
                        $catComp=[];
                        $catgrade = \App\GradingStudent::where('grading_exam_id', $compId)->where('user_id', Auth::user()->id)->orderBy('id','desc')->first();
                        //dd($catgrade);
                        if(isset($catgrade->mental_grade) && $catgrade->mental_grade!=NULL)
                        {
                            array_push($catComp,$catgrade->mental_grade);
                        }

                        if(isset($catgrade->abacus_grade) && $catgrade->abacus_grade!=NULL)
                        {
                            array_push($catComp,$catgrade->abacus_grade);
                        }

                        $i = 1;
                        //dd($catgrade);
                        @endphp

                        @if(isset($catComp) && count($catComp) > 0)
                        @foreach($catComp as $key=>$cat)

                            @php
                            //$checkPaperCategory = \App\PaperCategory::where('category_id', $cat)->where('competition_id', $compId)->count();

                            $checkPaperCategory = \App\GradingPaper::where('category_id', $cat)->where('grading_exam_id', $compId)->get();
                            @endphp



                            @php
                            $catt = \App\GradingCategory::where('id', $cat)->first();
                            if($key == 0){
                                $collaspse = '';
                                $show = 'show';
                            }else{
                                $collaspse = 'collapsed';
                                $show = '';
                            }
                            @endphp
                            @if($checkPaperCategory)
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button {{ $collaspse }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $i }}" aria-expanded="false" aria-controls="faq-{{ $i }}">{{ $catt->category_name}}</button>
                                    </h3>


                                    <div id="faq-{{ $i }}" class="accordion-collapse collapse {{ $show }}">
                                        <div class="accordion-body">
                                            <form method="post" action="{{ route('cart') }}">
                                            @csrf
                                            <input type="hidden" name="type" value="physicalgrading">
                                            <div class="row break-1500">
                                                @php
                                                $countt = count($checkPaperCategory);
                                                $modul = ceil($countt / 6);
                                                $counttN = number_format($modul);
                                                @endphp
                                                @for($i=0; $i<$counttN; $i++)
                                                <div class="col-xl-6 sp-col">
                                                    <div class="box-2">
                                                    @php
                                                    $skip = $i * 6;
                                                    $checkPaperCategory = \App\GradingPaper::where('category_id', $cat)->where('grading_exam_id', $compId)->skip($skip)->take(6)->get();
                                                    @endphp
                                                    @foreach($checkPaperCategory as $pape)
                                                    @php
                                                    $userId = Auth::user()->id;
                                                    $orderDetails = \App\OrderDetail::where('user_id', $userId)->where('order_type', 'physicalgrading')->pluck('comp_paper_id')->toArray();
                                                    @endphp

                                                        @php
                                                        $todayDate = date('Y-m-d');
                                                        if($competition->date_of_competition > $todayDate ){
                                                            if($pape->paper_type == 'practice'){
                                                        @endphp
                                                            <div class="bxrow">
                                                                @if(empty($pape->price))
                                                                <label>
                                                                    <span>{{ $pape->title }}</span>
                                                                    <strong>Included</strong>
                                                                </label>
                                                                @elseif(in_array($pape->id,$orderDetails))
                                                                <label>
                                                                    <span>{{ $pape->title }}</span>
                                                                    <strong>Paid</strong>
                                                                </label>
                                                                @else
                                                                <div class="checkbxtype">
                                                                    @if(!empty($pape->price) || !in_array($pape->id,$orderDetails))
                                                                    <input type="checkbox" onclick="checkchecked();" id="practice-{{ $pape->id }}" name="paper[]" value="{{ $pape->id }}">
                                                                    @endif
                                                                    <label><span>{{ $pape->title }}</span>
                                                                        <strong>${{ $pape->price ?? 0 }}</strong>
                                                                    </label>
                                                                </div>
                                                                @endif

                                                                @if(empty($pape->price) || in_array($pape->id,$orderDetails))
                                                                <a class="lnk btn-2" href="{{ asset('upload-file/'.$pape->pdf_file) }}" target="_blank">Download</a>

                                                                @endif
                                                            </div>
                                                        @php
                                                            }
                                                        }elseif($competition->date_of_competition == $todayDate){
                                                            if($pape->paper_type == 'actual'){
                                                        @endphp
                                                            <div class="bxrow">
                                                                @if(empty($pape->price))
                                                                <label>
                                                                    <span>{{ $pape->title }}</span>
                                                                    <strong>Included</strong>
                                                                </label>
                                                                @elseif(in_array($pape->id,$orderDetails))
                                                                <label>
                                                                    <span>{{ $pape->title }}</span>
                                                                    <strong>Paid</strong>
                                                                </label>
                                                                @else
                                                                <div class="checkbxtype">
                                                                    @if(!empty($pape->price) || !in_array($pape->id,$orderDetails))
                                                                    <input type="checkbox" onclick="checkchecked();" id="practice-{{ $pape->id }}" name="paper[]" value="{{ $pape->id }}">
                                                                    @endif
                                                                    <label><span>{{ $pape->title }}</span>
                                                                        <strong>${{ $pape->price ?? 0 }}</strong>
                                                                    </label>
                                                                </div>
                                                                @endif

                                                                @if(empty($pape->price) || in_array($pape->id,$orderDetails))
                                                                <a class="lnk btn-2" href="{{ asset('upload-file/'.$pape->pdf_file) }}" target="_blank">Download</a>

                                                                @endif
                                                            </div>
                                                        @php
                                                            }

                                                        }
                                                        @endphp
                                                    @endforeach
                                                    </div>
                                                </div>

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
                                                @endfor




                                            </div>
                                            <div class="output-2 mt-0">
                                                <button class="btn-1 addtocart" type="submit" style="display: none;">Add to Cart <i class="fa-solid fa-arrow-right-long"></i></button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @php
                                $i++;
                                @endphp
                            @endif
                        @endforeach
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

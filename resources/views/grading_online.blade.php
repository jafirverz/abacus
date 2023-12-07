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
                                        <strong>Title:</strong> {{ $competition->title }}
                                    </div>
                                    <div class="inrow">
                                        <strong>Date:</strong> {{ date('j F Y', strtotime($competition->date_of_competition)) }}
                                    </div>


                                </div>
                                <div class="col-lg-12 sp-col gincol-2">
                                    <div class="inrow">
                                        <strong>Result:</strong> <span class="status-1"></span>
                                    </div>
                                    <div class="inrow">
                                        <strong>Competition Type:</strong> <span class="status-1">{{ ucwords($competition->competition_type) }}</span>
                                    </div>
                                    {{--
                                    <div class="inrow">
                                        <a class="btn-1" href="#">Download Competition Pass <i class="fa-solid fa-arrow-right-long"></i></a>
                                    </div>
                                    --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-30">
                        <h4 class="title-6">Important Note</h4>
                        {{ $competition->description }}
                    </div>
                    <div class="accordion mt-30">

                        @php
                        $compId = $competition->id;

                        $catComp = \App\CategoryGrading::where('competition_id', $compId)->pluck('category_id')->toArray();

                        //dd($catComp);

                        $i = 1;
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
                                                    @foreach($checkPaperCategory as $paper)

                                                    @php
                                                    $orderDetails = array();
                                                    $userId = Auth::user()->id;
                                                    $orderDetails = \App\OrderDetail::where('user_id', $userId)->where('order_type', 'onlinecompetition')->pluck('comp_paper_id')->toArray();
                                                    $todayDate = date('Y-m-d');
                                                    if($competition->date_of_competition > $todayDate ){
                                                        if($paper->paper_type == 'practice'){
                                                    @endphp
                                                            <div class="bxrow">
                                                                <div class="checkbxtype nocheck">
                                                                    <input type="checkbox" id="practice-7" name="onlinepracticepaper[]">
                                                                    <label><span>{{ $paper->title }}</span>
                                                                        <strong>${{ $paper->price ?? 0 }}</strong>
                                                                    </label>
                                                                </div>

                                                                @if(!empty($paper->price) && !in_array($paper->id,$orderDetails))
                                                                <form method="post" action="{{ route('cart') }}">
                                                                    @csrf
                                                                    <input type="hidden" name="type" value="onlinecompetition">
                                                                    <input type="hidden" name="paper" value="{{ $paper->id }}">
                                                                <button class="lnk btn-2" type="submit" >Add to Cart</button>
                                                                </form>
                                                                @else
                                                                <a class="lnk btn-2" href="{{ url('grading-paper/'.$paper->id) }}" >View</a>
                                                                @endif
                                                            </div>

                                                    @php
                                                        }
                                                    }elseif($competition->date_of_competition == $todayDate){
                                                        if($paper->paper_type == 'actual'){
                                                    @endphp
                                                            <div class="bxrow">
                                                                <div class="checkbxtype">
                                                                    <input type="checkbox" id="practice-7">
                                                                    <label><span>{{ $paper->title }}</span>
                                                                        <strong>${{ $paper->price ?? 0 }}</strong>
                                                                    </label>
                                                                </div>
                                                                <a class="lnk btn-2" href="{{ url('grading-paper/'.$paper->id) }}" >View</a>
                                                            </div>
                                                    @php
                                                        }

                                                    }
                                                    @endphp
                                                    @endforeach

                                                    </div>
                                                </div>
                                                @endfor




                                            </div>
                                            <!-- <div class="output-2 mt-0">
                                                <a class="btn-1" href="#">Add to Cart <i class="fa-solid fa-arrow-right-long"></i></a>
                                            </div> -->
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
@endsection

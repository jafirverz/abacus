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
                    <a class="link-1 lico" href="be-overview.html"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
                </div>
                <h1 class="title-3">My Overview</h1>
                <div class="box-1">
                    <div class="row grid-2 sp-col-15">
                        <div class="col-xl-3 col-sm-5 sp-col gcol-1">
                            <img class="image" src="{{ asset($competition->comp_image) }}" alt="" />
                        </div>
                        <div class="col-xl-9 col-sm-7 sp-col gcol-2 mt-574-30">
                            <h2 class="title-4">Competition</h2>										
                            <div class="row sp-col-15">
                                <div class="col-lg-12 sp-col gincol-1">
                                    <div class="inrow">
                                        <strong>Title:</strong> {{ $competition->title }}
                                    </div>
                                    <div class="inrow">
                                        <strong>Date:</strong> {{ $competition->date_of_competition }}
                                    </div>	
                                    <div class="inrow">
                                        <strong>Allocated Competition Time:</strong> {{ $competition->start_time_of_competition }}
                                    </div>
                                    @php 
                                    $userCategory = json_decode(Auth::user()->category_id);
                                    if($userCategory){
                                        $catComp1 = \App\CompetitionCategory::whereIn('id', $userCategory)->pluck('category_name')->toArray();
                                        $categories = implode(',', $catComp1);
                                    }
                                    @endphp
                                    <div class="inrow">
                                        <strong>Registered Category:</strong> {{ $categories ?? '' }}
                                    </div>
                                    {{-- 	
                                    <div class="inrow">
                                        <strong>Venu:</strong> XXXX
                                    </div>
                                    --}}	
                                </div>
                                <div class="col-lg-12 sp-col gincol-2">
                                    <div class="inrow">
                                        <strong>Result:</strong> <span class="status-1"></span>
                                    </div>		
                                    <div class="inrow">
                                        <strong>Competition Type:</strong> <span class="status-1">{{ $competition->competition_type }}</span>
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
                        $catComp = \App\CategoryCompetition::where('competition_id', $compId)->pluck('category_id')->toArray();
                        $i = 1;
                        @endphp

                        @foreach($catComp as $key=>$cat)

                            @php
                            //$checkPaperCategory = \App\PaperCategory::where('category_id', $cat)->where('competition_id', $compId)->count();

                            $checkPaperCategory = \App\CompetitionPaper::where('category_id', $cat)->where('competition_controller_id', $compId)->get();
                            @endphp



                            @php 
                            $catt = \App\CompetitionCategory::where('id', $cat)->first();
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
                                            <input type="hidden" name="type" value="physicalcompetition">
                                            <div class="row break-1500">
                                                
                                                <div class="col-xl-6 sp-col">
                                                    <div class="box-2">
                                                    @foreach($checkPaperCategory as $pape)
                                                    @php 
                                                    $userId = Auth::user()->id;
                                                    $orderDetails = \App\OrderDetail::where('user_id', $userId)->where('order_type', 'physicalcompetition')->pluck('comp_paper_id')->toArray();
                                                    @endphp
                                                        
                                                        @php
                                                        $todayDate = date('Y-m-d'); 
                                                        if($competition->date_of_competition > $todayDate ){
                                                            if($pape->paper_type == 'practice'){
                                                        @endphp
                                                            <div class="bxrow">
                                                                @if(empty($pape->price) || in_array($pape->id,$orderDetails))
                                                                <label><span>{{ $pape->title }}</span></label>
                                                                @else
                                                                <div class="checkbxtype">
                                                                    @if(!empty($pape->price) || !in_array($pape->id,$orderDetails))
                                                                    <input type="checkbox" id="practice-7" name="paper[]" value="{{ $pape->id }}">
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
                                                                @if(empty($pape->price) || in_array($pape->id,$orderDetails))
                                                                <label><span>{{ $pape->title }}</span></label>
                                                                @else
                                                                <div class="checkbxtype">
                                                                    @if(!empty($pape->price) || !in_array($pape->id,$orderDetails))
                                                                    <input type="checkbox" id="practice-7" name="paper[]" value="{{ $pape->id }}">
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

                                                
                                            


                                            </div>
                                            <div class="output-2 mt-0">
                                                <button class="btn-1" type="submit">Add to Cart <i class="fa-solid fa-arrow-right-long"></i></button>
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

                        



                    </div>
                </div>
            </div>
        </div>
    </div>	
</main>
@endsection
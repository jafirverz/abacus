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
          <a class="link-1 lico" href="{{ url('home') }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <h1 class="title-3">My Overview</h1>
        <div class="box-1">
          <div class="row grid-2 sp-col-15">
            <div class="col-sm-3 sp-col gcol-1">
              <img class="image" src="{{ asset($checkSlug->image) }}" alt="" />
            </div>
            <div class="col-sm-9 sp-col gcol-2">
              <div class="row sp-col-15 align-items-center">
                <div class="col-lg-12 sp-col gincol-1">
                  <div class="gcontent">
                    <h2 class="title-4">{{ $checkSlug->title }}</h2>
                    {!! $checkSlug->description !!}
                  </div>
                </div>
                <form method="post" action="{{ route('cart') }}">
                  @csrf
                  <input type="hidden" name="levelId" value="{{ $checkSlug->id }}">
                  <input type="hidden" name="type" value="level">
                  <div class="col-lg-12 sp-col gincol-2">
                    <button type="submit" class="btn-1" >Upgrade to Premium Member for 9 months (SGD$9.90) <i
                        class="fa-solid fa-arrow-right-long"></i></button>
                    <div class="note-2"><i class="icon-info"></i> Sign-up as premium member to get access to all the
                      exercises and unlock all features in the worksheets</div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="accordion mt-30">
            @php
            $i = 1;
            @endphp
            @foreach($qestionTemplate as $questions)
            @php
            @endphp
            <div class="accordion-item">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#faq-{{ $i }}" aria-expanded="@if($i == 1) true @else false @endif" aria-controls="faq-{{ $i }}">{{ $questions->title }}</button>
              </h3>
              <div id="faq-{{ $i }}" class="accordion-collapse collapse">
                <div class="accordion-body">
                  <div class="row">
                    <div class="col-xl-6">
                      <div class="row">	
                        <div class="col-sm-6">
                          <ul class="list-1">
                            @php 
                            $flag = 0;
                            @endphp
                            @foreach($worksheets as $worksheet)
                              @php 
                              if(!empty($worksheet->amount)){
                                $flag = 1;
                              }
                              @endphp
                              @if(empty($worksheet->amount))
                                @php
                                $checkQuestions = \App\Question::where('worksheet_id', $worksheet->id)->first();
                                @endphp
                                @if($worksheet->question_template_id == $questions->id && $checkQuestions)
                                <li><a href="{{ url('worksheet/'.$worksheet->id.'/qId/'.$questions->id .'/lId/'.$checkSlug->id) }}">{{ $worksheet->title }}</a></li>
                                @endif
                              @endif
                            @endforeach
                            
                          </ul>
                        </div>														
                        
                      </div>
                    </div>
                    @if($flag == 1)
                    <div class="col-xl-6 mt-1199-20">
                      <h4 class="title-5">Premium Contents</h4>
                      <div class="row">															
                        <div class="col-sm-6">
                          <ul class="list-1 disabled">
                            @foreach($worksheets as $worksheet)
                              @if(!empty($worksheet->amount))
                                @php
                                $checkQuestions = \App\Question::where('worksheet_id', $worksheet->id)->first();
                                @endphp
                                @if($worksheet->question_template_id == $questions->id && $checkQuestions)
                                  <li>{{ $worksheet->title }}</li>
                                @endif
                              @endif
                            @endforeach
                          </ul>
                        </div>														
                        <!-- <div class="col-sm-6">
                          <ul class="list-1 disabled">
                            <li>Listing Question: Worksheet Title 9</li>
                            <li>Listing Question: Worksheet Title 10</li>
                          </ul>
                        </div> -->
                      </div>
                    </div>
                    @endif
                  </div>
                 
                </div>
              </div>
            </div>
            @php
            $i++;
            @endphp
            @endforeach
            
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

@endsection
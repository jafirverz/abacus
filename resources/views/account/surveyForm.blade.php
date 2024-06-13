@extends('layouts.app')
@section('content')
<main class="main-wrap">	
  <div class="tempt-3">
    <div class="container maxmain">
      <!-- <div class="mb-20">
        <a class="link-1 lico" href="{{ url('/') }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
      </div> -->
      <h1 class="title-3">Survey Form</h1>
      <form name="surveyform" method="post" action="{{ route('survey.submit') }}">
        @csrf
      <div class="box-5">
        <h2 class="title-1 text-center"><span>Course Title:</span> 3G Abacus Mental-Arithmetic Course</h2>
        
        <div class="chooselist-2">
          <div class="radiotype">
            <input  type="radio" required name="surveyfor" value="children" id="children" checked />
            <label for="children">Children Course</label>
          </div>
          <div class="radiotype">
            <input  type="radio" required name="surveyfor" value="adult" id="adult" />
            <label for="adult">Adult Course</label>
          </div>
        </div>
        <div class="row mb-40">
          <div class="col-lg-7 col-sm-6">
            <label class="lb-1">Name of Student:</label>
            <input class="form-control" required type="text" value="{{ Auth::user()->name }}" name="name" placeholder="enter student name" />
          </div>
          <div class="col-lg-5 col-sm-6">
            <label class="lb-1">Date</label>
            <div class="date-wrap">
              <i class="fa-solid fa-calendar-days ico"></i>
              <input class="form-control inptype-1 required" name="date" value="{{ date('Y-m-d') }}" type="text" placeholder="dd/mm/yyyy" />
            </div>
          </div>
        </div>
        <input type="hidden" name="surveyId" value="{{ $surveys->id }}">
        @php
        $i = 1;
        @endphp
        @foreach($surveyQuestions as $question)
          @php 
          $questionType = $question->type;
          @endphp
          <div class="title-10"><strong>{{ $i }}. {{ $question->title }}</strong> <em>{{ $question->note_help }}</em></div>
          @php 
          $questionOptions = \App\SurveyQuestionOption::where('survey_question_id', $question->id)->get();
          @endphp
          @if($questionType == 'radio' && $questionOptions)
            @foreach($questionOptions as $options)
              @if($options->option_type == 'without_title')
                <div class="row">
                  <div class="col-md-3">
                    <strong>{{ $options->title }}</strong>
                  </div>
                  <div class="col-md-9">
                    <div class="chooselist-3">
                      @php 
                      $optionChoices =  \App\OptionChoice::where('survey_question_option_id', $options->id)->get();
                      @endphp
                      @if($optionChoices)
                        @foreach($optionChoices as $choices)
                        @if($choices->title == 'Others:')
                        <div class="gitem hastxt">
                          <div class="input-group">
                            <div class="input-group-addon">
                              <div class="radiotype">
                                <input name="{{ strtolower($options->title) }}" type="radio" id="race-4" value="{{ $choices->title }}" />
                                <label for="race-4">{{ $choices->title }}</label>
                              </div>
                            </div>
                            <input class="form-control" type="text" />
                          </div>
                        </div>
                        @elseif($choices->title == 'Employed')
                        <div class="gitem hastxt">
                          <div class="input-group">
                            <div class="input-group-addon">
                              <div class="radiotype">
                                <input name="{{ strtolower($options->title) }}" type="radio" id="occ-4" value="{{ $choices->title }}" />
                                <label for="occ-4">{{ $choices->title }}</label>
                              </div>
                            </div>
                            <input class="form-control" type="text" />
                          </div>
                        </div>
                        @else
                          <div class="gitem">
                            <div class="radiotype">
                              <input name="{{ strtolower($options->title) }}" required type="radio" id="male" value="{{ $choices->title }}" />
                              <label for="male">{{ $choices->title }}</label>
                            </div>
                          </div>
                        @endif
                        @endforeach
                      @endif

                    </div>
                  </div>
                </div>
              @endif
            @endforeach
          

           @if($options->title == 'Level')
            <hr class="bdrtype-3" />
          @endif
          
          @if($options->option_type == 'with_title')
          @php
          if($options->title == 'Level'){
            $widd = "width: 25%";
            $class = "gtb-2 gtbw-1";
          }else{
            $widd = "width: 45%";
            $class = "gtb-2";
          }
          @endphp
          <div class="xscrollbar">
            <table class="{{ $class }}">
              <thead>
                <tr>
                  <th style="{{ $widd }}"><!--This course...--></th>
                  @php 
                  $optionChoices =  \App\OptionChoice::where('survey_question_option_id', $options->id)->get();
                  @endphp
                  @foreach($optionChoices as $choices)
                    <th>{{ $choices->title }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @php 
                
                $surveyQuesOptionChoices =  \App\SurveyQuestionOptionChoices::where('survey_question_option_id', $options->id)->get();
                @endphp
                @foreach($surveyQuesOptionChoices as $quesChoices)
                @if(Auth::user()->user_type_id == 3 && ($quesChoices->title == 'Intermediate Level' || $quesChoices->title == 'Advanced Level'))
                @else
                @php
                if($quesChoices->title == 'Intermediate Level' || $quesChoices->title == 'Advanced Level'){
                  $choiCl = 'subcontent';
                  $tdclass = 'sublb';
                }else{
                  $choiCl = '';
                  $tdclass = '';
                }
                @endphp
                  <tr class="{{ $choiCl }}">
                    <td><strong class="{{ $tdclass }}">{{ $quesChoices->title }}</strong></td>
                    @foreach($optionChoices as $choices)
                    <td>	
                      <div class="radiotype">
                          <input name="{{ strtolower($quesChoices->title) }}" required type="radio" id="ele-{{ rand() }}"  value="{{ $choices->title }}-{{ rand() }}" />
                          <label for="ele-1">{{ $choices->title }}</label>
                        </div>
                    </td>
                    @endforeach
                    
                  </tr>
                @endif
                @endforeach

              </tbody>
              @if($options->title != 'Level')
              <tfoot>
                <tr>
                  <td></td>
                  <td>< 1 year</td>
                  <td>1-2 years</td>
                  <td>2-3 years</td>
                  <td>> 3 years</td>
                </tr>
              </tfoot>
              @endif
            </table>
          </div>
          @endif

          <hr />
          @elseif($questionType == 'textarea' && $questionOptions)
              @foreach($questionOptions as $options)
                <label class="lb-1">{{ $options->title }}</label>
                <textarea class="form-control" cols="30" rows="5" placeholder="Type your feedback" name="{{ strtolower($options->title) }}" value=""></textarea>
              @endforeach
              <hr />
          @endif

          @php
          $i++;
          @endphp
        @endforeach

        <div class="row">
          <div class="col-lg">
            <div class="title-10 mt-0"><strong>4. Consent for feedbacks to be posted onto 3G Abacus Website</strong></div>
          </div>
          <div class="col-auto">
            <div class="chooselist-4">										
              <div class="radiotype">
                <input name="consent" value="allow" required type="radio" id="allow" />
                <label for="allow">I allow</label>
              </div>										
              <div class="radiotype">
                <input name="consent" value="donotallow" required type="radio" id="disallow" />
                <label for="disallow">I disallow</label>
              </div>
            </div>
          </div>
        </div>
      
      </div>
      @if(Auth::user()->user_type_id != 5)
      <div class="output-1">
        <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
      </div>
      @endif
    </form>
    </div>
  </div>	
</main>

@endsection
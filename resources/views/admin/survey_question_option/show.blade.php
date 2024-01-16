@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('options-survey-questions.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            {{--@include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('survey_crud', 'Edit',
            route('survey.edit', $survey->id))]) --}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="">Select Questions</label>
                                    <input class="form-control" type="text" readonly name="survey_question" value="{{ $surveysQuestions->title }}" disabled>
                                    @if ($errors->has('survey_question'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('survey_question') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                                @if($surveysQuestions->type == 'radio')
                                    @foreach($surveysQuestionOptions as $surveysQuestionOption)
                                        <div class="form-group">
                                            <div class="row" style="margin-bottom:30px;">
                                                <div class="col-md-5">
                                                    <input class="form-control" required value="{{ $surveysQuestionOption->title }}" name="input_1[]" placeholder="Option Name" type="text" disabled>
                                                </div>
                                                <div class="col-md-5">
                                                    <select name="radio_type[]" class="form-control" required disabled>
                                                        <option value="">-- Select --</option>
                                                        <option value="with_title" @if(old('radio_type', $surveysQuestionOption->option_type) == 'with_title') selected @endif>With Title</option>
                                                        <option value="without_title" @if(old('radio_type', $surveysQuestionOption->option_type) == 'without_title') selected @endif>Without Title</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="input-group-btn">
                                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                            </div> -->
                                        </div>
                                    @endforeach
                                    <div class="after-add-more"></div>
                                    <!-- <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div> -->
                                @elseif($surveysQuestions->type == 'textarea')
                                    @foreach($surveysQuestionOptions as $surveysQuestionOption)
                                        <div class="form-group">
                                            <div class="row" style="margin-bottom:30px;">
                                                <div class="col-md-5">
                                                    <input class="form-control" required value="{{ $surveysQuestionOption->title }}" name="input_1[]" placeholder="Option Name" type="text" disabled>
                                                </div>
                                            
                                            
                                            </div>
                                            <!-- <div class="input-group-btn">
                                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                            </div> -->
                                        </div>
                                        @endforeach
                                    <div class="after-add-more"></div>
                                    <!-- <div class="input-group-btn">
                                    <button class="btn btn-success add-more1" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div> -->
                                @endif

                                

                                
                            </div>


                            
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- Copy Fields -->
<div class="copy" style="display:none;">
    <div class="form-group">
        <div class="row">
        
            <div class="col-md-5">
                <input class="form-control" required value="" name="input_1[]" placeholder="Option Name" type="text">
            </div>
            <div class="col-md-5">
                <select name="radio_type[]" class="form-control" required>
                    <option value="">-- Select --</option>
                    <option value="with_title" >With Title</option>
                    <option value="without_title" >Without Title</option>
                </select>
            </div>

       </div>
       <div class="input-group-btn">
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
      </div>
    </div>
</div>

<!-- Copy Fields -->
<div class="copy1" style="display:none;">
    <div class="form-group">
        <div class="row">
        
            <div class="col-md-5">
                <input class="form-control" required value="" name="input_1[]" placeholder="Option Name" type="text">
            </div>
            

       </div>
       <div class="input-group-btn">
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
      </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        $('body').on('change','#worksheet', function() {
             alert(this.value);
             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var worksheet_id= this.value;
                //alert(make);
                //alert(id);
                $.ajax({
                    url:"<?php echo url('/'); ?>/admin/survey/find-worksheet",
                    method:"POST",
                    data:{_token: CSRF_TOKEN,worksheet_id:worksheet_id},
                    success:function(data){
                        //$("#model_header_list").html(data);
                        //$('.selectpicker').selectpicker('refresh');
                    }
                });
        });


        $(".add-more").click(function(){
              var html = $(".copy").html();
              $(".after-add-more").after(html);
          });

          $(".add-more1").click(function(){
          var html = $(".copy2").html();
          $(".after-add-more").after(html);
          });
          

          $("body").on("click",".remove",function(){
              $(this).parents(".form-group").remove();
          });

          $("body").on("click",".remove2",function(){
              $(this).parents(".row").remove();
          });

        });
    </script>

@endsection

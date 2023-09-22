@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('option-choices.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            {{--@include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('survey_crud', 'Edit',
            route('survey.edit', $survey->id))]) --}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('option-choices.update', $surveysQuestions->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="">Select Option</label>
                                    <input type="text" class="form-control" name="question_option" value="{{ $surveysQuestions->title }}" readonly>
                                    @if ($errors->has('question_option'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_option') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                                @foreach($optionChoices as $choice)
                                <div class="form-group">
                                    <div class="row" style="margin-bottom:30px;">
                                        <div class="col-md-5">
                                            <input class="form-control" required value="{{ $choice->title }}" name="input_1[]" placeholder="Choices Name" type="text">
                                        </div>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                    </div>
                                </div>
                                @endforeach

                                <div class="after-add-more"></div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>

                                
                                @if(count($surveyQuestionOptionChoices)>0)
                                    <label>Added Options</label>
                                    @foreach($surveyQuestionOptionChoices as $optionchoice)
                                    <div class="form-group">
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-5">
                                                <input class="form-control" required value="{{ $optionchoice->title }}" name="options[]" placeholder="Option Name" type="text">
                                            </div>
                                            
                                        </div>
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="after-add-more1"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more1" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                @endif
                                

                                
                            </div>

                            <input type="hidden" name="question_option_id" value="{{ $surveysQuestions->id }}">
                                
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </form>
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
                <input class="form-control" required value="" name="input_1[]" placeholder="Add Choices" type="text">
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
                <label>Add Options</label>
                <input class="form-control" required value="" name="options[]" placeholder="Add Options" type="text">
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
          $(".after-add-more1").after(html);
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

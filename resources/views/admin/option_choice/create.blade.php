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
            {{-- @include('admin.inc.breadcrumb',['breadcrumbs'=>Breadcrumbs::generate('survey_crud','Create',route('survey.create'))]) --}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('option-choices.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">


                                <div class="form-group">
                                    <label for="">Select Option</label>
                                    <select name="question_option" class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        <option value="">-- Select --</option>
                                        @foreach($surveysQuestionsOptions as $survey)
                                        <option value="<?php echo url('/'); ?>/admin/option-choices/create?quesOption={{ $survey->id }}" @if(isset($_GET['quesOption']) && $_GET['quesOption']==$survey->id) selected @endif>{{ $survey->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('question_option'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_option') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                

                                <div class="row after-add-more choicesadd" style="margin-bottom:30px;">
                                    <div class="col-md-5">
                                        <input class="form-control" required value="" name="input_1[]" placeholder="Add Choices" type="text">
                                    </div>
                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>

                                @php 
                                if(isset($_GET['quesOption'])){
                                    $quesOption = $_GET['quesOption'];
                                    $qesOption = \App\SurveyQuestionOption::where('id', $quesOption )->first();
                                    $option_type = $qesOption->option_type;
                                }else{
                                    $option_type = '';
                                    $quesOption = '';
                                }
                                
                                @endphp

                                @if(isset($option_type) && $option_type=='with_title')
                                    <div class="row after-add-more optionadd" style="margin-bottom:30px;">
                                        <div class="col-md-5">
                                            <label>Add Options</label>
                                            <input class="form-control" required value="" name="options[]" placeholder="Add Options" type="text">
                                        </div>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more1" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                @endif
                            

                            </div>

                            <input type="hidden" name="question_option_id" value="{{ $quesOption }}">
                            
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
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
          $(".choicesadd").after(html);
      });

      $(".add-more1").click(function(){
          var html = $(".copy1").html();
          $(".optionadd").after(html);
      });

      $("body").on("click",".remove",function(){
          $(this).parents(".form-group").remove();
      });

    });
</script>

@endsection

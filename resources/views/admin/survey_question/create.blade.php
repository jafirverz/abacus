@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('survey-questions.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            {{-- @include('admin.inc.breadcrumb',['breadcrumbs'=>Breadcrumbs::generate('survey_crud','Create',route('survey.create'))]) --}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('survey-questions.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">


                                <div class="form-group">
                                    <label for="">Select Survey</label>
                                    <select name="survey" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach($surveys as $survey)
                                        <option value="{{ $survey->id }}">{{ $survey->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('survey'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('survey') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                

                                <div class="form-group">
                                    <label for="">Question</label>
                                    <input type="text" required name="title" class="form-control" value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Note</label>
                                    <input type="text"  name="note" class="form-control" value="{{ old('note') }}">
                                    @if ($errors->has('note'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Qyestion Type</label>
                                    <select name="question_type" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option value="radio">Radio</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="textarea">Textarea</option>
                                        
                                    </select>
                                    @if ($errors->has('question_type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_type') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{-- <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea name="description" class="form-control my-editor" cols="30"
                                              rows="5">{{old('description')}}</textarea>
                                </div> --}}

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                            <option value="{{ $key }}" @if(old('status')==$key) selected @elseif($key==1) selected @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            

                            </div>
                            
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



      $("body").on("click",".remove",function(){
          $(this).parents(".form-group").remove();
      });

    });
</script>

@endsection

@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('grading-paper.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('grading_paper_crud', 'Create', route('grading-paper.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('grading-paper.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text"  name="title" class="form-control" value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="timer">Timer</label>
                                    <select  id="timer"  name="timer"   class="form-control">
                                        <option value="">-- Select --</option>
                                        <option @if(old('timer')=="Yes") selected @endif value="Yes">Yes</option>
                                        <option @if(old('timer')=="No") selected @endif value="No">No</option>
                                    </select>
                                    @if ($errors->has('timer'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('timer') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Time</label>
                                    <input type="number" required name="time" class="form-control" value="{{ old('time') }}">
                                    @if ($errors->has('time'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('time') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="question_type">Type</label>
                                    <select  id="question_type"  required class="form-control"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        <option value="">-- Select --</option>
                                        @if ($templates)
                                        @foreach ($templates as $item)
                                        <option value="<?php echo url('/'); ?>/admin/grading-paper/create?question-type={{ $item->id }}" @if(isset($_GET['question-type']) && $_GET['question-type']==$item->id) selected @endif> {{ $item->title }} </option>
                                        @endforeach
                                        @endif
                                    </select>

                                    @if ($errors->has('question_type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_type') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            @if(isset($_GET['question-type']) && $_GET['question-type']==5)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($_GET['question-type']) }}</label>
                                    <div class="row after-add-more" style="margin-bottom:30px;">
                                        <div class="col-md-3">
                                            <input class="form-control" required value="" name="input_1[]" placeholder="Number 1" type="text">
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" required value="" name="input_2[]" placeholder="Number 2" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <select name="input_3[]" class="form-control">
                                                <option value="add">Add</option>
                                                <option value="subtract">Subtract </option>
                                                <option value="multiply">Multiply</option>
                                                <option value="divide">Divide</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="answer[]" placeholder="= Answer" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
                                        </div>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                    @elseif(isset($_GET['question-type']) && $_GET['question-type']==4)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($_GET['question-type']) }}</label>
                                    <div class="row after-add-more" style="margin-bottom:30px;">
                                        <div class="col-md-6">
                                            <textarea class="" rows="5" cols="40" required value="" name="input_1[]" placeholder="Enter Column 1 data"></textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text">
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
                                        </div>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more3" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                    @elseif(isset($_GET['question-type']) && $_GET['question-type']==8)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($_GET['question-type']) }}</label>
                                    <div class="row after-add-more" style="margin-bottom:30px;">
                                        <div class="col-md-6">
                                            <textarea class="" rows="5" cols="40" required value="" name="input_1[]" placeholder="Enter Column 1 data"></textarea>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="input_2[]" placeholder="Block" type="text">
                                        </div>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more5" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                    @elseif(isset($_GET['question-type']) && ($_GET['question-type']==2 || $_GET['question-type']==3) )

                                <label for="" class=" control-label">{{ getQuestionTemplate($_GET['question-type']) }}</label>
                                <div class="row after-add-more" style="margin-bottom:30px;">
                                    <div class="col-md-6">
                                        <input class="form-control" required value="" name="input_1[]"  type="file">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
                                    </div>

                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more2" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>

                                @elseif(isset($_GET['question-type']) && $_GET['question-type']==1)

                                <label for="" class=" control-label">{{ getQuestionTemplate($_GET['question-type']) }}</label>
                                <div class="row after-add-more" style="margin-bottom:30px;">
                                    <div class="col-md-6">
                                        <input class="form-control" required value="" name="input_1[]"  type="file">
                                    </div>

                                    <div class="col-md-2">
                                        <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" required value="" name="input_2[]" placeholder="Block" type="text">
                                    </div>
                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more4" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>
                                @elseif(isset($_GET['question-type']) && ($_GET['question-type']==6 || $_GET['question-type']==7 || $_GET['question-type']==8 || $_GET['question-type']==9))

                                    <label for="" class=" control-label">{{ getQuestionTemplate($_GET['question-type']) }}</label>
                                    <div class="row after-add-more" style="margin-bottom:30px;">
                                        <div class="col-md-3">
                                            <input class="form-control" required value="" name="input_1[]" placeholder="Number 1" type="text">
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" required value="" name="input_2[]" placeholder="Number 2" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <select name="input_3[]" class="form-control">
                                                <option value="add">Add</option>
                                                <option value="subtract">Subtract </option>
                                                <option value="multiply">Multiply</option>
                                                <option value="divide">Divide</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="answer[]" placeholder="= Answer" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
                                        </div>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                            @endif

                            </div>
                            <input type="hidden" name="question_type" value="@if(isset($_GET['question-type'])) {{ $_GET['question-type'] }}  @endif">
                            <input type="hidden" name="worksheet_id" value="@if(isset($_GET['worksheet_id'])) {{ $_GET['worksheet_id'] }}  @endif">
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
            <div class="col-md-3">
                <input class="form-control" required value="" name="input_1[]" placeholder="Number 1" type="text">
            </div>
            <div class="col-md-3">
                <input class="form-control" required value="" name="input_2[]" placeholder="Number 2" type="text">
            </div>
            <div class="col-md-2">
                <select name="input_3[]" class="form-control">
                    <option value="add">Add</option>
                    <option value="subtract">Subtract </option>
                    <option value="multiply">Multiply</option>
                    <option value="divide">Divide</option>
                </select>
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="answer[]" placeholder="= Answer" type="text">
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
            </div>
       </div>
       <div class="input-group-btn">
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
      </div>
    </div>
</div>

<div class="copy2" style="display:none;">
    <div class="form-group">
        <div class="row">
        <div class="col-md-6">
            <input class="form-control" required name="input_1[]"  type="file">
        </div>
        <div class="col-md-3">
            <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text">
        </div>
        <div class="col-md-3">
            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
        </div>

       </div>
       <div class="input-group-btn">
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
      </div>
    </div>
</div>

<div class="copy3" style="display:none;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <textarea class="" rows="5" cols="40" required value="" name="input_1[]" placeholder="Enter Column 1 data"></textarea>
            </div>
            <div class="col-md-3">
                <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text">
            </div>
            <div class="col-md-3">
                <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
            </div>

        </div>
        <div class="input-group-btn">
            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
        </div>
    </div>
</div>
<div class="copy4" style="display:none;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <input class="form-control" required value="" name="input_1[]"  type="file">
            </div>

            <div class="col-md-2">
                <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text">
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="input_2[]" placeholder="Block" type="text">
            </div>
        </div>
    </div>
</div>
<div class="copy5" style="display:none;">
 <div class="form-group">
  <div class="row">
        <div class="col-md-6">
            <textarea class="" rows="5" cols="40" required value="" name="input_1[]" placeholder="Enter Column 1 data"></textarea>
        </div>
        <div class="col-md-2">
            <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text">
        </div>
        <div class="col-md-2">
            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
        </div>
        <div class="col-md-2">
            <input class="form-control" required value="" name="input_2[]" placeholder="Block" type="text">
        </div>
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
				url:"<?php echo url('/'); ?>/admin/question/find-worksheet",
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

      $(".add-more2").click(function(){
          var html = $(".copy2").html();
          $(".after-add-more").after(html);
      });

    $(".add-more3").click(function(){
        var html = $(".copy3").html();
        $(".after-add-more").after(html);
    });

    $(".add-more4").click(function(){
        var html = $(".copy4").html();
        $(".after-add-more").after(html);
    });
    $(".add-more5").click(function(){
        var html = $(".copy5").html();
        $(".after-add-more").after(html);
    });

      $("body").on("click",".remove",function(){
          $(this).parents(".form-group").remove();
      });

    });
</script>

@endsection

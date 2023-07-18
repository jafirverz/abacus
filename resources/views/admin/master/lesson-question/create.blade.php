@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lesson-questions.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Create', route('bank.create'))])--}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('lesson-questions.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="status">Select Question Template</label>
                                    <select name="questionTemplate" class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        <option value="">-- Select Question Template --</option>
                                        @foreach($questionTemplates as $key => $item)
                                            <option value="<?php echo url('/'); ?>/admin/lesson-questions/create?question-type={{ $item->id }}" @if(isset($_GET['question-type']) && $_GET['question-type']==$item->id) selected @endif>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('questionTemplate'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('questionTemplate') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="status">Select Lesson</label>
                                    <select name="lesson" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach($lessons as $key => $item)
                                            <option value="{{ $item->id }}" >{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('lesson'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('lesson') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Video Upload</label>
                                    <input type="file" name="videofile" class="form-control" id="">
                                    @if ($errors->has('videofile'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('videofile') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">PDF Upload</label>
                                    <input type="file" name="pdf" class="form-control" id="">
                                    @if ($errors->has('pdf'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('pdf') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Powerpoint Upload</label>
                                    <input type="file" name="powerpoint" class="form-control" id="">
                                    @if ($errors->has('powerpoint'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('powerpoint') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Abacus Simulator Link</label>
                                    <input type="text" name="abacus" class="form-control" id="">
                                    @if ($errors->has('abacus'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('abacus') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            @if(isset($_GET['question-type']) && $_GET['question-type']==5)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($_GET['question-type']) }}</label>
                                    <div class="row after-add-more" style="margin-bottom:30px;">
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="input_1[]" placeholder="Variable 1" type="text" required>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="input_2[]" class="form-control">
                                                <option value="multiply">Multiply</option>
                                                <option value="divide">Divide</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="input_3[]" placeholder="Variable 2" type="text" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text" required>
                                        </div>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                            @elseif(isset($_GET['question-type']) && $_GET['question-type']==6)
                            <label for="" class=" control-label">{{ getQuestionTemplate($_GET['question-type']) }}</label>
                            <div class="row after-add-more" style="margin-bottom:30px;">

                                <div class="col-md-2">
                                    <input class="form-control" required value="" name="input_1[]" placeholder="Variable 1" type="text" required>
                                </div>
                                <div class="col-md-2">
                                    <select name="input_2[]" class="form-control">
                                        <option value="add">Add</option>
                                        <option value="subtract">Subtract</option>
                                        <option value="multiply">Multiply</option>
                                        <option value="divide">Divide</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" required value="" name="input_3[]" placeholder="Variable 2" type="text" required>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text" required>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text" required>
                                </div>
                            </div>
                            <div class="input-group-btn">
                                <button class="btn btn-success add-more6" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                            </div>
                            @elseif(isset($_GET['question-type']) && ($_GET['question-type']==2 || $_GET['question-type']==3))

                                <label for="" class=" control-label">{{ getQuestionTemplate($_GET['question-type']) }}</label>
                                <div class="row after-add-more" style="margin-bottom:30px;">
                                    <div class="col-md-5">
                                        <input class="form-control" required value="" name="input_1[]"  type="file">
                                    </div>
                                    <div class="col-md-5">
                                        <input class="form-control" required value="" name="input_2[]" placeholder="Answer" type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" required value="" placeholder="Enter Marks" name="marks[]"  type="text">
                                    </div>

                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more2" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>


                            @elseif(isset($_GET['question-type']) && ($_GET['question-type']==1 ))

                                <label for="" class=" control-label">{{ getQuestionTemplate($_GET['question-type']) }}</label>
                                <div class="row after-add-more" style="margin-bottom:30px;">
                                    <div class="col-md-4">
                                        <input class="form-control" required value="" name="input_1[]"  type="file">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" required value="" name="input_2[]" placeholder="Answer" type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" required value="" placeholder="Enter Marks" name="marks[]"  type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" required value="" placeholder="Enter Block" name="blocks[]"  type="text">
                                    </div>

                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more1" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>

                                @elseif(isset($_GET['question-type']) && $_GET['question-type']==4)

                                    <label for="" class=" control-label">{{ getQuestionTemplate($_GET['question-type']) }}</label>
                                    <div class="row after-add-more" style="margin-bottom:30px;">
                                        <div class="col-md-5">
                                            <textarea class="" rows="5" cols="40" required value="" name="input_1[]" placeholder="Enter Column 1 data"></textarea>
                                        </div>

                                        <div class="col-md-5">
                                            <input class="form-control" required value="" name="input_2[]" placeholder="Answer" type="text">
                                        </div>

                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
                                        </div>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more3" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                            @endif


                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea class="form-control my-editor" name="description">{{ old('description') }}</textarea>
                                </div>

                                

                                <!-- <div class="form-group">
                                    <label for="title">Image</label>
                                    <input type="file" name="image" class="form-control" >
                                    
                                </div> -->


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
                                @if(isset($_GET['question-type']))
                                <input type="hidden" name="question_type" value="{{ $_GET['question-type'] }}">
                                @else
                                <input type="hidden" name="question_type" value="0">
                                @endif

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Submit</button>
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
        
            <div class="col-md-2">
                <input class="form-control" required value="" name="input_1[]" placeholder="Variable 1" type="text" required>
            </div>
            <div class="col-md-2">
                <select name="input_2[]" class="form-control">
                    <option value="multiply">Multiply</option>
                    <option value="divide">Divide</option>
                </select>
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="input_3[]" placeholder="Variable 2" type="text" required>
            </div>

            <div class="col-md-4">
                <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text" required>
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text" required>
            </div>

       </div>
       <div class="input-group-btn">
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
      </div>
    </div>
</div>

<div class="copy1" style="display:none;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <input class="form-control" required name="input_1[]"  type="file">
            </div>
            <div class="col-md-4">
                <input class="form-control" required value="" name="input_2[]" placeholder="Answer" type="text">
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="marks[]" placeholder="Enter Marks"  type="text">
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="blocks[]" placeholder="Enter Block"  type="text">
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
            <div class="col-md-5">
                <input class="form-control" required name="input_1[]"  type="file">
            </div>
            <div class="col-md-5">
                <input class="form-control" required value="" name="input_2[]" placeholder="Answer" type="text">
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="marks[]" placeholder="Enter Marks"  type="text">
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
            <div class="col-md-5">
                <textarea class="" rows="5" cols="40" required value="" name="input_1[]" placeholder="Enter Column 1 data"></textarea>
            </div>
            <div class="col-md-5">
                <input class="form-control" required value="" name="input_2[]" placeholder="Answer" type="text">
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
<div class="copy6" style="display:none;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-2">
                <input class="form-control" required value="" name="input_1[]" placeholder="Variable 1" type="text" required>
            </div>
            <div class="col-md-2">
                <select name="input_2[]" class="form-control">
                    <option value="add">Add</option>
                    <option value="subtract">Subtract</option>
                    <option value="multiply">Multiply</option>
                    <option value="divide">Divide</option>
                </select>
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="input_3[]" placeholder="Variable 2" type="text" required>
            </div>
            <div class="col-md-4">
                <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text" required>
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text" required>
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
          $(".add-more1").click(function(){
              var html = $(".copy1").html();
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
    
        $(".add-more6").click(function(){
            var html = $(".copy6").html();
            $(".after-add-more").after(html);
        });
    
          $("body").on("click",".remove",function(){
              $(this).parents(".form-group").remove();
          });
    
        });
    </script>
@endsection

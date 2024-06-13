@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('question.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            @php
            $worksheett = \App\Worksheet::where('id', $wId)->first();
            @endphp
            <h1>{{ $worksheett->title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('question_crud', 'Create', route('question.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('question.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" required name="title" class="form-control" value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                
                                
                                

                            @if($qId==5)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($qId) }}</label>
                                    <div class="row" style="margin-bottom:30px;">
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="input_1[]" placeholder="Variable 1" type="text" required>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="input_2[]" class="form-control">
                                                <option value="multiply">Multiply</option>
                                                <option value="divide">Divide</option>
                                                <option value="add">Add</option>
                                                <option value="subtract">Subtract</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="input_3[]" placeholder="Variable 2" type="text" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control number-separator" required value="" name="answer[]" placeholder="Answer" type="text" required>
                                        </div>
                                        <div class="col-md-1">
                                            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text" required>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" required value="" name="block[]" placeholder="Block Multiplication Only" type="text" required>
                                        </div>
                                    </div>
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>

                            @elseif($qId==7)
                                    <label for="" class=" control-label">Horizontal Questions</label>
                                    <div class="row" style="margin-bottom:30px;">
        
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
                                            <input class="form-control number-separator" required value="" name="answer[]" placeholder="Answer" type="text" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text" required>
                                        </div>
                                    </div>
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more7" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>


                                    <!-- ////////////////////////////////////// -->
                                    <label for="" class=" control-label">Vertical</label>
                                    <div class="row " style="margin-bottom:30px;">
                                        <div class="col-md-5">
                                            <textarea class="" rows="5" cols="40" required value="" name="vertical_1[]" placeholder="Enter Column 1 data"></textarea>
                                        </div>

                                        <div class="col-md-5">
                                            <input class="form-control number-separator" required value="" name="vertical_2[]" placeholder="Answer" type="text">
                                        </div>

                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="vertical_3[]" placeholder="Marks" type="text">
                                        </div>
                                    </div>
                                    <div class="after-add-more7-1"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more7-1" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>

                            @elseif($qId==6)
                            <label for="" class=" control-label">{{ getQuestionTemplate($qId) }}</label>
                            <div class="row " style="margin-bottom:30px;">

                                <div class="col-md-6">
                                    <input class="form-control" required value="" name="input_1[]" placeholder="Question" type="text" required>
                                </div>
                                <!-- <div class="col-md-2">
                                    <select name="input_2[]" class="form-control">
                                        <option value="add">Add</option>
                                        <option value="subtract">Subtract</option>
                                        <option value="multiply">Multiply</option>
                                        <option value="divide">Divide</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" required value="" name="input_3[]" placeholder="Variable 2" type="text" required>
                                </div> -->
                                <div class="col-md-4">
                                    <input class="form-control number-separator" required value="" name="answer[]" placeholder="Answer" type="text" required>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text" required>
                                </div>
                            </div>
                            <div class="after-add-more"></div>
                            <div class="input-group-btn">
                                <button class="btn btn-success add-more6" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                            </div>
                            @elseif($qId==2 || $qId==3)

                                <label for="" class=" control-label">{{ getQuestionTemplate($qId) }}</label>
                                <div class="row" style="margin-bottom:30px;">
                                    <div class="col-md-5">
                                        <input class="form-control" required value="" name="input_1[]"  type="file">
                                    </div>
                                    <div class="col-md-5">
                                        <input class="form-control number-separator" required value="" name="input_2[]" placeholder="Answer" type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" required value="" placeholder="Enter Marks" name="marks[]"  type="text">
                                    </div>

                                </div>
                                <div class="after-add-more"></div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more2" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>


                            @elseif($qId==11)

                                <label for="" class=" control-label">{{ getQuestionTemplate($qId) }}</label>
                                <div class="row" style="margin-bottom:30px;">
                                    <div class="col-md-5">
                                        <input class="form-control" required value="" name="input_1[]"  type="file">
                                    </div>
                                </div>
                                <div class="after-add-more"></div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more11" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>


                            @elseif($qId==1 )

                                <label for="" class=" control-label">{{ getQuestionTemplate($qId) }}</label>
                                <div class="row" style="margin-bottom:30px;">
                                    
                                    <div class="col-md-4">
                                        <input class="form-control" required value="" name="input_1[]"  type="file">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control number-separator" required value="" name="input_2[]" placeholder="Answer" type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" required value="" placeholder="Enter Marks" name="marks[]"  type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" required value="" placeholder="Enter Block" name="blocks[]"  type="text">
                                    </div>

                                </div>
                                <div class="after-add-more"></div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more1" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>

                                @elseif($qId==4)

                                    <label for="" class=" control-label">{{ getQuestionTemplate($qId) }}</label>
                                    <div class="row" style="margin-bottom:30px;">
                                        <div class="col-md-5">
                                            <textarea class="" rows="5" cols="40" required value="" name="input_1[]" placeholder="Enter Column 1 data"></textarea>
                                        </div>

                                        <div class="col-md-5">
                                            <input class="form-control number-separator" required value="" name="answer[]" placeholder="Answer" type="text">
                                        </div>

                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
                                        </div>
                                    </div>
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more3" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>

                            @elseif($qId==8)
                                    <div class="form-group">
                                        <label for="">Abacus Link</label>
                                        <input type="text" required name="link" class="form-control" value="{{ old('link') }}">
                                        @if ($errors->has('link'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('link') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <label for="" class=" control-label">{{ getQuestionTemplate($qId) }}</label>
                                    <div class="row" style="margin-bottom:30px;">
                                        <div class="col-md-4">
                                            <textarea class="" rows="5" cols="40" required value="" name="input_1[]" placeholder="Enter Column 1 data"></textarea>
                                        </div>

                                        <div class="col-md-4">
                                            <input class="form-control number-separator" required value="" name="answer[]" placeholder="Answer" type="text">
                                        </div>

                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="" name="blocks[]" placeholder="Block" type="text">
                                        </div>
                                    </div>
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more8" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>



                                @elseif($qId==10)
                                    <div class="form-group">
                                        <label for="">Upload PDF</label>
                                        <input type="file" required name="pdf" class="form-control" >
                                        @if ($errors->has('file'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('file') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    

                            @endif

                            </div>
                            <input type="hidden" name="question_type" value="{{ $qId }}">
                            <input type="hidden" name="worksheet_id" value="{{ $wId }}">
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
        
            <div class="col-md-2">
                <input class="form-control" required value="" name="input_1[]" placeholder="Variable 1" type="text" required>
            </div>
            <div class="col-md-2">
                <select name="input_2[]" class="form-control">
                    <option value="multiply">Multiply</option>
                    <option value="divide">Divide</option>
                    <option value="add">Add</option>
                    <option value="subtract">Subtract</option>
                </select>
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="input_3[]" placeholder="Variable 2" type="text" required>
            </div>

            <div class="col-md-2">
                <input class="form-control number-separator" required value="" name="answer[]" placeholder="Answer" type="text" required>
            </div>
            <div class="col-md-1">
                <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text" required>
            </div>
            <div class="col-md-3">
                <input class="form-control" required value="" name="block[]" placeholder="Block Multiplication Only" type="text" required>
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
                <input class="form-control number-separator" required value="" name="input_2[]" placeholder="Answer" type="text">
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
                <input class="form-control number-separator" required value="" name="input_2[]" placeholder="Answer" type="text">
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
                <input class="form-control number-separator" required value="" name="answer[]" placeholder="Answer" type="text">
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
            <div class="col-md-6">
                <input class="form-control" required value="" name="input_1[]" placeholder="Question" type="text" required>
            </div>
            <!-- <div class="col-md-2">
                <select name="input_2[]" class="form-control">
                    <option value="add">Add</option>
                    <option value="subtract">Subtract</option>
                    <option value="multiply">Multiply</option>
                    <option value="divide">Divide</option>
                </select>
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="input_3[]" placeholder="Variable 2" type="text" required>
            </div> -->
            <div class="col-md-4">
                <input class="form-control number-separator" required value="" name="answer[]" placeholder="Answer" type="text" required>
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

<div class="copy7" style="display:none;">
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
                <input class="form-control number-separator" required value="" name="answer[]" placeholder="Answer" type="text" required>
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

<div class="copy7-1" style="display:none;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-5">
                <textarea class="" rows="5" cols="40" required value="" name="vertical_1[]" placeholder="Enter Column 1 data"></textarea>
            </div>
            <div class="col-md-5">
                <input class="form-control number-separator" required value="" name="vertical_2[]" placeholder="Answer" type="text">
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="vertical_3[]" placeholder="Marks" type="text">
            </div>
        </div>
        <div class="input-group-btn">
            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
        </div>
    </div>
</div>

<div class="copy8" style="display:none;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <textarea class="" rows="5" cols="40" required value="" name="input_1[]" placeholder="Enter Column 1 data"></textarea>
            </div>
            <div class="col-md-4">
                <input class="form-control number-separator" required value="" name="answer[]" placeholder="Answer" type="text">
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="blocks[]" placeholder="Block" type="text">
            </div>
        </div>
        <div class="input-group-btn">
            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
        </div>
    </div>
</div>

<div class="copy11" style="display:none;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-5">
                <input class="form-control" required name="input_1[]"  type="file">
            </div>
       </div>
       <div class="input-group-btn">
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
      </div>
    </div>
</div>

<!-- <script src="https://cdn.jsdelivr.net/gh/amiryxe/easy-number-separator/easy-number-separator.js"></script>
<script>
  $(function () {
    easyNumberSeparator({
      selector: '.number-separator',
      separator: ',',
      //resultInput: '.number-separator',
    })
  });
  
</script> -->

<script>

$(document).ready(function () {

    // $('body').on('change','#worksheet', function() {
    //      alert(this.value);
    //      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		// 	var worksheet_id= this.value;
		// 	//alert(make);
		// 	//alert(id);
		// 	$.ajax({
		// 		url:"<?php echo url('/'); ?>/admin/question/find-worksheet",
		// 		method:"POST",
		// 		data:{_token: CSRF_TOKEN,worksheet_id:worksheet_id},
		// 		success:function(data){
		// 			//$("#model_header_list").html(data);
		// 			//$('.selectpicker').selectpicker('refresh');
		// 		}
		// 	});
    // });



      $(".add-more").click(function(){
          var html = $(".copy").html();
          $(".after-add-more").append(html);
          easyNumberSeparator({
            selector: '.number-separator',
            separator: ',',
            //resultInput: '.number-separator',
            })  
      });
      $(".add-more1").click(function(){
          var html = $(".copy1").html();
          $(".after-add-more").append(html);
          easyNumberSeparator({
            selector: '.number-separator',
            separator: ',',
            //resultInput: '.number-separator',
            })
      });

      $(".add-more2").click(function(){
          var html = $(".copy2").html();
          $(".after-add-more").append(html);
          easyNumberSeparator({
            selector: '.number-separator',
            separator: ',',
            //resultInput: '.number-separator',
            })
      });

    $(".add-more3").click(function(){
        var html = $(".copy3").html();
        $(".after-add-more").append(html);
        easyNumberSeparator({
        selector: '.number-separator',
        separator: ',',
        //resultInput: '.number-separator',
        })

        //$('input[type=text]').addClass('number-separator');
    });

    $(".add-more6").click(function(){
        var html = $(".copy6").html();
        $(".after-add-more").append(html);
        easyNumberSeparator({
        selector: '.number-separator',
        separator: ',',
        //resultInput: '.number-separator',
        })
    });

    $(".add-more7").click(function(){
        var html = $(".copy7").html();
        $(".after-add-more").append(html);
        easyNumberSeparator({
        selector: '.number-separator',
        separator: ',',
        //resultInput: '.number-separator',
        })
    });

    $(".add-more7-1").click(function(){
        var html = $(".copy7-1").html();
        $(".after-add-more7-1").append(html);
        easyNumberSeparator({
        selector: '.number-separator',
        separator: ',',
        //resultInput: '.number-separator',
        })
    });

    $(".add-more8").click(function(){
        var html = $(".copy8").html();
        $(".after-add-more").append(html);
        easyNumberSeparator({
        selector: '.number-separator',
        separator: ',',
        //resultInput: '.number-separator',
        })
    });

    $(".add-more11").click(function(){
        var html = $(".copy11").html();
        $(".after-add-more").append(html);
        easyNumberSeparator({
        selector: '.number-separator',
        separator: ',',
        //resultInput: '.number-separator',
        })
    });

      $("body").on("click",".remove",function(){
          $(this).parents(".form-group").remove();
      });

    });
</script>

@endsection

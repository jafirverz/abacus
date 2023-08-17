@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('question.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('question_crud', 'Edit',
            route('question.edit', $question->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('question.update', $question->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title', $question->title) }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="worksheet">Worksheet</label>
                                    <select disabled="disabled"  id="worksheet_id" class="form-control"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        <option value="">-- Select --</option>
                                        @if ($worksheets)
                                        @foreach ($worksheets as $item)
                                        <option value="<?php echo url('/'); ?>/admin/question/{{ $question->id }}/edit?question-type={{ $item->question_type }}" @if(old('worksheet_id', $question->worksheet_id)==$item->id) selected @endif> {{ $item->title }} </option>
                                        @endforeach
                                        @endif
                                    </select>

                                    @if ($errors->has('worksheet'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('worksheet') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                @if($question->question_type==8)
                                    <div class="form-group">
                                        <label for="">Abacus Link</label>
                                        <input type="text" required name="link" class="form-control" value="{{ old('link', $question->link) }}">
                                        @if ($errors->has('link'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('link') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                @endif


                                @php 
                                $_GET['question-type'] = '';
                                @endphp
                                @if((isset($_GET['question-type']) && $_GET['question-type']==9) || $question->question_type==9)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(3) }}</label>
                                    @php
                                        $json_question=json_decode($question->json_question);
                                        for($i=0;$i<count($json_question->input_1);$i++)
                                        {

                                    @endphp

                                        <div class="form-group">
                                            <div class="row" style="margin-bottom:30px;">
                                                <div class="col-md-4">
                                                    <input class="form-control" required value="{{ $json_question->input_1[$i] }}" name="input_1[]" placeholder="Number 1" type="text">
                                                </div>
                                                <div class="col-md-4">
                                                    <input class="form-control" required value="{{ $json_question->input_2[$i] }}" name="input_2[]" placeholder="Number 2" type="text">
                                                </div>
                                                <div class="col-md-4">
                                                    <input class="form-control" required value="{{ $json_question->input_3[$i] }}" name="input_3[]" placeholder="= Answer" type="text">
                                                </div>
                                            </div>
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                            </div>
                                        </div>
                                    @php } @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>

                                    @elseif((isset($_GET['question-type']) && $_GET['question-type']==2) || $question->question_type==2 || $question->question_type==3 || $_GET['question-type']==3)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(2) }}</label>
                                    @php
                                    //$json_question=json_decode($question->json_question);
                                    $json_question=\App\MiscQuestion::where('question_id', $question->id)->get();
                                    foreach($json_question as $quest)
                                    {

                                        @endphp

                                            <div class="form-group">
                                                <div class="row" style="margin-bottom:30px;">
                                                    <div class="col-md-4">
                                                        <input class="form-control"  value="{{ $quest->question_1 }}" name="input_1_old[]" type="hidden">
                                                        <a href="{{ url('/') }}/upload-file/{{ $quest->question_1 }}" target="_blank"> {{ $quest->question_1 }} </a>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" required value="{{ $quest->answer }}" name="input_2_old[]" placeholder="Answer" type="text">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input class="form-control" required value="{{ $quest->marks }}" name="marks_old[]" placeholder="Marks" type="text">
                                                    </div>
                                                </div>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                        @php } @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more2" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>

                                    @elseif((isset($_GET['question-type']) && $_GET['question-type']==1) || $question->question_type==1)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(1) }}</label>
                                    @php
                                    //$json_question=json_decode($question->json_question);
                                    $json_question=\App\MiscQuestion::where('question_id', $question->id)->get();
                                    foreach($json_question as $quest)
                                    {

                                        @endphp

                                            <div class="form-group">
                                                <div class="row" style="margin-bottom:30px;">
                                                    <div class="col-md-4">
                                                        <input class="form-control"  value="{{ $quest->question_1 }}" name="input_1_old[]" type="hidden">
                                                        <a href="{{ url('/') }}/upload-file/{{ $quest->question_1 }}" target="_blank"> {{ $quest->question_1 }} </a>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" required value="{{ $quest->answer }}" name="input_2_old[]" placeholder="Answer" type="text">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input class="form-control" required value="{{ $quest->marks }}" name="marks_old[]" placeholder="Marks" type="text">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input class="form-control" required value="{{ $quest->block }}" name="blocks_old[]" placeholder="Block" type="text">
                                                    </div>
                                                </div>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                        @php } @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more1" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>

                                @elseif((isset($_GET['question-type']) && $_GET['question-type']==4) || $question->question_type==4)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(4) }}</label>
                                    @php
                                        $json_question=\App\MiscQuestion::where('question_id', $question->id)->get();
                                        foreach($json_question as $quest)
                                        {

                                    @endphp

                                    <div class="form-group">
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-5">
                                                <textarea rows="5" cols="40" name="input_1[]">{{ $quest->question_1 }}</textarea>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" required value="{{ $quest->answer }}" name="answer[]" placeholder="Answer" type="text">
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" required value="{{ $quest->marks }}" name="marks[]" placeholder="Marks" type="text">
                                            </div>
                                        </div>
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div>
                                    </div>
                                    @php } @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more3" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                @elseif((isset($_GET['question-type']) && $_GET['question-type']==6) || $question->question_type==6)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(6) }}</label>
                                    @php
                                        $getQues = \App\MiscQuestion::where('question_id', $question->id)->get();
                                        foreach($getQues as $ques)
                                        {

                                    @endphp

                                    <div class="form-group">
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-2">
                                                <input class="form-control" required value="{{ $ques->question_1 }}" name="input_1[]" placeholder="Variable 1" type="text" required>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="input_2[]" class="form-control">
                                                    <option value="add" @if($ques->symbol == 'add') selected @endif>Add</option>
                                                    <option value="subtract" @if($ques->symbol == 'subtract') selected @endif>Subtract</option>
                                                    <option value="multiply" @if($ques->symbol == 'multiply') selected @endif>Multiply</option>
                                                    <option value="divide" @if($ques->symbol == 'divide') selected @endif>Divide</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" required value="{{ $ques->question_2 }}" name="input_3[]" placeholder="Variable 2" type="text" required>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" required value="{{ $ques->answer }}" name="answer[]" placeholder="Answer" type="text" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" required value="{{ $ques->marks }}" name="marks[]" placeholder="Marks" type="text" required>
                                            </div>
                                        </div>
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div>
                                    </div>
                                    @php } @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more6" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>

                                    @elseif((isset($_GET['question-type']) && $_GET['question-type']==5) || $question->question_type==5)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(5) }}</label>
                                    @php
                                        $getQues = \App\MiscQuestion::where('question_id', $question->id)->get();
                                        foreach($getQues as $ques)
                                        {

                                    @endphp

                                    <div class="form-group">
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-2">
                                                <input class="form-control" required value="{{ $ques->question_1 }}" name="input_1[]" placeholder="Variable 1" type="text" required>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="input_2[]" class="form-control">
                                                   
                                                    <option value="multiply" @if($ques->symbol == 'multiply') selected @endif>Multiply</option>
                                                    <option value="divide" @if($ques->symbol == 'divide') selected @endif>Divide</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" required value="{{ $ques->question_2 }}" name="input_3[]" placeholder="Variable 2" type="text" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" required value="{{ $ques->answer }}" name="answer[]" placeholder="Answer" type="text" required>
                                            </div>
                                            <div class="col-md-1">
                                                <input class="form-control" required value="{{ $ques->marks }}" name="marks[]" placeholder="Marks" type="text" required>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" required value="{{ $ques->block }}" name="block[]" placeholder="Block Multiplication Only" type="text" required>
                                            </div>
                                        </div>
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div>
                                    </div>
                                    @php } @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more5" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>


                                @elseif((isset($_GET['question-type']) && $_GET['question-type']==8) || $question->question_type==8)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(8) }}</label>
                                    @php
                                        $json_question=\App\MiscQuestion::where('question_id', $question->id)->get();
                                        foreach($json_question as $quest)
                                        {

                                    @endphp

                                    <div class="form-group">
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-4">
                                                <textarea rows="5" cols="40" name="input_1[]">{{ $quest->question_1 }}</textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" required value="{{ $quest->answer }}" name="answer[]" placeholder="Answer" type="text">
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" required value="{{ $quest->marks }}" name="marks[]" placeholder="Marks" type="text">
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" required value="{{ $quest->block }}" name="blocks[]" placeholder="Block" type="text">
                                            </div>
                                        </div>
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div>
                                    </div>
                                    @php } @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more8" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                @endif



                            </div>
                            @if(!empty($_GET['question-type']))
                            <input type="hidden" name="question_type" value="{{ $_GET['question-type'] }}">
                            @else
                            <input type="hidden" name="question_type" value="{{ $question->question_type }}">
                            @endif

                            @if(isset($_GET['worksheet_id']))
                            <input type="hidden" name="worksheet_id" value="{{ $_GET['worksheet_id'] }}">
                            @else
                            <input type="hidden" name="worksheet_id" value="{{ $question->worksheet_id }}">
                            @endif
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
        <div class="col-md-4">
            <input class="form-control" required value="" name="input_1[]" placeholder="Number 1" type="text">
        </div>
        <div class="col-md-4">
            <input class="form-control" required value="" name="input_2[]" placeholder="Number 2" type="text">
        </div>
        <div class="col-md-4">
            <input class="form-control" required value="" name="input_3[]" placeholder="= Answer" type="text">
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

<div class="copy2" style="display:none;">
    <div class="form-group">
        <div class="row">
        <div class="col-md-4">
            <input class="form-control" required name="input_1[]"  type="file">
        </div>
        <div class="col-md-4">
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

<div class="copy3" style="display:none;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-5">
                <textarea class="" rows="5" cols="40" required value="" name="input_1[]" placeholder="Enter Column 1 data"></textarea>
            </div>
            <div class="col-md-5">
                <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text">
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

<div class="copy5" style="display:none;">
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
            <div class="col-md-2">
                <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text" required>
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

<div class="copy8" style="display:none;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <textarea class="" rows="5" cols="40" required value="" name="input_1[]" placeholder="Enter Column 1 data"></textarea>
            </div>
            <div class="col-md-4">
                <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text">
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

        $(".add-more5").click(function(){
            var html = $(".copy5").html();
            $(".after-add-more").after(html);
        });

        $(".add-more8").click(function(){
            var html = $(".copy8").html();
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

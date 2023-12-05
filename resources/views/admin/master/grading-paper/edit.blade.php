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
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('grading_paper_crud', 'Edit',
            route('grading-paper.edit', $paper->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('grading-paper.update', $paper->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exam_grade">Exam Grade</label>
                                    <select  name="exam_grade"  required class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($grades)
                                        @foreach ($grades as $item)
                                        <option value="{{ $item->id }}" @if(old('exam_grade', $paper->exam_grade)==$item->id) selected @endif> {{ $item->title }} </option>
                                        @endforeach
                                        @endif
                                    </select>

                                    @if ($errors->has('exam_grade'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('exam_grade') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title', $paper->title) }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="type">Paper Type</label>
                                    <select name="type" class="form-control">
                                        <option value="">-- Select --</option>
                                        <option @if(old('type', $paper->type)==1) selected @endif value="1">Actual</option>
                                        <option @if(old('type', $paper->type)==2) selected @endif value="2">Practice</option>
                                    </select>
                                    @if ($errors->has('type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('type') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="timer">Timer</label>
                                    <select  id="timer" name="timer"  class="form-control">
                                        <option value="">-- Select --</option>
                                        <option @if(old('timer', $paper->timer)=="Yes") selected @endif value="Yes">Yes</option>
                                        <option @if(old('timer', $paper->timer)=="No") selected @endif value="No">No</option>
                                    </select>
                                    @if ($errors->has('timer'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('timer') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Time</label>
                                    <input type="number"  name="time" class="form-control" value="{{ old('time',$paper->time) }}">
                                    @if ($errors->has('time'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('time') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="question_type">Question Template</label>
                                    <select disabled="disabled"  id="question_type" class="form-control"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        <option value="">-- Select --</option>
                                        @if ($templates)
                                        @foreach ($templates as $item)
                                        <option value="<?php echo url('/'); ?>/admin/grading-paper/{{ $paper->id }}/edit?question-type={{ $item->id }}" @if(old('question_type', $paper->question_type)==$item->id) selected @endif> {{ $item->title }} </option>
                                        @endforeach
                                        @endif
                                    </select>

                                    @if ($errors->has('question_type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_type') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                    @if((isset($_GET['question-type']) && $_GET['question-type']==5) || $paper->question_type==5)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(5) }}</label>
                                    @php
                                    $detail=getPaperQuestions($paper->id);
                                    if($detail)
                                    {
                                    foreach($detail as $key=>$value)
                                    {
                                    @endphp

                                        <div class="form-group">
                                            <div class="row" style="margin-bottom:30px;">
                                                <div class="col-md-3">
                                                    <input class="form-control" required value="{{ $value->input_1 }}" name="old_input_1[]" placeholder="Number 1" type="text">
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" required value="{{ $value->input_2 }}" name="old_input_2[]" placeholder="Number 2" type="text">
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="old_input_3[]" class="form-control">
                                                        <option @if($value->input_3=='add') selected @endif value="add" >Add</option>
                                                        <option @if($value->input_3=='subtract') selected @endif value="subtract">Subtract </option>
                                                        <option @if($value->input_3=='multiply') selected @endif value="multiply">Multiply</option>
                                                        <option @if($value->input_3=='divide') selected @endif value="divide">Divide</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" required value="{{ $value->answer }}" name="old_answer[]" placeholder="= Answer" type="text">
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" required value="{{ $value->marks }}" name="old_marks[]" placeholder="= Marks" type="text">
                                                </div>
                                            </div>
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="listing_detail_id[]" value="{{ $value->id }}">
                                    @php }} @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                    @elseif((isset($_GET['question-type']) && $_GET['question-type']==7) || $paper->question_type==7)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(7) }}</label>
                                    @php
                                    $detail=getPaperQuestions($paper->id);
                                    if($detail)
                                    {
                                    foreach($detail as $key=>$value)
                                    {
                                    @endphp

                                        <div class="form-group">
                                            <div class="row" style="margin-bottom:30px;">
                                                <div class="col-md-3">
                                                    <input class="form-control" required value="{{ $value->input_1 }}" name="old_input_1[]" placeholder="Number 1" type="text">
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" required value="{{ $value->input_2 }}" name="old_input_2[]" placeholder="Number 2" type="text">
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="old_input_3[]" class="form-control">
                                                        <option @if($value->input_3=='add') selected @endif value="add" >Add</option>
                                                        <option @if($value->input_3=='subtract') selected @endif value="subtract">Subtract </option>
                                                        <option @if($value->input_3=='multiply') selected @endif value="multiply">Multiply</option>
                                                        <option @if($value->input_3=='divide') selected @endif value="divide">Divide</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" required value="{{ $value->answer }}" name="old_answer[]" placeholder="= Answer" type="text">
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" required value="{{ $value->marks }}" name="old_marks[]" placeholder="= Marks" type="text">
                                                </div>
                                            </div>
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="listing_detail_id[]" value="{{ $value->id }}">
                                    @php }} @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                    @elseif((isset($_GET['question-type']) && $_GET['question-type']==4) || $paper->question_type==4)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(4) }}</label>
                                    @php
                                    $detail=getPaperQuestions($paper->id);
                                    if($detail)
                                    {
                                    foreach($detail as $key=>$value)
                                    {
                                    @endphp

                                    <div class="form-group">
                                            <div class="row" style="margin-bottom:30px;">
                                                <div class="col-md-6">
                                                    <textarea class="" rows="5" cols="40" required value="" name="old_input_1[]" placeholder="Enter Column 1 data">{{ $value->input_1 }}</textarea>
                                                </div>

                                                <div class="col-md-2">
                                                    <input class="form-control" required value="{{ $value->answer }}" name="old_answer[]" placeholder="= Answer" type="text">
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" required value="{{ $value->marks }}" name="old_marks[]" placeholder="= Marks" type="text">
                                                </div>
                                            </div>
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                            </div>
                                    </div>
                                    <input type="hidden" name="listing_detail_id[]" value="{{ $value->id }}">
                                    @php }} @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more3" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                    @elseif((isset($_GET['question-type']) && $_GET['question-type']==8) || $paper->question_type==8)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(8) }}</label>
                                    @php
                                    $detail=getPaperQuestions($paper->id);
                                    if($detail)
                                    {
                                    foreach($detail as $key=>$value)
                                    {
                                    @endphp

                                    <div class="form-group">
                                            <div class="row" style="margin-bottom:30px;">
                                                <div class="col-md-6">
                                                    <textarea class="" rows="5" cols="40" required value="" name="old_input_1[]" placeholder="Enter Column 1 data">{{ $value->input_1 }}</textarea>
                                                </div>

                                                <div class="col-md-2">
                                                    <input class="form-control" required value="{{ $value->answer }}" name="old_answer[]" placeholder="= Answer" type="text">
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" required value="{{ $value->marks }}" name="old_marks[]" placeholder="= Marks" type="text">
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" required value="{{ $value->input_2 }}" name="old_input_2[]" placeholder="= Marks" type="text">
                                                </div>
                                            </div>
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                            </div>
                                    </div>
                                    <input type="hidden" name="listing_detail_id[]" value="{{ $value->id }}">
                                    @php }} @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more5" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                    @elseif((isset($_GET['question-type']) && $_GET['question-type']==1) || $paper->question_type==1)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(2) }}</label>
                                    @php
                                    $detail=getPaperQuestions($paper->id);
                                    if($detail)
                                    {
                                    foreach($detail as $key=>$value)
                                    {
                                    @endphp

                                            <div class="form-group">
                                                <div class="row" style="margin-bottom:30px;">
                                                    <div class="col-md-6">
                                                        <input class="form-control"  value="{{ $value->input_1 }}" name="old_input_1[]" type="hidden">
                                                        <a href="{{ url('/') }}/upload-file/{{ $value->input_1 }}" target="_blank"> {{ $value->input_1 }} </a>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input class="form-control" required value="{{ $value->answer }}" name="old_answer[]" placeholder="= Answer" type="text">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input class="form-control" required value="{{ $value->marks }}" name="old_marks[]" placeholder="= Marks" type="text">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input class="form-control" required value="{{ $value->input_2 }}" name="old_input_2[]" placeholder="Block" type="text">
                                                    </div>
                                                </div>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="listing_detail_id[]" value="{{ $value->id }}">
                                        @php }} @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more4" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                    @elseif((isset($_GET['question-type']) && $_GET['question-type']==2) || $paper->question_type==2)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(2) }}</label>
                                    @php
                                    $detail=getPaperQuestions($paper->id);
                                    if($detail)
                                    {
                                    foreach($detail as $key=>$value)
                                    {
                                    @endphp

                                            <div class="form-group">
                                                <div class="row" style="margin-bottom:30px;">
                                                    <div class="col-md-6">
                                                        <a href="{{ url('/') }}/upload-file/{{ $value->input_1 }}" target="_blank"> {{ $value->input_1 }} </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control"  value="{{ $value->input_1 }}" name="old_input_1[]" type="hidden">
                                                        <input class="form-control" required value="{{ $value->answer }}" name="old_answer[]" placeholder="= Answer" type="text">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control" required value="{{ $value->marks }}" name="old_marks[]" placeholder="= Marks" type="text">
                                                    </div>
                                                </div>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="listing_detail_id[]" value="{{ $value->id }}">
                                        @php }} @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more2" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                    @elseif((isset($_GET['question-type']) && $_GET['question-type']==3) || $paper->question_type==3)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(3) }}</label>
                                    @php
                                    $detail=getPaperQuestions($paper->id);
                                    if($detail)
                                    {
                                    foreach($detail as $key=>$value)
                                    {
                                    @endphp

                                            <div class="form-group">
                                                <div class="row" style="margin-bottom:30px;">
                                                    <div class="col-md-6">
                                                        <a href="{{ url('/') }}/upload-file/{{ $value->input_1 }}" target="_blank"> {{ $value->input_1 }} </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control"  value="{{ $value->input_1 }}" name="old_input_1[]" type="hidden">
                                                        <input class="form-control" required value="{{ $value->answer }}" name="old_answer[]" placeholder="= Answer" type="text">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control" required value="{{ $value->marks }}" name="old_marks[]" placeholder="= Marks" type="text">
                                                    </div>
                                                </div>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="listing_detail_id[]" value="{{ $value->id }}">
                                        @php }} @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more2" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                @elseif((isset($_GET['question-type']) && $_GET['question-type']==6) || $paper->question_type==6)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(6) }}</label>
                                    @php
                                    $detail=getPaperQuestions($paper->id);
                                    if($detail)
                                    {
                                    foreach($detail as $key=>$value)
                                    {
                                    @endphp

                                        <div class="form-group">
                                            <div class="row" style="margin-bottom:30px;">
                                                <div class="col-md-3">
                                                    <input class="form-control" required value="{{ $value->input_1 }}" name="old_input_1[]" placeholder="Number 1" type="text">
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" required value="{{ $value->input_2 }}" name="old_input_2[]" placeholder="Number 2" type="text">
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="old_input_3[]" class="form-control">
                                                        <option value="add">Add</option>
                                                        <option value="subtract">Subtract </option>
                                                        <option value="multiply">Multiply</option>
                                                        <option value="divide">Divide</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" required value="{{ $value->answer }}" name="old_answer[]" placeholder="= Answer" type="text">
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" required value="{{ $value->marks }}" name="old_marks[]" placeholder="= Marks" type="text">
                                                </div>
                                            </div>
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="listing_detail_id[]" value="{{ $value->id }}">
                                    @php }} @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                                    @endif



                            </div>
                            @if(isset($_GET['question-type']))
                            <input type="hidden" name="question_type" value="{{ $_GET['question-type'] }}">
                            @else
                            <input type="hidden" name="question_type" value="{{ $paper->question_type }}">
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

          $("body").on("click",".remove2",function(){
              $(this).parents(".row").remove();
          });

        });
    </script>

@endsection

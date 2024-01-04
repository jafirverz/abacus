  @extends('admin.layout.app')

@section('content')
@php
  $question_template_id = getPaperDetail($paper_id)->question_template_id;
@endphp
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('test-paper-question.index',$list->paper_id ) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
          @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_test_paper_question_crud', $list->paper_id ,
            'Edit', route('test-paper-question.edit', ['paper_id' => $list->paper_id , 'id' => $list->id]))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('test-paper-question.update',  ['paper_id' => $list->paper_id , 'id' => $list->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="question">Instruction</label>
                                    <input type="text" name="question" class="form-control" id=""
                                        value="{{ old('question', $list->question) }}">
                                    @if ($errors->has('question'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label >Question Template</label>
                                    <select disabled  class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($questions)
                                            @foreach ($questions as $key=>$item)
                                            <option value="{{ $item->id }}" @if($question_template_id ==$item->id)
                                                selected
                                                @endif>{{ $item->title }}</option>
                                            @endforeach
                                            @if(getPaperDetail($paper_id)->paper_type==1)
                                            <option  @if($question_template_id==11)
                                                selected
                                                @endif value="11">Other</option>
                                            @endif
                                        @endif
                                    </select>
                                    @if ($errors->has('question_template_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_template_id') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                @if(getPaperDetail($paper_id)->paper_type==1 && $question_template_id==11)

                                <div class="form-group">
                                    <label for="write_from">Write From </label>
                                    <input type="text" name="write_from" class="form-control" id=""
                                        value="{{ old('write_from', $list->write_from) }}">
                                    @if ($errors->has('write_from'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('write_from') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="write_to">Write To </label>
                                    <input type="text" name="write_to" class="form-control" id=""
                                        value="{{ old('write_to', $list->write_to) }}">
                                    @if ($errors->has('write_to'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('write_to') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="marks">Marks </label>
                                    <input type="text" name="marks" class="form-control" id=""
                                        value="{{ old('marks', $list->marks) }}">
                                    @if ($errors->has('marks'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('marks') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @endif
                                @if(isset($question_template_id) && $question_template_id==7)
                                    <div class="form-group">
                                        <label for="template">Input Type</label>
                                        <select disabled name="template" class="form-control">
                                            <option value="">-- Select --</option>
                                            @if (gradingExamLayout())
                                            @foreach (gradingExamLayout() as $key=>$item)
                                            <option value="{{ $key }}" @if(old('template', $list->template)==$key)
                                                selected
                                                @endif>{{ $item }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('template'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('template') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <input type="hidden" name="template" value="{{ $list->template }}">
                                @endif
                                @if(isset($question_template_id) && $question_template_id==5)
                                    @php
                                    $detail=getAllQuestions($list->id);
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
                                                <div class="col-md-2">
                                                    <select name="old_input_3[]" class="form-control">
                                                        <option @if($value->input_3=='add') selected @endif value="add" >Add</option>
                                                        <option @if($value->input_3=='subtract') selected @endif value="subtract">Subtract </option>
                                                        <option @if($value->input_3=='multiply') selected @endif value="multiply">Multiply</option>
                                                        <option @if($value->input_3=='divide') selected @endif value="divide">Divide</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" required value="{{ $value->input_2 }}" name="old_input_2[]" placeholder="Number 2" type="text">
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
                                @php } } @endphp
                                <div class="after-add-more"></div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>
                                @elseif(isset($question_template_id) && $question_template_id==4)
                                @php
                                $detail=getAllQuestions($list->id);
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
                            @php } } @endphp
                            <div class="after-add-more"></div>
                            <div class="input-group-btn">
                                <button class="btn btn-success add-more3" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                            </div>
                            @elseif(isset($question_template_id) && $question_template_id==7)
                             @if($list->template==1)
                                        @php
                                        $detail=getAllQuestions($list->id);
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
                                    @php } } @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more3" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>
                             @else
                                        @php
                                        $detail=getAllQuestions($list->id);
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
                                                        <div class="col-md-2">
                                                            <select name="old_input_3[]" class="form-control">
                                                                <option @if($value->input_3=='add') selected @endif value="add" >Add</option>
                                                                <option @if($value->input_3=='subtract') selected @endif value="subtract">Subtract </option>
                                                                <option @if($value->input_3=='multiply') selected @endif value="multiply">Multiply</option>
                                                                <option @if($value->input_3=='divide') selected @endif value="divide">Divide</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input class="form-control" required value="{{ $value->input_2 }}" name="old_input_2[]" placeholder="Number 2" type="text">
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
                                    @php } } @endphp
                                    <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>


                                @endif
                            @elseif(isset($question_template_id) && $question_template_id==8)
                                @php
                                $detail=getAllQuestions($list->id);
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
                            @php } } @endphp
                            <div class="after-add-more"></div>
                            <div class="input-group-btn">
                                <button class="btn btn-success add-more5" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                            </div>
                            @elseif(isset($question_template_id) && $question_template_id==3)
                                @php
                                $detail=getAllQuestions($list->id);
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
                            @php } } @endphp
                            <div class="after-add-more"></div>
                            <div class="input-group-btn">
                                <button class="btn btn-success add-more2" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                            </div>
                            @elseif(isset($question_template_id) && $question_template_id==2)
                                @php
                                $detail=getAllQuestions($list->id);
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
                            @php } } @endphp
                            <div class="after-add-more"></div>
                            <div class="input-group-btn">
                                <button class="btn btn-success add-more3" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                            </div>
                            @elseif(isset($question_template_id) && $question_template_id==11)
                            @php
                                $detail=\App\TestPaperQuestionDetail::where('test_paper_question_id',$list->id)->where('input_3','text')->get();
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

                                                <div class="col-md-3">
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
                            @php } } @endphp
                            <div class="after-add-more-oth-text"></div>
                            <div class="input-group-btn">
                                <button class="btn btn-success add-more33" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                            </div>

                                @php
                                $o_detail=\App\TestPaperQuestionDetail::where('test_paper_question_id',$list->id)->where('input_3','file')->get();
                                if($o_detail)
                                {
                                foreach($o_detail as $key=>$value)
                                {
                                @endphp

                                <div class="form-group">
                                                <div class="row" style="margin-bottom:30px;">
                                                    <div class="col-md-6">
                                                        <a href="{{ url('/') }}/{{ $value->input_1 }}" target="_blank"> {{ $value->input_1 }} </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control"  value="{{ $value->input_1 }}" name="old_o_input_1[]" type="hidden">
                                                        <input class="form-control" required value="{{ $value->answer }}" name="old_o_answer[]" placeholder="= Answer" type="text">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control" required value="{{ $value->marks }}" name="old_o_marks[]" placeholder="= Marks" type="text">
                                                    </div>
                                                </div>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-danger remove_o" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                <input type="hidden" name="o_listing_detail_id[]" value="{{ $value->id }}">
                            @php } } @endphp
                            <div class="after-add-more-oth-file"></div>
                            <div class="input-group-btn">
                                <button class="btn btn-success add-more22" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                            </div>
                            @elseif(isset($question_template_id) && $question_template_id==1)
                            @php
                            $detail=getAllQuestions($list->id);
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
                        @php } } @endphp
                        <div class="after-add-more"></div>
                        <div class="input-group-btn">
                            <button class="btn btn-success add-more4" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                        </div>
                            @elseif(isset($question_template_id) && $question_template_id==6)
                                @php
                                    $detail=getAllQuestions($list->id);
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
                                                <div class="col-md-2">
                                                    <select name="old_input_3[]" class="form-control">
                                                        <option value="add">Add</option>
                                                        <option value="subtract">Subtract </option>
                                                        <option value="multiply">Multiply</option>
                                                        <option value="divide">Divide</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="form-control" required value="{{ $value->input_2 }}" name="old_input_2[]" placeholder="Number 2" type="text">
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
                                @php } } @endphp
                                <div class="after-add-more"></div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>
                               @endif


                            </div>
                            <input type="hidden" name="type" value="<?=$question_template_id?>">
                            <input type="hidden" name="paper_id" value="<?=$paper_id?>">
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Update</button>
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
            <div class="col-md-2">
                <select name="input_3[]" class="form-control">
                    <option value="add">Add</option>
                    <option value="subtract">Subtract </option>
                    <option value="multiply">Multiply</option>
                    <option value="divide">Divide</option>
                </select>
            </div>
            <div class="col-md-3">
                <input class="form-control" required value="" name="input_2[]" placeholder="Number 2" type="text">
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
<div class="copy22" style="display:none;">
    <div class="form-group">
        <div class="row">
        <div class="col-md-6">
            <input class="form-control" required name="o_input_1[]"  type="file">
        </div>
        <div class="col-md-3">
            <input class="form-control" required value="" name="o_answer[]" placeholder="Answer" type="text">
        </div>
        <div class="col-md-3">
            <input class="form-control" required value="" name="o_marks[]" placeholder="Marks" type="text">
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
<div class="copy33" style="display:none;">
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
          $(".add-more22").click(function(){
          var html = $(".copy22").html();
          $(".after-add-more-oth-file").after(html);
          });

        $(".add-more3").click(function(){
            var html = $(".copy3").html();
            $(".after-add-more").after(html);
        });

        $(".add-more33").click(function(){
            var html = $(".copy33").html();
            $(".after-add-more-oth-text").after(html);
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

          $("body").on("click",".remove_o",function(){
              $(this).parents(".form-group").remove();
          });

          $("body").on("click",".remove2",function(){
              $(this).parents(".row").remove();
          });

        });
    </script>
@endsection

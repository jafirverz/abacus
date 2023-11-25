@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('worksheet.questions', $wId) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        
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


                                
                                @if($question->question_type==9)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($question->question_type) }}</label>
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
                                            <!-- <div class="input-group-btn">
                                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                            </div> -->
                                        </div>
                                    @php } @endphp
                                    <!-- <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div> -->

                                    @elseif($question->question_type==2 || $question->question_type==3)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($question->question_type) }}</label>
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
                                                <!-- <div class="input-group-btn">
                                                    <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div> -->
                                            </div>
                                        @php } @endphp
                                    <!-- <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more2" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div> -->

                                    @elseif($question->question_type==1)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($question->question_type) }}</label>
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
                                                <!-- <div class="input-group-btn">
                                                    <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div> -->
                                            </div>
                                        @php } @endphp
                                    <!-- <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more1" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div> -->

                                @elseif($question->question_type==4)
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
                                        <!-- <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div> -->
                                    </div>
                                    @php } @endphp
                                    <!-- <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more3" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div> -->
                                @elseif($question->question_type==6)
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
                                        <!-- <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div> -->
                                    </div>
                                    @php } @endphp
                                    <!-- <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more6" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div> -->




                                @elseif($question->question_type==7)
                                    <label for="" class=" control-label">{{ getQuestionTemplate(7) }}</label>
                                    @php
                                        $getQues = \App\MiscQuestion::where('question_id', $question->id)->where('symbol', '!=', 'vertical')->get();
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
                                        <!-- <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div> -->
                                    </div>
                                    @php } @endphp
                                    <!-- <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more7" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div> -->

                                    <!-- ///////////////////////////////////////////////// -->
                                    <label for="" class=" control-label">{{ getQuestionTemplate(4) }}</label>
                                    @php
                                        $json_question=\App\MiscQuestion::where('question_id', $question->id)->where('symbol', 'vertical')->get();
                                        foreach($json_question as $quest)
                                        {

                                    @endphp

                                    <div class="form-group">
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-5">
                                                <textarea rows="5" cols="40" name="vertical_1[]">{{ $quest->question_1 }}</textarea>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" required value="{{ $quest->answer }}" name="vertical_2[]" placeholder="Answer" type="text">
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" required value="{{ $quest->marks }}" name="vertical_3[]" placeholder="Marks" type="text">
                                            </div>
                                        </div>
                                        <!-- <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div> -->
                                    </div>
                                    @php } @endphp
                                    <!-- <div class="after-add-more7-1"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more7-1" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div> -->


                                    @elseif($question->question_type==5)
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
                                                    <option value="add" @if($ques->symbol == 'add') selected @endif>Add</option>
                                                    <option value="subtract" @if($ques->symbol == 'subtract') selected @endif>Subtract</option>
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
                                        <!-- <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div> -->
                                    </div>
                                    @php } @endphp
                                    <!-- <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more5" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div> -->


                                @elseif($question->question_type==8)
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
                                        <!-- <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div> -->
                                    </div>
                                    @php } @endphp
                                    <!-- <div class="after-add-more"></div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more8" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div> -->


                                @elseif($question->question_type==10)
                                    <label for="" class=" control-label">Grading Sample Questions</label>
                                    

                                    <div class="form-group">
                                        <label for="">Upload PDF</label>
                                        <input type="file"  name="pdf" class="form-control" >
                                   </div>
                                   <p><a href="{{ asset($question->link) ?? '' }}" target="_blank">PDF</a></p>
                                    
                                @endif



                            </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



@endsection

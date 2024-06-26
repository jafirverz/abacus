@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('papers.questions', ['id' => $pId]) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
{{--            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_bank_crud', 'Edit', route('bank.edit', $bank->id))])--}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('comp-questions.update', $competitionPaper->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                               

                                @php 
                                if(isset($competitionPaper->id)){
                                    $paperId = $competitionPaper->id;
                                    $compPaper = \App\CompetitionPaper::where('id', $paperId )->first();
                                    $question_template_id = $compPaper->question_template_id;
                                }else{
                                    $question_template_id = '';
                                }
                                
                                @endphp

                                @if(isset($question_template_id) && $question_template_id==9)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($question_template_id) }}</label>
                                    <div class="row after-add-more" style="margin-bottom:30px;">
                                        <div class="col-md-4">
                                            <input class="form-control" required value="" name="input_1[]" placeholder="Number 1" type="text">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control number-separator" required value="" name="input_2[]" placeholder="Number 2" type="text">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" required value="" name="input_3[]" placeholder="= Answer" type="text">
                                        </div>
                                    </div>
                                    
                            @elseif(isset($question_template_id) && ($question_template_id==2 || $question_template_id==1 || $question_template_id==3))

                                <label for="" class=" control-label">{{ getQuestionTemplate($question_template_id) }}</label>
                                @php 
                                $compPaperQuestion = \App\CompetitionQuestions::where('competition_paper_id', $paperId )->get();
                                $i = 1;
                                @endphp

                                @foreach($compPaperQuestion as $questionss)
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="form-control">Q{{ $i }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{{ url('/') }}/upload-file/{{  $questionss->question_1 }}" target="_blank">{{ $questionss->question_1 }} </a>
                                            <input class="form-control" required value="{{  $questionss->question_1 }}" name="input_1_old[]" placeholder="" type="hidden">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control number-separator" required value="{{  $questionss->answer }}" name="input_2_old[]" placeholder="Answer" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="{{  $questionss->marks }}" name="marks_old[]" placeholder="Marks" type="text">
                                        </div>
                                        <div class="col-md-1">
                                            <input class="form-control" required value="{{  $questionss->block }}" name="block_old[]" placeholder="Block" type="text">
                                        </div>
                                        
                                    </div>
                                </div>
                                @php 
                                $i++;
                                @endphp
                                @endforeach
                                

                                @elseif(isset($question_template_id) && $question_template_id==4)


                                    <label for="" class=" control-label">{{ getQuestionTemplate($question_template_id) }}</label>
                                    @php 
                                    $compPaperQuestion = \App\CompetitionQuestions::where('competition_paper_id', $paperId )->get();
                                    $i = 1;
                                    @endphp

                                    @foreach($compPaperQuestion as $questionss)
                                    <div class="form-group">
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-1">
                                                <div class="form-control">Q{{ $i }}</div>
                                            </div>
                                            <div class="col-md-5">
                                                <textarea rows="5" cols="40" name="vertical_1[]">{{ $questionss->question_1 }}</textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control number-separator" required value="{{ $questionss->answer }}" name="vertical_2[]" placeholder="Answer" type="text">
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" required value="{{ $questionss->marks }}" name="vertical_3[]" placeholder="Marks" type="text">
                                            </div>
                                        </div>
                                        <!-- <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                        </div> -->
                                    </div>
                                    @php 
                                    $i++;
                                    @endphp
                                    @endforeach
                                    
                                
                                @elseif(isset($question_template_id) && $question_template_id==5)


                                    <label for="" class=" control-label">{{ getQuestionTemplate($question_template_id) }}</label>
                                    @php 
                                    $compPaperQuestion = \App\CompetitionQuestions::where('competition_paper_id', $paperId )->get();
                                    $i = 1;
                                    @endphp

                                    @foreach($compPaperQuestion as $questionss)
                                    <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="form-control">Q{{ $i }}</div>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="{{ $questionss->question_1 }}" name="input_1[]" placeholder="Variable 1" type="text" required>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="input_2[]" class="form-control">
                                                <option value="multiply" @if($questionss->symbol == 'multiply') selected @endif>Multiply</option>
                                                <option value="divide" @if($questionss->symbol == 'divide') selected @endif>Divide</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="{{ $questionss->question_2 }}" name="input_3[]" placeholder="Variable 2" type="text" required>
                                        </div>

                                        <div class="col-md-4">
                                            <input class="form-control number-separator" required value="{{ $questionss->answer }}" name="answer[]" placeholder="Answer" type="text" required>
                                        </div>
                                        <div class="col-md-1">
                                            <input class="form-control" required value="{{  $questionss->marks }}" name="marks[]" placeholder="Marks" type="text">
                                        </div>
                                        
                                        
                                    </div>
                                    </div>
                                    @php 
                                    $i++;
                                    @endphp
                                    @endforeach
                                    


                                @elseif(isset($question_template_id) && $question_template_id==6)


                                    <label for="" class=" control-label">{{ getQuestionTemplate($question_template_id) }}</label>
                                    @php 
                                    $compPaperQuestion = \App\CompetitionQuestions::where('competition_paper_id', $paperId )->get();
                                    $i = 1;
                                    @endphp

                                    @foreach($compPaperQuestion as $questionss)
                                    <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="form-control">Q{{ $i }}</div>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="{{ $questionss->question_1 }}" name="input_1[]" placeholder="Variable 1" type="text" required>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="input_2[]" class="form-control">
                                                <option value="add" @if($questionss->symbol == 'add') selected @endif>Add</option>
                                                <option value="subtract" @if($questionss->symbol == 'subtract') selected @endif>Subtract</option>
                                                <option value="multiply" @if($questionss->symbol == 'multiply') selected @endif>Multiply</option>
                                                <option value="divide" @if($questionss->symbol == 'divide') selected @endif>Divide</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="{{ $questionss->question_2 }}" name="input_3[]" placeholder="Variable 2" type="text" required>
                                        </div>

                                        <div class="col-md-4">
                                            <input class="form-control number-separator" required value="{{ $questionss->answer }}" name="answer[]" placeholder="Answer" type="text" required>
                                        </div>
                                        <div class="col-md-1">
                                            <input class="form-control" required value="{{  $questionss->marks }}" name="marks[]" placeholder="Marks" type="text">
                                        </div>
                                        
                                        
                                    </div>
                                    </div>
                                    @php 
                                    $i++;
                                    @endphp
                                    @endforeach
                                    


                                @elseif(isset($question_template_id) && $question_template_id==7)


                                    <label for="" class=" control-label">{{ getQuestionTemplate($question_template_id) }}</label>
                                    @php 
                                    $compPaperQuestion = \App\CompetitionQuestions::where('competition_paper_id', $paperId )->get();
                                    $i=1;
                                    @endphp

                                    @foreach($compPaperQuestion as $questionss)
                                    <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="form-control">Q{{ $i }}</div>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="{{ $questionss->question_1 }}" name="input_1[]" placeholder="Variable 1" type="text" required>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="input_2[]" class="form-control">
                                                <option value="multiply" @if($questionss->symbol == 'multiply') selected @endif>Multiply</option>
                                                <option value="divide" @if($questionss->symbol == 'divide') selected @endif>Divide</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" required value="{{ $questionss->question_2 }}" name="input_3[]" placeholder="Variable 2" type="text" required>
                                        </div>

                                        <div class="col-md-4">
                                            <input class="form-control number-separator" required value="{{ $questionss->answer }}" name="answer[]" placeholder="Answer" type="text" required>
                                        </div>
                                        <div class="col-md-1">
                                            <input class="form-control" required value="{{  $questionss->marks }}" name="marks[]" placeholder="Marks" type="text">
                                        </div>
                                        
                                        
                                    </div>
                                    </div>
                                    @php 
                                    $i++;
                                    @endphp
                                    @endforeach
                                    

                            @endif

                               

                                
                            <input type="hidden" name="paperId" value="{{ $competitionPaper->id }}">
                            <input type="hidden" name="question_template_id" value="{{ $competitionPaper->question_template_id }}">

                               

                                {{-- 
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
                                --}}

                            </div>
                            
                            <!-- <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Update</button>
                            </div> -->
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
        <div class="col-md-2">
            <input class="form-control" required value="" name="block[]" placeholder="Block" type="text">
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
            <div class="col-md-2">
                <input class="form-control" required value="" name="input_1[]" placeholder="Variable 1" type="text" required>
            </div>
            <div class="col-md-2">
                <select name="input_2[]" class="form-control">
                    <option value="add">Add</option>
                    <option value="subtract">Subtract</option>
                </select>
            </div>
            <div class="col-md-2">
                <input class="form-control" required value="" name="input_3[]" placeholder="Variable 2" type="text" required>
            </div>

            <div class="col-md-4">
                <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text" required>
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

            <div class="col-md-4">
                <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text" required>
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
                <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
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
                <input class="form-control" required value="" name="marks[]" placeholder="Marks" type="text">
            </div>

        </div>
        <div class="input-group-btn">
            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
    
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

        $(".add-more5").click(function(){
            var html = $(".copy5").html();
            $(".after-add-more").after(html);
        });

        $(".add-more6").click(function(){
            var html = $(".copy6").html();
            $(".after-add-more").after(html);
        });

        $(".add-more7").click(function(){
            var html = $(".copy7").html();
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

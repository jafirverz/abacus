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
                <a href="{{ route('test-paper-question.index',$paper_id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_test_paper_question_crud', $paper_id,
            'Create', route('test-paper-question.create', $paper_id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('test-paper-question.store',$paper_id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="question">Question</label>
                                    <input type="text" name="question" class="form-control" id=""
                                        value="{{ old('question') }}">
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
                                        @endif
                                    </select>
                                    @if ($errors->has('question_template_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_template_id') }}</strong>

                                    </span>
                                    @endif
                                </div>



                                @if(isset($question_template_id) && $question_template_id==9 || $question_template_id==5)
                                    <label for="" class=" control-label">{{ getQuestionTemplate($question_template_id) }}</label>
                                    <div class="row after-add-more" style="margin-bottom:30px;">
                                        <div class="col-md-3">
                                            <input class="form-control" required value="" name="input_1[]" placeholder="Number 1" type="text">
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" required value="" name="input_2[]" placeholder="Number 2" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <select name="input_3[]" class="form-control">
                                                <option value="multiply">Multiply</option>
                                                <option value="divide">Divide</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" required value="" name="answer[]" placeholder="= Answer" type="text">
                                        </div>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                    </div>


                            @elseif(isset($question_template_id) && $question_template_id==4)

                                <label for="" class=" control-label">{{ getQuestionTemplate($question_template_id) }}</label>
                                <div class="row after-add-more" style="margin-bottom:30px;">

                                    <div class="col-md-8">
                                        <textarea class="form-control" required  name="input_1[]" placeholder="Variable 1" required></textarea>
                                    </div>


                                    <div class="col-md-4">
                                        <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text" required>
                                    </div>
                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more3" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>
                                @elseif(isset($question_template_id) && $question_template_id==6)
                                <div class="row after-add-more" style="margin-bottom:30px;">
                                    <div class="col-md-6">
                                        <input class="form-control" required value="" name="input_1[]"  type="file" placeholder="Upload File">
                                    </div>

                                    <div class="col-md-6">
                                        <input class="form-control" required value="" name="answer[]"  type="text" placeholder="Answer">
                                    </div>

                                </div>

                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more4" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>

                            @endif


                            </div>
                            <input type="hidden" name="paper_id" value="<?=$paper_id?>">
                            <input type="hidden" name="type" value="<?=$question_template_id?>">
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
        <div class="col-md-3">
            <input class="form-control" required value="" name="input_1[]" placeholder="Number 1" type="text">
        </div>
        <div class="col-md-3">
            <input class="form-control" required value="" name="input_2[]" placeholder="Number 2" type="text">
        </div>
        <div class="col-md-2">
            <select name="input_3[]" class="form-control">
                <option value="multiply">Multiply</option>
                <option value="divide">Divide</option>
            </select>
        </div>
        <div class="col-md-4">
            <input class="form-control" required value="" name="answer[]" placeholder="= Answer" type="text">
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
        <div class="col-md-6">
            <input class="form-control" required value="" name="input_2[]" placeholder="Answer" type="text">
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
            <div class="col-md-8">
                <textarea class="form-control" required value="" name="input_1[]" placeholder="Variable 1" required></textarea>
            </div>



            <div class="col-md-4">
                <input class="form-control" required value="" name="answer[]" placeholder="Answer" type="text" required>
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
            <div class="col-md-6">
                <input class="form-control" required value="" name="answer[]"  type="text" placeholder="Answer">
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
        $(".add-more4").click(function(){
            var html = $(".copy4").html();
            $(".after-add-more").after(html);
        });


          $("body").on("click",".remove",function(){
              $(this).parents(".form-group").remove();
          });

        });
    </script>
@endsection

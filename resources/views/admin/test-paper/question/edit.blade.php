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
                                    <label for="question">Question</label>
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
                                        @endif
                                    </select>
                                    @if ($errors->has('question_template_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('question_template_id') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                @if(isset($question_template_id) && $question_template_id==9 || $question_template_id==5)
                                    @php
                                    $detail=getAllQuestions($list->id);
                                    if($detail)
                                    {
                                    foreach($detail as $key=>$value)
                                    {
                                    @endphp
                                    <div class="form-group">
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-4">
                                                <input class="form-control" required value="{{ $value->input_1 }}" name="old_input_1[]" placeholder="Number 1" type="text">
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" required value="{{ $value->input_2 }}" name="old_input_2[]" placeholder="Number 2" type="text">
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" required value="{{ $value->answer }}" name="old_answer[]" placeholder="= Answer" type="text">
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
                                        <div class="col-md-4">
                                            <input class="form-control" required value="{{ $value->input_1 }}" name="old_input_1[]" placeholder="Number 1" type="text">
                                        </div>

                                        <div class="col-md-4">
                                            <input class="form-control" required value="{{ $value->answer }}" name="old_answer[]" placeholder="= Answer" type="text">
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
                                            <div class="col-md-6">
                                                <input class="form-control"  value="{{ $value->input_1 }}" name="old_input_1[]" type="hidden">
                                                <a href="{{ url('/') }}/{{ $value->input_1 }}" target="_blank"> {{ $value->input_1 }} </a>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" required value="{{ $value->answer }}" name="old_answer[]" placeholder="Answer" type="text">
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
                <input class="form-control" required value="" name="answer[]" placeholder="= Answer" type="text">
            </div>
       </div>
       <div class="input-group-btn">
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
      </div>
    </div>
    <input type="hidden" name="listing_detail_id[]" value="">
</div>
<div class="copy2" style="display:none;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <input class="form-control" required value="" name="input_1[]"  type="text" placeholder="Question">
            </div>
            <div class="col-md-4">
                <input class="form-control" required value="" name="input_2[]"  type="text" placeholder="Price">
            </div>
            <div class="col-md-4">
                <select class="form-control" required name="input_3[]">
                    <option value="">--Select--</option>
                    @foreach(getAllGradingPaper() as $val)
                    <option value="{{ $val->id }}">{{ $val->title }}</option>
                    @endforeach
                </select>
            </div>
       </div>
       <div class="input-group-btn">
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
      </div>
    </div>
    <input type="hidden" name="listing_detail_id[]" value="">
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

          $("body").on("click",".remove",function(){
              $(this).parents(".form-group").remove();
          });

          $(".add-more4").click(function(){
            var html = $(".copy4").html();
            $(".after-add-more").after(html);
        });

        });
    </script>
@endsection

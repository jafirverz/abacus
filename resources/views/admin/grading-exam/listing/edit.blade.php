@extends('admin.layout.app')

@section('content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('grading-exam-list.index',$list->grading_exams_id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
          @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_grading_exam_list_crud', $list->grading_exams_id,
            'Edit', route('grading-exam-list.edit', ['exam_id' => $list->grading_exams_id, 'id' => $list->id]))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('grading-exam-list.update',  ['exam_id' => $list->grading_exams_id, 'id' => $list->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="heading">Heading</label>
                                    <input type="text" name="heading" class="form-control" id=""
                                        value="{{ old('heading', $list->heading) }}">
                                    @if ($errors->has('heading'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('heading') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @if(getExamDetail($exam_id)->type==1)
                                <label for="" class=" control-label">Physical</label>
                                @php
                                    $detail=getAllGradingExamListDetail($list->id);
                                    if($detail)
                                    {
                                    foreach($detail as $key=>$value)
                                    {

                                @endphp

                                    <div class="form-group">
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-4">
                                                <input class="form-control" required value="{{ $value->title }}" name="old_input_1[]" placeholder="Question" type="text">
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" required value="{{ $value->price }}" name="old_input_2[]" placeholder="Price" type="text">
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control"  value="{{ $value->uploaded_file }}" name="old_input_3[]" type="hidden">
                                                <a href="{{ url('/') }}/{{ $value->uploaded_file }}" target="_blank"> {{ $value->uploaded_file }} </a>
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
                               @else
                               <label for="" class=" control-label">Online</label>
                                @php
                                    $detail=getAllGradingExamListDetail($list->id);
                                    if($detail)
                                    {
                                    foreach($detail as $key=>$value)
                                    {

                                @endphp

                                    <div class="form-group">
                                        <div class="row" style="margin-bottom:30px;">
                                            <div class="col-md-4">
                                                <input class="form-control" required value="{{ $value->title }}" name="old_input_1[]" placeholder="Question" type="text">
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" required value="{{ $value->price }}" name="old_input_2[]" placeholder="Price" type="text">
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control" required name="old_input_3[]">
                                                    <option value="">--Select--</option>
                                                    @foreach(getAllGradingPaper() as $val)
                                                    <option @if($val->id==$value->paper_id) selected @endif value="{{ $val->id }}">{{ $val->title }}</option>
                                                    @endforeach
                                                </select>
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
                               @endif


                            </div>
                            <input type="hidden" name="type" value="<?=getExamDetail($exam_id)->type?>">
                            <input type="hidden" name="exam_id" value="<?=$exam_id?>">
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
                <input class="form-control" required value="" name="input_1[]"  type="text" placeholder="Question">
            </div>
            <div class="col-md-4">
                <input class="form-control" required value="" name="input_2[]"  type="text" placeholder="Price">
            </div>
            <div class="col-md-4">
                <input class="form-control" required value="" name="input_3[]"  type="file">
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


          $("body").on("click",".remove",function(){
              $(this).parents(".form-group").remove();
          });

        });
    </script>
@endsection

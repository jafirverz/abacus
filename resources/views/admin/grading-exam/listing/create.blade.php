@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('grading-exam-list.index',$exam_id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_grading_exam_list_crud', $exam_id,
            'Create', route('grading-exam-list.create', $exam_id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('grading-exam-list.store',$exam_id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="heading">Heading</label>
                                    <input type="text" name="heading" class="form-control" id=""
                                        value="{{ old('heading') }}">
                                    @if ($errors->has('heading'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('heading') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                @if(getExamDetail($exam_id)->type==1)
                                <label for="" class=" control-label">Physical</label>
                                <div class="row after-add-more" style="margin-bottom:30px;">

                                    <div class="col-md-4">
                                        <input class="form-control" required value="" name="input_1[]"  type="text" placeholder="Question">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" required value="" name="input_2[]"  type="text" placeholder="Price">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" required value="" name="input_3[]"  type="file" placeholder="Upload File">
                                    </div>

                                </div>

                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>
                                @else
                                <label for="" class=" control-label">Online</label>
                                <div class="row after-add-more" style="margin-bottom:30px;">

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
                                    <button class="btn btn-success add-more2" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>
                                @endif
                            </div>
                            <input type="hidden" name="type" value="<?=getExamDetail($exam_id)->type?>">
                            <input type="hidden" name="exam_id" value="<?=$exam_id?>">
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

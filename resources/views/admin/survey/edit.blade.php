@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('survey.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            {{--@include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('survey_crud', 'Edit',
            route('survey.edit', $survey->id))]) --}}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('survey.update', $surveys->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" required name="title" class="form-control" value="{{ old('title', $surveys->title) }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea name="description" class="form-control my-editor" cols="30"
                                              rows="5">{{old('description', $surveys->description)}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                            <option value="{{ $key }}" @if(old('status')==$key) selected @elseif($surveys->status == $key) selected @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                
                            </div>


                                
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



<script>

    $(document).ready(function () {

        $('body').on('change','#worksheet', function() {
             alert(this.value);
             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var worksheet_id= this.value;
                //alert(make);
                //alert(id);
                $.ajax({
                    url:"<?php echo url('/'); ?>/admin/survey/find-worksheet",
                    method:"POST",
                    data:{_token: CSRF_TOKEN,worksheet_id:worksheet_id},
                    success:function(data){
                        //$("#model_header_list").html(data);
                        //$('.selectpicker').selectpicker('refresh');
                    }
                });
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

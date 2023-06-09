@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('announcement.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_announcement_crud', 'Edit', route('announcement.edit', $announcement->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('announcement.update', $announcement->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="" value="{{ old('title', $announcement->title) }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" class="form-control">
                                    @if ($errors->has('image'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif

                                    @if(isset($announcement->image))
                                    <div class="d-block">
                                        <a href="{{ asset($announcement->image) }}" target="_blank"><img
                                                src="{{ asset($announcement->image) }}" alt="" width="200px"></a>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="announcement_date">Date</label>
                                    <input type="text" name="announcement_date" class="form-control datepicker1" id=""
                                        value="{{ old('announcement_date', $announcement->announcement_date) }}">
                                    @if ($errors->has('announcement_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('announcement_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="">{{ old('description', $announcement->description) }}</textarea>
                                    @if ($errors->has('description'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="function">Function</label>
                                    <textarea name="function" class="form-control" id="">{{ old('function', $announcement->function) }}</textarea>
                                    @if ($errors->has('function'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('function') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group after-add-more">
                                    <label for="attachments">Attachments</label>
                                    <input type="file" name="attachments[]" multiple="multiple" class="form-control">
                                    @if ($errors->has('attachments'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('attachments') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>

                                @php
                                    $json=json_decode($announcement->attachments);
                                    for($i=0;$i<count($json);$i++)
                                    {
                                @endphp

                                            <div class="form-group">
                                                <input class="form-control"  value="{{ $json[$i] }}" name="input_1_old[]" type="hidden">
                                                <a href="{{ url('/') }}/upload-file/{{ $json[$i] }}" target="_blank"> {{ $json[$i] }} </a>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                @php } @endphp
                                <div class="form-group">
                                    <label for="teacher_id">Teacher</label>
                                    <select name="teacher_id" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($instructors)
                                        @foreach ($instructors as $item)
                                        <option value="{{ $item->id }}" @if(old('teacher_id', $announcement->teacher_id)==$item->id)
                                            selected
                                            @endif>{{ $item->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('teacher_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('teacher_id') }}</strong>
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
<div class="copy" style="display:none;">
    <div class="form-group">
      <input class="form-control" required name="attachments[]"  type="file">
       <div class="input-group-btn">
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
      </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("input[name='title']").on("change", function () {
            var title = slugify($(this).val());
            $("input[name='slug']").val(title);
        });
    });

    $(".add-more").click(function(){
              var html = $(".copy").html();
              $(".after-add-more").after(html);
          });

          $("body").on("click",".remove",function(){
              $(this).parents(".form-group").remove();
          });
</script>
@endsection

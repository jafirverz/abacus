@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('gallery.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_gallery_crud', 'Create',
            route('gallery.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('gallery.store') }}" id="gallery" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                        value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                {{-- <div class="form-group">
                                    <div class="custom-file">
                                        <label for="customFile2">Main Image</label>
                                        <input type="file" name="main_image" class="form-control" id="customFile2">
                                        
                                        <small class="text-muted">
                                            Logo size should be 1400x450 for better resolution. Only png, jpg, and gif
                                            files upto 25mb are accepted.
                                        </small>
                                        @if ($errors->has('main_image'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('main_image') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div> --}}
                    <div class="form-group">
                        <div class="section-title">Gallery</div>
                        <div class="form-row">
                            <div class="attachment_data col-12"></div>
                            <div class="col-12 line">
                                <div class="custom-file uploaded_file">
                                    <label class="form-control-file" for="customFile1">Choose file</label>
                                    <input type="file" name="picture[]" class="form-control-file" id="customFile1"
                                        multiple="multiple">
                                </div>
                                <small
                                    class="text-muted">{{ fileReadText(['png', 'jpg', 'gif'], '25MB', '800x360') }}</small>
                            </div>
                            @if ($errors->has('picture.*'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('picture.*') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="view_order">View Order</label>
                        <input type="number" name="view_order" class="form-control" id=""
                            value="{{ old('view_order', 0) }}" min="0">
                        @if ($errors->has('view_order'))
                        <span class="text-danger d-block">
                            <strong>{{ $errors->first('view_order') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" id="">
                            <option value="">-- Select --</option>
                            @if(getActiveStatus())
                            @foreach (getActiveStatus() as $key => $item)
                            <option value="{{ $key }}" @if(old('status')==$key) selected @elseif($key==1) selected
                                @endif>{{ $item }}
                            </option>
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

<script>
    $(document).ready(function () {
        
		$("body").on("change","input.form-control-file", function () {
            
            var ref = $(this);
			var uploadedfileCount =$("input[name='main_images[]']")
              .map(function(){return $(this).val();}).length;
              var toBeuploadedFileCount = $("[name='picture[]']").prop("files").length;
			
			var all_files = $("input[name='picture[]']").map(function(){
				var files_name= $(this).val();
				return files_name;}).get();
			//alert(all_files);
            if ((uploadedfileCount+toBeuploadedFileCount) > 10) {
                ref.val('');
                alert("Maximum limit 10 is reached.");
            } else {
                if (ref.val()) {
                    ref.attr("readonly", true);
					var len=ref.index('.form-control-file') + 1;
					var formData = new FormData($('#gallery')[0]);
					formData.append('all_files', all_files);
                    $.ajax({
                        type: "POST",
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: '{{ route("gallery.upload-files") }}',
                        data: formData,
                        cache: false,
                        async: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            ref.attr("readonly", false);
                            ref.val('');
                            if (data.trim() == 'invalid_file_size') {
                                alert("Invalid! Supported file size upto 5mb.");
                            } else if (data.trim() == 'invalid_file_type') {
                                alert("Invalid! Supported pdf file only.");
                            } 
							else if (data.trim() == 'duplicate_file_name') {
                                alert("This file already added.");
                            } 
							else if (data.trim() == 'tile_name_empty') {
                                alert("Please enter title before uploading file.");
                            } else if (data.trim() == 'max_upload_exceed') {
                                alert("Maximum limit 10 is reached.");
                            } 
							else {
                                ref.parents("div.form-row").find("div.attachment_data").append(data);
                            }
                        }
                    });
                }
                
            }
        });

        $("body").on("click", ".remove_file", function () {
            $(this).parents("div.row-file").remove();
        });
		
		$("body").on("click", ".remove-folder", function () {
            $(this).parents("div.box-13").remove();
        });
		
    });

</script>
@endsection
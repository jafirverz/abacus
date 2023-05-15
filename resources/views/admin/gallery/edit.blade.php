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
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_gallery_crud', 'Edit',
            route('gallery.edit', $gallery->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('gallery.update', $gallery->id) }}" id="gallery" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                        value="{{ old('title',$gallery->title) }}">

                                </div>


                                <div class="form-group">
                                    <div class="section-title">Picture</div>
                                    <div class="form-row">
                                        <div class="attachment_data col-12">
                                            @php
                                            $attachments=json_decode($gallery->gallery_images);
                                            @endphp

                                            @if(isset($attachments))
                                            @foreach($attachments as $attachment)

                                            <div class="tb-col row-file col-6" style="margin:20px 0;">
                                                <a class="fas fa-minus-circle link-2 remove_file"
                                                    href="javascript:void(0);"></a>
                                                {{$attachment->image}}
                                                <a class="btn-download" target="_blank"
                                                    href="{{url($attachment->image)}}">
                                                    <i class="fas fa-download"></i></a>
                                                <input type="number" class="form-control" name="img_order[]"
                                                    style="width:70px; float:right; height:35px;"
                                                    value="{{$attachment->display_order}}" min="0">
                                                <input type="hidden" name="main_images[]"
                                                    value="<?php echo $attachment->image ?>">
                                                <input type="hidden" name="thum_images[]"
                                                    value="<?php echo $attachment->thumb ?>">
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="line col-12">
                                            <div class="custom-file uploaded_file">
                                                <label class="form-control-file" for="customFile1">Choose file</label>
                                                <input type="file" name="picture[]" class="form-control-file"
                                                    id="customFile1" multiple="multiple">
                                            </div>
                                            <small
                                                class="text-muted">{{ fileReadText(['png', 'jpg', 'gif'], '25MB', '800x360') }}</small>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="view_order">View Order</label>
                                    <input type="number" name="view_order" class="form-control" id=""
                                        value="{{ old('view_order', $gallery->view_order) }}" min="0">

                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                        <option value="{{ $key }}" @if(old('status', $gallery->status)==$key) selected
                                            @elseif($key==1) selected
                                            @endif>{{ $item }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>

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
        $("body").on("change","#autoquote_id", function () {
             var id = $(this).val();
             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		  
			   $.ajax({
				url:"{{ url('admin/gallery/get-auto-quote') }}/"+id,
				type: "POST",
				dataType: 'json',
				data:{ _token: CSRF_TOKEN},
				cache: false,
                async: false,
				success:function(data)
				{
				$("#customer_name").val(data.customer_name);
				$("#make").val(data.make);
				$("#model").val(data.model);
				}
			  });
        });
		
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
						method:	"POST",
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
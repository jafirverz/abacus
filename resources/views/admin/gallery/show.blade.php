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
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_gallery_crud', 'Show',
            route('gallery.show', $gallery->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                                
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input readonly="readonly" type="text" name="title" class="form-control" id="title"
                                        value="{{ old('title',$gallery->title) }}">
                                    
                                </div>
								
                                <div class="form-group">
                                    <div class="custom-file">
                                        <div class="section-title">Main Image</div>
                                        
                                       <p><img height="80" src="{{url('storage/gallery/'.$gallery->main_image)}}"></p>
                                    </div>
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
                          
              <img width="100" src="{{url('storage/gallery/'.$attachment->image)}}">
              <input type="number" readonly="readonly" class="form-control" name="img_order[]" style="width:70px; float:right; height:35px;" value="{{$attachment->display_order}}" min="0">
              <input type="hidden" name="picture_uploaded[]" value="<?php echo $attachment->image ?>">
                    </div>
                    @endforeach 
                  @endif
                    </div>
                                        
                                       
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="view_order">View Order</label>
                                    <input readonly="readonly" type="number" name="view_order" class="form-control" id=""
                                        value="{{ old('view_order', $gallery->view_order) }}" min="0">
                                    
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select disabled="disabled" name="status" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                        <option value="{{ $key }}" @if(old('status', $gallery->status)==$key) selected @elseif($key==1) selected
                                            @endif>{{ $item }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                   
                                </div>
                                
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

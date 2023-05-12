@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <div class="section-header-back">
        <a href="{{ route('slider.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>{{ $title ?? '-' }}</h1>
      @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_slider_crud', 'Edit',
      route('slider.edit', $slider->id))])
    </div>

    <div class="section-body">
      @include('admin.inc.messages')
      <div class="row">
        <div class="col-12">
          <div class="card">
            <form action="{{ route('slider.update', $slider->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="card-body">
                <div class="form-group">
                  <label for="title" class=" control-label">Title</label>
                  <div class="">
                    <input type="hidden" name="page_id" value="{{ $slider->page_id }}">
                    <input class="form-control" placeholder="" value="{{  old('title',$slider->title) }}" name="title"
                      type="text">
                    @if($errors->has('title'))
                    <span class="text-danger d-block"> <strong>{{ $errors->first('title') }}</strong> </span>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <label for="content">Content</label>
                  <textarea name="content" class="form-control my-editor" id="content" cols="30"
                    rows="10">{!! old('content',$slider->content) !!}</textarea>
                  @if ($errors->has('content'))
                  <span class="text-danger d-block">
                    <strong>{{ $errors->first('content') }}</strong>
                  </span>
                  @endif
                </div>

                <div class="form-group">
                  <div class="section-title">Slider Image</div>
                  <div class="custom-file">
                    <label class="form-control-file" for="customFile1">Choose file</label>
                    <input type="file" name="slider_images" class="form-control-file" id="customFile1">
                    <span class="text-muted">{{ fileReadText(['png', 'jpg', 'gif'], '2MB', '1400x648') }}</span>
                    @if ($errors->has('slider_images')) <span class="text-danger d-block">
                      <strong>{{ $errors->first('slider_images') }}</strong> </span> @endif
                    @if(isset($slider->slider_images))
                    <div class="d-block">
                      <a href="{{ asset($slider->slider_images) }}" target="_blank"><img
                          src="{{ asset($slider->slider_images) }}" alt="" height="80px"></a>
                    </div>
                    @endif
                  </div>
                </div><br />
                <div class="form-group non-external">
                  <label for="link_label">Link Label</label>
                  <input type="text" name="link_label" class="form-control" id=""
                    value="{{old('link_label',$slider->link_label) }}">
                  @if ($errors->has('link_label'))
                  <span class="text-danger d-block">
                    <strong>{{ $errors->first('link_label') }}</strong>
                  </span>
                  @endif
                </div>

                <div class="form-group non-external">
                  <label for="link">Link</label>
                  <input type="text" name="link" class="form-control" id=""
                    value="{{old('link',$slider->link) }}">
                  @if ($errors->has('link'))
                  <span class="text-danger d-block">
                    <strong>{{ $errors->first('link') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group">
                  <label for="view_order" class=" control-label">View Order</label>
                  <div class="">
                    <input class="form-control" placeholder="" value="{{  old('view_order',$slider->view_order) }}"
                      name="view_order" type="number">
                    @if($errors->has('view_order')) <span class="text-danger d-block">
                      <strong>{{ $errors->first('view_order') }}</strong> </span> @endif </div>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select name="status" class="form-control" id="">
                    <option value="">-- Select --</option>

                    @if(getActiveStatus())
                    @foreach (getActiveStatus() as $key => $item)

                    <option value="{{ $key }}" @if(old('status')==$key) selected @elseif($key==1) selected @endif>
                      {{ $item }}

                    </option>

                    @endforeach
                    @endif

                  </select>
                  @if ($errors->has('status')) <span class="text-danger d-block">
                    <strong>{{ $errors->first('status') }}</strong> </span> @endif </div>

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
@endsection
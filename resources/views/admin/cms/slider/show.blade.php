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
      @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_slider_crud', 'Show',
      route('slider.show', $slider->id))])
    </div>

    <div class="section-body">
      @include('admin.inc.messages')
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label for="title" class=" control-label">Title</label>
                <p>{{ $slider->title ?? "" }}</p>
              </div>

              <div class="form-group">
                <label for="content">Content </label>
                <p>{!! $slider->content ?? '' !!}</p>
              </div>

              <div class="form-group">
                <label for="link_title" class=" control-label">Link Label </label>
                <p>{{ $slider->link_label ?? "" }}</p>
                <div class="form-group">
                  <label for="link" class=" control-label">Link</label>
                  <p><a href="{{ $slider->link ?? '' }}" target="_blank">{{ $slider->link ?? '' }}</a></p>
                  <div class="form-group">
                    <div class="section-title">Slider Image</div>
                    <div class="custom-file">

                      @if(isset($slider->slider_images))
                      <div class="d-block">
                        <a href="{{ asset($slider->slider_images) }}" target="_blank"><img
                            src="{{ asset($slider->slider_images) }}" alt="" height="80px"></a>
                      </div>
                      @endif
                    </div>
                  </div><br />

                  <div class="form-group">
                    <label for="view_order" class=" control-label">View Order</label>
                   <p>{{ $slider->view_order ?? "" }}</p>
                  <div class="form-group">
                    <label for="status">Status</label>
                    <p>{{ getActiveStatus($slider->status) }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
  </section>
</div>
<script>
  $(document).ready(function() {
        $("input, textarea, select").attr("disabled", true);
    });
</script>
@endsection
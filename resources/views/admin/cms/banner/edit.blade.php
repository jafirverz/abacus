@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('banner.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_banner_crud', 'Edit',
            route('banner.edit', $banner->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('banner.update', $banner->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="page_id">Page</label>
                                    <select name="page_id" class="form-control" id=""
                                        style="font-family: 'FontAwesome', 'Helvetica';">
                                        <option value="">-- Select --</option>
                                        {!! getDropdownPageList($pages, $banner->page_id, $parent_id = 0) !!}
                                    </select>
                                    @if ($errors->has('page_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('page_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                {{-- <div class="form-group">
                                    <label for="url" class=" control-label">URL</label>
                                    <div class="">
                                        <input class="form-control" placeholder=""
                                            value="{{  old('url',$banner->url) }}" name="url" type="text"> <small
                                            class="text-muted">
                                            Eg. http://example.com
                                        </small>
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <div class="section-title">Banner Image</div>
                                    <div class="custom-file">
                                        <label class="form-control-file" for="customFile1">Choose file</label>
                                        <input type="file" name="banner_image" class="form-control-file"
                                            id="customFile1">
                                        <small class="text-muted">
                                            Logo size should be 1400x450 for better resolution. Only png, jpg, and gif
                                            files upto 25mb are accepted.
                                        </small>
                                        @if ($errors->has('banner_image'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('banner_image') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    @if(isset($banner->banner_image))
                                    <div class="d-block">
                                        <a href="{{ asset($banner->banner_image) }}" target="_blank"><img
                                                src="{{ asset($banner->banner_image) }}" alt="" width="200px"></a>
                                    </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                        <option value="{{ $key }}" @if($banner->status==$key) selected @elseif($key==1)
                                            selected
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
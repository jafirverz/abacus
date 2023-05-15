@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('partner.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_partner_crud', 'Edit', route('partner.edit', $partner->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('partner.update', $partner->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                            <div class="form-group">
                                <label for="partner_name" class=" control-label">Partner Name</label>
                                <div class="">
                                <input class="form-control" placeholder="" value="{{  old('partner_name',$partner->partner_name) }}" name="partner_name" type="text">                                   @if ($errors->has('partner_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('partner_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                </div>
                                
                                <div class="form-group">
                                <label for="url" class=" control-label">URL</label>
                                <div class="">
                                <input class="form-control" placeholder="" value="{{  old('url',$partner->url) }}" name="url" type="text">                            <small class="text-muted">
                                       Eg. http://example.com
                                    </small>
                                </div>
                                </div>
                                <div class="form-group">
                                <div class="section-title">Logo</div>
                                <div class="custom-file">
                                    <label class="form-control-file" for="customFile1">Choose file</label>
                                    <input type="file" name="logo" class="form-control-file" id="customFile1">
                                     <small class="text-muted">
                                            Logo size should be 374x264 for better resolution. Only png, jpg, and gif
                                            files upto 2.5mb are accepted.
                                        </small>
                                    @if ($errors->has('logo'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @if(isset($partner->logo))
                                <div  class="d-block">
                                    <a href="{{ asset($partner->logo) }}" target="_blank"><img src="{{ asset($partner->logo) }}" alt="" width="200px"></a>
                                </div>
                                @endif
                                </div>
                                <div class="form-group">
                                <label for="view_order" class=" control-label">View Order</label>
                                <div class="">
                                <input class="form-control" placeholder="" value="{{  old('view_order',$partner->view_order) }}" name="view_order" type="number">                   	                 @if ($errors->has('view_order'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('view_order') }}</strong>
                                    </span>
                                @endif
                                </div>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if(getActiveStatus())
                                        @foreach (getActiveStatus() as $key => $item)
                                        <option value="{{ $key }}" @if($partner->status==$key) selected @elseif($key==1) selected
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
                                <a href="{{ route('partner.index') }}" class="btn btn-primary"><i class="fas fa-window-close"></i> Cancel</a>
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

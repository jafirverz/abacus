@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('chat-window.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_chat_window_crud', 'Edit', route('chat-window.edit', $chatWindow->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('chat-window.update', $chatWindow->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                            <div class="form-group">
                                <label for="title" class=" control-label">Title</label>
                                <div class="">
                                <input class="form-control" placeholder="" value="{{  old('title',$chatWindow->title) }}" name="title" type="text">                                   @if ($errors->has('partner_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                </div>
                                
                                <div class="form-group">
                                <label for="url" class=" control-label">URL</label>
                                <div class="">
                                <input class="form-control" placeholder="" value="{{  old('url',$chatWindow->url) }}" name="url" type="text">                            <small class="text-muted">
                                       Eg. http://example.com
                                    </small>
                                </div>
                                </div>
                                <div class="form-group">
                                <div class="section-title">Icon</div>
                                <div class="custom-file">
                                    <label class="form-control-file" for="customFile1">Choose file</label>
                                    <input type="file" name="icon" class="form-control-file" id="customFile1">
                                     <small class="text-muted">
                                            Icon size should be 20x20 for better resolution. Only png, jpg, and gif
                                            files upto 2.5mb are accepted.
                                        </small>
                                    @if ($errors->has('icon'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('icon') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @if(isset($chatWindow->icon))
                                <div  class="d-block">
                                    <a href="{{ asset($chatWindow->icon) }}" target="_blank"><img src="{{ asset($chatWindow->icon) }}" alt="" width="200px"></a>
                                </div>
                                @endif
                                </div>
                                <div class="form-group">
                                <label for="view_order" class=" control-label">View Order</label>
                                <div class="">
                                <input class="form-control" placeholder="" value="{{  old('view_order',$chatWindow->view_order) }}" name="view_order" type="number">                   	                 @if ($errors->has('view_order'))
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
                                        <option value="{{ $key }}" @if($chatWindow->status==$key) selected @elseif($key==1) selected
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
                                <a href="{{ route('chat-window.index') }}" class="btn btn-primary"><i class="fas fa-window-close"></i> Cancel</a>
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

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
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_oneMotoring_crud', 'Create', route('oneMotoring.create'))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('oneMotoring.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                <label for="title" class=" control-label">Title</label>
                                <div class="">
                                <input class="form-control" placeholder="" value="{{  old('title') }}" name="title" type="text">                                   
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                </div>
                                
                                <div class="form-group">
                                <label for="url" class=" control-label">Link</label>
                                <div class="">
                                <input class="form-control" placeholder="" value="{{  old('link') }}" name="link" type="text">                                   
                                    @if ($errors->has('link'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('link') }}</strong>
                                    </span>
                                    @endif
                                <small class="text-muted">Eg. http://example.com</small>
                                </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" class="form-control" id="">
                                        <option value="">-- Select --</option>
                                        @if($categories)
                                        @foreach ($categories as $key => $item)
                                        <option value="{{ $item->id }}" @if(old('category_id')==$item->id) selected  @endif>{{ $item->title}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('category_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('category_id') }}</strong>
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
                                <div class="form-group">
                                <label for="view_order" class=" control-label">View Order</label>
                                <div class="">
                                <input class="form-control" placeholder="" value="{{  old('view_order') }}" name="view_order" type="number">                                    
                                    @if ($errors->has('view_order'))    
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('view_order') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('partner.index') }}" class="btn btn-primary"><i class="fas fa-window-close"></i> Cancel</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

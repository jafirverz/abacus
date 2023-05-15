@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('testimonial.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_testimonial_crud', 'Edit',
            route('testimonial.edit', $testimonial->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('testimonial.update', $testimonial->id) }}" id="testimonial"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="title"> Name</label>
                                    <input type="text" name="customer_name" class="form-control" id="customer_name"
                                        value="{{ old('customer_name',$testimonial->customer_name) }}">
                                    @if ($errors->has('customer_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('customer_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
								<div class="form-group">
                                    <label for="designation">Designation</label>
                                    <input type="text" name="designation" class="form-control" id="designation"
                                        value="{{ old('designation',$testimonial->designation) }}">
                                    @if ($errors->has('designation'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('designation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea name="content" class="form-control" id="" cols="30"
                                        rows="5">{!! old('content',$testimonial->content) !!}</textarea>
                                    @if ($errors->has('content'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="section-title">Picture</div>
                                    <div class="custom-file">
                                        <label class="form-control-file" for="customFile1">Choose file</label>
                                        <input type="file" name="picture" class="form-control-file" id="customFile1" multiple="multiple">
                                       <small class="text-muted">{{ fileReadText(['png', 'jpg', 'gif'], '2MB', '380x200') }}</small>
                                        @if ($errors->has('picture'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('picture') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    @if(isset($testimonial->picture))
                                    <div class="d-block">
                                        <a href="{{ asset($testimonial->picture) }}" target="_blank"><img src="{{ asset($testimonial->picture) }}" alt=""
                                                width="200px"></a>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="view_order">View Order</label>
                                    <input type="number" name="view_order" class="form-control" id=""
                                        value="{{ old('view_order', $testimonial->view_order) }}" min="0">
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
                                        @if(getFormStatus())
                                        @foreach (getFormStatus() as $key => $item)
                                        <option value="{{ $key }}" @if(old('status')==$key) selected
                                            @elseif($key==$testimonial->status)
                                            selected @endif>{{ $item }}
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
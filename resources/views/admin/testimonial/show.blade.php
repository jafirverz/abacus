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
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_testimonial_crud', 'Show',
            route('testimonial.show', $testimonial->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputEmail3" class="  col-sm-2  col-form-label">Name</label>
                                <div class=" col-sm-10">
                                    <p>{{$testimonial->name}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="  col-sm-2  col-form-label">Designation</label>
                                <div class=" col-sm-10">
                                    <p>{{$testimonial->designation}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="  col-sm-2  col-form-label">Picture</label>
                                <div class=" col-sm-10">
                                    <a href="{{ asset($testimonial->picture) }}" target="_blank"><img style="max-width:364px; width:100%" src="{{ asset($testimonial->picture) }}" alt=""></a>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="inputEmail3" class="  col-sm-2  col-form-label">Content</label>
                                <div class=" col-sm-10">
                                    <p>{{ $testimonial->content}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="  col-sm-2  col-form-label">View Order</label>
                                <div class=" col-sm-10">
                                    <p>{{ $testimonial->view_order }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="  col-sm-2  col-form-label">Status</label>
                                <div class=" col-sm-10">
                                    @if(getFormStatus())
                                    <div
                                        class="badge @if ($testimonial->status==1) badge-success @else badge-danger @endif">
                                        {{ getFormStatus($testimonial->status) }}</div>
                                    @endif

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="  col-sm-2  col-form-label">Submission Date</label>
                                <div class=" col-sm-10">
                                    <p>{{ $testimonial->created_at->format('d M, Y h:i A') }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="  col-sm-2  col-form-label">Updated At</label>
                                <div class=" col-sm-10">
                                    <p>{{ $testimonial->updated_at->format('d M, Y h:i A') }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>




            </div>
        </div>
    </section>
</div>
@endsection
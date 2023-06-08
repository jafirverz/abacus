@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('template.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_template_crud', 'Show',
            route('template.show', $template->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Title</strong>: {{ $template->title }}
                                </div>
                                <div class="form-group">
                                    <strong>View Order</strong>: {{ $template->view_order }}
                                </div>
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $template->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $template->updated_at->format('d M, Y h:i A') }}
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

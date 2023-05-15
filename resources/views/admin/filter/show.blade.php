@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('filter.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_filter_crud', 'Show',
            route('filter.show', $filter->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                                <div class="form-group">
                                    <strong>Type</strong>:
                                    {{ getFilterType($filter->type )}}
                                </div>
                                <div class="form-group">
                                    <strong>Title</strong>: {{ $filter->title }}
                                </div>
                                <div class="form-group">
                                    <strong>From Value</strong>:
                                    {{ $filter->from_value }}
                                </div>
                                <div class="form-group">
                                    <strong>To Value</strong>:
                                    {{ $filter->to_value }}
                                </div>

                                <div class="form-group">
                                    <strong>View Order</strong>: {{ $filter->view_order }}
                                </div>
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $filter->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $filter->updated_at->format('d M, Y h:i A') }}
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

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
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_oneMotoring_crud', 'Show', route('partner.show', $oneMotoring->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                    <strong>Title</strong>:
                                    {{$oneMotoring->title}}
                                </div>
                                <div class="form-group">
                                    <strong>Link</strong>:
                                    {{$oneMotoring->link}}
                                </div>
                                <div class="form-group">
                                    <strong>Category</strong>:
                                    {{$oneMotoring->category}}
                                </div>
                                 <div class="form-group">
                                    <strong>Status</strong>: {{ getActiveStatus($oneMotoring->status) }}
                                </div>
                                <div class="form-group">
                                    <strong>View Order</strong>:
                                    {{$oneMotoring->view_order}}
                                </div>
                               
                                
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $oneMotoring->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $oneMotoring->updated_at->format('d M, Y h:i A') }}
                                </div>
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

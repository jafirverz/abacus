@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('pages.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_faq_crud', 'Show',
            route('faqs.show', $faq->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Title</strong>: {{ $faq->title }}
                                </div>
                                <div class="form-group">
                                    <strong>Content</strong>:
                                    {{$faq->content}}
                                </div>
                                
                                <div class="form-group">
                                    <strong>View Order</strong>: {{ $faq->view_order }}
                                </div>
                                 <div class="form-group">
                                    <strong>Status</strong>: {{ getActiveStatus($faq->status) }}
                                </div>
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $faq->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $faq->updated_at->format('d M, Y h:i A') }}
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

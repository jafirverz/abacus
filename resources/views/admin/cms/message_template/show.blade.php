@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('message-template.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_message_template_crud', 'Show', route('message-template.show', $message_template->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <strong>Title</strong>: {{ $message_template->title }}
                            </div>
                            <div class="form-group">
                                <strong>Content</strong>: {!! $message_template->content !!}
                            </div>

                            <div class="form-group">
                                <strong>Status</strong>: {{ getActiveStatus($message_template->status) }}
                            </div>
                            <div class="form-group">
                                <strong>Created At</strong>: {{ $message_template->created_at->format('d M, Y h:i A') }}
                            </div>
                            <div class="form-group">
                                <strong>Updated At</strong>: {{ $message_template->updated_at->format('d M, Y h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

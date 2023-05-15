@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('smart-block.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_smart_block_crud', 'Show',
            route('smart-block.show', $smart_block->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <strong>Title</strong>: {{ $smart_block->title }}
                            </div>
                            <div class="form-group">
                                <strong>Header</strong>: {{ $smart_block->header }}
                            </div>
                            <div class="form-group">
                                <strong>Content</strong>: {!! $smart_block->content !!}
                            </div>
                            <div class="form-group">
                                <strong>Created At</strong>: {{ $smart_block->created_at->format('d M, Y h:i A') }}
                            </div>
                            <div class="form-group">
                                <strong>Updated At</strong>: {{ $smart_block->updated_at->format('d M, Y h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
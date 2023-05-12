@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('specifications.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_specifications_crud', 'Show', route('specifications.show', $specifications->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <strong>Features</strong>: {{ $specifications->specification }}
                            </div>
                            <div class="form-group">
                                <strong>Position</strong>: {{ $specifications->position }}
                            </div>
                            
                            <div class="form-group">
                                <strong>Status</strong>: {{ getActiveStatus($specifications->status) }}
                            </div>
                            <div class="form-group">
                                <strong>Created At</strong>: {{ $specifications->created_at->format('d M, Y h:i A') }}
                            </div>
                            <div class="form-group">
                                <strong>Updated At</strong>: {{ $specifications->updated_at->format('d M, Y h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

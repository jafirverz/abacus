@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('attributes.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_car_attributes_crud', 'Show', route('attributes.show', $attributes->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <strong>Attribute Title</strong>: {{ $attributes->attribute_title }}
                            </div>
                            <div class="form-group">
                                <strong>Position</strong>: {{ $attributes->position }}
                            </div>
                            
                            <div class="form-group">
                                <strong>Status</strong>: {{ getActiveStatus($attributes->status) }}
                            </div>
                            <div class="form-group">
                                <strong>Created At</strong>: {{ $attributes->created_at->format('d M, Y h:i A') }}
                            </div>
                            <div class="form-group">
                                <strong>Updated At</strong>: {{ $attributes->updated_at->format('d M, Y h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

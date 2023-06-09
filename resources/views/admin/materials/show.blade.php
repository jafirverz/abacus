@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('teaching-materials.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_teaching_materials_crud', 'Show',
            route('teaching-materials.show', $material->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Title</strong>: {{ $material->title }}
                                </div>
                                <div class="form-group">
                                    <strong>Uploaded Files</strong>:  <a href="{{ asset($material->uploaded_files) }}" target="_blank">{{ asset($material->uploaded_files) }}</a>
                                </div>
                                <div class="form-group">
                                    <strong>Title</strong>: {{ $material->title }}
                                </div>
                                <div class="form-group">
                                    <strong>Description</strong>: {{ $material->description }}
                                </div>
                                <div class="form-group">
                                    <strong>Teacher</strong>: {{ $material->teacher->name }}
                                </div>
                                <div class="form-group">
                                    <strong>Created At</strong>: {{ $material->created_at->format('d M, Y h:i A') }}
                                </div>
                                <div class="form-group">
                                    <strong>Updated At</strong>: {{ $material->updated_at->format('d M, Y h:i A') }}
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

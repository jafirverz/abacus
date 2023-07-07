@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('test-paper.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
           @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('test_paper_crud', 'Show', route('test-paper.show', $paper->id))])
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>: {{ $paper->title ?? '' }}
                            </div>
                            <div class="form-group">
                                <label for="template">Template</label>: {{ $paper->template->title }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

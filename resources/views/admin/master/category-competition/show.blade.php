@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('category-competition.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
           @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('category_competition_crud', 'Show', route('category-competition.show', $category->id))])
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category_name">Category Name</label>: {{ $category->category_name ?? '' }}
                            </div>

                            <div class="form-group">
                                <label for="title">Description</label>: {{ $category->description ?? '' }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

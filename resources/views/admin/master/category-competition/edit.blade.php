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
          @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('category_competition_crud', 'Edit', route('category-competition.edit', $category->id))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('category-competition.update', $category->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" name="category_name" class="form-control" id=""
                                        value="{{ old('category_name', $category->category_name) }}">
                                    @if ($errors->has('category_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('category_name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea class="form-control" name="description">{{ old('description', $category->description) }}</textarea>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('category-grading.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
          @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('category_grading_crud', 'Create', route('category-grading.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('category-grading.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="category_name">Title</label>
                                    <input type="text" name="category_name" class="form-control" id=""
                                        value="{{ old('category_name') }}">
                                    @if ($errors->has('category_name'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('category_name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="grade_type_id">Grade Type</label>
                                    <select name="grade_type_id" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($grade_types)
                                        @foreach ($grade_types as $item)
                                        <option value="{{ $item->id }}" @if(old('grade_type_id')==$item->id)
                                            selected
                                            @endif>{{ $item->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('grade_type_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('grade_type_id') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

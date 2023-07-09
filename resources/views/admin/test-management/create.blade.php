@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('test-management.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('test_management_crud', 'Create', route('test-management.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('test-management.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id=""
                                        value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="template">Input Type</label>
                                    <select name="template" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if (gradingExamLayout())
                                        @foreach (gradingExamLayout() as $key=>$item)
                                        <option value="{{ $key }}" @if(old('template')==$key)
                                            selected
                                            @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('template'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('template') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="student_id">Students</label>
                                    <select name="student_id[]" class="form-control" multiple>
                                        <option value="">-- Select --</option>
                                        @if ($students)
                                        @foreach ($students as $item)
                                        <option value="{{ $item->id }}" @if(old('teacher_id')==$item->id)
                                            selected
                                            @endif>{{ $item->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('student_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('student_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="course_id">Course</label>
                                    <select name="course_id" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($courses)
                                        @foreach ($courses as $item)
                                        <option value="{{ $item->id }}" @if(old('course_id')==$item->id)
                                            selected
                                            @endif>{{ $item->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('course_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('course_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="paper_id">Paper</label>
                                    <select name="paper_id" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($papers)
                                        @foreach ($papers as $item)
                                        <option value="{{ $item->id }}" @if(old('paper_id')==$item->id)
                                            selected
                                            @endif>{{ $item->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('paper_id'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('paper_id') }}</strong>
                                    </span>
                                    @endif
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

<script>
    $(document).ready(function () {
        $("input[name='title']").on("change", function () {
            var title = slugify($(this).val());
            $("input[name='slug']").val(title);
        });
    });

</script>
@endsection

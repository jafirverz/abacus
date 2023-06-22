@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('grading-exam.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
          @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('grading_exam_crud', 'Create', route('grading-exam.create'))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('grading-exam.store') }}" method="post" enctype="multipart/form-data">
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
                                    <label for="type">Type</label>
                                    <select name="type" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if (gradingExamType())
                                        @foreach (gradingExamType() as $key=>$item)
                                        <option value="{{ $key }}" @if(old('type')==$item)
                                            selected
                                            @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('type'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('type') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="layout">Layout</label>
                                    <select name="layout" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if (gradingExamLayout())
                                        @foreach (gradingExamLayout() as $key=>$item)
                                        <option value="{{ $key }}" @if(old('type')==$item)
                                            selected
                                            @endif>{{ $item }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('layout'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('layout') }}</strong>

                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exam_date">Exam Date</label>
                                    <input type="text" name="exam_date" class="form-control datetimepicker" id=""
                                        value="{{ old('exam_date') }}">
                                    @if ($errors->has('exam_date'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('exam_date') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="student_id">Student</label>
                                    <select multiple name="student_id[]" class="form-control">
                                        <option value="">-- Select --</option>
                                        @if ($students)
                                        @foreach ($students as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                    <label for="important_note">Notes</label>
                                    <textarea name="important_note" class="form-control my-editor" id="" cols="30"
                                    rows="10"> {{ old('important_note') }} </textarea>
                                    @if ($errors->has('important_note'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('important_note') }}</strong>
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
@endsection
